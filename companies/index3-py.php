<?php
session_start();
require_once '../includes/db-conn.php';
require_once 'AdvancedAIConnector.php';
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

// Get filter values
$education_year = isset($_GET['education_year']) ? intval($_GET['education_year']) : '';
$now_status = isset($_GET['now_status']) ? $_GET['now_status'] : '';
$skill_filter = isset($_GET['skill_filter']) ? $_GET['skill_filter'] : '';

// Initialize AI Connector
$ai_connector = new AdvancedAIConnector('http://localhost:5000');
$ai_service_healthy = $ai_connector->healthCheck();

// Get matches from Python AI service
$suggestions = [];
if ($ai_service_healthy) {
    $ai_matches = $ai_connector->getAIMatches($user_id, 20);
    
    // Convert to expected format
    foreach ($ai_matches as $ai_match) {
        $suggestions[] = [
            'id' => $ai_match['candidate_id'],
            'full_name' => $ai_match['full_name'],
            'profile_picture' => $ai_match['profile_picture'],
            'course_name' => $ai_match['course_name'],
            'study_year' => $ai_match['study_year'],
            'school' => $ai_match['education']['school'] ?? '',
            'course' => $ai_match['education']['field_of_study'] ?? '',
            'start_year' => $ai_match['education']['start_year'] ?? '',
            'job_company' => $ai_match['experience']['company'] ?? '',
            'job_role' => $ai_match['experience']['title'] ?? '',
            'skills' => $ai_match['skills'],
            'match_score' => $ai_match['match_score'],
            'score_breakdown' => $ai_match['breakdown'],
            'ai_insights' => $ai_match['insights'],
            'strengths' => $ai_match['strengths'],
            'improvement_areas' => $ai_match['improvement_areas'],
            'priority' => 1
        ];
    }
} else {
    // Fallback to basic PHP matching
    require_once 'BasicCandidateMatcher.php';
    $matcher = new BasicCandidateMatcher($conn, $user_id);
    
    // ... (include your existing PHP matching logic here)
    // This would be your original PHP matching code as fallback
}

// If no AI matches and no fallback matches, show empty state
if (empty($suggestions)) {
    $suggestions = [];
}
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

        .strength-badge {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 4px 8px;
            border-radius: 10px;
            font-size: 0.7rem;
            margin: 2px;
        }

        .improvement-badge {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
            color: white;
            padding: 4px 8px;
            border-radius: 10px;
            font-size: 0.7rem;
            margin: 2px;
        }
    </style>
</head>

<body>
<?php include_once("../includes/header.php"); ?>
<?php include_once("../includes/company-sidebar.php"); ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>AI-Powered Candidate Matching 
            <span class="ai-badge">
                <?= $ai_service_healthy ? 'AI Active' : 'Basic Mode' ?>
            </span>
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Smart Recruitment</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <!-- Filter Section -->
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
                            <i class="fas fa-filter me-2"></i>Find Candidates
                        </button>
                    </div>
                </form>

                <!-- Active Filters Display -->
                <?php if ($education_year || $now_status || $skill_filter): ?>
                    <div class="mt-3">
                        <h6 class="text-muted mb-2">Active Filters:</h6>
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
                    <h4 class="mb-1">
                        <?php if ($ai_service_healthy): ?>
                            🤖 AI-Matched <?= count($suggestions) ?> Candidates
                        <?php else: ?>
                            👥 <?= count($suggestions) ?> Candidates (Basic Matching)
                        <?php endif; ?>
                    </h4>
                    <p class="mb-0 match-quality">
                        Sorted by Match Score • Best matches first
                    </p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="bg-white text-dark rounded-pill px-3 py-2 d-inline-block">
                        <small><strong>Match Quality:</strong> 
                            <span class="text-success">Excellent (80%+)</span> • 
                            <span class="text-info">Good (60-79%)</span> • 
                            <span class="text-warning">Average (40-59%)</span>
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Results Section -->
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
                            <div class="match-score <?= $score_class ?>" title="Match Score">
                                <?= $person['match_score'] ?>%
                            </div>

                            <!-- Candidate Header -->
                            <div class="d-flex align-items-center mb-3">
                                <img src="../oddstudents/<?= htmlspecialchars($person['profile_picture']) ?>" 
                                     alt="Profile" 
                                     class="profile-img me-3"
                                     onerror="this.src='../uploads/profile_pictures/default.png'">
                                <div class="flex-grow-1">
                                    <h5 class="mb-1"><?= htmlspecialchars($person['full_name']) ?></h5>
                                    
                                    <!-- Course Name -->
                                    <?php if (!empty($person['course_name'])): ?>
                                        <span class="badge bg-primary"><?= htmlspecialchars($person['course_name']) ?></span>
                                    <?php endif; ?>
                                    
                                    <!-- Study Year -->
                                    <?php if (!empty($person['study_year'])): ?>
                                        <div class="mt-1">
                                            <span class="study-year-badge">Batch: <?= htmlspecialchars($person['study_year']) ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <a href="../admin/former-student-profile.php?former_student_id=<?= $person['id']; ?>" 
                                       class="btn btn-sm btn-outline-primary mt-2" target="_blank">
                                        <i class="fas fa-external-link-alt me-1"></i>View Profile
                                    </a>
                                </div>
                            </div>

                            <!-- AI Insights -->
                            <?php if (isset($person['ai_insights']) && !empty($person['ai_insights'])): ?>
                                <div class="ai-insights">
                                    <h6><i class="fas fa-robot me-2"></i>AI Analysis</h6>
                                    <?php foreach ($person['ai_insights'] as $insight): ?>
                                        <div class="alert alert-info py-2 mb-2">
                                            <small><?= htmlspecialchars($insight) ?></small>
                                        </div>
                                    <?php endforeach; ?>
                                    
                                    <?php if (!empty($person['strengths'])): ?>
                                        <div class="mt-2">
                                            <strong>Strengths:</strong>
                                            <?php foreach ($person['strengths'] as $strength): ?>
                                                <span class="strength-badge"><?= htmlspecialchars($strength) ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Score Breakdown -->
                            <?php if (isset($person['score_breakdown']) && is_array($person['score_breakdown'])): ?>
                                <div class="score-breakdown">
                                    <?php foreach ($person['score_breakdown'] as $factor => $score): ?>
                                        <div class="breakdown-item">
                                            <span class="breakdown-label"><?= ucfirst(str_replace('_', ' ', $factor)) ?>:</span>
                                            <span class="breakdown-value"><?= round($score, 1) ?> pts</span>
                                        </div>
                                    <?php endforeach; ?>
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
                        <h4>No candidates found</h4>
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
document.addEventListener('DOMContentLoaded', function() {
    // Add interactivity to cards
    const cards = document.querySelectorAll('.modern-card');
    cards.forEach(card => {
        card.addEventListener('click', function(e) {
            if (e.target.tagName === 'A' || e.target.closest('a')) return;
            const profileLink = this.querySelector('a[href*="former-student-profile"]');
            if (profileLink) {
                window.open(profileLink.href, '_blank');
            }
        });
    });

    // Skill input suggestions
    const skillInput = document.getElementById('skill_filter');
    if (skillInput) {
        const commonSkills = ['javascript', 'python', 'react', 'node.js', 'java', 'php', 'html', 'css', 'sql', 'mongodb'];
        
        skillInput.addEventListener('focus', function() {
            this.placeholder = 'e.g., ' + commonSkills.slice(0, 3).join(', ');
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