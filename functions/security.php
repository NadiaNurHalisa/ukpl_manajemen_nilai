<?php
/**
 * Security Enhancement Module
 * Addresses critical vulnerabilities identified in STLC testing phase
 * 
 * @author Security Team
 * @version 1.0
 * @created 2024-01-15
 */

class SecurityManager {
    
    /**
     * CSRF Protection Implementation
     */
    public static function generateCSRFToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    public static function validateCSRFToken($token) {
        if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
            return false;
        }
        return true;
    }
    
    public static function renderCSRFField() {
        $token = self::generateCSRFToken();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
    }
    
    /**
     * Rate Limiting Implementation
     */
    public static function checkRateLimit($identifier, $maxAttempts = 5, $timeWindow = 900) {
        $key = 'rate_limit_' . $identifier;
        
        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = [
                'attempts' => 0,
                'first_attempt' => time()
            ];
        }
        
        $data = $_SESSION[$key];
        
        // Reset if time window has passed
        if (time() - $data['first_attempt'] > $timeWindow) {
            $_SESSION[$key] = [
                'attempts' => 1,
                'first_attempt' => time()
            ];
            return true;
        }
        
        // Check if limit exceeded
        if ($data['attempts'] >= $maxAttempts) {
            return false;
        }
        
        // Increment attempts
        $_SESSION[$key]['attempts']++;
        return true;
    }
    
    public static function getRemainingLockoutTime($identifier, $timeWindow = 900) {
        $key = 'rate_limit_' . $identifier;
        if (!isset($_SESSION[$key])) {
            return 0;
        }
        
        $data = $_SESSION[$key];
        $elapsed = time() - $data['first_attempt'];
        return max(0, $timeWindow - $elapsed);
    }
    
    /**
     * Input Validation & Sanitization
     */
    public static function validateInput($input, $type, $options = []) {
        $input = trim($input);
        
        switch ($type) {
            case 'username':
                if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $input)) {
                    throw new InvalidArgumentException('Username must be 3-20 characters, alphanumeric and underscore only');
                }
                break;
                
            case 'email':
                if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
                    throw new InvalidArgumentException('Invalid email format');
                }
                break;
                
            case 'password':
                $minLength = $options['min_length'] ?? 8;
                if (strlen($input) < $minLength) {
                    throw new InvalidArgumentException("Password must be at least {$minLength} characters");
                }
                if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/', $input)) {
                    throw new InvalidArgumentException('Password must contain uppercase, lowercase, number and special character');
                }
                break;
                
            case 'name':
                if (!preg_match('/^[a-zA-Z\s]{2,50}$/', $input)) {
                    throw new InvalidArgumentException('Name must be 2-50 characters, letters and spaces only');
                }
                break;
                
            case 'grade':
                $score = floatval($input);
                if ($score < 0 || $score > 100) {
                    throw new InvalidArgumentException('Grade must be between 0 and 100');
                }
                break;
                
            case 'id':
                if (!is_numeric($input) || intval($input) <= 0) {
                    throw new InvalidArgumentException('Invalid ID format');
                }
                break;
        }
        
        return $input;
    }
    
    /**
     * SQL Injection Prevention
     */
    public static function sanitizeSQL($input) {
        return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * XSS Prevention
     */
    public static function sanitizeOutput($input) {
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Session Security Enhancement
     */
    public static function enhanceSessionSecurity() {
        // Regenerate session ID periodically
        if (!isset($_SESSION['last_regeneration'])) {
            $_SESSION['last_regeneration'] = time();
        } elseif (time() - $_SESSION['last_regeneration'] > 300) { // 5 minutes
            session_regenerate_id(true);
            $_SESSION['last_regeneration'] = time();
        }
        
        // Note: Session security flags are set before session_start() in auth.php
        // ini_set calls moved to prevent "Session ini settings cannot be changed when a session is active" warnings
        
        // Add session fingerprinting
        $fingerprint = self::generateSessionFingerprint();
        if (isset($_SESSION['fingerprint']) && $_SESSION['fingerprint'] !== $fingerprint) {
            session_destroy();
            throw new SecurityException('Session security violation detected');
        }
        $_SESSION['fingerprint'] = $fingerprint;
    }
    
    private static function generateSessionFingerprint() {
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $acceptLanguage = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '';
        $acceptEncoding = $_SERVER['HTTP_ACCEPT_ENCODING'] ?? '';
        
        return hash('sha256', $userAgent . $acceptLanguage . $acceptEncoding);
    }
    
    /**
     * Security Headers
     */
    public static function setSecurityHeaders() {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: DENY');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header('Content-Security-Policy: default-src \'self\'; script-src \'self\' \'unsafe-inline\' https://cdn.tailwindcss.com; style-src \'self\' \'unsafe-inline\' https://cdn.tailwindcss.com');
        
        // HTTPS enforcement (in production)
        if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
            header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
        }
    }
    
    /**
     * Security Logging
     */
    public static function logSecurityEvent($event, $details = [], $severity = 'INFO') {
        $logEntry = [
            'timestamp' => date('Y-m-d H:i:s'),
            'event' => $event,
            'severity' => $severity,
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            'session_id' => session_id(),
            'user_id' => $_SESSION['user']['id'] ?? 'anonymous',
            'details' => $details
        ];
        
        $logFile = __DIR__ . '/../logs/security.log';
        $logDir = dirname($logFile);
        
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
        
        file_put_contents($logFile, json_encode($logEntry) . "\n", FILE_APPEND | LOCK_EX);
    }
    
    /**
     * Database Connection Security
     */
    public static function secureDBConnection($pdo) {
        // Set secure SQL mode
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        // Disable multiple statements to prevent injection
        $pdo->setAttribute(PDO::MYSQL_ATTR_MULTI_STATEMENTS, false);
        
        return $pdo;
    }
}

/**
 * Custom Security Exception
 */
class SecurityException extends Exception {
    public function __construct($message = "", $code = 0, ?Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
        SecurityManager::logSecurityEvent('SECURITY_EXCEPTION', ['message' => $message], 'ERROR');
    }
}

/**
 * Initialize security measures
 */
function initializeSecurity() {
    try {
        SecurityManager::setSecurityHeaders();
        SecurityManager::enhanceSessionSecurity();
        SecurityManager::logSecurityEvent('SECURITY_INIT', [], 'INFO');
    } catch (SecurityException $e) {
        error_log('Security initialization failed: ' . $e->getMessage());
        header('HTTP/1.1 500 Internal Server Error');
        exit('Security error occurred');
    }
}

?>
