-- Quick Fix: Update Admin Password
-- Run this in phpMyAdmin SQL tab to fix the admin password

USE nymkalgaon;

-- Update the admin user password to 'admin123' (properly hashed)
UPDATE users 
SET password = '$2y$12$qJoNY8izTmP12juBIAA5ce3iGbz29GDRnTqSPVRsmJD1amf234Jxm'
WHERE email = 'admin@nymkalgaon.com';

-- Verify the update
SELECT id, name, email, 'Password Updated' as status FROM users WHERE email = 'admin@nymkalgaon.com';
