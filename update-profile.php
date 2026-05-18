<?php
session_start();
require_once 'includes/db-conn.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // CSRF Protection Validation
    if (!isset($_POST['csrf_token']) || !SecureShield::verifyCSRFToken($_POST['csrf_token'])) {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Security validation failed. Cross-Site Request Forgery (CSRF) detected.';
        header("Location: user-profile.php");
        exit();
    }

    if (!isset($_SESSION['student_id'])) {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Unauthorized access!';
        header("Location: user-profile.php");
        exit();
    }

    $user_id = $_SESSION['student_id'];
    $username = trim($_POST['username']);
    $reg_id = trim($_POST['reg_id']);
    $study_year = trim($_POST['study_year']);
    $email = trim($_POST['email']);
    
    // Encrypt sensitive Personal Identifiable Information (PII) before database storage
    $nic = SecureShield::encryptData(trim($_POST['nic']));
    $mobile = SecureShield::encryptData(trim($_POST['mobile']));
    
    $course_id = isset($_POST['course_id']) ? (int)$_POST['course_id'] : null;

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Invalid email format!';
        header("Location: user-profile.php");
        exit();
    }

    try {
        // Secure Parameterized Database Update via PDO
        $sql = "UPDATE students SET username = :username, reg_id = :reg_id, study_year = :study_year, email = :email, nic = :nic, mobile = :mobile, course_id = :course_id WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'username' => $username,
            'reg_id' => $reg_id,
            'study_year' => $study_year,
            'email' => $email,
            'nic' => $nic,
            'mobile' => $mobile,
            'course_id' => $course_id,
            'id' => $user_id
        ]);
        
        $_SESSION['status'] = 'success';
        $_SESSION['message'] = 'Profile updated successfully with advanced AES-256-GCM encryption!';
    } catch (PDOException $e) {
        error_log("Secure profile update failed: " . $e->getMessage());
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Failed to secure profile details!';
    }

    // Redirect back to profile page
    header("Location: user-profile.php");
    exit();
}
?>
