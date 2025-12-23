<?php
session_start();
include_once("../includes/db-conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and fetch inputs
    $username = trim($_POST['username']);
    $reg_id = trim($_POST['reg_id']);
    $nic = strtoupper(trim($_POST['nic']));
    $study_year = trim($_POST['study_year']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    $password = $_POST['password'];
    $course_id = isset($_POST['course_id']) ? intval($_POST['course_id']) : null; // optional course selection

    // Basic validation
    if (empty($username) || empty($reg_id) || empty($nic) || empty($study_year) || empty($email) || empty($mobile) || empty($password)) {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'All fields are required!';
        header("Location: pages-add-new-student.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Invalid email format.';
        header("Location: pages-add-new-student.php");
        exit();
    }

    // Check for duplicate email or NIC
    $checkQuery = "SELECT id FROM students WHERE email = ? OR nic = ?";
    if ($stmt = $conn->prepare($checkQuery)) {
        $stmt->bind_param("ss", $email, $nic);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'Email or NIC already exists. Please try again with different details.';
            $stmt->close();
            header("Location: pages-add-new-student.php");
            exit();
        }
        $stmt->close();
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Database error. Please try again.';
        exit();
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert student
    $insertQuery = "INSERT INTO students (username, reg_id, nic, study_year, email, mobile, password, course_id)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    if ($stmt = $conn->prepare($insertQuery)) {
        $stmt->bind_param("sssssssi", $username, $reg_id, $nic, $study_year, $email, $mobile, $hashed_password, $course_id);
        if ($stmt->execute()) {
            $_SESSION['status'] = 'success';
            $_SESSION['message'] = 'Student account successfully created!';
            $stmt->close();
            $conn->close();
            header("Location: pages-add-new-student.php");
            exit();
        } else {
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'Failed to create account. Please try again.';
        }
        $stmt->close();
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Database error. Please try again.';
    }

    $conn->close();
}
?>
