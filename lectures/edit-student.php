<?php
session_start();
require_once '../includes/db-conn.php';

// Redirect if not logged in
if (!isset($_SESSION['lecturer_id'])) {
    header("Location: ../index.php");
    exit();
}

// Validate student ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error_message'] = "Invalid request.";
    header("Location: manage-students.php");
    exit();
}

$student_id = intval($_GET['id']);

// Fetch admin details (optional)
$user_id = $_SESSION['lecturer_id'];
$sql = "SELECT username, email, nic, mobile, profile_picture FROM lectures WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Fetch student details
$sql = "SELECT * FROM students WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$student) {
    $_SESSION['error_message'] = "Student not found.";
    header("Location: manage-students.php");
    exit();
}

// Fetch HND courses for dropdown
$course_result = $conn->query("SELECT id, name FROM hnd_courses ORDER BY name ASC");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $nic = strtoupper(trim($_POST['nic']));
    $mobile = trim($_POST['mobile']);
    $study_year = intval($_POST['study_year']);
    $course_id = intval($_POST['course_id']);

    if (!$username || !$email || !$nic || !$mobile || !$study_year || !$course_id) {
        $_SESSION['error_message'] = "All fields are required and must be valid!";
        header("Location: edit-student.php?id=$student_id");
        exit();
    }

    // Validate mobile (9 digits) and NIC
    if (!preg_match('/^\d{9}$/', $mobile)) {
        $_SESSION['error_message'] = "Mobile number must be 9 digits without +94.";
        header("Location: edit-student.php?id=$student_id");
        exit();
    }
    if (!preg_match('/^[0-9]{9}[VvXx]$/', $nic)) {
        $_SESSION['error_message'] = "NIC format is invalid.";
        header("Location: edit-student.php?id=$student_id");
        exit();
    }

    // Update student details
    $sql = "UPDATE students SET username=?, email=?, nic=?, mobile=?, study_year=?, course_id=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssiii", $username, $email, $nic, $mobile, $study_year, $course_id, $student_id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Student details updated successfully!";
        $stmt->close();
        header("Location: manage-students.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error updating student details: " . $stmt->error;
        $stmt->close();
        header("Location: edit-student.php?id=$student_id");
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Student - EduWide</title>
<?php include_once("../includes/css-links-inc.php"); ?>
</head>
<body>
<?php include_once("../includes/header.php"); ?>
<?php include_once("../includes/lectures-sidebar.php"); ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Edit Student</h1>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Student Details</h5>

                        <?php if (isset($_SESSION['error_message'])): ?>
                            <div class='alert alert-danger'><?= $_SESSION['error_message']; ?></div>
                            <?php unset($_SESSION['error_message']); ?>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['success_message'])): ?>
                            <div class='alert alert-success'><?= $_SESSION['success_message']; ?></div>
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
                                <label for="nic" class="form-label">NIC</label>
                                <input type="text" class="form-control" id="nic" name="nic" value="<?= htmlspecialchars($student['nic']); ?>" oninput="this.value=this.value.toUpperCase();" required>
                            </div>

                            <div class="mb-3">
                                <label for="mobile" class="form-label">Mobile</label>
                                <input type="text" class="form-control" id="mobile" name="mobile" value="<?= htmlspecialchars($student['mobile']); ?>" required>
                                <small class="text-muted">Format: 712345678 (without +94)</small>
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
                            <a href="manage-students.php" class="btn btn-danger">Cancel</a>
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
