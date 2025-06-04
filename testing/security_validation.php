<?php
/**
 * Security Validation Script
 * Tests the implemented security enhancements from STLC Phase 3
 * 
 * @author Security Team
 * @version 2.0
 * @created 2024-01-15
 */

require_once __DIR__ . '/../functions/security.php';
require_once __DIR__ . '/../database.php';

class SecurityValidator {
    
    private $testResults = [];
    private $totalTests = 0;
    private $passedTests = 0;
    
    public function runAllTests() {
        echo "=== SECURITY ENHANCEMENT VALIDATION ===\n";
        echo "Testing implemented security fixes from STLC Phase 3\n\n";
        
        $this->testCSRFProtection();
        $this->testRateLimiting();
        $this->testInputValidation();
        $this->testSessionSecurity();
        $this->testSecurityHeaders();
        $this->testSecurityLogging();
        $this->testDatabaseSecurity();
        
        $this->displayResults();
    }
    
    private function testCSRFProtection() {
        echo "1. Testing CSRF Protection Implementation...\n";
        
        // Test token generation
        $token1 = SecurityManager::generateCSRFToken();
        $token2 = SecurityManager::generateCSRFToken();
        $this->assert($token1 === $token2, "CSRF tokens should be consistent within session");
        
        // Test token validation
        $this->assert(SecurityManager::validateCSRFToken($token1), "Valid CSRF token should pass validation");
        $this->assert(!SecurityManager::validateCSRFToken('invalid_token'), "Invalid CSRF token should fail validation");
        
        // Test field rendering
        $field = SecurityManager::renderCSRFField();
        $this->assert(strpos($field, 'csrf_token') !== false, "CSRF field should contain token input");
        
        echo "   ✓ CSRF Protection tests completed\n\n";
    }
    
    private function testRateLimiting() {
        echo "2. Testing Rate Limiting Implementation...\n";
        
        $identifier = 'test_user_' . time();
        
        // Test normal rate limiting
        for ($i = 1; $i <= 4; $i++) {
            $result = SecurityManager::checkRateLimit($identifier, 5, 60);
            $this->assert($result === true, "Attempt $i should be allowed");
        }
        
        // Test rate limit exceeded
        $result = SecurityManager::checkRateLimit($identifier, 5, 60);
        $this->assert($result === true, "5th attempt should still be allowed");
        
        $result = SecurityManager::checkRateLimit($identifier, 5, 60);
        $this->assert($result === false, "6th attempt should be blocked");
        
        // Test lockout time
        $lockoutTime = SecurityManager::getRemainingLockoutTime($identifier, 60);
        $this->assert($lockoutTime > 0, "Lockout time should be positive");
        
        echo "   ✓ Rate Limiting tests completed\n\n";
    }
    
    private function testInputValidation() {
        echo "3. Testing Input Validation & Sanitization...\n";
        
        // Test username validation
        try {
            SecurityManager::validateInput('validuser123', 'username');
            $this->recordTest("Username validation - valid input", true);
        } catch (Exception $e) {
            $this->recordTest("Username validation - valid input", false);
        }
        
        try {
            SecurityManager::validateInput('invalid user!', 'username');
            $this->recordTest("Username validation - invalid input", false);
        } catch (Exception $e) {
            $this->recordTest("Username validation - invalid input", true);
        }
        
        // Test email validation
        try {
            SecurityManager::validateInput('test@example.com', 'email');
            $this->recordTest("Email validation - valid input", true);
        } catch (Exception $e) {
            $this->recordTest("Email validation - valid input", false);
        }
        
        // Test password validation
        try {
            SecurityManager::validateInput('StrongPass123!', 'password');
            $this->recordTest("Password validation - strong password", true);
        } catch (Exception $e) {
            $this->recordTest("Password validation - strong password", false);
        }
        
        try {
            SecurityManager::validateInput('weak', 'password');
            $this->recordTest("Password validation - weak password", false);
        } catch (Exception $e) {
            $this->recordTest("Password validation - weak password", true);
        }
        
        // Test grade validation
        try {
            SecurityManager::validateInput('85.5', 'grade');
            $this->recordTest("Grade validation - valid grade", true);
        } catch (Exception $e) {
            $this->recordTest("Grade validation - valid grade", false);
        }
        
        try {
            SecurityManager::validateInput('150', 'grade');
            $this->recordTest("Grade validation - invalid grade", false);
        } catch (Exception $e) {
            $this->recordTest("Grade validation - invalid grade", true);
        }
        
        echo "   ✓ Input Validation tests completed\n\n";
    }
    
    private function testSessionSecurity() {
        echo "4. Testing Session Security Enhancement...\n";
        
        // Start session for testing
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        try {
            SecurityManager::enhanceSessionSecurity();
            $this->recordTest("Session security enhancement initialization", true);
        } catch (Exception $e) {
            $this->recordTest("Session security enhancement initialization", false);
        }
        
        // Test session fingerprinting
        $this->assert(isset($_SESSION['fingerprint']), "Session fingerprint should be set");
        
        echo "   ✓ Session Security tests completed\n\n";
    }
    
