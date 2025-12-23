<?php
session_start();
require_once '../includes/db-conn.php';

// Redirect if not logged in
if (!isset($_SESSION['lecturer_id'])) {
    header("Location: ../index.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error_message'] = "Invalid request.";
    header("Location: manage-former-students-edu.php");
    exit();
}

$former_student_id = intval($_GET['id']);

// Fetch admin details
$user_id = $_SESSION['lecturer_id'];
$sql = "SELECT username, email, nic, mobile, profile_picture FROM lectures WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Fetch former student details
$sql = "SELECT * FROM former_students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $former_student_id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$student) {
    $_SESSION['error_message'] = "Student not found.";
    header("Location: manage-former-students-edu.php");
    exit();
}

// Fetch HND courses for dropdown
$course_result = $conn->query("SELECT id, name FROM hnd_courses ORDER BY name ASC");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $reg_id = trim($_POST['reg_id']);
    $nic = strtoupper(trim($_POST['nic']));
    $mobile = trim($_POST['mobile']);
    $study_year = intval($_POST['study_year']);
    $course_id = intval($_POST['course_id']);

    if (!$username || !$email || !$reg_id || !$nic || !$mobile || !$study_year || !$course_id) {
        $_SESSION['error_message'] = "All fields are required!";
        header("Location: edit-former-student.php?id=$former_student_id");
        exit();
    }

    // Update former student details
    $sql = "UPDATE former_students SET username=?, email=?, reg_id=?, nic=?, mobile=?, study_year=?, course_id=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssiii", $username, $email, $reg_id, $nic, $mobile, $study_year, $course_id, $former_student_id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Former student details updated successfully!";
        $stmt->close();
        header("Location: manage-former-students-edu.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error updating student details: " . $stmt->error;
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Former Student - EduWide</title>
<?php include_once("../includes/css-links-inc.php"); ?>
</head>
<body>
<?php include_once("../includes/header.php"); ?>
<?php include_once("../includes/lectures-sidebar.php"); ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Edit Former Student</h1>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Former Student Details</h5>

                        <?php if (isset($_SESSION['error_message'])): ?>
                            <div class="alert alert-danger"><?= $_SESSION['error_message']; ?></div>
                            <?php unset($_SESSION['error_message']); ?>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['success_message'])): ?>
                            <div class="alert alert-success"><?= $_SESSION['success_message']; ?></div>
                            <?php unset($_SESSION['success_message']); ?>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($student['username']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($student['email']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="reg_id" class="form-label">Reg ID</label>
                                <input type="text" class="form-control" id="reg_id" name="reg_id" value="<?= htmlspecialchars($student['reg_id']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="nic" class="form-label">NIC</label>
                                <input type="text" class="form-control" id="nic" name="nic" value="<?= htmlspecialchars($student['nic']); ?>" oninput="this.value=this.value.toUpperCase();" required>
                            </div>

                            <div class="mb-3">
                                <label for="mobile" class="form-label">Mobile</label>
                                <input type="text" class="form-control" id="mobile" name="mobile" value="<?= htmlspecialchars($student['mobile']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="study_year" class="form-label">Study Year</label>
                                <input type="number" class="form-control" id="study_year" name="study_year" value="<?= htmlspecialchars($student['study_year']); ?>" min="2000" max="<?= date('Y') + 2 ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="course_id" class="form-label">HND Course</label>
                                <select class="form-control" id="course_id" name="course_id" required>
                                    <option value="" disabled>-- Select Course --</option>
                                    <?php while ($course = $course_result->fetch_assoc()): ?>
                                        <option value="<?= $course['id']; ?>" <?= ($student['course_id'] == $course['id']) ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($course['name']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success">Update</button>
                            <a href="manage-former-students-edu.php" class="btn btn-danger">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include_once("../includes/footer.php"); ?>
<?php include_once("../includes/js-links-inc.php"); ?>
</body>
</html>
