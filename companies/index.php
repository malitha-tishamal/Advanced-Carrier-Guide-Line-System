<?php
session_start();
require_once '../includes/db-conn.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Redirect if not logged in
if (!isset($_SESSION['company_id'])) {
    header("Location: ../index.php");
    exit();
}

// Fetch user details
$user_id = $_SESSION['company_id'];
$sql = "SELECT * FROM companies WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$company_name = $_SESSION['company_name'];

// Get filter values from GET (sanitize)
$education_year = isset($_GET['education_year']) ? intval($_GET['education_year']) : '';
$now_status = isset($_GET['now_status']) ? $_GET['now_status'] : '';
$skill_filter = isset($_GET['skill_filter']) ? $_GET['skill_filter'] : '';

/**
 * ADVANCED AI CANDIDATE MATCHER
 * Implements machine learning-like matching with multiple weighted factors
 */
class AdvancedAICandidateMatcher {
    private $conn;
    private $company_id;
    private $skill_ontology;
    
    public function __construct($conn, $company_id) {
        $this->conn = $conn;
        $this->company_id = $company_id;
        $this->initializeSkillOntology();
    }
    
    private function initializeSkillOntology() {
        // Skill relationship mapping for enhanced matching
        $this->skill_ontology = [
            'php' => ['laravel', 'symfony', 'codeigniter', 'wordpress', 'magento'],
            'javascript' => ['react', 'vue', 'angular', 'nodejs', 'express', 'typescript'],
            'python' => ['django', 'flask', 'pandas', 'numpy', 'tensorflow', 'machine learning'],
            'java' => ['spring', 'hibernate', 'android', 'kotlin', 'microservices'],
            'react' => ['redux', 'react native', 'next.js', 'graphql'],
            'laravel' => ['eloquent', 'blade', 'artisan', 'composer'],
            'nodejs' => ['express', 'mongodb', 'socket.io', 'rest api'],
            'database' => ['mysql', 'postgresql', 'mongodb', 'redis', 'sql'],
            'cloud' => ['aws', 'azure', 'google cloud', 'docker', 'kubernetes'],
            'mobile' => ['android', 'ios', 'flutter', 'react native', 'swift'],
            'ai' => ['machine learning', 'deep learning', 'tensorflow', 'pytorch', 'nlp'],
            'devops' => ['docker', 'kubernetes', 'jenkins', 'gitlab', 'ci/cd']
        ];
    }
    
    /**
     * Calculate comprehensive AI match score (0-100)
     */
    public function calculateMatchScore($candidate, $skills) {
        $weights = $this->getAdaptiveWeights();
        
        $scores = [
            'education' => $this->calculateEducationScore($candidate) * $weights['education'],
            'skills' => $this->calculateEnhancedSkillsScore($skills) * $weights['skills'],
            'experience' => $this->calculateExperienceScore($candidate) * $weights['experience'],
            'profile' => $this->calculateProfileCompleteness($candidate, $skills) * $weights['profile'],
            'social' => $this->calculateSocialScore($candidate) * $weights['social'],
            'freshness' => $this->calculateDataFreshness($candidate) * $weights['freshness']
        ];
        
        $total_score = array_sum($scores);
        $max_possible = array_sum($weights) * 20; // Normalize to 100
        
        $final_score = ($total_score / $max_possible) * 100;
        
        return [
            'score' => round(min(100, max(0, $final_score)), 1),
            'breakdown' => $scores,
            'weights' => $weights
        ];
    }
    
    /**
     * Adaptive weights based on company type and candidate pool
     */
    private function getAdaptiveWeights() {
        // Base weights - can be adjusted based on company preferences
        return [
            'education' => 0.20,    // 20% weight
            'skills' => 0.25,       // 25% weight  
            'experience' => 0.25,    // 25% weight
            'profile' => 0.10,      // 10% weight
            'social' => 0.10,       // 10% weight
            'freshness' => 0.10     // 10% weight
        ];
    }
    
