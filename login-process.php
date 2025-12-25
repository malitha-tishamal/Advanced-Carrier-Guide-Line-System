<?php
session_start();
require_once 'includes/db-conn.php';

// Timezone (Sri Lanka)
date_default_timezone_set('Asia/Colombo');
$conn->query("SET time_zone = '+05:30'");

// Initialize login attempts
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['lockout_stage'] = 0;
    $_SESSION['last_attempt_time'] = time();
}

// Lockout durations (minutes)
$lockout_durations = [5 * 60, 10 * 60, 20 * 60, 60 * 60];

// Check lockout
if ($_SESSION['login_attempts'] >= 3) {
    $stage = $_SESSION['lockout_stage'];
    $timeout = $lockout_durations[$stage] ?? end($lockout_durations);
    $remaining = ($_SESSION['last_attempt_time'] + $timeout) - time();

    if ($remaining > 0) {
        $_SESSION['error_message'] =
            "Too many failed attempts. Try again in " . ceil($remaining / 60) . " minute(s).";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['login_attempts'] = 0;
        $_SESSION['lockout_stage']++;
    }
}

// Login submit
if (isset($_POST['submit'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Search order (former_students before students)
    $tables = ['admins', 'lectures', 'former_students', 'students', 'companies'];

    foreach ($tables as $table) {

        $sql = "SELECT * FROM $table WHERE email = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Password verified
        if ($user && password_verify($password, $user['password'])) {

            // Reset attempts
            $_SESSION['login_attempts'] = 0;
            $_SESSION['lockout_stage'] = 0;

            // ✅ STATUS CHECK (approved OR active)
            if (!in_array($user['status'], ['approved', 'active'])) {
                $_SESSION['error_message'] = "Your account is not active or not approved yet.";
                header("Location: index.php");
                exit();
            }

            $current_time = date("Y-m-d H:i:s");

            // ---------- ROLE HANDLING ----------
            if ($table === 'admins') {
                $_SESSION['admin_id'] = $user['id'];
                $redirect = "admin/index.php";

            } elseif ($table === 'lectures') {
                $_SESSION['lecturer_id'] = $user['id'];
                $redirect = "lectures/index.php";

            } elseif ($table === 'former_students') {
                $_SESSION['former_student_id'] = $user['id'];
                $redirect = "oddstudents/index.php";

            } elseif ($table === 'students') {
                $_SESSION['student_id'] = $user['id'];
                $redirect = "user-profile.php";

            } elseif ($table === 'companies') {
                $_SESSION['company_id'] = $user['id'];
                $redirect = "companies/index.php";
            }

            // Update last login
            $update = $conn->prepare("UPDATE $table SET last_login = ? WHERE id = ?");
            $update->bind_param("si", $current_time, $user['id']);
            $update->execute();

            $_SESSION['success_message'] = "Login successful!";
            header("Location: $redirect");
            exit();
        }
    }

    // ❌ Failed login
    $_SESSION['login_attempts']++;
    $_SESSION['last_attempt_time'] = time();
    $_SESSION['error_message'] = "Invalid email or password.";

    if ($_SESSION['login_attempts'] % 3 === 0) {
        $_SESSION['lockout_stage']++;
    }

    header("Location: index.php");
    exit();
}
?>
