<?php
/**
 * Production Database Configuration Template
 * Copy this file to config/db.php and update credentials
 */

// Database configuration
define('DB_SERVER', 'localhost');        // Usually 'localhost' or hosting provider's MySQL host
define('DB_USERNAME', 'your_db_username'); // Your database username
define('DB_PASSWORD', 'your_db_password'); // Your database password
define('DB_NAME', 'jj_jalebi');          // Database name (create this first)

// Create database connection
function getDBConnection() {
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    // Check connection
    if ($conn->connect_error) {
        error_log("Connection failed: " . $conn->connect_error);
        // In production, show generic error instead of exposing details
        die("Database connection failed. Please try again later.");
    }
    
    // Set charset to UTF-8
    $conn->set_charset("utf8mb4");
    
    return $conn;
}

// Start session if not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Helper function to sanitize input
function sanitize($conn, $input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Helper function to execute prepared statements
function executeQuery($conn, $sql, $params = []) {
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        return false;
    }
    
    if (!empty($params)) {
        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    return $stmt;
}

// Helper function to get results from prepared statement
function getResults($conn, $sql, $params = []) {
    $stmt = executeQuery($conn, $sql, $params);
    
    if (!$stmt) {
        return [];
    }
    
    $result = $stmt->get_result();
    $data = [];
    
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    $stmt->close();
    return $data;
}

// Helper function to get single row
function getSingleRow($conn, $sql, $params = []) {
    $stmt = executeQuery($conn, $sql, $params);
    
    if (!$stmt) {
        return null;
    }
    
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    $stmt->close();
    return $row;
}
?>
