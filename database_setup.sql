-- Database setup for Cookies Consent Demo
-- Run this in your MySQL/phpMyAdmin to set up everything

-- Create the database (if it doesn't exist)
CREATE DATABASE IF NOT EXISTS cookies_consent_db;
USE cookies_consent_db;

-- Create the consent_log table
CREATE TABLE IF NOT EXISTS consent_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    guid VARCHAR(36) NOT NULL UNIQUE,
    consent_time DATETIME NOT NULL,
    version INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create the admin_users table
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin user (username: admin, password: admin123)
-- You can change these credentials after first login
INSERT INTO admin_users (username, password_hash) VALUES 
('admin', '$2y$10$WcLm0jnAoJiw6pWam0G75uaurpHruMw20HwrvcAY3VmWnfY/L/X8y')
ON DUPLICATE KEY UPDATE username=username;

-- Note: The default password is 'admin123'
