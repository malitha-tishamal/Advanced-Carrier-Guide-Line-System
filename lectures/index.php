<?php
session_start();
require_once '../includes/db-conn.php';

// Redirect if not logged in
if (!isset($_SESSION['lecturer_id'])) {
    header("Location: ../index.php");
    exit();
}

// Fetch user details
$user_id = $_SESSION['lecturer_id'];
$sql = "SELECT * FROM lectures WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$query = "
    SELECT id, username, nic, email, mobile, linkedin, blog, github, facebook, profile_picture 
    FROM lectures
";
$result = mysqli_query($conn, $query);
$lecturers = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Fetch subjects for each lecturer
$subjects_query = "
    SELECT s.id, s.name, s.code
    FROM subjects s
    JOIN lectures_assignment la ON s.id = la.subject_id
    WHERE la.lecturer_id = ?
";
// Fetch all students
$query = "SELECT id, username, nic, email, mobile, linkedin, blog, github, facebook, profile_picture FROM students"; 
$result = mysqli_query($conn, $query); 
$students = mysqli_fetch_all($result, MYSQLI_ASSOC); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Home - EduWide</title>

    <?php include_once("../includes/css-links-inc.php"); ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style type="text/css">

.card.lecturer-card {
    border: none;
    border-radius: 15px;
    overflow: hidden;
    background: #fff;
    transition: transform 0.3s ease;
}

.card.lecturer-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}

.card-img-wrapper {
    height: 200px;
    overflow: hidden;
    position: relative;
}

.card-img-top {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    border: 5px solid rgba(13, 110, 253, 1);
    object-fit: cover;
}

.card-body {
    text-align: left;
}

.card-title {
    font-size: 0.9rem;
    font-weight: bold;
}

.card-text {
    font-size: 0.9rem;
    color: #555;
}

.social-links a {
    margin: 0 10px;
    font-size: 1.5rem;
    color: #555;
    transition: color 0.3s ease;
}

.social-links a:hover {
    color: #007bff;
}

.social-links i {
    transition: transform 0.2s ease;
}

.social-links a:hover i {
    transform: scale(1.2);
}

ul.list-unstyled li {
    font-size: 1rem;
    color: #333;
    display: flex;
    align-items: center;
    margin-bottom: 5px;
}

ul.list-unstyled li i {
    margin-right: 8px;
    color: #007bff;
}

    </style>
