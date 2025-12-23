<?php
session_start();
require_once "../includes/db-conn.php";

// Function to set session message and redirect
function redirectWithMessage($message, $type = 'success') {
    $_SESSION['flash_message'] = $message;
    $_SESSION['flash_type'] = $type;
    header("Location: manage-former-students-edu.php");
    exit();
}

// Approve user
if (isset($_GET['approve_id'])) {
    $user_id = intval($_GET['approve_id']);
    $sql = "UPDATE former_students SET status = 'approved' WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            redirectWithMessage("User approved successfully!");
        } else {
            redirectWithMessage("Error approving user.", "danger");
        }
        $stmt->close();
    }
}

// Disable user
if (isset($_GET['disable_id'])) {
    $user_id = intval($_GET['disable_id']);
    $sql = "UPDATE former_students SET status = 'disabled' WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            redirectWithMessage("User disabled successfully!");
        } else {
            redirectWithMessage("Error disabling user.", "danger");
        }
        $stmt->close();
    }
}

// Delete user
if (isset($_GET['delete_id'])) {
    $user_id = intval($_GET['delete_id']);
    $sql = "DELETE FROM former_students WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            redirectWithMessage("User deleted successfully!");
        } else {
            redirectWithMessage("Error deleting user.", "danger");
        }
        $stmt->close();
    }
}

// Reset user password
if (isset($_GET['reset_id'])) {
    $user_id = intval($_GET['reset_id']);
    $new_password = password_hash('00000000', PASSWORD_DEFAULT);
    $sql = "UPDATE former_students SET password = ? WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("si", $new_password, $user_id);
        if ($stmt->execute()) {
            redirectWithMessage("User password reset successfully!");
        } else {
            redirectWithMessage("Error resetting password.", "danger");
        }
        $stmt->close();
    }
}

$conn->close();
?>
