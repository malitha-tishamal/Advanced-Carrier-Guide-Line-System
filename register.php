<?php
// Start session to store success/error messages
session_start();

// Include database connection
include_once("includes/db-conn.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form inputs and sanitize them
    $username    = trim($_POST['username']);
    $reg_id      = trim($_POST['reg_id']);
    $raw_nic     = trim($_POST['nic']);
    $study_year  = trim($_POST['study_year']);
    $email       = trim($_POST['email']);
    $raw_mobile  = trim($_POST['mobile']);
    $password    = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $course_id   = $_POST['course_id']; 

    // Encrypt Sensitive PII for database storage
    $nic = SecureShield::encryptData($raw_nic);
    $mobile = SecureShield::encryptData($raw_mobile);

    // Check for duplicate Email (Fast Index Check)
    $emailCheck = $conn->prepare("SELECT id FROM students WHERE email = ?");
    $emailCheck->bind_param("s", $email);
    $emailCheck->execute();
    if ($emailCheck->get_result()->num_rows > 0) {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Email already exists. Please try again with a different email.';
        header("Location: pages-signup.php");
        exit();
    }
    
    // Check for duplicate NIC (Secure Iterative Decryption Check)
    $nicCheck = $conn->query("SELECT id, nic FROM students");
    $duplicate_nic = false;
    while($row = $nicCheck->fetch_assoc()) {
        if(SecureShield::decryptData($row['nic']) === $raw_nic) {
            $duplicate_nic = true;
            break;
        }
    }

    if ($duplicate_nic) {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'NIC already exists in our system. Please try again.';
        header("Location: pages-signup.php");
        exit();
    }

    // Prepare SQL query to insert student data into the database
    $query = "INSERT INTO students (username, reg_id, nic, study_year, email, mobile, password, course_id) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ssssssss", $username, $reg_id, $nic, $study_year, $email, $mobile, $password, $course_id);

        if ($stmt->execute()) {
            $_SESSION['status'] = 'success';
            $_SESSION['message'] = 'Student account successfully created!';
            header("Location: pages-signup.php");
            exit();
        } else {
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'Failed to create account. Please try again.';
            header("Location: pages-signup.php");
            exit();
        }

        $stmt->close();
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Database error. Please try again.';
        header("Location: pages-signup.php");
        exit();
    }
}
?>
