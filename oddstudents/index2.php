<?php
session_start();
require_once '../includes/db-conn.php';

if (!isset($_SESSION['former_student_id'])) {
    header("Location: ../index.php");
    exit();
}

$current_user_id = $_SESSION['former_student_id'];

// Get comprehensive current user data
function getUserProfileData($conn, $user_id) {
    $data = [];
    
    // Basic user info
    $stmt = $conn->prepare("
        SELECT fs.*, hc.name as course_name 
        FROM former_students fs 
        LEFT JOIN hnd_courses hc ON fs.course_id = hc.id 
        WHERE fs.id = ?
    ");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $data['basic'] = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    
    // All education history
    $stmt = $conn->prepare("
        SELECT school, field_of_study, start_year, end_year 
        FROM education 
        WHERE user_id = ? 
        ORDER BY end_year DESC
    ");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $data['education'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    
    // All work experience
    $stmt = $conn->prepare("
        SELECT company, title, industry, start_date, end_date 
        FROM experiences 
        WHERE user_id = ? 
        ORDER BY end_date DESC
    ");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $data['experience'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    
    // All skills with categories
    $stmt = $conn->prepare("
        SELECT s.skill_name, s.category
        FROM former_student_skills fss
        JOIN (
            SELECT id, skill_name, 'Business Finance' AS category FROM business_finance_skills
            UNION ALL SELECT id, skill_name, 'Engineering' FROM engineering_skills
            UNION ALL SELECT id, skill_name, 'HND Accountancy' FROM hnd_accountancy_skills
            UNION ALL SELECT id, skill_name, 'HND Agriculture' FROM hnd_agriculture_skills
            UNION ALL SELECT id, skill_name, 'HND Building Services' FROM hnd_building_services_skills
            UNION ALL SELECT id, skill_name, 'HND Business Admin' FROM hnd_business_admin_skills
            UNION ALL SELECT id, skill_name, 'HND English' FROM hnd_english_skills
            UNION ALL SELECT id, skill_name, 'HND Food Tech' FROM hnd_food_tech_skills
            UNION ALL SELECT id, skill_name, 'HND Management' FROM hnd_management_skills
            UNION ALL SELECT id, skill_name, 'HND Mechanical' FROM hnd_mechanical_skills
            UNION ALL SELECT id, skill_name, 'HND Quantity Survey' FROM hnd_quantity_survey_skills
            UNION ALL SELECT id, skill_name, 'HND THM' FROM hnd_thm_skills
            UNION ALL SELECT id, skill_name, 'IT' FROM it_student_skills
        ) s ON fss.skill_id = s.id
        WHERE fss.student_id = ?
    ");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $data['skills'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    
    return $data;
}

// Advanced matching algorithm with multiple factors
function calculateMatchScore($current_user, $other_user) {
    $score = 0;
    $max_possible_score = 0;
    
    // 1. Course Similarity (Highest Priority)
    $course_weight = 0.25;
    if ($current_user['basic']['course_id'] == $other_user['basic']['course_id']) {
        $score += 100 * $course_weight;
    }
    $max_possible_score += 100 * $course_weight;
    
    // 2. Education Similarity
    $education_weight = 0.20;
    $edu_score = calculateEducationSimilarity($current_user['education'], $other_user['education']);
    $score += $edu_score * $education_weight;
    $max_possible_score += 100 * $education_weight;
    
    // 3. Work Experience Similarity
    $work_weight = 0.20;
    $work_score = calculateWorkSimilarity($current_user['experience'], $other_user['experience']);
    $score += $work_score * $work_weight;
    $max_possible_score += 100 * $work_weight;
    
    // 4. Skills Compatibility
    $skills_weight = 0.15;
    $skills_score = calculateSkillsCompatibility($current_user['skills'], $other_user['skills']);
    $score += $skills_score * $skills_weight;
    $max_possible_score += 100 * $skills_weight;
    
    // 5. Study Year Proximity
    $year_weight = 0.10;
    $year_score = calculateYearProximity($current_user['basic']['study_year'], $other_user['basic']['study_year']);
    $score += $year_score * $year_weight;
    $max_possible_score += 100 * $year_weight;
    
    // 6. Career Path Alignment
    $career_weight = 0.10;
    $career_score = calculateCareerAlignment($current_user, $other_user);
    $score += $career_score * $career_weight;
    $max_possible_score += 100 * $career_weight;
    
    // Normalize to 0-100 scale
    if ($max_possible_score > 0) {
        $normalized_score = ($score / $max_possible_score) * 100;
    } else {
        $normalized_score = 0;
    }
    
    return min(100, max(0, round($normalized_score)));
}

function calculateEducationSimilarity($current_edu, $other_edu) {
    if (empty($current_edu) || empty($other_edu)) return 0;
    
    $score = 0;
    $max_per_field = 25; // Max points per matching field
    
    foreach ($current_edu as $current) {
        foreach ($other_edu as $other) {
            $field_score = 0;
            
            // School match
            if (!empty($current['school']) && !empty($other['school']) && 
                similar_text(strtolower($current['school']), strtolower($other['school'])) > 80) {
                $field_score += 10;
            }
            
            // Field of study match
            if (!empty($current['field_of_study']) && !empty($other['field_of_study']) && 
                similar_text(strtolower($current['field_of_study']), strtolower($other['field_of_study'])) > 70) {
                $field_score += 15;
            }
            
            // Time proximity (studied around same time)
            if (!empty($current['end_year']) && !empty($other['end_year'])) {
                $year_diff = abs($current['end_year'] - $other['end_year']);
                if ($year_diff <= 2) {
                    $field_score += 5;
                } elseif ($year_diff <= 5) {
                    $field_score += 2;
                }
            }
            
            $score = max($score, $field_score);
        }
    }
    
    return min($max_per_field, $score);
}

function calculateWorkSimilarity($current_work, $other_work) {
    if (empty($current_work) || empty($other_work)) return 0;
    
    $score = 0;
    $max_per_job = 30;
    
    foreach ($current_work as $current) {
        foreach ($other_work as $other) {
            $job_score = 0;
            
            // Company match
            if (!empty($current['company']) && !empty($other['company']) && 
                similar_text(strtolower($current['company']), strtolower($other['company'])) > 80) {
                $job_score += 12;
            }
            
            // Job title similarity
            if (!empty($current['title']) && !empty($other['title'])) {
                $title_similarity = similar_text(strtolower($current['title']), strtolower($other['title']));
                if ($title_similarity > 85) {
                    $job_score += 15;
                } elseif ($title_similarity > 70) {
                    $job_score += 10;
                } elseif ($title_similarity > 50) {
                    $job_score += 5;
                }
            }
            
            // Industry match
            if (!empty($current['industry']) && !empty($other['industry']) && 
                $current['industry'] == $other['industry']) {
                $job_score += 8;
            }
            
            $score = max($score, $job_score);
        }
    }
    
    return min($max_per_job, $score);
}

function calculateSkillsCompatibility($current_skills, $other_skills) {
    if (empty($current_skills) || empty($other_skills)) return 0;
    
    $current_skill_names = array_column($current_skills, 'skill_name');
    $other_skill_names = array_column($other_skills, 'skill_name');
    
    // Exact matches
    $exact_matches = array_intersect($current_skill_names, $other_skill_names);
    $exact_score = count($exact_matches) * 3;
    
    // Category matches
    $current_categories = array_unique(array_column($current_skills, 'category'));
    $other_categories = array_unique(array_column($other_skills, 'category'));
    $category_matches = array_intersect($current_categories, $other_categories);
    $category_score = count($category_matches) * 2;
    
    // Complementary skills (skills current user doesn't have but other user has)
    $complementary_skills = array_diff($other_skill_names, $current_skill_names);
    $complementary_score = min(10, count($complementary_skills) * 0.5);
    
    $total_score = $exact_score + $category_score + $complementary_score;
    return min(40, $total_score); // Cap at 40 points
}

function calculateYearProximity($current_year, $other_year) {
    if (empty($current_year) || empty($other_year)) return 0;
    
    $year_diff = abs($current_year - $other_year);
    
    if ($year_diff == 0) return 15;
    if ($year_diff == 1) return 12;
    if ($year_diff == 2) return 8;
    if ($year_diff == 3) return 5;
    if ($year_diff <= 5) return 2;
    
    return 0;
}

function calculateCareerAlignment($current_user, $other_user) {
    $score = 0;
    
    // Check if career paths are similar (education -> work progression)
    $current_career_path = getCareerPathType($current_user);
    $other_career_path = getCareerPathType($other_user);
    
    if ($current_career_path == $other_career_path) {
        $score += 20;
    }
    
    // Check for mentor-mentee potential (experienced vs new)
    $current_experience_level = getExperienceLevel($current_user['experience']);
    $other_experience_level = getExperienceLevel($other_user['experience']);
    
    $experience_diff = abs($current_experience_level - $other_experience_level);
    if ($experience_diff >= 2) { // Good mentor-mentee match
        $score += 15;
    } elseif ($experience_diff <= 1) { // Good peer match
        $score += 10;
    }
    
    return min(35, $score);
}

function getCareerPathType($user) {
    $edu_fields = array_column($user['education'] ?? [], 'field_of_study');
    $work_titles = array_column($user['experience'] ?? [], 'title');
    
    $fields_str = implode(' ', $edu_fields);
    $titles_str = implode(' ', $work_titles);
    
    $all_text = $fields_str . ' ' . $titles_str;
    
    if (stripos($all_text, 'manager') !== false || stripos($all_text, 'director') !== false) {
        return 'management';
    } elseif (stripos($all_text, 'developer') !== false || stripos($all_text, 'engineer') !== false) {
        return 'technical';
    } elseif (stripos($all_text, 'analyst') !== false || stripos($all_text, 'data') !== false) {
        return 'analytical';
    } elseif (stripos($all_text, 'sales') !== false || stripos($all_text, 'marketing') !== false) {
        return 'commercial';
    } else {
        return 'general';
    }
}

function getExperienceLevel($experiences) {
    $years = 0;
    foreach ($experiences as $exp) {
        if (!empty($exp['start_date']) && !empty($exp['end_date'])) {
            $start = new DateTime($exp['start_date']);
            $end = new DateTime($exp['end_date']);
            $years += $start->diff($end)->y;
        }
    }
    
    if ($years >= 10) return 5;
    if ($years >= 7) return 4;
    if ($years >= 5) return 3;
    if ($years >= 3) return 2;
    if ($years >= 1) return 1;
    return 0;
}

// Main matching logic
$current_user = getUserProfileData($conn, $current_user_id);

// Get all potential matches (approved users excluding current user)
$stmt = $conn->prepare("
    SELECT DISTINCT fs.id
    FROM former_students fs
    WHERE fs.id != ? AND fs.status = 'approved'
    LIMIT 200
");
$stmt->bind_param("i", $current_user_id);
$stmt->execute();
$potential_user_ids = array_column($stmt->get_result()->fetch_all(MYSQLI_ASSOC), 'id');
$stmt->close();

// Calculate matches with scores
$matches_with_scores = [];
foreach ($potential_user_ids as $user_id) {
    $other_user = getUserProfileData($conn, $user_id);
    $match_score = calculateMatchScore($current_user, $other_user);
    
    if ($match_score >= 20) { // Only include matches with reasonable scores
        $matches_with_scores[] = [
            'user_data' => $other_user['basic'],
            'education' => $other_user['education'][0] ?? [], // Latest education
            'experience' => $other_user['experience'][0] ?? [], // Latest experience
            'skills' => $other_user['skills'],
            'match_score' => $match_score
        ];
    }
}

// Sort by match score (descending)
usort($matches_with_scores, function($a, $b) {
    return $b['match_score'] - $a['match_score'];
});

// Take top 20 matches
$suggestions = array_slice($matches_with_scores, 0, 20);

// If no good matches, fallback to same course
if (empty($suggestions) && !empty($current_user['basic']['course_id'])) {
    $fallback_stmt = $conn->prepare("
        SELECT fs.*, hc.name as course_name
        FROM former_students fs
        LEFT JOIN hnd_courses hc ON fs.course_id = hc.id
        WHERE fs.id != ? AND fs.status = 'approved' AND fs.course_id = ?
        ORDER BY RAND()
        LIMIT 20
    ");
    $fallback_stmt->bind_param("ii", $current_user_id, $current_user['basic']['course_id']);
    $fallback_stmt->execute();
    $fallback_result = $fallback_stmt->get_result();
    
    while ($row = $fallback_result->fetch_assoc()) {
        $other_user = getUserProfileData($conn, $row['id']);
        $suggestions[] = [
            'user_data' => $row,
            'education' => $other_user['education'][0] ?? [],
            'experience' => $other_user['experience'][0] ?? [],
            'skills' => $other_user['skills'],
            'match_score' => 15 // Base score for same course
        ];
    }
    $fallback_stmt->close();
}
?>

<!-- Rest of your HTML remains the same, just update the display to use the new structure -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>AI-Powered Connections</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <?php include_once("../includes/css-links-inc.php"); ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        /* Add a progress bar for match score */
        .match-progress {
            height: 6px;
            background: #e9ecef;
            border-radius: 3px;
            margin-top: 5px;
            overflow: hidden;
        }
        
        .match-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #28a745, #20c997);
            border-radius: 3px;
            transition: width 0.3s ease;
        }
        
        .match-quality {
            font-size: 0.75rem;
            color: #6c757d;
            margin-top: 2px;
        }
        
        .ai-badge {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 0.7rem;
            font-weight: 500;
        }
    </style>
</head>
<body>
<?php include_once("../includes/header.php"); ?>
<?php include_once("../includes/formers-sidebar.php"); ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>AI-Powered Connections <span class="ai-badge">Smart Matching</span></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Smart Connections</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <!-- Current User Info Card -->
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Your Profile <small class="text-muted">(AI Matching Base)</small></h5>
                        <div class="d-flex align-items-center">
                            <img src="<?= htmlspecialchars($current_user['basic']['profile_picture']) ?>" alt="Profile" class="profile-img me-3">
                            <div>
                                <h6 class="mb-1"><?= htmlspecialchars($current_user['basic']['username']) ?></h6>
                                <?php if (!empty($current_user['basic']['course_name'])): ?>
                                    <span class="course-badge"><?= htmlspecialchars($current_user['basic']['course_name']) ?></span>
                                <?php endif; ?>
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <i class="fas fa-graduation-cap me-1"></i>
                                        <?= count($current_user['education']) ?> Education entries
                                    </small>
                                    <small class="text-muted ms-3">
                                        <i class="fas fa-briefcase me-1"></i>
                                        <?= count($current_user['experience']) ?> Work experiences
                                    </small>
                                    <small class="text-muted ms-3">
                                        <i class="fas fa-code me-1"></i>
                                        <?= count($current_user['skills']) ?> Skills
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- AI-Powered Suggestions -->
            <?php if (count($suggestions) > 0): ?>
                <div class="col-12">
                    <h5 class="mb-3">
                        Smart Matches Based On: 
                        <small class="text-muted">Course, Education, Work, Skills & Career Path</small>
                    </h5>
                </div>
                <?php foreach ($suggestions as $person): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="modern-card">
                            <div class="card-header">
                                <div class="match-score" title="AI Match Score: <?= $person['match_score'] ?>%">
                                    <?= $person['match_score'] ?>
                                </div>
                                <div class="d-flex align-items-center">
                                    <img src="../oddstudents/<?= htmlspecialchars($person['user_data']['profile_picture']) ?>" 
                                         alt="Profile" 
                                         class="profile-img me-3"
                                         onerror="this.src='../uploads/profile_pictures/default.png'">
                                    <div>
                                        <h5 class="mb-1"><?= htmlspecialchars($person['user_data']['username']) ?></h5>
                                        <?php if (!empty($person['user_data']['course_name'])): ?>
                                            <span class="course-badge"><?= htmlspecialchars($person['user_data']['course_name']) ?></span>
                                        <?php endif; ?>
                                        <div class="match-progress">
                                            <div class="match-progress-bar" style="width: <?= $person['match_score'] ?>%"></div>
                                        </div>
                                        <div class="match-quality">
                                            <?php if ($person['match_score'] >= 80): ?>
                                                Excellent Match
                                            <?php elseif ($person['match_score'] >= 60): ?>
                                                Strong Match
                                            <?php elseif ($person['match_score'] >= 40): ?>
                                                Good Match
                                            <?php else: ?>
                                                Potential Connection
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Skills Display -->
                            <?php if (!empty($person['skills'])): ?>
                                <div class="skills-container">
                                    <div class="skills-title">
                                        <i class="fas fa-code me-1"></i>Top Skills
                                    </div>
                                    <div class="skills-list">
                                        <?php 
                                        $displaySkills = array_slice($person['skills'], 0, 5);
                                        foreach ($displaySkills as $skill): ?>
                                            <span class="skill-tag"><?= htmlspecialchars($skill['skill_name']) ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php if (count($person['skills']) > 5): ?>
                                        <div class="more-skills-text">
                                            +<?= count($person['skills']) - 5 ?> more skills
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <div class="edu-work-container mb-3">
                                <?php if (!empty($person['experience']['title'])): ?>
                                    <div>
                                        <h6 class="text-muted mb-1"><i class="bi bi-briefcase-fill"></i> Current Role</h6>
                                        <p class="mb-0">
                                            <strong><?= htmlspecialchars($person['experience']['title']) ?></strong>
                                            <?php if (!empty($person['experience']['company'])): ?>
                                                at <?= htmlspecialchars($person['experience']['company']) ?>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($person['education']['school'])): ?>
                                    <div>
                                        <h6 class="text-muted mb-1"><i class="bi bi-mortarboard"></i> Education</h6>
                                        <p class="mb-0">
                                            <?= htmlspecialchars($person['education']['school']) ?>
                                            <?php if (!empty($person['education']['field_of_study'])): ?>
                                                - <?= htmlspecialchars($person['education']['field_of_study']) ?>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <div class="social-icons">
                                    <?php if (!empty($person['user_data']['facebook'])): ?>
                                        <a href="<?= htmlspecialchars($person['user_data']['facebook']) ?>" target="_blank" title="Facebook">
                                            <i class="fab fa-facebook" style="color: #1877F2;"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($person['user_data']['github'])): ?>
                                        <a href="<?= htmlspecialchars($person['user_data']['github']) ?>" target="_blank" title="GitHub">
                                            <i class="fab fa-github" style="color: #171515;"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($person['user_data']['linkedin'])): ?>
                                        <a href="<?= htmlspecialchars($person['user_data']['linkedin']) ?>" target="_blank" title="LinkedIn">
                                            <i class="fab fa-linkedin" style="color: #0077B5;"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <a href="former-student-profile.php?former_student_id=<?= $person['user_data']['id']; ?>" 
                                   class="btn btn-sm btn-primary">View Profile</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="no-suggestions">
                        <i class="fas fa-robot"></i>
                        <h5>No AI Matches Found</h5>
                        <p class="text-muted">Our AI couldn't find strong matches based on your profile. Try updating your education and work experience.</p>
                        <a href="edit-profile.php" class="btn btn-primary me-2">Update Profile</a>
                        <a href="browse-profiles.php" class="btn btn-outline-primary">Browse All</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include_once("../includes/footer.php"); ?>
<?php include_once("../includes/js-links-inc.php"); ?>
</body>
</html>

<?php $conn->close(); ?>