<?php
session_start();
require_once 'includes/db-conn.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if active student is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: index.php");
    exit();
}

$current_user_id = $_SESSION['student_id'];

// Debug: Check session
error_log("DEBUG: User ID: " . $current_user_id);

try {
    // Get current user details including course information (active student)
    $stmt = $conn->prepare("SELECT s.*, hc.name as course_name 
                           FROM students s 
                           LEFT JOIN hnd_courses hc ON s.course_id = hc.id 
                           WHERE s.id = ?");
    
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("i", $current_user_id);
    
    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }
    
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    
    if (!$user) {
        throw new Exception("User not found with ID: " . $current_user_id);
    }
    
    $current_user_course_id = $user['course_id'] ?? null;
    $current_user_course_name = $user['course_name'] ?? '';
    
    error_log("DEBUG: Current user course ID: " . $current_user_course_id);

    // Get current user education + work (from active students tables)
    $edu_stmt = $conn->prepare("SELECT school, field_of_study, start_year, end_year FROM students_education WHERE user_id = ? ORDER BY id DESC LIMIT 1");
    
    if ($edu_stmt) {
        $edu_stmt->bind_param("i", $current_user_id);
        $edu_stmt->execute();
        $edu_data = $edu_stmt->get_result()->fetch_assoc();
        $edu_stmt->close();
    } else {
        error_log("ERROR: Education query prepare failed: " . $conn->error);
        $edu_data = [];
    }
    
    $work_stmt = $conn->prepare("SELECT company, title FROM students_experiences WHERE user_id = ? ORDER BY id DESC LIMIT 1");
    
    if ($work_stmt) {
        $work_stmt->bind_param("i", $current_user_id);
        $work_stmt->execute();
        $work_data = $work_stmt->get_result()->fetch_assoc();
        $work_stmt->close();
    } else {
        error_log("ERROR: Work query prepare failed: " . $conn->error);
        $work_data = [];
    }

    $school = $edu_data['school'] ?? '';
    $field = $edu_data['field_of_study'] ?? '';
    $start_year = $edu_data['start_year'] ?? '';
    $end_year = $edu_data['end_year'] ?? '';
    $company = $work_data['company'] ?? '';
    $title = $work_data['title'] ?? '';
    $current_user_study_year = $user['study_year'] ?? '';

    // ============ FORMER STUDENTS SECTION ============
    $former_suggestions = [];
    $former_fallback_suggestions = [];

    // Enhanced AI-Like Weighted Matching with Course Priority for FORMER STUDENTS
    $former_query = "
    SELECT 
        fs.id, 
        fs.username AS full_name, 
        fs.profile_picture, 
        fs.facebook, 
        fs.github, 
        fs.linkedin, 
        fs.blog,
        fs.study_year,
        fs.course_id,
        hc.name as course_name,
        e.school, 
        e.field_of_study AS course, 
        w.company AS job_company, 
        w.title AS job_role,
        COUNT(DISTINCT e.id) AS education_count,
        COUNT(DISTINCT w.id) AS experience_count,
        (
            -- High priority: Same course (most important)
            CASE WHEN fs.course_id = ? THEN 80 ELSE 0 END
            +
            -- Medium priority: Same education institution
            CASE WHEN e.school = ? THEN 40 ELSE 0 END
            +
            -- Medium priority: Same company
            CASE WHEN w.company = ? THEN 30 ELSE 0 END
            +
            -- Low priority: Same field of study
            CASE WHEN e.field_of_study = ? THEN 15 ELSE 0 END
            +
            -- Low priority: Same job title
            CASE WHEN w.title = ? THEN 10 ELSE 0 END
            +
            -- Bonus for having multiple education entries
            (COUNT(DISTINCT e.id) * 2) 
            + 
            -- Bonus for having multiple work experiences
            (COUNT(DISTINCT w.id) * 2)
            +
            -- Bonus for same study year
            CASE WHEN fs.study_year = ? THEN 5 ELSE 0 END
        ) AS score
    FROM 
        former_students fs
    LEFT JOIN 
        education e ON fs.id = e.user_id
    LEFT JOIN 
        experiences w ON fs.id = w.user_id
    LEFT JOIN
        hnd_courses hc ON fs.course_id = hc.id
    WHERE 
        fs.status = 'approved'
    GROUP BY 
        fs.id
    HAVING 
        score > 0
    ORDER BY 
        score DESC, RAND()
    LIMIT 10
    ";

    $former_stmt = $conn->prepare($former_query);
    
    if ($former_stmt) {
        $former_stmt->bind_param("issssi", 
            $current_user_course_id, 
            $school, 
            $company, 
            $field, 
            $title, 
            $current_user_study_year
        );
        
        $former_stmt->execute();
        $former_result = $former_stmt->get_result();

        while ($row = $former_result->fetch_assoc()) {
            // Fetch skills for former student
            $skills_sql = "
                SELECT s.skill_name, s.category
                FROM former_student_skills fss
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
                ) s ON fss.skill_id = s.id
                WHERE fss.student_id = ?
                ORDER BY s.category, s.skill_name
            ";
            
            $skills_stmt = $conn->prepare($skills_sql);
            if ($skills_stmt) {
                $skills_stmt->bind_param("i", $row['id']);
                $skills_stmt->execute();
                $skills_result = $skills_stmt->get_result();
                $row['skills'] = $skills_result->fetch_all(MYSQLI_ASSOC);
                $skills_stmt->close();
            } else {
                $row['skills'] = [];
                error_log("ERROR: Skills query prepare failed for student ID: " . $row['id']);
            }
            
            $row['user_type'] = 'former';
            $former_suggestions[] = $row;
        }
        $former_stmt->close();
    } else {
        error_log("ERROR: Former students query prepare failed: " . $conn->error);
    }

    // If no former suggestions found based on criteria, show random approved users from same course
    if (empty($former_suggestions) && $current_user_course_id) {
        $former_fallback_query = "
        SELECT 
            fs.id, 
            fs.username AS full_name, 
            fs.profile_picture, 
            fs.facebook, 
            fs.github, 
            fs.linkedin, 
            fs.blog,
            fs.study_year,
            fs.course_id,
            hc.name as course_name,
            (SELECT school FROM education WHERE user_id = fs.id ORDER BY id DESC LIMIT 1) as school,
            (SELECT field_of_study FROM education WHERE user_id = fs.id ORDER BY id DESC LIMIT 1) as course,
            (SELECT company FROM experiences WHERE user_id = fs.id ORDER BY id DESC LIMIT 1) as job_company,
            (SELECT title FROM experiences WHERE user_id = fs.id ORDER BY id DESC LIMIT 1) as job_role
        FROM 
            former_students fs
        LEFT JOIN
            hnd_courses hc ON fs.course_id = hc.id
        WHERE 
            fs.status = 'approved' AND fs.course_id = ?
        ORDER BY RAND()
        LIMIT 10
        ";
        
        $former_fallback_stmt = $conn->prepare($former_fallback_query);
        if ($former_fallback_stmt) {
            $former_fallback_stmt->bind_param("i", $current_user_course_id);
            $former_fallback_stmt->execute();
            $former_fallback_result = $former_fallback_stmt->get_result();
            
            while ($row = $former_fallback_result->fetch_assoc()) {
                // Fetch skills for fallback suggestions too
                $skills_sql = "
                    SELECT s.skill_name, s.category
                    FROM former_student_skills fss
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
                    ) s ON fss.skill_id = s.id
                    WHERE fss.student_id = ?
                    ORDER BY s.category, s.skill_name
                ";
                
                $skills_stmt = $conn->prepare($skills_sql);
                if ($skills_stmt) {
                    $skills_stmt->bind_param("i", $row['id']);
                    $skills_stmt->execute();
                    $skills_result = $skills_stmt->get_result();
                    $row['skills'] = $skills_result->fetch_all(MYSQLI_ASSOC);
                    $skills_stmt->close();
                } else {
                    $row['skills'] = [];
                }
                
                $row['user_type'] = 'former';
                $former_fallback_suggestions[] = $row;
            }
            $former_fallback_stmt->close();
        }
    }

    // ============ ACTIVE STUDENTS SECTION ============
    $active_suggestions = [];
    $active_fallback_suggestions = [];

    // Enhanced AI-Like Weighted Matching with Course Priority for OTHER ACTIVE STUDENTS
    $active_query = "
    SELECT 
        s.id, 
        s.username AS full_name, 
        s.profile_picture, 
        s.facebook, 
        s.github, 
        s.linkedin, 
        s.blog,
        s.study_year,
        s.course_id,
        hc.name as course_name,
        se.school, 
        se.field_of_study AS course, 
        we.company AS job_company, 
        we.title AS job_role,
        COUNT(DISTINCT se.id) AS education_count,
        COUNT(DISTINCT we.id) AS experience_count,
        (
            -- High priority: Same course (most important)
            CASE WHEN s.course_id = ? THEN 80 ELSE 0 END
            +
            -- Medium priority: Same education institution
            CASE WHEN se.school = ? THEN 40 ELSE 0 END
            +
            -- Medium priority: Same company (for experiences)
            CASE WHEN we.company = ? THEN 30 ELSE 0 END
            +
            -- Low priority: Same field of study
            CASE WHEN se.field_of_study = ? THEN 15 ELSE 0 END
            +
            -- Low priority: Same job title
            CASE WHEN we.title = ? THEN 10 ELSE 0 END
            +
            -- Bonus for having multiple education entries
            (COUNT(DISTINCT se.id) * 2) 
            + 
            -- Bonus for having multiple work experiences
            (COUNT(DISTINCT we.id) * 2)
            +
            -- Bonus for same study year
            CASE WHEN s.study_year = ? THEN 5 ELSE 0 END
        ) AS score
    FROM 
        students s
    LEFT JOIN 
        students_education se ON s.id = se.user_id
    LEFT JOIN 
        students_experiences we ON s.id = we.user_id
    LEFT JOIN
        hnd_courses hc ON s.course_id = hc.id
    WHERE 
        s.status = 'active' AND s.id != ?
    GROUP BY 
        s.id
    HAVING 
        score > 0
    ORDER BY 
        score DESC, RAND()
    LIMIT 10
    ";

    $active_stmt = $conn->prepare($active_query);
    
    if ($active_stmt) {
        $active_stmt->bind_param("issssii", 
            $current_user_course_id, 
            $school, 
            $company, 
            $field, 
            $title, 
            $current_user_study_year,
            $current_user_id
        );
        
        $active_stmt->execute();
        $active_result = $active_stmt->get_result();

        while ($row = $active_result->fetch_assoc()) {
            // Fetch skills for this active student from multiple skills tables
            $skills_sql = "
                SELECT s.skill_name, s.category
                FROM active_student_skills ass
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
                ) s ON ass.skill_id = s.id
                WHERE ass.student_id = ?
                ORDER BY s.category, s.skill_name
            ";
            
            $skills_stmt = $conn->prepare($skills_sql);
            if ($skills_stmt) {
                $skills_stmt->bind_param("i", $row['id']);
                $skills_stmt->execute();
                $skills_result = $skills_stmt->get_result();
                $skills = $skills_result->fetch_all(MYSQLI_ASSOC);
                $row['skills'] = $skills;
                $skills_stmt->close();
            } else {
                $row['skills'] = [];
            }
            
            $row['user_type'] = 'active';
            $active_suggestions[] = $row;
        }
        $active_stmt->close();
    } else {
        error_log("ERROR: Active students query prepare failed: " . $conn->error);
    }

    // If no active suggestions found based on criteria, show random active students from same course
    if (empty($active_suggestions) && $current_user_course_id) {
        $active_fallback_query = "
        SELECT 
            s.id, 
            s.username AS full_name, 
            s.profile_picture, 
            s.facebook, 
            s.github, 
            s.linkedin, 
            s.blog,
            s.study_year,
            s.course_id,
            hc.name as course_name,
            (SELECT school FROM students_education WHERE user_id = s.id ORDER BY id DESC LIMIT 1) as school,
            (SELECT field_of_study FROM students_education WHERE user_id = s.id ORDER BY id DESC LIMIT 1) as course,
            (SELECT company FROM students_experiences WHERE user_id = s.id ORDER BY id DESC LIMIT 1) as job_company,
            (SELECT title FROM students_experiences WHERE user_id = s.id ORDER BY id DESC LIMIT 1) as job_role
        FROM 
            students s
        LEFT JOIN
            hnd_courses hc ON s.course_id = hc.id
        WHERE 
            s.status = 'active' AND s.id != ? AND s.course_id = ?
        ORDER BY RAND()
        LIMIT 10
        ";
        
        $active_fallback_stmt = $conn->prepare($active_fallback_query);
        if ($active_fallback_stmt) {
            $active_fallback_stmt->bind_param("ii", $current_user_id, $current_user_course_id);
            $active_fallback_stmt->execute();
            $active_fallback_result = $active_fallback_stmt->get_result();
            
            while ($row = $active_fallback_result->fetch_assoc()) {
                // Fetch skills for fallback suggestions too
                $skills_sql = "
                    SELECT s.skill_name, s.category
                    FROM active_student_skills ass
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
                    ) s ON ass.skill_id = s.id
                    WHERE ass.student_id = ?
                    ORDER BY s.category, s.skill_name
                ";
                
                $skills_stmt = $conn->prepare($skills_sql);
                if ($skills_stmt) {
                    $skills_stmt->bind_param("i", $row['id']);
                    $skills_stmt->execute();
                    $skills_result = $skills_stmt->get_result();
                    $skills = $skills_result->fetch_all(MYSQLI_ASSOC);
                    $row['skills'] = $skills;
                    $skills_stmt->close();
                } else {
                    $row['skills'] = [];
                }
                
                $row['user_type'] = 'active';
                $active_fallback_suggestions[] = $row;
            }
            $active_fallback_stmt->close();
        }
    }

    // Combine all suggestions
    $all_former_suggestions = array_merge($former_suggestions, $former_fallback_suggestions);
    $all_active_suggestions = array_merge($active_suggestions, $active_fallback_suggestions);
    
    error_log("DEBUG: Former suggestions count: " . count($all_former_suggestions));
    error_log("DEBUG: Active suggestions count: " . count($all_active_suggestions));

} catch (Exception $e) {
    // Display error for debugging
    echo "<div style='background: #f8d7da; color: #721c24; padding: 20px; border-radius: 5px; margin: 20px;'>";
    echo "<h3>Error: " . htmlspecialchars($e->getMessage()) . "</h3>";
    echo "<p><strong>File:</strong> " . $e->getFile() . " (Line: " . $e->getLine() . ")</p>";
    echo "<p><strong>Stack Trace:</strong></p><pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    echo "</div>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>People You May Know</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <?php 
    if (file_exists("includes/css-links-inc.php")) {
        include_once("includes/css-links-inc.php");
    } else {
        echo "<!-- CSS file not found -->";
    }
    ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .modern-card {
            background: #fff;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
            margin-bottom: 20px;
            position: relative;
        }

        .modern-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .profile-img {
            width: 85px;
            height: 85px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #0d6efd;
        }

        .social-icons a {
            color: #444;
            margin-right: 12px;
            transition: color 0.2s;
            text-decoration: none;
        }

        .social-icons a:hover {
            color: #0d6efd;
        }

        .edu-work-container {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            flex-wrap: wrap;
        }

        .edu-work-container div {
            flex: 1;
            min-width: 150px;
        }

        .course-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
            margin-top: 5px;
            display: inline-block;
        }

        .match-score {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #28a745;
            color: white;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .card-header {
            position: relative;
            margin-bottom: 15px;
        }

        .study-year {
            color: #6c757d;
            font-size: 0.85rem;
            margin-top: 3px;
        }

        .no-suggestions {
            text-align: center;
            padding: 40px;
            background: #f8f9fa;
            border-radius: 10px;
            margin: 20px 0;
        }

        .no-suggestions i {
            font-size: 3rem;
            color: #6c757d;
            margin-bottom: 15px;
        }

        /* Skills Section Styles */
        .skills-container {
            margin: 15px 0;
        }

        .skill-tag {
            display: inline-block;
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 0.75rem;
            margin: 2px;
            margin-bottom: 5px;
        }

        .skills-title {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .more-skills-text {
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 5px;
            font-style: italic;
        }

        .user-type-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 600;
            z-index: 1;
        }

        .former-badge {
            background: linear-gradient(135deg, #6f42c1, #20c997);
            color: white;
        }

        .active-badge {
            background: linear-gradient(135deg, #007bff, #6610f2);
            color: white;
        }

        .section-title {
            padding-bottom: 10px;
            margin-bottom: 20px;
            border-bottom: 2px solid #e9ecef;
        }
        
        .current-user-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-left: 4px solid #0d6efd;
        }
        
        .debug-info {
            background: #e9ecef;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
<?php 
if (file_exists("includes/header.php")) {
    include_once("includes/header.php");
} else {
    echo "<!-- Header file not found -->";
}
?>

<?php 
if (file_exists("includes/students-sidebar.php")) {
    include_once("includes/students-sidebar.php");
} else {
    echo "<!-- Sidebar file not found -->";
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>People You May Know</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Connections</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <!-- Current User Info Card -->
            <div class="col-12 mb-4">
                <div class="card current-user-card">
                    <div class="card-body">
                        <h5 class="card-title">Your Profile (Current Student)</h5>
                        <div class="d-flex align-items-center">
                            <img src="../oddstudents/<?= htmlspecialchars($user['profile_picture'] ?? 'default.png') ?>" 
                                 alt="Profile" 
                                 class="profile-img me-3"
                                 onerror="this.src='../uploads/profile_pictures/default.png'">
                            <div>
                                <h6 class="mb-1"><?= htmlspecialchars($user['username'] ?? 'User') ?></h6>
                                <?php if (!empty($current_user_course_name)): ?>
                                    <span class="course-badge"><?= htmlspecialchars($current_user_course_name) ?></span>
                                <?php endif; ?>
                                <?php if (!empty($user['study_year'])): ?>
                                    <div class="study-year">Study Year: <?= htmlspecialchars($user['study_year']) ?></div>
                                <?php endif; ?>
                                <?php if (!empty($school)): ?>
                                    <div class="study-year">Education: <?= htmlspecialchars($school) ?></div>
                                <?php endif; ?>
                                <?php if (!empty($company)): ?>
                                    <div class="study-year">Work: <?= htmlspecialchars($company) ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FORMER STUDENTS SECTION -->
            <div class="col-lg-6">
                <div class="section-title">
                    <h4><i class="fas fa-user-graduate me-2"></i>Alumni</h4>
                    <p class="text-muted">Connect with graduates from your course</p>
                </div>
                
                <?php if (count($all_former_suggestions) > 0): ?>
                    <?php foreach ($all_former_suggestions as $person): ?>
                        <div class="mb-4">
                            <div class="modern-card">
                                <div class="card-header">
                                    <span class="user-type-badge former-badge">Alumni</span>
                                    <?php if (isset($person['score'])): ?>
                                        <div class="match-score" title="Match Score">
                                            <?= min(99, intval($person['score'])) ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="d-flex align-items-center">
                                        <img src="../oddstudents/<?= htmlspecialchars($person['profile_picture'] ?? 'default.png') ?>" 
                                             alt="Profile" 
                                             class="profile-img me-3"
                                             onerror="this.src='../uploads/profile_pictures/default.png'">
                                        <div>
                                            <h5 class="mb-1"><?= htmlspecialchars($person['full_name'] ?? 'Unknown') ?></h5>
                                            <?php if (!empty($person['course_name'])): ?>
                                                <span class="course-badge"><?= htmlspecialchars($person['course_name']) ?></span>
                                            <?php endif; ?>
                                            <?php if (!empty($person['study_year'])): ?>
                                                <div class="study-year">Graduated: <?= htmlspecialchars($person['study_year']) ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Skills Display -->
                                <?php if (!empty($person['skills'])): ?>
                                    <div class="skills-container">
                                        <div class="skills-title">
                                            <i class="fas fa-code me-1"></i>Skills
                                        </div>
                                        <div class="skills-list">
                                            <?php 
                                            $displaySkills = array_slice($person['skills'], 0, 3);
                                            foreach ($displaySkills as $skill): ?>
                                                <span class="skill-tag"><?= htmlspecialchars($skill['skill_name'] ?? 'Skill') ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                        <?php if (count($person['skills']) > 3): ?>
                                            <div class="more-skills-text">
                                                View profile to see all <?= count($person['skills']) ?> skills
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <div class="edu-work-container mb-3">
                                    <?php if (!empty($person['job_role'])): ?>
                                        <div>
                                            <h6 class="text-muted mb-1"><i class="bi bi-briefcase-fill"></i> Work</h6>
                                            <p class="mb-0">
                                                <strong><?= htmlspecialchars($person['job_role']) ?></strong>
                                                <?php if (!empty($person['job_company'])): ?>
                                                    at <?= htmlspecialchars($person['job_company']) ?>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($person['school'])): ?>
                                        <div>
                                            <h6 class="text-muted mb-1"><i class="bi bi-mortarboard"></i> Education</h6>
                                            <p class="mb-0">
                                                <?= htmlspecialchars($person['school']) ?>
                                                <?php if (!empty($person['course'])): ?>
                                                    - <?= htmlspecialchars($person['course']) ?>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="social-icons">
                                        <?php if (!empty($person['facebook'])): ?>
                                            <a href="<?= htmlspecialchars($person['facebook']) ?>" target="_blank" title="Facebook">
                                                <i class="fab fa-facebook" style="color: #1877F2;"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (!empty($person['github'])): ?>
                                            <a href="<?= htmlspecialchars($person['github']) ?>" target="_blank" title="GitHub">
                                                <i class="fab fa-github" style="color: #171515;"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (!empty($person['linkedin'])): ?>
                                            <a href="<?= htmlspecialchars($person['linkedin']) ?>" target="_blank" title="LinkedIn">
                                                <i class="fab fa-linkedin" style="color: #0077B5;"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (!empty($person['blog'])): ?>
                                            <a href="<?= htmlspecialchars($person['blog']) ?>" target="_blank" title="Blog">
                                                <i class="fas fa-blog" style="color: #fc4f08;"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <a href="former-student-profile.php?former_student_id=<?= $person['id']; ?>" 
                                       class="btn btn-sm btn-primary">View Profile</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-suggestions">
                        <i class="fas fa-user-graduate"></i>
                        <h5>No alumni found</h5>
                        <p class="text-muted">We couldn't find any alumni based on your course and information.</p>
                        <a href="browse-alumni.php" class="btn btn-primary">Browse All Alumni</a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- OTHER ACTIVE STUDENTS SECTION -->
            <div class="col-lg-6">
                <div class="section-title">
                    <h4><i class="fas fa-users me-2"></i>Current Students</h4>
                    <p class="text-muted">Connect with fellow students from your course</p>
                </div>
                
                <?php if (count($all_active_suggestions) > 0): ?>
                    <?php foreach ($all_active_suggestions as $person): ?>
                        <div class="mb-4">
                            <div class="modern-card">
                                <div class="card-header">
                                    <span class="user-type-badge active-badge">Current Student</span>
                                    <?php if (isset($person['score'])): ?>
                                        <div class="match-score" title="Match Score">
                                            <?= min(99, intval($person['score'])) ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="d-flex align-items-center">
                                        <img src="../oddstudents/<?= htmlspecialchars($person['profile_picture'] ?? 'default.png') ?>" 
                                             alt="Profile" 
                                             class="profile-img me-3"
                                             onerror="this.src='../uploads/profile_pictures/default.png'">
                                        <div>
                                            <h5 class="mb-1"><?= htmlspecialchars($person['full_name'] ?? 'Unknown') ?></h5>
                                            <?php if (!empty($person['course_name'])): ?>
                                                <span class="course-badge"><?= htmlspecialchars($person['course_name']) ?></span>
                                            <?php endif; ?>
                                            <?php if (!empty($person['study_year'])): ?>
                                                <div class="study-year">Study Year: <?= htmlspecialchars($person['study_year']) ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Skills Display -->
                                <?php if (!empty($person['skills'])): ?>
                                    <div class="skills-container">
                                        <div class="skills-title">
                                            <i class="fas fa-code me-1"></i>Skills
                                        </div>
                                        <div class="skills-list">
                                            <?php 
                                            $displaySkills = array_slice($person['skills'], 0, 3);
                                            foreach ($displaySkills as $skill): ?>
                                                <span class="skill-tag"><?= htmlspecialchars($skill['skill_name'] ?? 'Skill') ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                        <?php if (count($person['skills']) > 3): ?>
                                            <div class="more-skills-text">
                                                View profile to see all <?= count($person['skills']) ?> skills
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <div class="edu-work-container mb-3">
                                    <?php if (!empty($person['job_role'])): ?>
                                        <div>
                                            <h6 class="text-muted mb-1"><i class="bi bi-briefcase-fill"></i> Work</h6>
                                            <p class="mb-0">
                                                <strong><?= htmlspecialchars($person['job_role']) ?></strong>
                                                <?php if (!empty($person['job_company'])): ?>
                                                    at <?= htmlspecialchars($person['job_company']) ?>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($person['school'])): ?>
                                        <div>
                                            <h6 class="text-muted mb-1"><i class="bi bi-mortarboard"></i> Education</h6>
                                            <p class="mb-0">
                                                <?= htmlspecialchars($person['school']) ?>
                                                <?php if (!empty($person['course'])): ?>
                                                    - <?= htmlspecialchars($person['course']) ?>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="social-icons">
                                        <?php if (!empty($person['facebook'])): ?>
                                            <a href="<?= htmlspecialchars($person['facebook']) ?>" target="_blank" title="Facebook">
                                                <i class="fab fa-facebook" style="color: #1877F2;"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (!empty($person['github'])): ?>
                                            <a href="<?= htmlspecialchars($person['github']) ?>" target="_blank" title="GitHub">
                                                <i class="fab fa-github" style="color: #171515;"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (!empty($person['linkedin'])): ?>
                                            <a href="<?= htmlspecialchars($person['linkedin']) ?>" target="_blank" title="LinkedIn">
                                                <i class="fab fa-linkedin" style="color: #0077B5;"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (!empty($person['blog'])): ?>
                                            <a href="<?= htmlspecialchars($person['blog']) ?>" target="_blank" title="Blog">
                                                <i class="fas fa-blog" style="color: #fc4f08;"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <a href="student-profile.php?student_id=<?= $person['id']; ?>" 
                                       class="btn btn-sm btn-primary">View Profile</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-suggestions">
                        <i class="fas fa-users"></i>
                        <h5>No current students found</h5>
                        <p class="text-muted">We couldn't find any current students based on your course and information.</p>
                        <a href="browse-students.php" class="btn btn-primary">Browse All Students</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<?php 
if (file_exists("includes/footer.php")) {
    include_once("includes/footer.php");
} else {
    echo "<!-- Footer file not found -->";
}
?>

<?php 
if (file_exists("includes/js-links-inc.php")) {
    include_once("includes/js-links-inc.php");
} else {
    echo "<!-- JS links file not found -->";
}
?>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
</body>
</html>

<?php 
if (isset($conn)) {
    $conn->close();
}
?>