</head>
<body>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Lecture Dashbord</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item"><a href="">Dashbord</a></li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <?php include_once("../includes/header.php") ?>
                            <?php include_once("../includes/lectures-sidebar.php") ?>

   
                        <section class="section">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-title">Recent Login Activities</div>
                                        <div class="card-body"> 
                                            <!-- Recently Logged-In Lecturers -->
                                            <?php
                                            $recent_lecturers_query = "SELECT * FROM lectures ORDER BY last_login DESC LIMIT 20";
                                            $recent_lecturers_result = $conn->query($recent_lecturers_query);
                                            ?>
                                            <div class="container mt-2">
                                                <h4 class="mb-2">Recently Logged-In Lecturers</h4>
                                                <div class="row">
                                                    <?php while ($lecturer = $recent_lecturers_result->fetch_assoc()): ?>
                                                        <div class="col-md-4 col-lg-3">
                                                            <div class="card mini-card shadow-lg">
                                                                <div class="d-flex align-items-center p-2">
                                                                    <img src="<?php echo $lecturer['profile_picture']; ?>" 
                                                                         alt="Profile Picture"
                                                                         class="rounded-circle me-2"
                                                                         style="width: 80px; height: 80px; object-fit: cover;"
                                                                         onerror="this.onerror=null;this.src='uploads/profile_pictures/default.jpg';">
                                                                    <div>
                                                                        <h6 class="mb-0"><?php echo $lecturer['username']; ?></h6>
                                                                        <small class="text-muted">
                                                                            <?php 
                                                                            if (!empty($lecturer['last_login'])) {
                                                                                echo "Last login: " . date("M d, Y h:i A", strtotime($lecturer['last_login']));
                                                                            } else {
                                                                                echo "Last login: N/A";
                                                                            }
                                                                            ?>
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endwhile; ?>
                                                </div>
                                            </div>

                                            <!-- Recently Logged-In Students -->
                                            <?php 
                                            $recent_students_query = "SELECT * FROM students ORDER BY last_login DESC LIMIT 25";
                                            $recent_students_result = $conn->query($recent_students_query);
                                            ?>
                                            <div class="container mt-2">
                                                <h4 class="mb-2">Recently Logged-In Students</h4>
                                                <div class="row">
                                                    <?php while ($student = $recent_students_result->fetch_assoc()): ?>
                                                        <div class="col-md-4 col-lg-3">
                                                            <div class="card mini-card shadow-lg">
                                                                <div class="d-flex align-items-center p-2">
                                                                    <img src="../<?php echo $student['profile_picture']; ?>" 
                                                                         alt="Profile Picture"
                                                                         class="rounded-circle me-2"
                                                                         style="width: 80px; height: 80px; object-fit: cover;"
                                                                         onerror="this.onerror=null;this.src='../uploads/profile_pictures/default.png';">
                                                                    <div>
                                                                        <h6 class="mb-0"><?php echo $student['username']; ?></h6>
                                                                        <small class="text-muted">
                                                                            <?php 
                                                                            if (!empty($student['last_login'])) {
                                                                                echo "Last login: " . date("M d, Y h:i A", strtotime($student['last_login']));
                                                                            } else {
                                                                                echo "Last login: N/A";
                                                                            }
                                                                            ?>
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endwhile; ?>
                                                </div>
                                            </div>

                                            <!-- Recently Logged-In Former Students -->
                                            <?php
                                            $recent_former_students_query = "SELECT * FROM former_students ORDER BY last_login DESC LIMIT 25";
                                            $recent_former_students_result = $conn->query($recent_former_students_query);
                                            ?>
                                            <div class="container mt-2">
                                                <h4 class="mb-2">Recently Logged-In Former Students</h4>
                                                <div class="row">
                                                    <?php while ($former_student = $recent_former_students_result->fetch_assoc()): ?>
                                                        <div class="col-md-4 col-lg-3">
                                                            <div class="card mini-card shadow-lg">
                                                                <div class="d-flex align-items-center p-2">
                                                                    <img src="../oddstudents/<?php echo $former_student['profile_picture']; ?>" 
                                                                         alt="Profile Picture"
                                                                         class="rounded-circle me-2"
                                                                         style="width: 80px; height: 80px; object-fit: cover;"
                                                                         onerror="this.onerror=null;this.src='../oddstudents/uploads/profile_pictures/default.png';">
                                                                    <div>
                                                                        <h6 class="mb-0"><?php echo $former_student['username']; ?></h6>
                                                                        <small class="text-muted">
                                                                            <?php 
                                                                            if (!empty($former_student['last_login'])) {
                                                                                echo "Last login: " . date("M d, Y h:i A", strtotime($former_student['last_login']));
                                                                            } else {
                                                                                echo "Last login: N/A";
                                                                            }
                                                                            ?>
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endwhile; ?>
                                                </div>
                                            </div>

                                            <style>
                                                .mini-card {
                                                    border-radius: 12px;
                                                    transition: transform 0.2s;
                                                    background-color: #f8f9fa;
                                                    margin-bottom: 10px;
                                                }

                                                .mini-card:hover {
                                                    transform: scale(1.02);
                                                    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.08);
                                                }
                                            </style>
 
                                
                                        </div>
                                    </div>
                                </div>
                            </section>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <?php include_once("../includes/footer.php") ?>
    <?php include_once("../includes/js-links-inc.php") ?>
</body>
</html>
