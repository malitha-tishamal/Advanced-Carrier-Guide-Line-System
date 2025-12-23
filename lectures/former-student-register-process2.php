<?php
session_start();
require_once '../includes/db-conn.php';

// Check if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Collect and sanitize inputs
    $username    = trim($_POST['username']);
    $course_id   = intval($_POST['course_id']);
    $reg_id      = trim($_POST['reg_id']);
    $nic         = strtoupper(trim($_POST['nic']));
    $email       = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $mobile      = trim($_POST['mobile']);
    $study_year  = intval($_POST['study_year']);
    $nowstatus   = $_POST['nowstatus'] ?? '';
    $password    = $_POST['password'];

    // Basic validation
    if (!$username || !$course_id || !$reg_id || !$nic || !$email || !$mobile || !$study_year || !$nowstatus || !$password) {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Please fill in all required fields!';
        header('Location: add-former-student.php');
        exit();
    }

    // Check if email or reg_id already exists
    $stmt = $conn->prepare("SELECT id FROM former_students WHERE email = ? OR reg_id = ?");
    $stmt->bind_param("ss", $email, $reg_id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Email or Registration ID already exists!';
        $stmt->close();
        header('Location: add-former-student.php');
        exit();
    }
    $stmt->close();

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into former_students table
    $stmt = $conn->prepare("INSERT INTO former_students (username, course_id, reg_id, nic, email, mobile, study_year, nowstatus, password, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sissssiss", $username, $course_id, $reg_id, $nic, $email, $mobile, $study_year, $nowstatus, $hashed_password);

    if ($stmt->execute()) {
        $_SESSION['status'] = 'success';
        $_SESSION['message'] = 'Former student account created successfully!';
        $stmt->close();
        header('Location: add-former-student.php');
        exit();
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Database error: ' . $stmt->error;
        $stmt->close();
        header('Location: add-former-student.php');
        exit();
    }

} else {
    // Invalid access
    header('Location: add-former-student.php');
    exit();
}
?>
