<?php
session_start();
require_once '../includes/db-conn.php';

// Redirect if not logged in
if (!isset($_SESSION['lecturer_id'])) {
    header("Location: ../index.php");
    exit();
}

// Fetch admin details
$user_id = $_SESSION['lecturer_id'];
$stmt = $conn->prepare("SELECT username, email, nic, mobile, profile_picture FROM lectures WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Handle Reset Password request
if (isset($_GET['reset_id'])) {
    $reset_id = intval($_GET['reset_id']);
    $hashedPassword = password_hash('00000000', PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE former_students SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $hashedPassword, $reset_id);
    if($stmt->execute()){
        $_SESSION['flash_message'] = "Password reset successfully!";
        $_SESSION['flash_type'] = "success";
    } else {
        $_SESSION['flash_message'] = "Error resetting password.";
        $_SESSION['flash_type'] = "danger";
    }
    $stmt->close();
    header("Location: manage-former-students-edu.php");
    exit();
}

// Fetch filtering parameters
$search = $_GET['search'] ?? '';
$study_year = $_GET['study_year'] ?? '';
$status = $_GET['status'] ?? '';
$course_id = $_GET['course_id'] ?? '';

// Fetch all courses
$coursesResult = $conn->query("SELECT id, name FROM hnd_courses ORDER BY name ASC");

// Build SQL query
$sql = "SELECT fs.*, hc.name AS course_name
        FROM former_students fs
        LEFT JOIN hnd_courses hc ON fs.course_id = hc.id
        WHERE 1";

if ($search !== '') {
    $sql .= " AND (fs.username LIKE '%$search%' OR fs.reg_id LIKE '%$search%')";
}
if ($study_year !== '') {
    $sql .= " AND fs.study_year = '$study_year'";
}
if ($status !== '') {
    $sql .= " AND fs.status = '$status'";
}
if ($course_id !== '') {
    $sql .= " AND fs.course_id = '$course_id'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Manage Former Students - EduWide</title>
    <?php include_once("../includes/css-links-inc.php"); ?>
</head>
<body>
    <?php include_once("../includes/header.php"); ?>
    <?php include_once("../includes/lectures-sidebar.php"); ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Manage Former Students</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">Pages</li>
                    <li class="breadcrumb-item active">Manage Former Students</li>
                </ol>
            </nav>
        </div>

        <!-- Flash Message -->
        <?php if(isset($_SESSION['flash_message'])): ?>
            <div class="alert alert-<?= $_SESSION['flash_type'] ?? 'success' ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['flash_message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php
            unset($_SESSION['flash_message']);
            unset($_SESSION['flash_type']);
        endif;
        ?>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <!-- Filters -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <form method="GET" action="">
                                <div class="row g-2">
                                    <div class="col-md-3">
                                        <input type="text" name="search" class="form-control" placeholder="Search by Name or Reg ID" value="<?= htmlspecialchars($search) ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="study_year" class="form-select">
                                            <option value="">All Years</option>
                                            <?php
                                            $current_year = date("Y");
                                            for ($year = 2000; $year <= $current_year + 2; $year++) {
                                                $selected = ($study_year == "$year") ? 'selected' : '';
                                                echo "<option value='$year' $selected>Year $year</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status" class="form-select">
                                            <option value="">All Status</option>
                                            <option value="active" <?= ($status == 'active') ? 'selected' : '' ?>>Active</option>
                                            <option value="pending" <?= ($status == 'pending') ? 'selected' : '' ?>>Pending</option>
                                            <option value="disabled" <?= ($status == 'disabled') ? 'selected' : '' ?>>Disabled</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="course_id" class="form-select">
                                            <option value="">All Courses</option>
                                            <?php while ($course = $coursesResult->fetch_assoc()): ?>
                                                <option value="<?= $course['id'] ?>" <?= ($course_id == $course['id']) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($course['name']) ?>
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Students Table -->
                    <div class="card">
                        <div class="card-body">
                            <table class="table datatable table-bordered align-middle text-center">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Profile</th>
                                        <th>Username</th>
                                        <th>Reg ID</th>
                                        <th>NIC</th>
                                        <th>Study Year</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Course</th>
                                        <th>Now Status</th>
                                        <th>Status</th>
                                        <th>Approve</th>
                                        <th>Disable</th>
                                        <th>Delete</th>
                                        <th>Edit</th>
                                        <th>Profile</th>
                                        <th>Reset Password</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($result->num_rows > 0): ?>
                                        <?php while ($row = $result->fetch_assoc()):
                                            $statusVal = strtolower($row['status']);
                                            $isApproved = ($statusVal === 'active' || $statusVal === 'approved');
                                            $isDisabled = ($statusVal === 'disabled');
                                        ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['id']) ?></td>
                                            <td>
                                                <img src="../oddstudents/<?= htmlspecialchars($row['profile_picture'] ?: 'default.png') ?>" width="150" 
                                                     onerror="this.src='../oddstudents/default.png'">
                                            </td>
                                            <td><?= htmlspecialchars($row['username']) ?></td>
                                            <td><?= htmlspecialchars($row['reg_id']) ?></td>
                                            <td><?= htmlspecialchars($row['nic']) ?></td>
                                            <td><?= htmlspecialchars($row['study_year']) ?></td>
                                            <td><?= htmlspecialchars($row['email']) ?></td>
                                            <td><?= htmlspecialchars($row['mobile']) ?></td>
                                            <td><?= htmlspecialchars($row['course_name']) ?></td>
                                            <td><?= htmlspecialchars($row['nowstatus']) ?></td>
                                            <td>
                                                <?php
                                                if ($isApproved) echo "<span class='btn btn-success btn-sm w-100'>Approved</span>";
                                                elseif ($isDisabled) echo "<span class='btn btn-danger btn-sm w-100'>Disabled</span>";
                                                elseif ($statusVal === 'pending') echo "<span class='btn btn-warning btn-sm w-100'>Pending</span>";
                                                else echo "<span class='btn btn-secondary btn-sm w-100'>" . ucfirst(htmlspecialchars($row['status'])) . "</span>";
                                                ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-success btn-sm w-100 approve-btn" data-id="<?= htmlspecialchars($row['id']) ?>" 
                                                    <?= $isApproved ? 'disabled style="opacity:0.5;"' : '' ?>>Approve</button>
                                            </td>
                                            <td>
                                                <button class="btn btn-warning btn-sm w-100 disable-btn" data-id="<?= htmlspecialchars($row['id']) ?>" 
                                                    <?= $isDisabled ? 'disabled style="opacity:0.5;"' : '' ?>>Disable</button>
                                            </td>
                                            <td>
                                                <button class="btn btn-danger btn-sm w-100 delete-btn" data-id="<?= htmlspecialchars($row['id']) ?>">Delete</button>
                                            </td>
                                            <td>
                                                <a href="edit-former_student.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-primary btn-sm w-100">Edit</a>
                                            </td>
                                            <td>
                                                <a href="former-student-profile.php?former_student_id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-primary btn-sm w-100">Profile</a>
                                            </td>
                                            <td>
                                                <button class="btn btn-secondary btn-sm w-100 reset-btn" data-id="<?= htmlspecialchars($row['id']) ?>">Reset Password</button>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="17" class="text-center">No students found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <?php include_once("../includes/footer.php"); ?>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <?php include_once("../includes/js-links-inc.php"); ?>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const approveButtons = document.querySelectorAll('.approve-btn');
        const disableButtons = document.querySelectorAll('.disable-btn');
        const deleteButtons = document.querySelectorAll('.delete-btn');
        const resetButtons = document.querySelectorAll('.reset-btn');

        approveButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.getAttribute('data-id');
                window.location.href = `process-former-students-edu.php?approve_id=${id}`;
            });
        });

        disableButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.getAttribute('data-id');
                window.location.href = `process-former-students-edu.php?disable_id=${id}`;
            });
        });

        deleteButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.getAttribute('data-id');
                if (confirm('Are you sure you want to delete this student?')) {
                    window.location.href = `process-former-students-edu.php?delete_id=${id}`;
                }
            });
        });

        resetButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.getAttribute('data-id');
                if (confirm("Are you sure you want to reset this student's password?")) {
                    window.location.href = `manage-former-students-edu.php?reset_id=${id}`;
                }
            });
        });
    });
    </script>

</body>
</html>

<?php $conn->close(); ?>