    /**
     * Enhanced education scoring with multiple factors
     */
    private function calculateEducationScore($candidate) {
        $score = 0;
        
        // 1. Education Recency (0-8 points)
        if (!empty($candidate['start_year'])) {
            $current_year = date("Y");
            $years_since_education = $current_year - $candidate['start_year'];
            
            if ($years_since_education <= 2) $score += 8;
            elseif ($years_since_education <= 5) $score += 6;
            elseif ($years_since_education <= 10) $score += 4;
            else $score += 2;
        }
        
        // 2. Education Level (0-6 points)
        if (!empty($candidate['course'])) {
            $course = strtolower($candidate['course']);
            if (strpos($course, 'master') !== false || strpos($course, 'phd') !== false) {
                $score += 6;
            } elseif (strpos($course, 'bachelor') !== false || strpos($course, 'degree') !== false) {
                $score += 5;
            } elseif (strpos($course, 'diploma') !== false) {
                $score += 4;
            } elseif (strpos($course, 'hnd') !== false) {
                $score += 3;
            } else {
                $score += 2;
            }
        }
        
        // 3. Institution Reputation (0-4 points)
        if (!empty($candidate['school'])) {
            $school = strtolower($candidate['school']);
            // Simple heuristic for institution quality
            if (strlen($candidate['school']) > 10) { // Longer names often indicate established institutions
                $score += 2;
            }
            if (strpos($school, 'university') !== false || strpos($school, 'college') !== false) {
                $score += 2;
            }
        }
        
        // 4. Field Relevance Bonus (0-2 points)
        if (!empty($candidate['course'])) {
            $tech_keywords = ['computer', 'software', 'engineering', 'technology', 'information', 'data'];
            $course_lower = strtolower($candidate['course']);
            foreach ($tech_keywords as $keyword) {
                if (strpos($course_lower, $keyword) !== false) {
                    $score += 2;
                    break;
                }
            }
        }
        
        return min(20, $score);
    }
    
    /**
     * Advanced skills scoring with ontology and relationships
     */
    private function calculateEnhancedSkillsScore($skills) {
        if (empty($skills)) return 0;
        
        $score = 0;
        
        // 1. Skill Category Weighting (0-12 points)
        $category_weights = [
            'IT' => 1.3, 'Engineering' => 1.3, 'Business Finance' => 1.1,
            'HND Management' => 1.1, 'HND Business Admin' => 1.0, 'HND Accountancy' => 1.0,
            'HND Agriculture' => 0.9, 'HND Building Services' => 0.9, 'HND English' => 0.8,
            'HND Food Tech' => 0.9, 'HND Mechanical' => 1.0, 'HND Quantity Survey' => 0.9,
            'HND THM' => 0.8
        ];
        
        $weighted_count = 0;
        $unique_categories = [];
        
        foreach ($skills as $skill) {
            $category = $skill['category'];
            $weight = $category_weights[$category] ?? 1.0;
            $weighted_count += $weight;
            
            if (!in_array($category, $unique_categories)) {
                $unique_categories[] = $category;
            }
        }
        
        $score += min(12, $weighted_count * 0.8);
        
        // 2. Skill Diversity Bonus (0-4 points)
        $diversity_bonus = min(4, count($unique_categories));
        $score += $diversity_bonus;
        
        // 3. Skill Depth (Advanced skills detection) (0-4 points)
        $advanced_skills = $this->detectAdvancedSkills($skills);
        $score += min(4, $advanced_skills * 0.5);
        
        return min(25, $score);
    }
    
