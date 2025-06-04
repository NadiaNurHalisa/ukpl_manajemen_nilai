<?php
session_start();
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/security.php';

// Initialize security measures
initializeSecurity();

function login($username, $password, $csrfToken = null) {
    global $pdo;
    
    try {
        // CSRF Token validation
        if ($csrfToken && !SecurityManager::validateCSRFToken($csrfToken)) {
            SecurityManager::logSecurityEvent('CSRF_VIOLATION', ['username' => $username], 'CRITICAL');
            throw new SecurityException('CSRF token validation failed');
        }
        
        // Input validation
        $username = SecurityManager::validateInput($username, 'username');
        
        // Rate limiting check
        $clientIP = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        if (!SecurityManager::checkRateLimit('login_' . $clientIP, 5, 900)) {
            $lockoutTime = SecurityManager::getRemainingLockoutTime('login_' . $clientIP, 900);
            SecurityManager::logSecurityEvent('RATE_LIMIT_EXCEEDED', [
                'username' => $username, 
                'ip' => $clientIP,
                'lockout_remaining' => $lockoutTime
            ], 'WARNING');
            throw new SecurityException("Too many login attempts. Try again in " . ceil($lockoutTime/60) . " minutes.");
        }
        
        // Database query with prepared statement
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            // Successful login
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'full_name' => $user['full_name'],
                'login_time' => time()
            ];
            
            SecurityManager::logSecurityEvent('LOGIN_SUCCESS', [
                'user_id' => $user['id'],
                'username' => $username
            ], 'INFO');
            
            return ['success' => true, 'message' => 'Login successful'];
        } else {
            // Failed login
            SecurityManager::logSecurityEvent('LOGIN_FAILED', [
                'username' => $username,
                'ip' => $clientIP
            ], 'WARNING');
            
            return ['success' => false, 'message' => 'Invalid username or password'];
        }
        
    } catch (SecurityException $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    } catch (InvalidArgumentException $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    } catch (Exception $e) {
        SecurityManager::logSecurityEvent('LOGIN_ERROR', [
            'username' => $username,
            'error' => $e->getMessage()
        ], 'ERROR');
        return ['success' => false, 'message' => 'Login failed due to system error'];
    }
}

function checkAuth() {
    try {
        if (!isset($_SESSION['user'])) {
            SecurityManager::logSecurityEvent('UNAUTHORIZED_ACCESS', [
                'requested_page' => $_SERVER['REQUEST_URI'] ?? 'unknown'
            ], 'WARNING');
            header('Location: login.php');
            exit;
        }
        
        // Check session timeout (30 minutes)
        if (isset($_SESSION['user']['login_time']) && 
            (time() - $_SESSION['user']['login_time']) > 1800) {
            SecurityManager::logSecurityEvent('SESSION_TIMEOUT', [
                'user_id' => $_SESSION['user']['id'],
                'username' => $_SESSION['user']['username']
            ], 'INFO');
            logout();
        }
        
        // Update last activity time
        $_SESSION['user']['last_activity'] = time();
        
    } catch (SecurityException $e) {
        logout();
    }
}

function logout() {
    if (isset($_SESSION['user'])) {
        SecurityManager::logSecurityEvent('LOGOUT', [
            'user_id' => $_SESSION['user']['id'],
            'username' => $_SESSION['user']['username']
        ], 'INFO');
    }
    
    session_destroy();
    header('Location: login.php');
    exit;
}

function register($username, $password, $full_name, $csrfToken = null) {
    global $pdo;
    
    try {
        // CSRF Token validation
        if ($csrfToken && !SecurityManager::validateCSRFToken($csrfToken)) {
            SecurityManager::logSecurityEvent('CSRF_VIOLATION', ['action' => 'register'], 'CRITICAL');
            throw new SecurityException('CSRF token validation failed');
        }
        
        // Input validation
        $username = SecurityManager::validateInput($username, 'username');
        $password = SecurityManager::validateInput($password, 'password', ['min_length' => 8]);
        $full_name = SecurityManager::validateInput($full_name, 'name');
        
        // Check if username already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            SecurityManager::logSecurityEvent('REGISTRATION_DUPLICATE', [
                'username' => $username
            ], 'WARNING');
            return ['success' => false, 'message' => 'Username already exists'];
        }
        
        // Hash password and insert new user
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, password, full_name, created_at) VALUES (?, ?, ?, NOW())");
        $result = $stmt->execute([$username, $hash, $full_name]);
        
        if ($result) {
            SecurityManager::logSecurityEvent('REGISTRATION_SUCCESS', [
                'username' => $username,
                'full_name' => $full_name
            ], 'INFO');
            return ['success' => true, 'message' => 'Registration successful'];
        } else {
            return ['success' => false, 'message' => 'Registration failed'];
        }
        
    } catch (SecurityException $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    } catch (InvalidArgumentException $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    } catch (Exception $e) {
        SecurityManager::logSecurityEvent('REGISTRATION_ERROR', [
            'username' => $username,
            'error' => $e->getMessage()
        ], 'ERROR');
        return ['success' => false, 'message' => 'Registration failed due to system error'];
    }
}
?>
