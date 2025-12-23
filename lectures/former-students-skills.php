<?php
session_start();
require_once '../includes/db-conn.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Redirect if not logged in
if (!isset($_SESSION['lecturer_id'])) {
    header("Location: ../index.php");
    exit();
}

// Fetch logged-in admin user details
$user_id = $_SESSION['lecturer_id'];
$sql = "SELECT * FROM lectures WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Filter parameters for former students
$search = isset($_GET['search']) ? $_GET['search'] : '';
$study_year = isset($_GET['study_year']) ? $_GET['study_year'] : '';
$nowstatus = isset($_GET['nowstatus']) ? $_GET['nowstatus'] : '';
$course_id = isset($_GET['course_id']) ? $_GET['course_id'] : '';
$skills = isset($_GET['skills']) ? (is_array($_GET['skills']) ? $_GET['skills'] : [$_GET['skills']]) : [];

// Status options for former students
$statusOptions = ['study' => 'Studying', 'work' => 'Working', 'intern' => 'Internship', 'free' => 'Available'];

// Build SQL query for former students
$sql = "SELECT DISTINCT s.*, c.name AS course_name 
        FROM former_students s 
        LEFT JOIN hnd_courses c ON s.course_id = c.id 
        WHERE 1=1";

$params = [];
$types = '';

// Apply filters
if ($search !== '') {
    $sql .= " AND (s.username LIKE ? OR s.reg_id LIKE ? OR s.email LIKE ?)";
    $search_term = "%$search%";
    $params = array_merge($params, [$search_term, $search_term, $search_term]);
    $types .= 'sss';
}

if ($study_year !== '') {
    $sql .= " AND s.study_year = ?";
    $params[] = $study_year;
    $types .= 's';
}

if ($nowstatus !== '') {
    $sql .= " AND s.nowstatus = ?";
    $params[] = $nowstatus;
    $types .= 's';
}

if ($course_id !== '') {
    $sql .= " AND s.course_id = ?";
    $params[] = $course_id;
    $types .= 'i';
}

// Skills filter
if (!empty($skills)) {
    $placeholders = str_repeat('?,', count($skills) - 1) . '?';
    $sql .= " AND s.id IN (
        SELECT DISTINCT fss.student_id 
        FROM former_student_skills fss 
        WHERE fss.skill_id IN ($placeholders)
    )";
    $params = array_merge($params, $skills);
    $types .= str_repeat('i', count($skills));
}

// Add ordering
$sql .= " ORDER BY s.username ASC";

// Prepare and execute the query
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
$total_students = $result->num_rows;
$stmt->close();

// Fetch all courses for dropdown
$courses = $conn->query("SELECT id, name FROM hnd_courses ORDER BY name ASC");

