<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'ayurweb_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// Site configuration
define('SITE_URL', 'http://localhost/ayurweb/');
define('SITE_NAME', 'AYURWEB');

// Security configuration
define('ENCRYPTION_KEY', 'your-secret-key-here-change-this');
define('SESSION_LIFETIME', 3600); // 1 hour

// Rate limiting configuration
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_COOLDOWN', 900); // 15 minutes

/**
 * Database Connection Class
 */
class Database {
    private $host = DB_HOST;
    private $db_name = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASS;
    private $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password,
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                )
            );
        } catch(PDOException $exception) {
            log_error("Connection error: " . $exception->getMessage());
            die("Database connection failed");
        }
        return $this->conn;
    }
}

/**
 * Authentication Functions
 */
function is_logged_in() {
    return isset($_SESSION['user_id']) && isset($_SESSION['username']);
}

function login_user($user_id, $username) {
    $_SESSION['user_id'] = $user_id;
    $_SESSION['username'] = $username;
    $_SESSION['login_time'] = time();
    
    // Regenerate session ID for security
    session_regenerate_id(true);
}

function logout_user() {
    $_SESSION = array();
    
    // Delete session cookie
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-42000, '/');
    }
    
    // Destroy session
    session_destroy();
}

function require_login($redirect_to = 'login.php') {
    if (!is_logged_in()) {
        $current_url = $_SERVER['REQUEST_URI'];
        redirect($redirect_to . '?redirect=' . urlencode($current_url));
    }
    
    // Check session timeout
    if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time'] > SESSION_LIFETIME)) {
        logout_user();
        set_message("Your session has expired. Please login again.", "warning");
        redirect($redirect_to);
    }
}

/**
 * Input Sanitization Functions
 */
function sanitize_input($data) {
    if (is_array($data)) {
        return array_map('sanitize_input', $data);
    }
    
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Redirect Functions
 */
function redirect($url) {
    if (!headers_sent()) {
        header("Location: " . $url);
        exit();
    } else {
        echo "<script>window.location.href = '" . $url . "';</script>";
        exit();
    }
}

/**
 * Flash Message Functions
 */
function set_message($message, $type = 'info') {
    $_SESSION['flash_message'] = array(
        'message' => $message,
        'type' => $type
    );
}

function get_flash_message() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $message;
    }
    return null;
}

/**
 * Rate Limiting Functions
 */
function get_rate_limit_key($identifier) {
    return 'rate_limit_' . md5($identifier);
}

function check_rate_limit($identifier) {
    $key = get_rate_limit_key($identifier);
    
    if (!isset($_SESSION[$key])) {
        return true;
    }
    
    $data = $_SESSION[$key];
    $current_time = time();
    
    // Reset if cooldown period has passed
    if ($current_time - $data['first_attempt'] >= LOGIN_COOLDOWN) {
        unset($_SESSION[$key]);
        return true;
    }
    
    return $data['attempts'] < MAX_LOGIN_ATTEMPTS;
}

function increment_rate_limit($identifier) {
    $key = get_rate_limit_key($identifier);
    $current_time = time();
    
    if (!isset($_SESSION[$key])) {
        $_SESSION[$key] = array(
            'attempts' => 1,
            'first_attempt' => $current_time
        );
    } else {
        $_SESSION[$key]['attempts']++;
    }
}

/**
 * Logging Functions
 */
function log_error($message) {
    $log_file = 'logs/error.log';
    $timestamp = date('Y-m-d H:i:s');
    $log_message = "[{$timestamp}] {$message}" . PHP_EOL;
    
    // Create logs directory if it doesn't exist
    if (!file_exists('logs')) {
        mkdir('logs', 0755, true);
    }
    
    error_log($log_message, 3, $log_file);
}

function log_activity($user_id, $action, $details = '') {
    try {
        $database = new Database();
        $db = $database->getConnection();
        
        $query = "INSERT INTO activity_logs (user_id, action, details, ip_address, user_agent, created_at) 
                  VALUES (:user_id, :action, :details, :ip_address, :user_agent, NOW())";
        
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':action', $action);
        $stmt->bindParam(':details', $details);
        $stmt->bindParam(':ip_address', $_SERVER['REMOTE_ADDR']);
        $stmt->bindParam(':user_agent', $_SERVER['HTTP_USER_AGENT']);
        $stmt->execute();
    } catch (Exception $e) {
        log_error("Failed to log activity: " . $e->getMessage());
    }
}

