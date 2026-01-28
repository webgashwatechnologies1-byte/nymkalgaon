-- NYM Kalgaon Database Schema
-- Run this SQL in phpMyAdmin to create all required tables

-- Create database if not exists
CREATE DATABASE IF NOT EXISTS nymkalgaon;
USE nymkalgaon;

-- ========================================
-- USERS TABLE (Authentication)
-- ========================================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(191) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default admin user
-- Email: admin@nymkalgaon.com | Password: admin123
INSERT INTO users (name, email, password) VALUES 
('Admin', 'admin@nymkalgaon.com', '$2y$12$qJoNY8izTmP12juBIAA5ce3iGbz29GDRnTqSPVRsmJD1amf234Jxm');

-- ========================================
-- NEWS TABLE (Multiple Records - CRUD)
-- ========================================
CREATE TABLE IF NOT EXISTS news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    news_date DATE NOT NULL,
    image VARCHAR(255) NOT NULL,
    heading VARCHAR(255) NOT NULL,
    subheading VARCHAR(255) NOT NULL,
    details TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sample news data
INSERT INTO news (news_date, image, heading, subheading, details) VALUES 
('2026-01-15', 'sample-news.jpg', 'Snowfall Cup 2026 Announced', 'Registration Opens Soon', 'We are excited to announce the Snowfall Cup 2026 cricket tournament. Teams can register starting next week. Stay tuned for more updates!'),
('2026-01-10', 'sample-news2.jpg', 'New Cricket Ground Inaugurated', 'State-of-the-art Facilities', 'Our new cricket ground with modern facilities has been inaugurated. The ground features professional pitches and seating arrangements for spectators.');

-- ========================================
-- FEATURED TABLE (Single Record Only)
-- ========================================
CREATE TABLE IF NOT EXISTS featured (
    id TINYINT PRIMARY KEY DEFAULT 1,
    dotext VARCHAR(100) NOT NULL,
    heading VARCHAR(255) NOT NULL,
    subheading VARCHAR(255) NOT NULL,
    details TEXT NOT NULL,
    image VARCHAR(255) NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CHECK (id = 1)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert initial featured content
INSERT INTO featured (id, dotext, heading, subheading, details, image) VALUES 
(1, 'Featured Tournament', 'Snowfall Cup 2026', 'Join the Biggest Cricket Event', 'Experience the thrill of competitive cricket at the Snowfall Cup 2026. Register your team today and be part of this exciting tournament!', 'featured-default.jpg');