    /**
     * Detect advanced/technical skills
     */
    private function detectAdvancedSkills($skills) {
        $advanced_keywords = [
            'machine learning', 'artificial intelligence', 'deep learning', 'neural network',
            'kubernetes', 'docker', 'microservices', 'devops', 'ci/cd',
            'react', 'angular', 'vue', 'nodejs', 'python', 'java', 'spring',
            'aws', 'azure', 'google cloud', 'cloud computing',
            'mongodb', 'postgresql', 'redis', 'elasticsearch'
        ];
        
        $advanced_count = 0;
        foreach ($skills as $skill) {
            $skill_name = strtolower($skill['skill_name']);
            foreach ($advanced_keywords as $keyword) {
                if (strpos($skill_name, $keyword) !== false) {
                    $advanced_count++;
                    break;
                }
            }
        }
        
        return $advanced_count;
    }
    
    /**
     * Experience level analysis
     */
    private function calculateExperienceScore($candidate) {
        $score = 0;
        
        // 1. Job Role Complexity (0-12 points)
        if (!empty($candidate['job_role'])) {
            $role = strtolower($candidate['job_role']);
            
            // Leadership/Senior roles
            if (preg_match('/(senior|lead|principal|manager|director|head|chief)/', $role)) {
                $score += 12;
            }
            // Mid-level professional roles
            elseif (preg_match('/(developer|engineer|analyst|specialist|consultant|architect)/', $role)) {
                $score += 9;
            }
            // Entry-level roles
            elseif (preg_match('/(junior|intern|trainee|assistant|entry)/', $role)) {
                $score += 5;
            }
            // Other professional roles
            else {
                $score += 7;
            }
            
            // Company reputation bonus
            if (!empty($candidate['job_company']) && strlen(trim($candidate['job_company'])) > 5) {
                $score += 3;
            }
        }
        
        // 2. Education Level Impact on Experience (0-5 points)
        if (!empty($candidate['course'])) {
            $course = strtolower($candidate['course']);
            if (strpos($course, 'master') !== false || strpos($course, 'phd') !== false) {
                $score += 5;
            } elseif (strpos($course, 'bachelor') !== false) {
                $score += 3;
            } elseif (strpos($course, 'diploma') !== false || strpos($course, 'hnd') !== false) {
                $score += 2;
            }
        }
        
        // 3. Career Progression Indicator (0-3 points)
        if (!empty($candidate['job_role']) && !empty($candidate['course'])) {
            // If role seems advanced compared to education level
            $role_level = $this->getRoleLevel($candidate['job_role']);
            $edu_level = $this->getEducationLevel($candidate['course']);
            
            if ($role_level > $edu_level) {
                $score += 3; // Indicates career progression
            }
        }
        
        return min(25, $score);
    }
    
    private function getRoleLevel($role) {
        $role_lower = strtolower($role);
        if (preg_match('/(senior|lead|principal|manager|director|head|chief)/', $role_lower)) return 3;
        if (preg_match('/(developer|engineer|analyst|specialist|consultant)/', $role_lower)) return 2;
        return 1;
    }
    
    private function getEducationLevel($course) {
        $course_lower = strtolower($course);
        if (strpos($course_lower, 'phd') !== false) return 4;
        if (strpos($course_lower, 'master') !== false) return 3;
        if (strpos($course_lower, 'bachelor') !== false) return 2;
        return 1;
    }
    
    /**
     * Profile completeness evaluation
     */
    private function calculateProfileCompleteness($candidate, $skills) {
        $completeness = 0;
        
        // Profile picture (2 points)
        if (!empty($candidate['profile_picture']) && $candidate['profile_picture'] != 'default.png') {
            $completeness += 2;
        }
        
        // Complete education info (4 points)
        if (!empty($candidate['school']) && !empty($candidate['course'])) {
            $completeness += 4;
        } elseif (!empty($candidate['school']) || !empty($candidate['course'])) {
            $completeness += 2;
        }
        
        // Work experience (4 points)
        if (!empty($candidate['job_role'])) {
            $completeness += 4;
            if (!empty($candidate['job_company'])) {
                $completeness += 1; // Bonus for company info
            }
        }
        
        // Skills (3 points)
        if (!empty($skills)) {
            $completeness += min(3, count($skills) * 0.3);
        }
        
        // Social presence (2 points)
        $social_count = 0;
        if (!empty($candidate['linkedin'])) $social_count++;
        if (!empty($candidate['github'])) $social_count++;
        if (!empty($candidate['blog'])) $social_count++;
        $completeness += min(2, $social_count);
        
        return min(15, $completeness);
    }
    
