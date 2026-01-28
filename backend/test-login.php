<?php
// Password Test & Debug Tool
// Access: http://localhost/nymkalgaon/backend/test-login.php
// DELETE THIS FILE AFTER FIXING THE ISSUE!

require_once 'config.php';

echo "<!DOCTYPE html>
<html>
<head>
    <title>Login Debug Tool</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; border-bottom: 2px solid #667eea; padding-bottom: 10px; }
        .section { margin: 20px 0; padding: 15px; background: #f9f9f9; border-left: 4px solid #667eea; }
        .success { color: #10b981; font-weight: bold; }
        .error { color: #ef4444; font-weight: bold; }
        .info { color: #3b82f6; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #667eea; color: white; }
        code { background: #eee; padding: 2px 6px; border-radius: 3px; font-family: monospace; }
        .warning { background: #fef3c7; border-left-color: #f59e0b; color: #92400e; padding: 15px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🔐 Login Debug Tool</h1>
        <p class='warning'>⚠️ <strong>SECURITY WARNING:</strong> Delete this file after fixing your login issue!</p>";

// Test 1: Check database connection
echo "<div class='section'>
        <h2>1️⃣ Database Connection</h2>";
if ($conn->connect_error) {
    echo "<p class='error'>❌ Connection failed: " . $conn->connect_error . "</p>";
} else {
    echo "<p class='success'>✅ Database connected successfully</p>";
}
echo "</div>";

// Test 2: Check if users table exists and show all users
echo "<div class='section'>
        <h2>2️⃣ Users in Database</h2>";
$result = $conn->query("SELECT id, name, email, created_at FROM users");
if ($result) {
    if ($result->num_rows > 0) {
        echo "<table>
                <tr><th>ID</th><th>Name</th><th>Email</th><th>Created</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['created_at']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='error'>❌ No users found in database!</p>";
        echo "<p class='info'>💡 Run the schema.sql file to create the default admin user.</p>";
    }
} else {
    echo "<p class='error'>❌ Error: " . $conn->error . "</p>";
}
echo "</div>";

// Test 3: Test password verification
echo "<div class='section'>
        <h2>3️⃣ Password Verification Test</h2>";

$test_email = 'admin@nymkalgaon.com';
$test_password = 'admin123';

$stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
$stmt->bind_param("s", $test_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    echo "<p class='info'>Testing login for: <code>{$test_email}</code> with password: <code>{$test_password}</code></p>";
    
    echo "<p><strong>Stored Hash:</strong><br><code style='word-break: break-all;'>{$user['password']}</code></p>";
    
    if (password_verify($test_password, $user['password'])) {
        echo "<p class='success'>✅ Password verification SUCCESSFUL!</p>";
        echo "<p class='success'>🎉 Login should work with these credentials:</p>";
        echo "<ul>
                <li><strong>Email:</strong> admin@nymkalgaon.com</li>
                <li><strong>Password:</strong> admin123</li>
              </ul>";
    } else {
        echo "<p class='error'>❌ Password verification FAILED!</p>";
        echo "<p class='info'>💡 The password hash in the database is incorrect.</p>";
        echo "<p class='info'>📝 <strong>Fix:</strong> Run the <code>fix-password.sql</code> file in phpMyAdmin to update the password.</p>";
        
        // Generate correct hash
        $correct_hash = password_hash($test_password, PASSWORD_DEFAULT);
        echo "<p><strong>Correct Hash for 'admin123':</strong><br><code style='word-break: break-all;'>{$correct_hash}</code></p>";
        echo "<p class='info'>Or run this SQL:</p>";
        echo "<pre style='background: #1f2937; color: #10b981; padding: 15px; border-radius: 5px; overflow-x: auto;'>UPDATE users SET password = '{$correct_hash}' WHERE email = 'admin@nymkalgaon.com';</pre>";
    }
} else {
    echo "<p class='error'>❌ User 'admin@nymkalgaon.com' not found!</p>";
    echo "<p class='info'>💡 Run the schema.sql file to create the default admin user.</p>";
}
$stmt->close();
echo "</div>";

// Test 4: Session check
echo "<div class='section'>
        <h2>4️⃣ Session Status</h2>";
if (session_status() === PHP_SESSION_ACTIVE) {
    echo "<p class='success'>✅ Session is active</p>";
    if (isset($_SESSION['user_id'])) {
        echo "<p class='info'>Current user logged in: <code>{$_SESSION['user_name']}</code> ({$_SESSION['user_email']})</p>";
    } else {
        echo "<p class='info'>No user currently logged in</p>";
    }
} else {
    echo "<p class='error'>❌ Session not active</p>";
}
echo "</div>";

// Instructions
echo "<div class='section'>
        <h2>📋 Quick Fix Instructions</h2>
        <ol>
            <li>Open phpMyAdmin: <code>http://localhost/phpmyadmin</code></li>
            <li>Select the <code>nymkalgaon</code> database</li>
            <li>Click on <strong>SQL</strong> tab</li>
            <li>Copy and paste the contents of <code>backend/fix-password.sql</code></li>
            <li>Click <strong>Go</strong></li>
            <li>Try logging in again with:
                <ul>
                    <li>Email: <code>admin@nymkalgaon.com</code></li>
                    <li>Password: <code>admin123</code></li>
                </ul>
            </li>
            <li><strong>DELETE THIS FILE</strong> (<code>backend/test-login.php</code>) after fixing!</li>
        </ol>
      </div>";

echo "<div style='margin-top: 30px; padding: 15px; background: #fee; border: 1px solid #fcc; border-radius: 5px;'>
        <strong>⚠️ IMPORTANT:</strong> This file exposes sensitive information. Delete it immediately after fixing your login issue!
      </div>";

echo "</div></body></html>";

$conn->close();
?>
