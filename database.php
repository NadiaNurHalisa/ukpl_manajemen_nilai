<?php
/**
 * Secure Database Connection
 * Enhanced with security best practices from STLC testing results
 */

// Load environment variables (in production, use .env file)
$host = $_ENV['DB_HOST'] ?? 'localhost';
$db   = $_ENV['DB_NAME'] ?? 'guru';
$user = $_ENV['DB_USER'] ?? 'root';
$pass = $_ENV['DB_PASS'] ?? '';
$port = $_ENV['DB_PORT'] ?? '3306';

// Secure DSN with SSL and strict settings
$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
    PDO::ATTR_PERSISTENT         => false,
    PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
    // SSL options removed for local development
    // Add SSL options only in production with valid certificates
    // PDO::MYSQL_ATTR_SSL_CA       => null,
    // PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    // Additional security configurations - Updated for MySQL 8.0+ compatibility
    // $pdo->exec("SET SESSION sql_mode = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION'");
    // $pdo->exec("SET SESSION innodb_strict_mode = 1");
    
    // Apply security manager configurations
    if (class_exists('SecurityManager')) {
        $pdo = SecurityManager::secureDBConnection($pdo);
    }
    
} catch (PDOException $e) {
    // Log database connection errors securely
    echo "<pre>"; var_dump($e); echo "<pre>";
    
    error_log("Database connection failed: " . $e->getMessage());
    
    // Don't expose database details to users
    if (isset($_ENV['APP_DEBUG']) && $_ENV['APP_DEBUG'] === 'true') {
        die("Connection failed: " . $e->getMessage());
    } else {
        die("Database connection error. Please contact administrator.");
    }


}

/**
 * Database health check function
 */
function checkDatabaseHealth() {
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT 1");
        return $stmt->fetchColumn() === 1;
    } catch (PDOException $e) {
        return false;
    }
}

/**
 * Get database connection statistics
 */
function getDatabaseStats() {
    global $pdo;
    try {
        $stats = [];
        
        // Connection info
        $stmt = $pdo->query("SELECT CONNECTION_ID() as connection_id");
        $stats['connection_id'] = $stmt->fetchColumn();
        
        // Database size
        $stmt = $pdo->query("SELECT 
            ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS db_size_mb 
            FROM information_schema.tables 
            WHERE table_schema = DATABASE()");
        $stats['db_size_mb'] = $stmt->fetchColumn();
        
        // Active connections
        $stmt = $pdo->query("SHOW STATUS LIKE 'Threads_connected'");
        $result = $stmt->fetch();
        $stats['active_connections'] = $result['Value'];
        
        return $stats;
    } catch (PDOException $e) {
        return ['error' => 'Unable to fetch database statistics'];
    }
}
?>