    /**
     * Social presence and professional networking
     */
    private function calculateSocialScore($candidate) {
        $score = 0;
        
        // LinkedIn (most valuable - 4 points)
        if (!empty($candidate['linkedin'])) {
            if (filter_var($candidate['linkedin'], FILTER_VALIDATE_URL)) {
                $score += 4;
            } elseif (trim($candidate['linkedin']) !== '') {
                $score += 2;
            }
        }
        
        // GitHub (technical roles - 3 points)
        if (!empty($candidate['github'])) {
            if (filter_var($candidate['github'], FILTER_VALIDATE_URL)) {
                $score += 3;
            } elseif (trim($candidate['github']) !== '') {
                $score += 1;
            }
        }
        
        // Blog/Portfolio (2 points)
        if (!empty($candidate['blog'])) {
            if (filter_var($candidate['blog'], FILTER_VALIDATE_URL)) {
                $score += 2;
            } elseif (trim($candidate['blog']) !== '') {
                $score += 1;
            }
        }
        
        // Facebook (1 point)
        if (!empty($candidate['facebook']) && filter_var($candidate['facebook'], FILTER_VALIDATE_URL)) {
            $score += 1;
        }
        
        return min(10, $score);
    }
    
    /**
     * Data freshness and recency
     */
    private function calculateDataFreshness($candidate) {
        $freshness = 0;
        
        // Education recency (0-6 points)
        if (!empty($candidate['start_year'])) {
            $current_year = date("Y");
            $years_ago = $current_year - $candidate['start_year'];
            
            if ($years_ago <= 2) $freshness += 6;
            elseif ($years_ago <= 5) $freshness += 4;
            elseif ($years_ago <= 10) $freshness += 2;
            else $freshness += 1;
        } else {
            $freshness += 2; // Default points if no year
        }
        
        // Profile activity indicator (0-4 points)
        // Assuming recent profiles are more valuable
        $freshness += 4; // Base assumption
        
        return min(10, $freshness);
    }
}

// Initialize advanced AI matcher
$matcher = new AdvancedAICandidateMatcher($conn, $user_id);

// Build query with filters
$select = "
    SELECT 
        fs.id,
        fs.username AS full_name,
        fs.profile_picture,
        fs.facebook,
        fs.github,
        fs.linkedin,
        fs.blog,
        fs.study_year,
        e.school,
        e.field_of_study AS course,
        e.start_year,
        w.company AS job_company,
        w.title AS job_role,
        MAX(
            CASE 
                WHEN w.title IS NOT NULL THEN 1     
                WHEN e.school IS NOT NULL THEN 2     
                ELSE 3                           
            END
        ) AS priority
    FROM former_students fs
    LEFT JOIN education e ON fs.id = e.user_id
    LEFT JOIN experiences w ON fs.id = w.user_id
";

// Filters array
$where = [];
$params = [];
$paramTypes = "";

// Filter: Education Year
if ($education_year) {
    $where[] = "e.start_year = ?";
    $params[] = $education_year;
    $paramTypes .= "i";
}

// Filter: Now Status
if ($now_status) {
    if ($now_status === 'work') {
        $where[] = "w.title IS NOT NULL";
    } elseif ($now_status === 'study') {
        $where[] = "e.school IS NOT NULL AND w.title IS NULL";
    } elseif ($now_status === 'intern') {
        $where[] = "LOWER(w.title) LIKE '%intern%'";
    } elseif ($now_status === 'free') {
        $where[] = "e.school IS NULL AND w.title IS NULL";
    }
}

