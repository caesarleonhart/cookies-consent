<?php
// Database configuration and helper (PDO)

$DB_HOST = getenv('DB_HOST') ?: '127.0.0.1';
$DB_NAME = getenv('DB_NAME') ?: 'cookies_consent_db';
$DB_USER = getenv('DB_USER') ?: 'root';
$DB_PASS = getenv('DB_PASS') ?: '';
$DB_CHARSET = 'utf8mb4';

$dsn = "mysql:host={$DB_HOST};dbname={$DB_NAME};charset={$DB_CHARSET}";
$options = [
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES => false,
];

try {
	$pdo = new PDO($dsn, $DB_USER, $DB_PASS, $options);
} catch (Throwable $e) {
	http_response_code(500);
	echo 'Database connection failed. Please check configuration in config.php';
	exit;
}

function base_url($path = '') {
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
    $url .= "://".$_SERVER['HTTP_HOST'];
    
    // Always return the project root: /cookies-consent
    // This is the simplest and most reliable approach
    $project_path = '/cookies-consent';
    
    $url .= $project_path;
    return $url . '/' . ltrim($path, '/');
}