    private function testSecurityHeaders() {
        echo "5. Testing Security Headers Implementation...\n";
        
        // Capture headers
        ob_start();
        SecurityManager::setSecurityHeaders();
        $headers = xdebug_get_headers();
        ob_end_clean();
        
        $requiredHeaders = [
            'X-Content-Type-Options: nosniff',
            'X-Frame-Options: DENY',
            'X-XSS-Protection: 1; mode=block'
        ];
        
        foreach ($requiredHeaders as $header) {
            $found = false;
            foreach ($headers as $setHeader) {
                if (strpos($setHeader, explode(':', $header)[0]) !== false) {
                    $found = true;
                    break;
                }
            }
            $this->recordTest("Security header: " . explode(':', $header)[0], $found);
        }
        
        echo "   ✓ Security Headers tests completed\n\n";
    }
    
    private function testSecurityLogging() {
        echo "6. Testing Security Logging Implementation...\n";
        
        // Test log file creation
        $logDir = __DIR__ . '/../logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
        
        // Test logging functionality
        SecurityManager::logSecurityEvent('TEST_EVENT', ['test' => 'data'], 'INFO');
        
        $logFile = $logDir . '/security.log';
        $this->assert(file_exists($logFile), "Security log file should be created");
        
        $logContent = file_get_contents($logFile);
        $this->assert(strpos($logContent, 'TEST_EVENT') !== false, "Log should contain test event");
        
        echo "   ✓ Security Logging tests completed\n\n";
    }
    
    private function testDatabaseSecurity() {
        echo "7. Testing Database Security Implementation...\n";
        
        global $pdo;
        
        // Test database connection security
        $this->assert($pdo instanceof PDO, "Database connection should be established");
        
        // Test prepared statements are enabled
        $attribute = $pdo->getAttribute(PDO::ATTR_EMULATE_PREPARES);
        $this->assert($attribute === false, "Prepared statements should not be emulated");
        
        // Test error mode
        $errorMode = $pdo->getAttribute(PDO::ATTR_ERRMODE);
        $this->assert($errorMode === PDO::ERRMODE_EXCEPTION, "Error mode should be set to exception");
        
        // Test database health check
        if (function_exists('checkDatabaseHealth')) {
            $this->assert(checkDatabaseHealth(), "Database health check should pass");
        }
        
        echo "   ✓ Database Security tests completed\n\n";
    }
    
    private function assert($condition, $message) {
        $this->recordTest($message, $condition);
    }
    
    private function recordTest($testName, $passed) {
        $this->totalTests++;
        if ($passed) {
            $this->passedTests++;
            $status = "✓ PASS";
        } else {
            $status = "✗ FAIL";
        }
        
        $this->testResults[] = [
            'name' => $testName,
            'status' => $status,
            'passed' => $passed
        ];
        
        echo "   $status: $testName\n";
    }
    
    private function displayResults() {
        echo "\n=== SECURITY VALIDATION SUMMARY ===\n";
        echo "Total Tests: {$this->totalTests}\n";
        echo "Passed: {$this->passedTests}\n";
        echo "Failed: " . ($this->totalTests - $this->passedTests) . "\n";
        echo "Success Rate: " . round(($this->passedTests / $this->totalTests) * 100, 2) . "%\n\n";
        
        // Show failed tests
        $failedTests = array_filter($this->testResults, function($test) {
            return !$test['passed'];
        });
        
        if (!empty($failedTests)) {
            echo "FAILED TESTS:\n";
            foreach ($failedTests as $test) {
                echo "- {$test['name']}\n";
            }
            echo "\n";
        }
        
        // Security status assessment
        $successRate = ($this->passedTests / $this->totalTests) * 100;
        if ($successRate >= 90) {
            echo "🛡️  SECURITY STATUS: EXCELLENT - All critical security measures implemented\n";
        } elseif ($successRate >= 75) {
            echo "🔒 SECURITY STATUS: GOOD - Most security measures implemented\n";
        } elseif ($successRate >= 50) {
            echo "⚠️  SECURITY STATUS: NEEDS IMPROVEMENT - Some security gaps remain\n";
        } else {
            echo "🚨 SECURITY STATUS: CRITICAL - Major security vulnerabilities present\n";
        }
        
        echo "\n=== NEXT STEPS ===\n";
        echo "1. Address any failed security tests\n";
        echo "2. Implement additional monitoring and alerting\n";
        echo "3. Regular security audits and penetration testing\n";
        echo "4. Keep security libraries and frameworks updated\n";
        echo "5. Train development team on secure coding practices\n";
    }
}

// Run the validation if script is executed directly
if (basename(__FILE__) === basename($_SERVER['SCRIPT_NAME'])) {
    $validator = new SecurityValidator();
    $validator->runAllTests();
}

?>