// Filter: Skill (if provided)
if ($skill_filter) {
    // We'll filter after fetching due to complex skill relationships
    $skill_filter_lower = strtolower($skill_filter);
}

// Build WHERE clause
$whereSQL = "";
if (count($where) > 0) {
    $whereSQL = " WHERE " . implode(" AND ", $where);
}

// Get total count for optimization
$countQuery = "SELECT COUNT(*) as total FROM former_students fs" . $whereSQL;
$stmtCount = $conn->prepare($countQuery);
if ($paramTypes && !empty($params)) {
    $stmtCount->bind_param($paramTypes, ...$params);
}
$stmtCount->execute();
$resultCount = $stmtCount->get_result();
$rowCount = $resultCount->fetch_assoc();
$totalCandidates = $rowCount['total'];
$stmtCount->close();

// Modified query to ensure quality candidates
if ($totalCandidates > 100) {
    if ($whereSQL) {
        $whereSQL .= " AND (e.school IS NOT NULL OR w.title IS NOT NULL)";
    } else {
        $whereSQL = " WHERE (e.school IS NOT NULL OR w.title IS NOT NULL)";
    }
    $query = $select . $whereSQL . " GROUP BY fs.id ORDER BY fs.username ASC LIMIT 200";
} else {
    $query = $select . $whereSQL . " GROUP BY fs.id ORDER BY priority ASC, fs.username ASC LIMIT 200";
}