/**
 * Utility Functions
 */
function format_date($date, $format = 'F j, Y') {
    if (empty($date) || $date === '0000-00-00' || $date === '0000-00-00 00:00:00') {
        return 'Not specified';
    }
    return date($format, strtotime($date));
}

function time_ago($datetime) {
    $time = time() - strtotime($datetime);
    
    if ($time < 60) return 'just now';
    if ($time < 3600) return floor($time/60) . ' minutes ago';
    if ($time < 86400) return floor($time/3600) . ' hours ago';
    if ($time < 2592000) return floor($time/86400) . ' days ago';
    if ($time < 31104000) return floor($time/2592000) . ' months ago';
    return floor($time/31104000) . ' years ago';
}

function generate_csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Quiz and Dosha Functions
 */
function calculate_dosha_results($answers) {
    $scores = array('vata' => 0, 'pitta' => 0, 'kapha' => 0);
    
    // This is a simplified calculation - you'll need to implement based on your quiz logic
    foreach ($answers as $answer) {
        switch ($answer) {
            case 'vata':
                $scores['vata']++;
                break;
            case 'pitta':
                $scores['pitta']++;
                break;
            case 'kapha':
                $scores['kapha']++;
                break;
        }
    }
    
    return $scores;
}

function get_dominant_dosha($scores) {
    return array_keys($scores, max($scores))[0];
}

function get_dosha_description($dosha) {
    $descriptions = array(
        'vata' => 'Vata types are typically energetic, creative, and quick-thinking. They benefit from routine, warm foods, and calming practices.',
        'pitta' => 'Pitta types are usually focused, ambitious, and strong-willed. They benefit from cooling foods, moderate exercise, and stress management.',
        'kapha' => 'Kapha types are generally calm, stable, and nurturing. They benefit from stimulating activities, light foods, and regular exercise.'
    );
    
    return $descriptions[$dosha] ?? 'Unknown dosha type';
}

/**
 * Database Setup Function
 */
function setup_database() {
    try {
        $database = new Database();
        $db = $database->getConnection();
        
        // Users table
        $users_table = "CREATE TABLE IF NOT EXISTS users (
            id INT PRIMARY KEY AUTO_INCREMENT,
            username VARCHAR(50) UNIQUE NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            password_hash VARCHAR(255) NOT NULL,
            first_name VARCHAR(50) NOT NULL,
            last_name VARCHAR(50) NOT NULL,
            phone VARCHAR(20),
            date_of_birth DATE,
            gender ENUM('male', 'female', 'other'),
            is_active BOOLEAN DEFAULT TRUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            last_login TIMESTAMP NULL
        )";
        
        // Quiz results table
        $quiz_results_table = "CREATE TABLE IF NOT EXISTS quiz_results (
            id INT PRIMARY KEY AUTO_INCREMENT,
            user_id INT,
            vata_score INT DEFAULT 0,
            pitta_score INT DEFAULT 0,
            kapha_score INT DEFAULT 0,
            dominant_dosha VARCHAR(10),
            quiz_data JSON,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )";
        
        // Activity logs table
        $activity_logs_table = "CREATE TABLE IF NOT EXISTS activity_logs (
            id INT PRIMARY KEY AUTO_INCREMENT,
            user_id INT,
            action VARCHAR(100) NOT NULL,
            details TEXT,
            ip_address VARCHAR(45),
            user_agent TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )";
        
        $db->exec($users_table);
        $db->exec($quiz_results_table);
        $db->exec($activity_logs_table);
        
        return true;
    } catch (Exception $e) {
        log_error("Database setup error: " . $e->getMessage());
        return false;
    }
}
/**
 * Update the dominant dosha for the current user
 */
function update_user_dosha($user_id, $dosha) {
    try {
        $database = new Database();
        $db = $database->getConnection();

        $query = "UPDATE users SET dosha = :dosha WHERE id = :user_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':dosha', $dosha);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (Exception $e) {
        log_error("Failed to update dosha: " . $e->getMessage());
        return false;
    }
}
// Initialize database tables if they don't exist
setup_database();

// Set timezone
date_default_timezone_set('Asia/Kolkata');

// Error reporting (disable in production)
if ($_SERVER['SERVER_NAME'] === 'localhost') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
?>