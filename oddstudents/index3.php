<?php
session_start();
require_once '../includes/db-conn.php';
require_once 'ai_connector.php';

if (!isset($_SESSION['former_student_id'])) {
    header("Location: ../index.php");
    exit();
}

$current_user_id = $_SESSION['former_student_id'];

// Initialize AI Connector
$ai_connector = new AIConnector('http://localhost:5000');

// Check if AI service is available
$ai_service_healthy = $ai_connector->healthCheck();

// Get matches from AI service or fallback
$suggestions = $ai_connector->getAIMatches($current_user_id, 20);

// Get current user info for display
$stmt = $conn->prepare("SELECT fs.*, hc.name as course_name FROM former_students fs LEFT JOIN hnd_courses hc ON fs.course_id = hc.id WHERE fs.id = ?");
$stmt->bind_param("i", $current_user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>AI-Powered Connections</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <?php include_once("../includes/css-links-inc.php"); ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .ai-badge {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 600;
        }
        
        .score-breakdown {
            font-size: 0.75rem;
            color: #6c757d;
            margin-top: 5px;
        }
        
        .breakdown-bar {
            height: 4px;
            background: #e9ecef;
            border-radius: 2px;
            margin: 2px 0;
            overflow: hidden;
        }
        
        .breakdown-fill {
            height: 100%;
            border-radius: 2px;
        }
        
        .career-badge {
            font-size: 0.7rem;
            padding: 2px 8px;
            border-radius: 10px;
            margin-left: 5px;
        }
        
        .career-entry { background: #e3f2fd; color: #1976d2; }
        .career-mid { background: #fff3e0; color: #f57c00; }
        .career-senior { background: #e8f5e8; color: #388e3c; }
    </style>
</head>
<body>
<?php include_once("../includes/header.php"); ?>
<?php include_once("../includes/formers-sidebar.php"); ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>
            AI-Powered Connections 
            <span class="ai-badge">
                <?= $ai_service_healthy ? 'AI Active' : 'Basic Mode' ?>
            </span>
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Smart Connections</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <!-- Current User Info -->
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            Your Profile 
                            <small class="text-muted">(AI Analysis Base)</small>
                        </h5>
                        <div class="d-flex align-items-center">
                            <img src="<?= htmlspecialchars($user['profile_picture']) ?>" alt="Profile" class="profile-img me-3">
                            <div>
                                <h6 class="mb-1"><?= htmlspecialchars($user['username']) ?></h6>
                                <?php if (!empty($user['course_name'])): ?>
                                    <span class="course-badge"><?= htmlspecialchars($user['course_name']) ?></span>
                                <?php endif; ?>
                                <?php if (!empty($user['study_year'])): ?>
                                    <div class="study-year">Study Year: <?= htmlspecialchars($user['study_year']) ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- AI-Powered Suggestions -->
            <?php if (count($suggestions) > 0): ?>
                <div class="col-12">
                    <h5 class="mb-3">
                        <?php if ($ai_service_healthy): ?>
                            🤖 AI Smart Matches 
                            <small class="text-muted">Powered by Machine Learning</small>
                        <?php else: ?>
                            Basic Matches 
                            <small class="text-muted">(AI Service Unavailable)</small>
                        <?php endif; ?>
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
                                    <div style="flex: 1;">
                                        <h5 class="mb-1">
                                            <?= htmlspecialchars($person['user_data']['username']) ?>
                                            <?php if (isset($person['career_trajectory'])): ?>
                                                <span class="career-badge career-<?= $person['career_trajectory']['other'] ?>">
                                                    <?= ucfirst(str_replace('_', ' ', $person['career_trajectory']['other'])) ?>
                                                </span>
                                            <?php endif; ?>
                                        </h5>
                                        <?php if (!empty($person['user_data']['course_name'])): ?>
                                            <span class="course-badge"><?= htmlspecialchars($person['user_data']['course_name']) ?></span>
                                        <?php endif; ?>
                                        
                                        <!-- Score Breakdown -->
                                        <?php if ($ai_service_healthy && isset($person['score_breakdown'])): ?>
                                            <div class="score-breakdown">
                                                <?php foreach ($person['score_breakdown'] as $factor => $score): ?>
                                                    <div class="d-flex justify-content-between">
                                                        <small><?= ucfirst(str_replace('_', ' ', $factor)) ?>:</small>
                                                        <small><?= $score ?>%</small>
                                                    </div>
                                                    <div class="breakdown-bar">
                                                        <div class="breakdown-fill" 
                                                             style="width: <?= $score ?>%; background: <?= 
                                                             $score > 70 ? '#28a745' : ($score > 40 ? '#ffc107' : '#dc3545') ?>">
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
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
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <div class="social-icons">
                                    <!-- Social links here -->
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
                        <h5>No Matches Found</h5>
                        <p class="text-muted">We couldn't find any matching profiles at the moment.</p>
                        <a href="browse-profiles.php" class="btn btn-primary">Browse All Profiles</a>
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


/*
Install Python Dependencies:
bash
pip install flask scikit-learn spacy pandas numpy mysql-connector-python joblib
python -m spacy download en_core_web_sm

Run the Python AI Service:
bash
python ai_matcher.p
y*/



*/
Step 1: Server Preparation
Update and Install Dependencies
bash
sudo apt update
sudo apt install python3-pip python3-venv
Step 2: Python Environment Setup
Create a Virtual Environment
bash
python3 -m venv /path/to/your/venv
source /path/to/your/venv/bin/activate
Install Required Packages
bash
pip install flask scikit-learn spacy pandas numpy mysql-connector-python joblib gunicorn
Download spaCy Model
bash
python -m spacy download en_core_web_sm
Step 3: Flask Application Deployment
Create the Flask Application File
Save the ai_matcher.py file (from previous code) in your project directory.

Test the Flask App
bash
python ai_matcher.py
Run with Gunicorn
bash
gunicorn -w 4 -b 0.0.0.0:5000 ai_matcher:app
Create a Systemd Service (for Ubuntu)
Create a file /etc/systemd/system/ai_matcher.service:

ini
[Unit]
Description=Gunicorn instance to serve AI Matcher
After=network.target

[Service]
User=www-data
Group=www-data
WorkingDirectory=/path/to/your/project
Environment="PATH=/path/to/your/venv/bin"
ExecStart=/path/to/your/venv/bin/gunicorn -w 4 -b 0.0.0.0:5000 ai_matcher:app

[Install]
WantedBy=multi-user.target
Then, start and enable the service:

bash
sudo systemctl start ai_matcher
sudo systemctl enable ai_matcher*/