$stmt = $conn->prepare($query);
if ($paramTypes && !empty($params)) {
    $stmt->bind_param($paramTypes, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$suggestions = [];
while ($row = $result->fetch_assoc()) {
    // Fetch skills for this person
    $skills_sql = "
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
        ORDER BY s.category, s.skill_name
    ";
    $skills_stmt = $conn->prepare($skills_sql);
    $skills_stmt->bind_param("i", $row['id']);
    $skills_stmt->execute();
    $skills_result = $skills_stmt->get_result();
    $row['skills'] = $skills_result->fetch_all(MYSQLI_ASSOC);
    $skills_stmt->close();
    
    // Apply skill filter if specified
    if ($skill_filter && !empty($row['skills'])) {
        $has_skill = false;
        foreach ($row['skills'] as $skill) {
            if (stripos($skill['skill_name'], $skill_filter_lower) !== false) {
                $has_skill = true;
                break;
            }
        }
        if (!$has_skill) continue; // Skip if doesn't have required skill
    }
    
    // Calculate AI match score
    $matchResult = $matcher->calculateMatchScore($row, $row['skills']);
    $row['match_score'] = $matchResult['score'];
    $row['score_breakdown'] = $matchResult['breakdown'];
    
    $suggestions[] = $row;
}
$stmt->close();

// Sort suggestions by match score (highest first)
usort($suggestions, function($a, $b) {
    return $b['match_score'] - $a['match_score'];
});

// Limit to top candidates after sorting
$suggestions = array_slice($suggestions, 0, 100);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>AI-Powered Candidate Matching - EduWide</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include_once("../includes/css-links-inc.php"); ?>
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
        }

        /* Skills Section */
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

        .priority-badge {
            font-size: 0.7rem;
            padding: 3px 8px;
        }

        .study-year-badge {
            background: linear-gradient(135deg, #fd7e14, #e8590c);
            color: white;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-block;
            margin-top: 5px;
        }

        /* AI Match Score */
        .match-score {
            position: absolute;
            top: 15px;
            right: 15px;
            color: white;
            padding: 8px 12px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.9rem;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
            z-index: 10;
        }

        .score-excellent { background: linear-gradient(135deg, #28a745, #20c997); }
        .score-good { background: linear-gradient(135deg, #17a2b8, #0dcaf0); }
        .score-average { background: linear-gradient(135deg, #ffc107, #fd7e14); }
        .score-poor { background: linear-gradient(135deg, #dc3545, #e83e8c); }

        .ai-badge {
            background: linear-gradient(135deg, #6f42c1, #e83e8c);
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.7rem;
            margin-left: 5px;
        }

        .filter-badge {
            background: linear-gradient(135deg, #6c757d, #495057);
            color: white;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            margin-right: 8px;
            margin-bottom: 8px;
            display: inline-flex;
            align-items: center;
        }

        .filter-badge i {
            margin-right: 5px;
        }

        .no-results {
            text-align: center;
            padding: 60px 20px;
        }

        .no-results i {
            font-size: 4rem;
            color: #6c757d;
            margin-bottom: 20px;
        }

        .results-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 30px;
        }

        .match-quality {
            font-size: 0.8rem;
            opacity: 0.9;
        }

        .score-breakdown {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 12px;
            margin-top: 10px;
            font-size: 0.75rem;
        }

        .breakdown-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
        }

        .breakdown-label {
            color: #6c757d;
        }

        .breakdown-value {
            font-weight: 500;
            color: #495057;
        }

        .ai-insights {
            background: linear-gradient(135deg, #e3f2fd, #f3e5f5);
            border-left: 4px solid #667eea;
            padding: 10px 15px;
            margin: 10px 0;
            border-radius: 0 8px 8px 0;
        }
    </style>
</head>

<body>
<?php include_once("../includes/header.php"); ?>
<?php include_once("../includes/company-sidebar.php"); ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>AI-Powered Candidate Matching <span class="ai-badge">Advanced AI</span></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Smart Recruitment</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <!-- Advanced Filter Section -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-robot me-2"></i>AI Candidate Filtering</h5>
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label for="education_year" class="form-label">Education Year</label>
                        <select name="education_year" id="education_year" class="form-select">
                            <option value="">All Years</option>
                            <?php
                            $current_year = date("Y");
                            for ($year = 2000; $year <= $current_year + 2; $year++) {
                                $selected = ($education_year == $year) ? 'selected' : '';
                                echo "<option value='$year' $selected>$year</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="now_status" class="form-label">Current Status</label>
                        <select name="now_status" id="now_status" class="form-select">
                            <option value="">All Status</option>
                            <option value="study" <?= ($now_status === 'study') ? 'selected' : '' ?>>Studying</option>
                            <option value="work" <?= ($now_status === 'work') ? 'selected' : '' ?>>Working</option>
                            <option value="intern" <?= ($now_status === 'intern') ? 'selected' : '' ?>>Internship</option>
                            <option value="free" <?= ($now_status === 'free') ? 'selected' : '' ?>>Available</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="skill_filter" class="form-label">Skill Filter</label>
                        <input type="text" name="skill_filter" id="skill_filter" class="form-control" 
                               placeholder="e.g., javascript, python" value="<?= htmlspecialchars($skill_filter) ?>">
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter me-2"></i>AI Match
                        </button>
                    </div>
                </form>

                <!-- Active Filters Display -->
                <?php if ($education_year || $now_status || $skill_filter): ?>
                    <div class="mt-3">
                        <h6 class="text-muted mb-2">Active AI Filters:</h6>
                        <?php if ($education_year): ?>
                            <span class="filter-badge">
                                <i class="fas fa-graduation-cap"></i>
                                Education Year: <?= $education_year ?>
                            </span>
                        <?php endif; ?>
                        <?php if ($now_status): ?>
                            <span class="filter-badge">
                                <i class="fas fa-user-check"></i>
                                Status: <?= ucfirst($now_status) ?>
                            </span>
                        <?php endif; ?>
                        <?php if ($skill_filter): ?>
                            <span class="filter-badge">
                                <i class="fas fa-code"></i>
                                Skill: <?= htmlspecialchars($skill_filter) ?>
                            </span>
                        <?php endif; ?>
                        <a href="?" class="btn btn-sm btn-outline-secondary ms-2">
                            <i class="fas fa-times me-1"></i>Clear All
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Results Header -->
        <?php if (count($suggestions) > 0): ?>
        <div class="results-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="mb-1">🤖 AI-Matched <?= count($suggestions) ?> Candidates</h4>
                    <p class="mb-0 match-quality">
                        Sorted by AI Match Score • Multi-factor analysis • Smart ranking
                    </p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="bg-white text-dark rounded-pill px-3 py-2 d-inline-block">
                        <small><strong>AI Scoring:</strong> 
                            <span class="text-success">Excellent (80%+)</span> • 
                            <span class="text-info">Good (60-79%)</span> • 
                            <span class="text-warning">Average (40-59%)</span>
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- AI-Powered Results -->
        <div class="row">
            <?php if (count($suggestions) > 0): ?>
                <?php foreach ($suggestions as $person): 
                    $score_class = 'score-excellent';
                    if ($person['match_score'] < 80) $score_class = 'score-good';
                    if ($person['match_score'] < 60) $score_class = 'score-average';
                    if ($person['match_score'] < 40) $score_class = 'score-poor';
                ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="modern-card">
                            <!-- AI Match Score -->
                            <div class="match-score <?= $score_class ?>" title="AI Match Score">
                                <?= $person['match_score'] ?>%
                            </div>

                            <!-- Priority Badge -->
                            <?php if ($person['priority'] == 1): ?>
                                <span class="badge bg-success priority-badge">💼 Work Experience</span>
                            <?php elseif ($person['priority'] == 2): ?>
                                <span class="badge bg-info priority-badge">🎓 Education</span>
                            <?php else: ?>
                                <span class="badge bg-secondary priority-badge">👤 Basic Profile</span>
                            <?php endif; ?>

                            <!-- Candidate Header -->
                            <div class="d-flex align-items-center mb-3">
                                <img src="../oddstudents/<?= htmlspecialchars($person['profile_picture']) ?>" 
                                     alt="Profile" 
                                     class="profile-img me-3"
                                     onerror="this.src='../uploads/profile_pictures/default.png'">
                                <div class="flex-grow-1">
                                    <h5 class="mb-1"><?= htmlspecialchars($person['full_name']) ?></h5>
                                    
                                    <!-- Study Year -->
                                    <?php if (!empty($person['study_year'])): ?>
                                        <div class="mt-1">
                                            <span class="study-year-badge">🎯 Batch: <?= htmlspecialchars($person['study_year']) ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <a href="former-student-profile.php?former_student_id=<?= $person['id']; ?>" 
                                       class="btn btn-sm btn-outline-primary mt-2" target="_blank">
                                        <i class="fas fa-external-link-alt me-1"></i>View Profile
                                    </a>
                                </div>
                            </div>

                            <!-- AI Score Breakdown -->
                            <div class="score-breakdown">
                                <div class="breakdown-item">
                                    <span class="breakdown-label">Education:</span>
                                    <span class="breakdown-value"><?= round($person['score_breakdown']['education'], 1) ?> pts</span>
                                </div>
                                <div class="breakdown-item">
                                    <span class="breakdown-label">Skills:</span>
                                    <span class="breakdown-value"><?= round($person['score_breakdown']['skills'], 1) ?> pts</span>
                                </div>
                                <div class="breakdown-item">
                                    <span class="breakdown-label">Experience:</span>
                                    <span class="breakdown-value"><?= round($person['score_breakdown']['experience'], 1) ?> pts</span>
                                </div>
                                <div class="breakdown-item">
                                    <span class="breakdown-label">Profile:</span>
                                    <span class="breakdown-value"><?= round($person['score_breakdown']['profile'], 1) ?> pts</span>
                                </div>
                                <div class="breakdown-item">
                                    <span class="breakdown-label">Social:</span>
                                    <span class="breakdown-value"><?= round($person['score_breakdown']['social'], 1) ?> pts</span>
                                </div>
                            </div>

                            <!-- AI Insights -->
                            <?php if ($person['match_score'] >= 80): ?>
                                <div class="ai-insights">
                                    <small><i class="fas fa-lightbulb me-1 text-warning"></i> 
                                    <strong>AI Insight:</strong> Excellent match! Strong technical skills and relevant experience.</small>
                                </div>
                            <?php elseif ($person['match_score'] >= 60): ?>
                                <div class="ai-insights">
                                    <small><i class="fas fa-lightbulb me-1 text-info"></i> 
                                    <strong>AI Insight:</strong> Good potential candidate with solid background.</small>
                                </div>
                            <?php endif; ?>

                            <!-- Skills Display -->
                            <?php if (!empty($person['skills'])): ?>
                                <div class="skills-container">
                                    <div class="skills-title">
                                        <i class="fas fa-code me-1"></i>Top Skills
                                    </div>
                                    <div class="skills-list">
                                        <?php 
                                        $displaySkills = array_slice($person['skills'], 0, 6);
                                        foreach ($displaySkills as $skill): ?>
                                            <span class="skill-tag"><?= htmlspecialchars($skill['skill_name']) ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php if (count($person['skills']) > 6): ?>
                                        <div class="more-skills-text">
                                            +<?= count($person['skills']) - 6 ?> more skills in profile
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Education & Work Info -->
                            <div class="edu-work-container mb-3">
                                <?php if (!empty($person['job_role'])): ?>
                                    <div>
                                        <h6 class="text-muted mb-1"><i class="fas fa-briefcase me-1"></i>Work</h6>
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
                                        <h6 class="text-muted mb-1"><i class="fas fa-graduation-cap me-1"></i>Education</h6>
                                        <p class="mb-0">
                                            <?= htmlspecialchars($person['school']) ?>
                                            <?php if (!empty($person['course'])): ?>
                                                - <?= htmlspecialchars($person['course']) ?>
                                            <?php endif; ?>
                                            <?php if (!empty($person['start_year'])): ?>
                                                <small class="text-muted">(<?= htmlspecialchars($person['start_year']) ?>)</small>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Social Media Links -->
                            <div class="social-icons">
                                <?php if (!empty($person['linkedin'])): ?>
                                    <a href="<?= htmlspecialchars($person['linkedin']) ?>" target="_blank" title="LinkedIn">
                                        <i class="fab fa-linkedin" style="color: #0077B5;"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if (!empty($person['github'])): ?>
                                    <a href="<?= htmlspecialchars($person['github']) ?>" target="_blank" title="GitHub">
                                        <i class="fab fa-github" style="color:#171515;"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if (!empty($person['blog'])): ?>
                                    <a href="<?= htmlspecialchars($person['blog']) ?>" target="_blank" title="Blog">
                                        <i class="fas fa-blog" style="color: #fc4f08;"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="no-results">
                        <i class="fas fa-robot"></i>
                        <h4>No AI-matched candidates found</h4>
                        <p class="text-muted mb-4">Try adjusting your search filters or broaden your criteria.</p>
                        <a href="?" class="btn btn-primary btn-lg">
                            <i class="fas fa-redo me-2"></i>Reset All Filters
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include_once("../includes/footer.php"); ?>
<?php include_once("../includes/js-links-inc.php"); ?>

<script>
// Add some interactivity
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth scrolling to results
    const cards = document.querySelectorAll('.modern-card');
    cards.forEach(card => {
        card.addEventListener('click', function(e) {
            if (e.target.tagName === 'A') return;
            const profileLink = this.querySelector('a[href*="dent-profile"]');
            if (profileLink) {
                window.open(profileLink.href, '_blank');
            }
        });
    });

    // Add search suggestions for skills
    const skillInput = document.getElementById('skill_filter');
    if (skillInput) {
        skillInput.addEventListener('focus', function() {
            this.placeholder = 'e.g., javascript, react, python, machine learning';
        });
        
        skillInput.addEventListener('blur', function() {
            this.placeholder = 'e.g., javascript, python';
        });
    }
});
</script>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
</body>
</html>

<?php
$conn->close();
?>