// Fetch all skills for filter from multiple tables
$all_skills = $conn->query("
    SELECT id, skill_name, 'IT' AS category FROM it_student_skills WHERE skill_name != ''
    UNION
    SELECT id, skill_name, 'Engineering' AS category FROM engineering_skills WHERE skill_name != ''
    UNION
    SELECT id, skill_name, 'Business Finance' AS category FROM business_finance_skills WHERE skill_name != ''
    UNION
    SELECT id, skill_name, 'Accountancy' AS category FROM hnd_accountancy_skills WHERE skill_name != ''
    UNION
    SELECT id, skill_name, 'Agriculture' AS category FROM hnd_agriculture_skills WHERE skill_name != ''
    UNION
    SELECT id, skill_name, 'Building Services' AS category FROM hnd_building_services_skills WHERE skill_name != ''
    UNION
    SELECT id, skill_name, 'Business Admin' AS category FROM hnd_business_admin_skills WHERE skill_name != ''
    UNION
    SELECT id, skill_name, 'English' AS category FROM hnd_english_skills WHERE skill_name != ''
    UNION
    SELECT id, skill_name, 'Food Tech' AS category FROM hnd_food_tech_skills WHERE skill_name != ''
    UNION
    SELECT id, skill_name, 'Management' AS category FROM hnd_management_skills WHERE skill_name != ''
    UNION
    SELECT id, skill_name, 'Mechanical' AS category FROM hnd_mechanical_skills WHERE skill_name != ''
    UNION
    SELECT id, skill_name, 'Quantity Survey' AS category FROM hnd_quantity_survey_skills WHERE skill_name != ''
    UNION
    SELECT id, skill_name, 'THM' AS category FROM hnd_thm_skills WHERE skill_name != ''
    ORDER BY category, skill_name
");

// Fetch selected skills info for display
$selected_skills_info = [];
if (!empty($skills)) {
    $skill_ids_str = implode(',', array_map('intval', $skills));
    $selected_skills_query = $conn->query("
        SELECT id, skill_name, category FROM (
            SELECT id, skill_name, 'IT' AS category FROM it_student_skills WHERE skill_name != ''
            UNION
            SELECT id, skill_name, 'Engineering' AS category FROM engineering_skills WHERE skill_name != ''
            UNION
            SELECT id, skill_name, 'Business Finance' AS category FROM business_finance_skills WHERE skill_name != ''
            UNION
            SELECT id, skill_name, 'Accountancy' AS category FROM hnd_accountancy_skills WHERE skill_name != ''
            UNION
            SELECT id, skill_name, 'Agriculture' AS category FROM hnd_agriculture_skills WHERE skill_name != ''
            UNION
            SELECT id, skill_name, 'Building Services' AS category FROM hnd_building_services_skills WHERE skill_name != ''
            UNION
            SELECT id, skill_name, 'Business Admin' AS category FROM hnd_business_admin_skills WHERE skill_name != ''
            UNION
            SELECT id, skill_name, 'English' AS category FROM hnd_english_skills WHERE skill_name != ''
            UNION
            SELECT id, skill_name, 'Food Tech' AS category FROM hnd_food_tech_skills WHERE skill_name != ''
            UNION
            SELECT id, skill_name, 'Management' AS category FROM hnd_management_skills WHERE skill_name != ''
            UNION
            SELECT id, skill_name, 'Mechanical' AS category FROM hnd_mechanical_skills WHERE skill_name != ''
            UNION
            SELECT id, skill_name, 'Quantity Survey' AS category FROM hnd_quantity_survey_skills WHERE skill_name != ''
            UNION
            SELECT id, skill_name, 'THM' AS category FROM hnd_thm_skills WHERE skill_name != ''
        ) AS all_skills
        WHERE id IN ($skill_ids_str)
    ");
    
    if ($selected_skills_query) {
        while ($row = $selected_skills_query->fetch_assoc()) {
            $selected_skills_info[] = $row;
        }
    }
}

// Get counts for overview stats
$former_count = $conn->query("SELECT COUNT(*) as count FROM former_students")->fetch_assoc()['count'];
$work_count = $conn->query("SELECT COUNT(*) as count FROM former_students WHERE nowstatus = 'work'")->fetch_assoc()['count'];
$study_count = $conn->query("SELECT COUNT(*) as count FROM former_students WHERE nowstatus = 'study'")->fetch_assoc()['count'];
$intern_count = $conn->query("SELECT COUNT(*) as count FROM former_students WHERE nowstatus = 'intern'")->fetch_assoc()['count'];
$free_count = $conn->query("SELECT COUNT(*) as count FROM former_students WHERE nowstatus = 'free'")->fetch_assoc()['count'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Former Students - EduWide</title>

    <?php include_once("../includes/css-links-inc.php"); ?>
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --dark-color: #1d3557;
            --light-color: #f8f9fa;
        }

        .student-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            overflow: hidden;
            margin-bottom: 25px;
            height: 100%;
        }

        .student-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }

        .student-card .card-body {
            padding: 25px;
        }

        .student-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary-color);
            margin: 0 auto 15px;
            display: block;
        }

        .student-name {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 5px;
            text-align: center;
        }

        .student-reg-id {
            color: var(--primary-color);
            font-weight: 500;
            text-align: center;
            margin-bottom: 15px;
            font-size: 0.9rem;
        }

        .stats-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin: 15px 0;
        }

        .stat-item {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 12px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .stat-item:hover .stat-number,
        .stat-item:hover .stat-label {
            color: white;
        }

        .stat-number {
            font-size: 1.3rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 2px;
            display: block;
        }

        .stat-label {
            font-size: 0.75rem;
            color: #6c757d;
            font-weight: 500;
        }

        .skills-section {
            margin: 15px 0;
        }

        .skills-label {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .skills-container {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            max-height: 80px;
            overflow-y: auto;
            padding: 5px;
        }

        .skill-badge {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .skill-category {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 1px 6px;
            border-radius: 8px;
            font-size: 0.6rem;
            margin-left: 4px;
        }

        .contact-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-top: 15px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            padding: 5px 0;
        }

        .contact-item:last-child {
            margin-bottom: 0;
        }

        .contact-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            flex-shrink: 0;
            font-size: 0.8rem;
        }

        .contact-details {
            flex: 1;
        }

        .contact-label {
            font-size: 0.75rem;
            color: #6c757d;
            margin-bottom: 1px;
        }

        .contact-value {
            font-size: 0.85rem;
            color: var(--dark-color);
            font-weight: 500;
        }

        .contact-link {
            color: var(--dark-color);
            text-decoration: none;
            transition: color 0.3s;
        }

        .contact-link:hover {
            color: var(--primary-color);
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: capitalize;
        }

        .status-work {
            background: #e8f5e8;
            color: #2e7d32;
        }

        .status-study {
            background: #e3f2fd;
            color: #1565c0;
        }

        .status-intern {
            background: #fff3e0;
            color: #ef6c00;
        }

        .status-free {
            background: #fce4ec;
            color: #c2185b;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 15px;
        }

        .btn-profile {
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 20px;
            font-size: 0.85rem;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 5px;
            flex: 1;
            justify-content: center;
        }

        .btn-profile:hover {
            background: var(--secondary-color);
            color: white;
            transform: translateY(-2px);
        }

        .student-id {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--primary-color);
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .card-header-section {
            position: relative;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
            margin-bottom: 15px;
        }

        .filters-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
            border: none;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: var(--primary-color);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #dee2e6;
        }

        .empty-state h5 {
            font-size: 1.3rem;
            margin-bottom: 10px;
            color: #495057;
        }

        .stats-overview {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .overview-card {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .overview-number {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .overview-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .overview-icon {
            font-size: 2.5rem;
            opacity: 0.8;
            margin-bottom: 10px;
        }

        .no-skills {
            font-size: 0.8rem;
            color: #6c757d;
            text-align: center;
            font-style: italic;
            padding: 10px;
        }

        /* Select2 Custom Styles */
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            min-height: 42px;
        }

        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: #4361ee;
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 12px;
            color: white;
            padding: 2px 8px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: white;
            margin-right: 4px;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: var(--primary-color);
        }

        .skills-filter-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin: 15px 0;
        }

        .selected-skills-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }

        .selected-skill-badge {
            background: var(--primary-color);
            color: white;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .remove-skill {
            cursor: pointer;
            font-weight: bold;
            padding: 0 2px;
        }

        .remove-skill:hover {
            color: #ff6b6b;
        }

        .results-count {
            background: var(--success-color);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        .active-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
            align-items: center;
        }

        .filter-badge {
            background: var(--primary-color);
            color: white;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .clear-filter {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            padding: 0 4px;
        }

        .clear-filter:hover {
            color: #ff6b6b;
        }

        @media (max-width: 768px) {
            .student-card .card-body {
                padding: 20px;
            }
            
            .student-avatar {
                width: 80px;
                height: 80px;
            }
            
            .stats-container {
                grid-template-columns: 1fr;
            }
            
            .stats-overview {
                grid-template-columns: 1fr;
            }
            
            .section-title {
                font-size: 1.3rem;
            }
        }

        .loading-spinner {
            display: none;
            text-align: center;
            padding: 20px;
        }
    </style>
</head>

<body>

    <?php include_once("../includes/header.php") ?>
    <?php include_once("../includes/lectures-sidebar.php") ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Former Students</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                    <li class="breadcrumb-item">Talent Pool</li>
                    <li class="breadcrumb-item active">Former Students</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-12">
                    <!-- Overview Stats -->
                    <div class="stats-overview">
                        <div class="overview-card">
                            <i class="fas fa-users overview-icon"></i>
                            <div class="overview-number"><?= $former_count ?></div>
                            <div class="overview-label">Total Former Students</div>
                        </div>
                        <div class="overview-card">
                            <i class="fas fa-briefcase overview-icon"></i>
                            <div class="overview-number"><?= $work_count ?></div>
                            <div class="overview-label">Currently Working</div>
                        </div>
                        <div class="overview-card">
                            <i class="fas fa-graduation-cap overview-icon"></i>
                            <div class="overview-number"><?= $study_count ?></div>
                            <div class="overview-label">Currently Studying</div>
                        </div>
                        <div class="overview-card">
                            <i class="fas fa-user-clock overview-icon"></i>
                            <div class="overview-number"><?= $intern_count + $free_count ?></div>
                            <div class="overview-label">Available / Interns</div>
                        </div>
                    </div>

                    <!-- Filters Card -->
                    <div class="card filters-card">
                        <div class="card-body">
                            <h4 class="section-title">
                                <i class="fas fa-filter"></i> Filter Former Students
                            </h4>
                            <form method="GET" action="" id="filterForm">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Search</label>
                                        <input type="text" name="search" class="form-control" placeholder="Name, Reg ID or Email" value="<?= htmlspecialchars($search) ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Study Year</label>
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
                                    <div class="col-md-3">
                                        <label class="form-label">Current Status</label>
                                        <select name="nowstatus" class="form-select">
                                            <option value="">All Status</option>
                                            <?php
                                            foreach ($statusOptions as $value => $label) {
                                                $selected = ($nowstatus === $value) ? 'selected' : '';
                                                echo "<option value=\"$value\" $selected>$label</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Course</label>
                                        <select name="course_id" class="form-select">
                                            <option value="">All Courses</option>
                                            <?php 
                                            if ($courses) {
                                                while ($course = $courses->fetch_assoc()): 
                                            ?>
                                                <option value="<?= $course['id'] ?>" <?= ($course_id == $course['id']) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($course['name']) ?>
                                                </option>
                                            <?php 
                                                endwhile; 
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <!-- Skills Filter -->
                                    <div class="col-12">
                                        <div class="skills-filter-section">
                                            <label class="form-label"><strong>Skills Filter</strong></label>
                                            <select class="form-control" id="skillsSelect" name="skills[]" multiple="multiple" style="width: 100%">
                                                <?php 
                                                if ($all_skills) {
                                                    while ($skill = $all_skills->fetch_assoc()): 
                                                ?>
                                                    <option value="<?= $skill['id'] ?>" 
                                                        <?= in_array($skill['id'], $skills) ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($skill['skill_name']) ?> 
                                                        <small class="text-muted">(<?= $skill['category'] ?>)</small>
                                                    </option>
                                                <?php 
                                                    endwhile; 
                                                }
                                                ?>
                                            </select>
                                            
                                            <!-- Selected Skills Display -->
                                            <?php if (!empty($selected_skills_info)): ?>
                                                <div class="selected-skills-badges mt-3">
                                                    <small class="text-muted">Selected Skills:</small>
                                                    <?php foreach ($selected_skills_info as $skill_info): ?>
                                                        <span class="selected-skill-badge">
                                                            <?= htmlspecialchars($skill_info['skill_name']) ?> (<?= $skill_info['category'] ?>)
                                                            <span class="remove-skill" data-skill-id="<?= $skill_info['id'] ?>">×</span>
                                                        </span>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-search me-2"></i>Apply Filters
                                            </button>
                                            <a href="?" class="btn btn-outline-secondary">
                                                <i class="fas fa-times me-2"></i>Clear All
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="section-title mb-0">
                                    <i class="fas fa-briefcase"></i>Former Student Profiles
                                </h4>
                                <div class="results-count">
                                    <i class="fas fa-users me-1"></i>
                                    <?= $total_students ?> Student<?= $total_students != 1 ? 's' : '' ?> Found
                                </div>
                            </div>

                            <!-- Active Filters -->
                            <?php if ($search || $study_year || $nowstatus || $course_id || !empty($skills)): ?>
                                <div class="active-filters">
                                    <strong>Active Filters:</strong>
                                    <?php if ($search): ?>
                                        <span class="filter-badge">
                                            Search: "<?= htmlspecialchars($search) ?>"
                                            <a href="?" class="clear-filter" onclick="removeFilter('search')">×</a>
                                        </span>
                                    <?php endif; ?>
                                    <?php if ($study_year): ?>
                                        <span class="filter-badge">
                                            Year: <?= $study_year ?>
                                            <a href="?" class="clear-filter" onclick="removeFilter('study_year')">×</a>
                                        </span>
                                    <?php endif; ?>
                                    <?php if ($nowstatus): ?>
                                        <span class="filter-badge">
                                            Status: <?= $statusOptions[$nowstatus] ?>
                                            <a href="?" class="clear-filter" onclick="removeFilter('nowstatus')">×</a>
                                        </span>
                                    <?php endif; ?>
                                    <?php if ($course_id): 
                                        $course_name = '';
                                        $course_query = $conn->query("SELECT name FROM hnd_courses WHERE id = $course_id");
                                        if ($course_query && $course_query->num_rows > 0) {
                                            $course_name = $course_query->fetch_assoc()['name'];
                                        }
                                    ?>
                                        <?php if ($course_name): ?>
                                            <span class="filter-badge">
                                                Course: <?= htmlspecialchars($course_name) ?>
                                                <a href="?" class="clear-filter" onclick="removeFilter('course_id')">×</a>
                                            </span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php if (!empty($skills)): ?>
                                        <span class="filter-badge">
                                            Skills: <?= count($skills) ?> selected
                                            <a href="?" class="clear-filter" onclick="removeFilter('skills')">×</a>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Loading Spinner -->
                            <div class="loading-spinner" id="loadingSpinner">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2">Loading students...</p>
                            </div>

                            <!-- Students Grid -->
                            <div id="studentsGrid">
                                <?php if ($result && $result->num_rows > 0): ?>
                                    <div class="row">
                                        <?php while ($student = $result->fetch_assoc()): 
                                            // Fetch projects count for this student
                                            $projects_count = 0;
                                            $projects_query = $conn->query("SELECT COUNT(*) as count FROM former_student_projects WHERE student_id = " . $student['id']);
                                            if ($projects_query) {
                                                $projects_count = $projects_query->fetch_assoc()['count'];
                                            }

                                            // Fetch actual skills for this student
                                            $student_skills = [];
                                            $skills_sql = "
                                                SELECT s.skill_name, s.category 
                                                FROM former_student_skills fs
                                                JOIN (
                                                    SELECT id, skill_name, 'IT' AS category FROM it_student_skills WHERE skill_name != ''
                                                    UNION ALL
                                                    SELECT id, skill_name, 'Engineering' AS category FROM engineering_skills WHERE skill_name != ''
                                                    UNION ALL
                                                    SELECT id, skill_name, 'Business Finance' AS category FROM business_finance_skills WHERE skill_name != ''
                                                    UNION ALL
                                                    SELECT id, skill_name, 'Accountancy' AS category FROM hnd_accountancy_skills WHERE skill_name != ''
                                                    UNION ALL
                                                    SELECT id, skill_name, 'Agriculture' AS category FROM hnd_agriculture_skills WHERE skill_name != ''
                                                    UNION ALL
                                                    SELECT id, skill_name, 'Building Services' AS category FROM hnd_building_services_skills WHERE skill_name != ''
                                                    UNION ALL
                                                    SELECT id, skill_name, 'Business Admin' AS category FROM hnd_business_admin_skills WHERE skill_name != ''
                                                    UNION ALL
                                                    SELECT id, skill_name, 'English' AS category FROM hnd_english_skills WHERE skill_name != ''
                                                    UNION ALL
                                                    SELECT id, skill_name, 'Food Tech' AS category FROM hnd_food_tech_skills WHERE skill_name != ''
                                                    UNION ALL
                                                    SELECT id, skill_name, 'Management' AS category FROM hnd_management_skills WHERE skill_name != ''
                                                    UNION ALL
                                                    SELECT id, skill_name, 'Mechanical' AS category FROM hnd_mechanical_skills WHERE skill_name != ''
                                                    UNION ALL
                                                    SELECT id, skill_name, 'Quantity Survey' AS category FROM hnd_quantity_survey_skills WHERE skill_name != ''
                                                    UNION ALL
                                                    SELECT id, skill_name, 'THM' AS category FROM hnd_thm_skills WHERE skill_name != ''
                                                ) s ON fs.skill_id = s.id
                                                WHERE fs.student_id = ?
                                                ORDER BY s.category, s.skill_name
                                                LIMIT 20
                                            ";
                                            $skills_stmt = $conn->prepare($skills_sql);
                                            if ($skills_stmt) {
                                                $skills_stmt->bind_param("i", $student['id']);
                                                $skills_stmt->execute();
                                                $skills_result = $skills_stmt->get_result();
                                                $student_skills = $skills_result->fetch_all(MYSQLI_ASSOC);
                                                $skills_stmt->close();
                                            }

                                            $skills_count = count($student_skills);
                                        ?>
                                            <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                                                <div class="card student-card">
                                                    <div class="card-body">
                                                        <div class="card-header-section">
                                                            <span class="student-id">ID: <?= $student['id'] ?></span>
                                                            <img src="../oddstudents/<?= htmlspecialchars($student['profile_picture']) ?>" 
                                                                 alt="<?= htmlspecialchars($student['username']) ?>" 
                                                                 class="student-avatar"
                                                                 onerror="this.src='../uploads/profile_pictures/default.png'">
                                                            <h5 class="student-name"><?= htmlspecialchars($student['username']) ?></h5>
                                                            <div class="student-reg-id"><?= htmlspecialchars($student['reg_id']) ?></div>
                                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                                <span class="status-badge status-<?= $student['nowstatus'] ?>">
                                                                    <?= $statusOptions[$student['nowstatus']] ?? ucfirst($student['nowstatus']) ?>
                                                                </span>
                                                                <?php if ($student['course_name']): ?>
                                                                    <span class="badge bg-light text-dark"><?= htmlspecialchars($student['course_name']) ?></span>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>

                                                        <!-- Stats -->
                                                        <div class="stats-container">
                                                            <div class="stat-item">
                                                                <span class="stat-number"><?= $projects_count ?></span>
                                                                <span class="stat-label">Projects</span>
                                                            </div>
                                                            <div class="stat-item">
                                                                <span class="stat-number"><?= $skills_count ?></span>
                                                                <span class="stat-label">Skills</span>
                                                            </div>
                                                            <div class="stat-item">
                                                                <span class="stat-number"><?= htmlspecialchars($student['study_year']) ?></span>
                                                                <span class="stat-label">Study Year</span>
                                                            </div>
                                                            <div class="stat-item">
                                                                <span class="stat-number"><?= htmlspecialchars($student['nic']) ?></span>
                                                                <span class="stat-label">NIC</span>
                                                            </div>
                                                        </div>

                                                        <!-- Skills Section -->
                                                        <div class="skills-section">
                                                            <div class="skills-label">
                                                                <i class="fas fa-code me-1"></i>Key Skills
                                                                <?php if ($skills_count > 8): ?>
                                                                    <small class="text-muted">(Showing 8 of <?= $skills_count ?>)</small>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="skills-container">
                                                                <?php if (!empty($student_skills)): ?>
                                                                    <?php foreach ($student_skills as $skill): ?>
                                                                        <span class="skill-badge">
                                                                            <?= htmlspecialchars($skill['skill_name']) ?>
                                                                            <span class="skill-category"><?= $skill['category'] ?></span>
                                                                        </span>
                                                                    <?php endforeach; ?>
                                                                <?php else: ?>
                                                                    <div class="no-skills">No skills added yet</div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>

                                                        <!-- Contact Info -->
                                                        <div class="contact-info">
                                                            <div class="contact-item">
                                                                <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                                                                <div class="contact-details">
                                                                    <div class="contact-label">Email</div>
                                                                    <a href="mailto:<?= htmlspecialchars($student['email']) ?>" class="contact-value contact-link">
                                                                        <?= htmlspecialchars($student['email']) ?>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="contact-item">
                                                                <div class="contact-icon"><i class="fas fa-phone"></i></div>
                                                                <div class="contact-details">
                                                                    <div class="contact-label">Mobile</div>
                                                                    <a href="tel:<?= htmlspecialchars($student['mobile']) ?>" class="contact-value contact-link">
                                                                        <?= htmlspecialchars($student['mobile']) ?>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Action Buttons -->
                                                        <div class="action-buttons">
                                                            <a href="former-student-profile.php?former_student_id=<?= $student['id'] ?>" class="btn btn-profile">
                                                                <i class="fas fa-eye me-1"></i>View Full Profile
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endwhile; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="empty-state">
                                        <i class="fas fa-briefcase"></i>
                                        <h5>No Former Students Found</h5>
                                        <p class="text-muted">No former students match your current filters. Try adjusting your search criteria.</p>
                                        <a href="?" class="btn btn-primary mt-3">
                                            <i class="fas fa-refresh me-2"></i>Clear Filters
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include_once("../includes/footer.php") ?>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <?php include_once("../includes/js-links-inc.php") ?>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Select2 for skills
            $('#skillsSelect').select2({
                placeholder: "Select skills to filter...",
                allowClear: true,
                width: '100%',
                closeOnSelect: false
            });

            // Remove skill badge functionality
            document.querySelectorAll('.remove-skill').forEach(button => {
                button.addEventListener('click', function() {
                    const skillId = this.getAttribute('data-skill-id');
                    const select = document.querySelector('#skillsSelect');
                    const option = select.querySelector(`option[value="${skillId}"]`);
                    
                    if (option) {
                        option.selected = false;
                    }
                    
                    // Trigger change event to update Select2
                    $(select).trigger('change');
                    
                    // Submit the form
                    document.getElementById('filterForm').submit();
                });
            });

            // Add smooth hover effects
            const studentCards = document.querySelectorAll('.student-card');
            studentCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Add animation to stat items
            const statItems = document.querySelectorAll('.stat-item');
            statItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });
                
                item.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Skills container scrolling
            const skillsContainers = document.querySelectorAll('.skills-container');
            skillsContainers.forEach(container => {
                if (container.scrollHeight > container.clientHeight) {
                    container.style.boxShadow = 'inset 0 -5px 10px -5px rgba(0,0,0,0.1)';
                }
            });

            console.log('Former students page loaded with <?= $total_students ?> students');
        });

        // Function to remove specific filter
        function removeFilter(filterName) {
            const url = new URL(window.location.href);
            url.searchParams.delete(filterName);
            window.location.href = url.toString();
        }

        // Function to quickly filter by a single skill
        function filterBySkill(skillId, skillName) {
            const select = document.querySelector('#skillsSelect');
            const option = select.querySelector(`option[value="${skillId}"]`);
            
            if (option) {
                // Clear existing selections and select only this skill
                $(select).val(null).trigger('change');
                option.selected = true;
                $(select).trigger('change');
                
                // Submit the form
                document.getElementById('filterForm').submit();
            }
        }

        // Show loading spinner when form is submitted
        document.getElementById('filterForm').addEventListener('submit', function() {
            document.getElementById('loadingSpinner').style.display = 'block';
            document.getElementById('studentsGrid').style.opacity = '0.5';
        });
    </script>

</body>

</html>

<?php
// Close database connection
$conn->close();
?>