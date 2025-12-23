<?php
require_once '../includes/db-conn.php';
session_start();

// Get former student ID from URL
if (!isset($_GET['former_student_id'])) {
    echo "Invalid profile!";
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

$student_id = intval($_GET['former_student_id']);

// Fetch student basic info
$sql = "SELECT * FROM former_students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
$stmt->close();

if (!$student) { 
    echo "Profile not found.";
    exit();
}

// Fetch education
$edu_sql = "SELECT * FROM education WHERE user_id = ? ORDER BY id DESC";
$stmt = $conn->prepare($edu_sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$education = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Fetch work experience
$work_sql = "SELECT * FROM experiences WHERE user_id = ? ORDER BY id DESC";
$stmt = $conn->prepare($work_sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$experiences = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Fetch summary
$summary_sql = "SELECT summary FROM summaries WHERE user_id = ? ORDER BY created_at DESC LIMIT 1";
$stmt = $conn->prepare($summary_sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$summary_result = $stmt->get_result();
$summary = $summary_result->fetch_assoc()['summary'] ?? '';
$stmt->close();

// Fetch about section
$about_sql = "SELECT about_text FROM about WHERE user_id = ? LIMIT 1";
$stmt = $conn->prepare($about_sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$about_result = $stmt->get_result();
$about = $about_result->fetch_assoc()['about_text'] ?? '';
$stmt->close();

// Fetch achievements
$achievements_sql = "SELECT * FROM former_students_achievements WHERE former_student_id = ? ORDER BY event_date DESC";
$stmt = $conn->prepare($achievements_sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$achievements = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Fetch certifications
$certifications_sql = "SELECT * FROM former_students_certifications WHERE former_student_id = ? ORDER BY date DESC";
$stmt = $conn->prepare($certifications_sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$certifications = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Fetch projects with images and links count
$projects_sql = "
    SELECT p.*, 
           COUNT(DISTINCT pp.id) as image_count, 
           COUNT(DISTINCT pl.id) as link_count
    FROM former_student_projects p 
    LEFT JOIN former_student_project_photos pp ON p.id = pp.project_id 
    LEFT JOIN former_student_project_links pl ON p.id = pl.project_id 
    WHERE p.student_id = ? 
    GROUP BY p.id 
    ORDER BY p.created_at DESC
";
$stmt = $conn->prepare($projects_sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$projects_result = $stmt->get_result();
$projects = $projects_result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Fetch skills from all relevant tables
$skills_sql = "
    SELECT s.skill_name, s.category
    FROM former_student_skills fs
    JOIN (
        SELECT id, skill_name, 'Business Finance' AS category FROM business_finance_skills
        UNION ALL
        SELECT id, skill_name, 'Engineering' AS category FROM engineering_skills
        UNION ALL
        SELECT id, skill_name, 'HND Accountancy' AS category FROM hnd_accountancy_skills
        UNION ALL
        SELECT id, skill_name, 'HND Agriculture' AS category FROM hnd_agriculture_skills
        UNION ALL
        SELECT id, skill_name, 'HND Building Services' AS category FROM hnd_building_services_skills
        UNION ALL
        SELECT id, skill_name, 'HND Business Admin' AS category FROM hnd_business_admin_skills
        UNION ALL
        SELECT id, skill_name, 'HND English' AS category FROM hnd_english_skills
        UNION ALL
        SELECT id, skill_name, 'HND Food Tech' AS category FROM hnd_food_tech_skills
        UNION ALL
        SELECT id, skill_name, 'HND Management' AS category FROM hnd_management_skills
        UNION ALL
        SELECT id, skill_name, 'HND Mechanical' AS category FROM hnd_mechanical_skills
        UNION ALL
        SELECT id, skill_name, 'HND Quantity Survey' AS category FROM hnd_quantity_survey_skills
        UNION ALL
        SELECT id, skill_name, 'HND THM' AS category FROM hnd_thm_skills
        UNION ALL
        SELECT id, skill_name, 'IT' AS category FROM it_student_skills
    ) s ON fs.skill_id = s.id
    WHERE fs.student_id = ?
    ORDER BY s.category, s.skill_name
";

$stmt = $conn->prepare($skills_sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$skills_result = $stmt->get_result();
$skills = $skills_result->fetch_all(MYSQLI_ASSOC);
$stmt->close();


// Fetch course name from hnd_courses
$course_name = '';
if (!empty($student['course_id'])) {
    $course_sql = "SELECT name FROM hnd_courses WHERE id = ?";
    $stmt = $conn->prepare($course_sql);
    $stmt->bind_param("i", $student['course_id']);
    $stmt->execute();
    $course_result = $stmt->get_result();
    $course_row = $course_result->fetch_assoc();
    $course_name = $course_row['name'] ?? '';
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($student['username']) ?>'s Profile - EduWide</title>
    <?php include_once("../includes/css-links-inc.php"); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --dark-color: #1d3557;
            --light-color: #f8f9fa;
        }

        body {
            background-color: #f0f2f5;
            font-family: 'Roboto', sans-serif;
        }

        .profile-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(30deg);
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid white;
            object-fit: cover;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .stats-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .stats-number {
            font-size: 1.8rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .stats-label {
            color: #6c757d;
            font-size: 0.85rem;
        }

        .section-card {
            background: white;
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
            overflow: hidden;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--dark-color);
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 8px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title i {
            color: var(--primary-color);
        }

        .info-card {
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .info-card h5 {
            color: var(--primary-color);
            margin-bottom: 15px;
            font-weight: 600;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f8f9fa;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #495057;
        }

        .info-value {
            color: #6c757d;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 5px;
            transition: all 0.3s;
            text-decoration: none;
        }

        .social-icon:hover {
            background: white;
            color: var(--primary-color);
            transform: translateY(-3px);
        }

        .timeline-item {
            border-left: 3px solid var(--primary-color);
            padding-left: 20px;
            padding-bottom: 20px;
            position: relative;
            margin-bottom: 15px;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -8px;
            top: 5px;
            width: 14px;
            height: 14px;
            background: var(--primary-color);
            border-radius: 50%;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
            margin-bottom: 0;
        }

        .achievement-card, .certification-card {
            border: 1px solid #e9ecef;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s;
            height: 100%;
            margin-bottom: 20px;
        }

        .achievement-card:hover, .certification-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #dee2e6;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        .status-inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .contact-info {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            color: #555;
        }

        .contact-info i {
            width: 20px;
            margin-right: 10px;
            color: var(--primary-color);
        }

        /* Skills & Projects Styles */
        .skill-badge {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            margin: 5px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.85rem;
        }

        .category-badge {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 0.7rem;
            margin-left: 5px;
        }

        .project-card {
            border: 1px solid #e9ecef;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
            margin-bottom: 20px;
        }

        .project-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .project-image {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }

        .project-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
            font-size: 0.85rem;
        }

        .modal-img {
            width: 100%;
            border-radius: 8px;
        }

        .project-link-item {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-right: 15px;
            margin-bottom: 8px;
            padding: 6px 12px;
            background: #f8f9fa;
            border-radius: 6px;
            border: 1px solid #e9ecef;
        }

        .skill-category {
            background: var(--primary-color);
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            margin: 10px 0 5px 0;
            font-weight: bold;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <?php include_once("../includes/header.php") ?>
    <?php include_once("../includes/lectures-sidebar.php") ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Former Student Profile</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="manage-former-students.php">Former Students</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Profile Header -->
                    <div class="profile-header">
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center">
                                <img src="../oddstudents/<?= htmlspecialchars($student['profile_picture']) ?>" 
                                     alt="Profile Picture" 
                                     class="profile-picture"
                                     onerror="this.src='../uploads/profile_pictures/default.png'">
                            </div>
                            <div class="col-md-6 text-center text-md-start">
                                <h1 class="mb-2"><?= htmlspecialchars($student['username']) ?></h1>
                                <?php if (!empty($course_name)): ?>
                                    <p class="fs-5 mb-2">
                                        <i class="fas fa-graduation-cap me-2"></i><?= htmlspecialchars($course_name) ?>
                                    </p>
                                <?php endif; ?>
                                <?php if (!empty($summary)): ?>
                                    <p class="mb-3"><?= nl2br(htmlspecialchars($summary)) ?></p>
                                <?php endif; ?>
                                
                                <!-- Status Badge -->
                                <span class="status-badge <?= $student['status'] == 'approved' ? 'status-active' : 'status-inactive' ?>">
                                    <i class="fas fa-circle me-1" style="font-size: 0.6rem;"></i>
                                    <?= ucfirst($student['status']) ?>
                                </span>
                                
                                <!-- Social Media Links -->
                                <div class="social-links mt-3">
                                    <?php if (!empty($student['linkedin'])): ?>
                                        <a href="<?= htmlspecialchars($student['linkedin']) ?>" target="_blank" class="social-icon">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($student['facebook'])): ?>
                                        <a href="<?= htmlspecialchars($student['facebook']) ?>" target="_blank" class="social-icon">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($student['github'])): ?>
                                        <a href="<?= htmlspecialchars($student['github']) ?>" target="_blank" class="social-icon">
                                            <i class="fab fa-github"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($student['blog'])): ?>
                                        <a href="<?= htmlspecialchars($student['blog']) ?>" target="_blank" class="social-icon">
                                            <i class="fas fa-blog"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <!-- Quick Stats -->
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <div class="stats-card">
                                            <div class="stats-number"><?= count($education) ?></div>
                                            <div class="stats-label">Education</div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="stats-card">
                                            <div class="stats-number"><?= count($experiences) ?></div>
                                            <div class="stats-label">Experience</div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="stats-card">
                                            <div class="stats-number"><?= count($achievements) ?></div>
                                            <div class="stats-label">Achievements</div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="stats-card">
                                            <div class="stats-number"><?= count($certifications) ?></div>
                                            <div class="stats-label">Certifications</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="stats-card">
                                            <div class="stats-number"><?= count($projects) ?></div>
                                            <div class="stats-label">Projects</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="stats-card">
                                            <div class="stats-number"><?= count($skills) ?></div>
                                            <div class="stats-label">Skills</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="row">
                        <!-- Left Column - Personal Info -->
                        <div class="col-lg-4">
                            <!-- Personal Information -->
                            <div class="section-card">
                                <div class="card-body">
                                    <h4 class="section-title">
                                        <i class="fas fa-user-circle"></i>Personal Information
                                    </h4>
                                    <div class="info-item">
                                        <span class="info-label">Student ID:</span>
                                        <span class="info-value">#<?= htmlspecialchars($student['id']) ?></span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Username:</span>
                                        <span class="info-value"><?= htmlspecialchars($student['username']) ?></span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Registration ID:</span>
                                        <span class="info-value"><?= htmlspecialchars($student['reg_id']) ?></span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">NIC:</span>
                                        <span class="info-value"><?= htmlspecialchars($student['nic']) ?></span>
                                    </div>
                                    <?php if (!empty($course_name)): ?>
                                        <div class="info-item">
                                            <span class="info-label">Course:</span>
                                            <span class="info-value"><?= htmlspecialchars($course_name) ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="info-item">
                                        <span class="info-label">Current Status:</span>
                                        <span class="info-value"><?= ucfirst(htmlspecialchars($student['nowstatus'] ?? 'N/A')) ?></span>
                                    </div>
                                    
                                    <!-- Contact Information -->
                                    <div class="mt-4 pt-3 border-top">
                                        <h6 class="text-primary mb-3">
                                            <i class="fas fa-address-book me-2"></i>Contact Information
                                        </h6>
                                        <?php if (!empty($student['email'])): ?>
                                            <div class="info-item">
                                                <span class="info-label">Email:</span>
                                                <span class="info-value"><?= htmlspecialchars($student['email']) ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($student['mobile'])): ?>
                                            <div class="info-item">
                                                <span class="info-label">Mobile:</span>
                                                <span class="info-value"><?= htmlspecialchars($student['mobile']) ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Account Information -->
                                    <div class="mt-4 pt-3 border-top">
                                        <h6 class="text-muted mb-3">Account Information</h6>
                                        <div class="info-item">
                                            <span class="info-label">Last Login:</span>
                                            <span class="info-value">
                                                <?= $student['last_login'] ? 
                                                    date('M j, Y g:i A', strtotime($student['last_login'])) : 
                                                    'Never' ?>
                                            </span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Member Since:</span>
                                            <span class="info-value">
                                                <?= date('M j, Y', strtotime($student['created_at'])) ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Skills Section -->
                            <div class="section-card">
                                <div class="card-body">
                                    <h4 class="section-title">
                                        <i class="fas fa-code"></i>Skills
                                    </h4>
                                    <?php if (!empty($skills)): ?>
                                        <div class="mb-4">
                                            <?php
                                            $current_category = '';
                                            foreach ($skills as $skill):
                                                if ($current_category != $skill['category']):
                                                    $current_category = $skill['category'];
                                            ?>
                                                    <div class="skill-category"><?= $skill['category'] ?> Skills</div>
                                            <?php endif; ?>
                                                <span class="skill-badge">
                                                    <?= htmlspecialchars($skill['skill_name']) ?>
                                                    <span class="category-badge"><?= $skill['category'] ?></span>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="empty-state">
                                            <i class="fas fa-code"></i>
                                            <h5>No Skills Added</h5>
                                            <p>No skills have been added yet.</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Education & Activities -->
                        <div class="col-lg-8">
                            <!-- About Me Section -->
                            <?php if (!empty($about)): ?>
                                <div class="section-card">
                                    <div class="card-body">
                                        <h4 class="section-title">
                                            <i class="fas fa-user-circle"></i>About Me
                                        </h4>
                                        <p class="lead"><?= nl2br(htmlspecialchars($about)) ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Education and Work Experience Section -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="section-card">
                                        <div class="card-body">
                                            <h4 class="section-title">
                                                <i class="fas fa-graduation-cap"></i>Education
                                            </h4>
                                            <?php if (!empty($education)): ?>
                                                <div class="timeline">
                                                    <?php foreach ($education as $edu): ?>
                                                        <div class="timeline-item">
                                                            <h5 class="mb-1 text-primary"><?= htmlspecialchars($edu['school']) ?></h5>
                                                            <p class="mb-1 fw-bold"><?= htmlspecialchars($edu['degree']) ?> in <?= htmlspecialchars($edu['field_of_study']) ?></p>
                                                            <p class="mb-2 text-muted">
                                                                <i class="far fa-calendar me-1"></i>
                                                                <?= htmlspecialchars($edu['start_month']) ?> <?= htmlspecialchars($edu['start_year']) ?> - 
                                                                <?= htmlspecialchars($edu['end_month']) ?> <?= htmlspecialchars($edu['end_year']) ?>
                                                            </p>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="empty-state">
                                                    <i class="fas fa-graduation-cap"></i>
                                                    <h5>No Education History</h5>
                                                    <p>No education information has been added yet.</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="section-card">
                                        <div class="card-body">
                                            <h4 class="section-title">
                                                <i class="fas fa-briefcase"></i>Work Experience
                                            </h4>
                                            <?php if (!empty($experiences)): ?>
                                                <div class="timeline">
                                                    <?php foreach ($experiences as $exp): ?>
                                                        <div class="timeline-item">
                                                            <h5 class="mb-1 text-primary"><?= htmlspecialchars($exp['title']) ?> at <?= htmlspecialchars($exp['company']) ?></h5>
                                                            <p class="mb-1 text-muted">
                                                                <i class="fas fa-map-marker-alt me-1"></i><?= htmlspecialchars($exp['location']) ?>
                                                            </p>
                                                            <p class="mb-2 text-muted">
                                                                <i class="far fa-calendar me-1"></i>
                                                                <?= htmlspecialchars($exp['start_month']) ?> <?= htmlspecialchars($exp['start_year']) ?> - 
                                                                <?= htmlspecialchars($exp['end_month']) ?> <?= htmlspecialchars($exp['end_year']) ?>
                                                            </p>
                                                            <?php if (!empty($exp['description'])): ?>
                                                                <p class="mb-0"><?= nl2br(htmlspecialchars($exp['description'])) ?></p>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="empty-state">
                                                    <i class="fas fa-briefcase"></i>
                                                    <h5>No Work Experience</h5>
                                                    <p>No work experience has been added yet.</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Projects Section -->
                            <div class="section-card">
                                <div class="card-body">
                                    <h4 class="section-title">
                                        <i class="fas fa-project-diagram"></i>Projects
                                    </h4>
                                    <?php if (!empty($projects)): ?>
                                        <div class="row">
                                            <?php foreach ($projects as $project): ?>
                                                <div class="col-md-6 mb-4">
                                                    <div class="project-card">
                                                        <?php
                                                        // Get first project image
                                                        $image_sql = "SELECT image_path FROM former_student_project_photos WHERE project_id = ? LIMIT 1";
                                                        $img_stmt = $conn->prepare($image_sql);
                                                        $img_stmt->bind_param("i", $project['id']);
                                                        $img_stmt->execute();
                                                        $img_result = $img_stmt->get_result();
                                                        $project_image = $img_result->fetch_assoc();
                                                        $img_stmt->close();
                                                        ?>
                                                        <?php if ($project_image): ?>
                                                            <img src="../<?= htmlspecialchars($project_image['image_path']) ?>" 
                                                                 class="project-image" 
                                                                 alt="<?= htmlspecialchars($project['title']) ?>"
                                                                 data-bs-toggle="modal" 
                                                                 data-bs-target="#projectModal<?= $project['id'] ?>"
                                                                 style="cursor: pointer;">
                                                        <?php else: ?>
                                                            <div class="project-image bg-light d-flex align-items-center justify-content-center">
                                                                <i class="fas fa-project-diagram fa-3x text-muted"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                        
                                                        <div class="card-body">
                                                            <h5 class="card-title"><?= htmlspecialchars($project['title']) ?></h5>
                                                            <p class="card-text text-muted"><?= nl2br(htmlspecialchars(substr($project['description'], 0, 150))) ?>...</p>
                                                            
                                                            <div class="project-meta">
                                                                <small class="text-muted">
                                                                    <i class="far fa-calendar me-1"></i>
                                                                    <?= date('M Y', strtotime($project['start_date'])) ?>
                                                                    <?php if($project['end_date']): ?>
                                                                        - <?= date('M Y', strtotime($project['end_date'])) ?>
                                                                    <?php else: ?>
                                                                        - Present
                                                                    <?php endif; ?>
                                                                </small>
                                                                <div>
                                                                    <span class="badge bg-light text-dark me-1">
                                                                        <i class="far fa-image"></i> <?= $project['image_count'] ?>
                                                                    </span>
                                                                    <span class="badge bg-light text-dark">
                                                                        <i class="fas fa-link"></i> <?= $project['link_count'] ?>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            
                                                            <button type="button" class="btn btn-outline-primary btn-sm w-100 mt-2" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#projectModal<?= $project['id'] ?>">
                                                                View Details
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Project Modal -->
                                                <div class="modal fade" id="projectModal<?= $project['id'] ?>" tabindex="-1">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"><?= htmlspecialchars($project['title']) ?></h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p><strong>Description:</strong></p>
                                                                <p><?= nl2br(htmlspecialchars($project['description'])) ?></p>
                                                                
                                                                <p><strong>Timeline:</strong> 
                                                                    <?= date('M j, Y', strtotime($project['start_date'])) ?>
                                                                    <?php if($project['end_date']): ?>
                                                                        - <?= date('M j, Y', strtotime($project['end_date'])) ?>
                                                                    <?php else: ?>
                                                                        - Present
                                                                    <?php endif; ?>
                                                                </p>
                                                                
                                                                <!-- Project Images -->
                                                                <?php
                                                                $photos_sql = "SELECT * FROM former_student_project_photos WHERE project_id = ?";
                                                                $photos_stmt = $conn->prepare($photos_sql);
                                                                $photos_stmt->bind_param("i", $project['id']);
                                                                $photos_stmt->execute();
                                                                $photos = $photos_stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                                                                $photos_stmt->close();
                                                                ?>
                                                                <?php if (!empty($photos)): ?>
                                                                    <p><strong>Project Images:</strong></p>
                                                                    <div class="row">
                                                                        <?php foreach ($photos as $photo): ?>
                                                                            <div class="col-4 mb-3">
                                                                                <img src="../<?= htmlspecialchars($photo['image_path']) ?>" 
                                                                                     class="img-thumbnail" 
                                                                                     style="width: 100%; height: 100px; object-fit: cover; cursor: pointer;"
                                                                                     data-bs-toggle="modal" 
                                                                                     data-bs-target="#imageModal"
                                                                                     data-img="../<?= htmlspecialchars($photo['image_path']) ?>">
                                                                            </div>
                                                                        <?php endforeach; ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                                
                                                                <!-- Project Links -->
                                                                <?php
                                                                $links_sql = "SELECT * FROM former_student_project_links WHERE project_id = ?";
                                                                $links_stmt = $conn->prepare($links_sql);
                                                                $links_stmt->bind_param("i", $project['id']);
                                                                $links_stmt->execute();
                                                                $links = $links_stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                                                                $links_stmt->close();
                                                                ?>
                                                                <?php if (!empty($links)): ?>
                                                                    <p><strong>Project Links:</strong></p>
                                                                    <div class="project-links">
                                                                        <?php foreach ($links as $link): ?>
                                                                            <div class="project-link-item mb-2">
                                                                                <i class="fas fa-external-link-alt me-2 text-primary"></i>
                                                                                <strong><?= htmlspecialchars($link['link_type']) ?>:</strong>
                                                                                <a href="<?= htmlspecialchars($link['link_url']) ?>" target="_blank" class="ms-2 text-decoration-none">
                                                                                    <?= htmlspecialchars($link['link_url']) ?>
                                                                                </a>
                                                                            </div>
                                                                        <?php endforeach; ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="empty-state">
                                            <i class="fas fa-project-diagram"></i>
                                            <h5>No Projects Added</h5>
                                            <p>No projects have been added yet.</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Achievements -->
                            <?php if (!empty($achievements)): ?>
                                <div class="section-card">
                                    <div class="card-body">
                                        <h4 class="section-title">
                                            <i class="fas fa-trophy"></i>Achievements
                                        </h4>
                                        <div class="row">
                                            <?php foreach ($achievements as $ach): ?>
                                                <div class="col-md-6 mb-3">
                                                    <div class="achievement-card">
                                                        <?php if (!empty($ach['image_path']) && file_exists('../oddstudents/' . $ach['image_path'])): ?>
                                                            <img src="../oddstudents/<?= htmlspecialchars($ach['image_path']) ?>" 
                                                                 class="card-img-top" 
                                                                 alt="Achievement Image" 
                                                                 style="height: 200px; object-fit: cover;">
                                                        <?php else: ?>
                                                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                                                <i class="fas fa-trophy fa-3x text-warning"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div class="card-body">
                                                            <h5 class="card-title"><?= htmlspecialchars($ach['event_title']) ?></h5>
                                                            <p class="card-text"><strong>Event:</strong> <?= htmlspecialchars($ach['event_name']) ?></p>
                                                            <p class="card-text"><strong>Organized by:</strong> <?= htmlspecialchars($ach['organized_by']) ?></p>
                                                            <p class="card-text"><strong>Date:</strong> <?= date('M j, Y', strtotime($ach['event_date'])) ?></p>
                                                            <p class="card-text"><?= nl2br(htmlspecialchars($ach['event_description'])) ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Certifications -->
                            <?php if (!empty($certifications)): ?>
                                <div class="section-card">
                                    <div class="card-body">
                                        <h4 class="section-title">
                                            <i class="fas fa-certificate"></i>Certifications
                                        </h4>
                                        <div class="row">
                                            <?php foreach ($certifications as $cert): ?>
                                                <div class="col-md-6 mb-3">
                                                    <div class="certification-card">
                                                        <?php if (!empty($cert['image_path']) && file_exists('../oddstudents/' . $cert['image_path'])): ?>
                                                            <img src="../oddstudents/<?= htmlspecialchars($cert['image_path']) ?>" 
                                                                 class="card-img-top" 
                                                                 alt="Certification Image" 
                                                                 style="height: 200px; object-fit: cover;">
                                                        <?php else: ?>
                                                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                                                <i class="fas fa-certificate fa-3x text-warning"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div class="card-body">
                                                            <h5 class="card-title"><?= htmlspecialchars($cert['certification_name']) ?></h5>
                                                            <p class="card-text"><strong>Issued by:</strong> <?= htmlspecialchars($cert['issued_by']) ?></p>
                                                            <p class="card-text"><strong>Date:</strong> <?= date('M j, Y', strtotime($cert['date'])) ?></p>
                                                            <?php if (!empty($cert['link'])): ?>
                                                                <p class="card-text">
                                                                    <strong>Link:</strong> 
                                                                    <a href="<?= htmlspecialchars($cert['link']) ?>" target="_blank" class="text-decoration-none">View Certificate</a>
                                                                </p>
                                                            <?php endif; ?>
                                                            <p class="card-text"><?= nl2br(htmlspecialchars($cert['certification_description'])) ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Back Button -->
                    <div class="text-center mt-4">
                        <a href="manage-former-students.php" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Former Students List
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Project Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="Project Image" class="modal-img">
                </div>
            </div>
        </div>
    </div>

    <?php include_once("../includes/footer.php") ?>
    <?php include_once("../includes/js-links-inc.php") ?>

    <script>
        // Image modal functionality
        const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
        const modalImage = document.getElementById('modalImage');
        
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('img-thumbnail') && e.target.hasAttribute('data-img')) {
                modalImage.src = e.target.getAttribute('data-img');
            }
        });

        // Add any JavaScript functionality here if needed
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Former student profile page loaded');
        });
    </script>
</body>
</html>

<?php $conn->close(); ?>