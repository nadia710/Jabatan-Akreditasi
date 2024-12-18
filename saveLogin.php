<?php
require_once 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['user'];
    $password = $_POST['password'];

    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE user = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Check the password
        if ($password === "jabatan" || $password === "admin") {
            // Store user information in session
            $_SESSION['user'] = $row['user'];
            $_SESSION['password'] = $password; // Store role based on password

            // Update last login time
            $update_stmt = $conn->prepare("UPDATE users SET last_login = NOW() WHERE user = ?");
            $update_stmt->bind_param("s", $user);
            $update_stmt->execute();

            // Redirect based on role
            if ($password === "jabatan") {
                echo "<script>alert('Login successfully as Staff.');</script>";
                echo "<script>window.location.assign('homepage.php');</script>";
            } elseif ($password === "admin") {
                echo "<script>alert('Login successfully as Admin.');</script>";
                echo "<script>window.location.assign('homepageAdmin.php');</script>";
            }
        } else {
            // Invalid password
            echo "<script>alert('Username or Password is incorrect!');</script>";
            echo "<script>window.location.assign('login.php');</script>";
        }
    } else {
        // User not found
        echo "<script>alert('Username or Password is incorrect!');</script>";
        echo "<script>window.location.assign('login.php');</script>";
    }

    // Close statements and connection
    $stmt->close();
    if (isset($update_stmt)) {
        $update_stmt->close();
    }
    $conn->close();
}
?>