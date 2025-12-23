<?php
session_start();
require_once "../includes/db-conn.php";

// Helper function to redirect with a session message
function redirectWithMsg($msg, $type = 'success') {
    $_SESSION['msg'] = "<div class='alert alert-$type alert-dismissible fade show' role='alert'>
                            $msg
                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                        </div>";
    header("Location: manage-students.php");
    exit();
}

// ====== APPROVE USER ======
if (isset($_GET['approve_id'])) {
    $user_id = intval($_GET['approve_id']);
    $sql = "UPDATE students SET status = 'active' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        redirectWithMsg("User approved successfully!", "success");
    } else {
        redirectWithMsg("Error approving user.", "danger");
    }
    $stmt->close();
}

// ====== DISABLE USER ======
if (isset($_GET['disable_id'])) {
    $user_id = intval($_GET['disable_id']);
    $sql = "UPDATE students SET status = 'disabled' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        redirectWithMsg("User disabled successfully!", "warning");
    } else {
        redirectWithMsg("Error disabling user.", "danger");
    }
    $stmt->close();
}

// ====== DELETE USER ======
if (isset($_GET['delete_id'])) {
    $user_id = intval($_GET['delete_id']);
    $sql = "DELETE FROM students WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        redirectWithMsg("User deleted successfully!", "success");
    } else {
        redirectWithMsg("Error deleting user.", "danger");
    }
    $stmt->close();
}

// ====== RESET PASSWORD ======
if (isset($_GET['reset_id'])) {
    $user_id = intval($_GET['reset_id']);
    $new_password = password_hash('00000000', PASSWORD_DEFAULT);

    $sql = "UPDATE students SET password = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_password, $user_id);

    if ($stmt->execute()) {
        redirectWithMsg("Password reset successfully to <b>00000000</b>.", "info");
    } else {
        redirectWithMsg("Error resetting password.", "danger");
    }
    $stmt->close();
}

$conn->close();
?>
