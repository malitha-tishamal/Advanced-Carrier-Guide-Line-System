<?php
session_start();
require_once '../includes/db-conn.php';

if (!isset($_SESSION['lecturer_id'])) {
    header("Location: ../index.php");
    exit();
}

// Fetch admin
$user_id = $_SESSION['lecturer_id'];
$stmt = $conn->prepare("SELECT * FROM lectures WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Handle AJAX requests
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action === 'fetch') {
        $semester = $_GET['semester'] ?? '';
        $course = $_GET['course'] ?? '';
        $search = $_GET['search'] ?? '';

        $sql = "SELECT * FROM subjects WHERE 1=1";
        $params = [];
        $types = "";

        if ($semester !== '') {
            $sql .= " AND semester = ?";
            $params[] = $semester;
            $types .= "s";
        }

        if ($course !== '') {
            $sql .= " AND course = ?";
            $params[] = $course;
            $types .= "s";
        }

        if ($search !== '') {
            $sql .= " AND name LIKE ?";
            $params[] = "%" . $search . "%";
            $types .= "s";
        }

        $sql .= " ORDER BY semester ASC, course ASC";

        $stmt = $conn->prepare($sql);
        if ($params) $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();

        echo '<table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Course</th>
                        <th>Code</th>
                        <th>Semester</th>
                        <th>Name</th>
                        <th>Description</th>
                        
                    </tr>
                </thead>
                <tbody>';
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['course']}</td>
                        <td>{$row['code']}</td>
                        <td>{$row['semester']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['description']}</td>
                        
                    </tr>";
            }
        } else {
            echo '<tr><td colspan="8">No subjects found.</td></tr>';
        }
        echo '</tbody></table>';
        exit();
    }

    if ($action === 'delete' && isset($_POST['id'])) {
        $id = intval($_POST['id']);
        $stmt = $conn->prepare("DELETE FROM subjects WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) echo "success";
        else echo "error";
        $stmt->close();
        exit();
    }
}

// Fetch semesters
$semesters = $conn->query("SELECT DISTINCT semester FROM subjects ORDER BY semester ASC");

// Fetch courses
$courses = $conn->query("SELECT DISTINCT course FROM subjects ORDER BY course ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Courses</title>
<?php include_once("../includes/css-links-inc.php"); ?>
</head>
<body>
<?php include_once("../includes/header.php") ?>
<?php include_once("../includes/lectures-sidebar.php") ?>

<main id="main" class="main">
<div class="pagetitle">
    <h1>Courses</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="">Home</a></li>
            <li class="breadcrumb-item">Courses</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="d-flex mb-3">
        <select id="semesterFilter" class="form-select w-25 me-2">
            <option value="">All Semesters</option>
            <?php while ($row = $semesters->fetch_assoc()) { ?>
                <option value="<?= htmlspecialchars($row['semester']) ?>"><?= htmlspecialchars($row['semester']) ?></option>
            <?php } ?>
        </select>

        <select id="courseFilter" class="form-select w-25 me-2">
            <option value="">All Courses</option>
            <?php while ($row = $courses->fetch_assoc()) { ?>
                <option value="<?= htmlspecialchars($row['course']) ?>"><?= htmlspecialchars($row['course']) ?></option>
            <?php } ?>
        </select>

        <input type="text" id="searchInput" class="form-control w-50" placeholder="Search subjects...">
    </div>

    <div id="subjectsTable"></div>
</section>
</main>

<?php include_once("../includes/footer.php") ?>
<?php include_once("../includes/js-links-inc.php") ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {

    function loadSubjects() {
        $.get("<?= $_SERVER['PHP_SELF']; ?>", {
            action: "fetch",
            semester: $("#semesterFilter").val(),
            course: $("#courseFilter").val(),
            search: $("#searchInput").val()
        }, function(data){
            $("#subjectsTable").html(data);
        });
    }

    loadSubjects();

    $("#semesterFilter, #courseFilter").on("change", loadSubjects);
    $("#searchInput").on("keyup", loadSubjects);

    $("#subjectsTable").on("click", ".delete-btn", function () {
        let id = $(this).data("id");
        if(confirm("Are you sure you want to delete this subject?")) {
            $.post("<?= $_SERVER['PHP_SELF']; ?>?action=delete", {id: id}, function(response){
                if(response === "success") loadSubjects();
                else alert("Error deleting subject.");
            });
        }
    });

});
</script>
</body>
</html>

<?php $conn->close(); ?>
