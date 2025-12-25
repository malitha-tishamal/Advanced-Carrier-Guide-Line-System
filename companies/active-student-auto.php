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
$experience_level = isset($_GET['experience_level']) ? $_GET['experience_level'] : '';
$education_level = isset($_GET['education_level']) ? $_GET['education_level'] : '';

/**
 * ADVANCED CANDIDATE MATCHER
 * Implements smart matching with multiple weighted factors
 */
class AdvancedCandidateMatcher {
    private $conn;
    private $company_id;
    private $skill_ontology;
    private $company_preferences;
    
    public function __construct($conn, $company_id) {
        $this->conn = $conn;
        $this->company_id = $company_id;
        $this->initializeSkillOntology();
        $this->loadCompanyPreferences();
    }
    
    private function initializeSkillOntology() {
        // Enhanced skill relationship mapping for better matching
        $this->skill_ontology = [
            'php' => ['laravel', 'symfony', 'codeigniter', 'wordpress', 'magento', 'php'],
            'javascript' => ['react', 'vue', 'angular', 'nodejs', 'express', 'typescript', 'javascript', 'js'],
            'python' => ['django', 'flask', 'pandas', 'numpy', 'tensorflow', 'machine learning', 'python'],
            'java' => ['spring', 'hibernate', 'android', 'kotlin', 'microservices', 'java'],
            'react' => ['redux', 'react native', 'next.js', 'graphql', 'react'],
            'laravel' => ['eloquent', 'blade', 'artisan', 'composer', 'laravel'],
            'nodejs' => ['express', 'mongodb', 'socket.io', 'rest api', 'node', 'nodejs'],
            'database' => ['mysql', 'postgresql', 'mongodb', 'redis', 'sql', 'database'],
            'cloud' => ['aws', 'azure', 'google cloud', 'docker', 'kubernetes', 'cloud'],
            'mobile' => ['android', 'ios', 'flutter', 'react native', 'swift', 'mobile'],
            'ai' => ['machine learning', 'deep learning', 'tensorflow', 'pytorch', 'nlp', 'artificial intelligence'],
            'devops' => ['docker', 'kubernetes', 'jenkins', 'gitlab', 'ci/cd', 'devops'],
            'frontend' => ['html', 'css', 'sass', 'bootstrap', 'tailwind', 'responsive design'],
            'backend' => ['api', 'rest', 'graphql', 'server', 'microservices'],
            'data' => ['analysis', 'analytics', 'visualization', 'sql', 'excel', 'power bi']
        ];
    }
    
    private function loadCompanyPreferences() {
        // Load company preferences from database or use defaults
        $this->company_preferences = [
            'prefers_experience' => true,
            'prefers_education' => true,
            'importance_skills' => 'high',
            'importance_social' => 'medium'
        ];
    }
    
    /**
     * Calculate comprehensive match score (0-100)
     */
    public function calculateMatchScore($candidate, $skills, $filters = []) {
        $weights = $this->getAdaptiveWeights($filters);
        
        $scores = [
            'education' => $this->calculateEducationScore($candidate, $filters) * $weights['education'],
            'skills' => $this->calculateEnhancedSkillsScore($skills, $filters) * $weights['skills'],
            'experience' => $this->calculateExperienceScore($candidate, $filters) * $weights['experience'],
            'profile' => $this->calculateProfileCompleteness($candidate, $skills) * $weights['profile'],
            'social' => $this->calculateSocialScore($candidate) * $weights['social'],
            'freshness' => $this->calculateDataFreshness($candidate) * $weights['freshness'],
            'relevance' => $this->calculateJobRelevance($candidate, $skills, $filters) * $weights['relevance']
        ];
        
        $total_score = array_sum($scores);
        $max_possible = array_sum($weights) * 20; // Normalize to 100
        
        $final_score = ($total_score / $max_possible) * 100;
        
        // Apply bonus for filter matches
        $filter_bonus = $this->calculateFilterBonus($candidate, $skills, $filters);
        $final_score = min(100, $final_score + $filter_bonus);
        
        return [
            'score' => round(min(100, max(0, $final_score)), 1),
            'breakdown' => $scores,
            'weights' => $weights,
            'filter_bonus' => $filter_bonus
        ];
    }
    
    /**
     * Adaptive weights based on filters and company preferences
     */
    private function getAdaptiveWeights($filters) {
        $weights = [
            'education' => 0.18,
            'skills' => 0.22,
            'experience' => 0.20,
            'profile' => 0.08,
            'social' => 0.08,
            'freshness' => 0.08,
            'relevance' => 0.16
        ];
        
        // Adjust weights based on filters
        if (!empty($filters['skill_filter'])) {
            $weights['skills'] = 0.30;
            $weights['experience'] = 0.15;
        }
        
        if (!empty($filters['experience_level'])) {
            $weights['experience'] = 0.30;
            $weights['education'] = 0.15;
        }
        
        if (!empty($filters['education_level'])) {
            $weights['education'] = 0.25;
        }
        
        // Normalize weights
        $total = array_sum($weights);
        foreach ($weights as $key => $value) {
            $weights[$key] = $value / $total;
        }
        
        return $weights;
    }
    
    /**
     * Enhanced education scoring with multiple factors
     */
    private function calculateEducationScore($candidate, $filters) {
        $score = 0;
        
        // 1. Education Level (0-8 points)
        if (!empty($candidate['course'])) {
            $course = strtolower($candidate['course']);
            $edu_level = 0;
            
            if (strpos($course, 'phd') !== false || strpos($course, 'doctorate') !== false) {
                $score += 8;
                $edu_level = 4;
            } elseif (strpos($course, 'master') !== false || strpos($course, 'msc') !== false || strpos($course, 'mba') !== false) {
                $score += 7;
                $edu_level = 3;
            } elseif (strpos($course, 'bachelor') !== false || strpos($course, 'degree') !== false || strpos($course, 'bsc') !== false || strpos($course, 'ba') !== false) {
                $score += 6;
                $edu_level = 2;
            } elseif (strpos($course, 'diploma') !== false || strpos($course, 'hnd') !== false) {
                $score += 5;
                $edu_level = 1;
            } else {
                $score += 3;
            }
            
            // Match education level filter
            if (!empty($filters['education_level'])) {
                $required_level = $this->getEducationLevelValue($filters['education_level']);
                if ($edu_level >= $required_level) {
                    $score += 4; // Bonus for meeting/exceeding requirement
                }
            }
        }
        
        // 2. Education Recency (0-6 points)
        if (!empty($candidate['start_year'])) {
            $current_year = date("Y");
            $years_since_education = $current_year - $candidate['start_year'];
            
            if ($years_since_education <= 2) $score += 6;
            elseif ($years_since_education <= 5) $score += 5;
            elseif ($years_since_education <= 10) $score += 3;
            else $score += 1;
            
            // Match education year filter
            if (!empty($filters['education_year']) && $candidate['start_year'] == $filters['education_year']) {
                $score += 3;
            }
        }
        
        // 3. Institution Reputation (0-4 points)
        if (!empty($candidate['school'])) {
            $school = strtolower($candidate['school']);
            // Check for known institutions or universities
            if (preg_match('/(university|college|institute|academy)/i', $school)) {
                $score += 2;
            }
            if (strlen(trim($candidate['school'])) > 15) { // Longer names often indicate established institutions
                $score += 2;
            }
        }
        
        // 4. Field Relevance (0-2 points)
        if (!empty($candidate['course'])) {
            $tech_keywords = ['computer', 'software', 'engineering', 'technology', 'information', 'data', 'science', 'technical', 'programming'];
            $business_keywords = ['business', 'management', 'administration', 'finance', 'accounting', 'marketing', 'economics'];
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
    
    private function getEducationLevelValue($level) {
        $levels = [
            'phd' => 4,
            'masters' => 3,
            'bachelors' => 2,
            'diploma' => 1,
            'certificate' => 0
        ];
        return $levels[$level] ?? 0;
    }
    
    /**
     * Advanced skills scoring with ontology and relationships
     */
    private function calculateEnhancedSkillsScore($skills, $filters) {
        if (empty($skills)) return 0;
        
        $score = 0;
        $filter_skill = !empty($filters['skill_filter']) ? strtolower($filters['skill_filter']) : '';
        
        // 1. Skill Category Weighting (0-10 points)
        $category_weights = [
            'IT' => 1.5, 'Engineering' => 1.4, 'Data Science' => 1.6,
            'Business Finance' => 1.2, 'HND Management' => 1.1, 
            'HND Business Admin' => 1.0, 'HND Accountancy' => 1.0,
            'HND Agriculture' => 0.9, 'HND Building Services' => 0.9, 
            'HND English' => 0.8, 'HND Food Tech' => 0.9, 
            'HND Mechanical' => 1.1, 'HND Quantity Survey' => 0.9,
            'HND THM' => 0.8, 'Design' => 1.2, 'Marketing' => 1.1
        ];
        
        $weighted_score = 0;
        $unique_categories = [];
        $skill_names = [];
        
        foreach ($skills as $skill) {
            $category = $skill['category'];
            $skill_name = strtolower($skill['skill_name']);
            $skill_names[] = $skill_name;
            
            $weight = $category_weights[$category] ?? 1.0;
            $weighted_score += $weight;
            
            if (!in_array($category, $unique_categories)) {
                $unique_categories[] = $category;
            }
            
            // Bonus for exact skill match
            if ($filter_skill && (strpos($skill_name, $filter_skill) !== false || 
                $this->isRelatedSkill($skill_name, $filter_skill))) {
                $weighted_score += 2;
            }
        }
        
        $score += min(10, $weighted_score * 0.5);
        
        // 2. Skill Diversity (0-5 points)
        $diversity_bonus = min(5, count($unique_categories));
        $score += $diversity_bonus;
        
        // 3. Skill Depth (Advanced skills detection) (0-5 points)
        $advanced_skills = $this->detectAdvancedSkills($skill_names);
        $score += min(5, $advanced_skills);
        
        // 4. Skill Combination Bonus (0-5 points)
        $combination_bonus = $this->calculateSkillCombinationBonus($skill_names);
        $score += min(5, $combination_bonus);
        
        return min(22, $score);
    }
    
    private function isRelatedSkill($skill, $target) {
        foreach ($this->skill_ontology as $parent => $related) {
            if (in_array($target, $related) && in_array($skill, $related)) {
                return true;
            }
        }
        return false;
    }
    
    private function detectAdvancedSkills($skill_names) {
        $advanced_keywords = [
            'machine learning', 'deep learning', 'artificial intelligence', 'neural network',
            'kubernetes', 'docker', 'microservices', 'devops', 'ci/cd', 'containerization',
            'react', 'angular', 'vue', 'nodejs', 'python', 'java', 'spring', 'django',
            'aws', 'azure', 'google cloud', 'cloud computing', 'serverless',
            'mongodb', 'postgresql', 'redis', 'elasticsearch', 'graphql',
            'typescript', 'next.js', 'nestjs', 'laravel', 'symfony'
        ];
        
        $advanced_count = 0;
        foreach ($skill_names as $skill) {
            foreach ($advanced_keywords as $keyword) {
                if (strpos($skill, $keyword) !== false) {
                    $advanced_count++;
                    break;
                }
            }
        }
        
        return min(5, $advanced_count * 0.5);
    }
    
    private function calculateSkillCombinationBonus($skill_names) {
        $valuable_combinations = [
            ['react', 'nodejs'],
            ['python', 'machine learning'],
            ['java', 'spring'],
            ['php', 'laravel'],
            ['javascript', 'react'],
            ['python', 'django'],
            ['aws', 'docker'],
            ['react', 'typescript'],
            ['mysql', 'php'],
            ['mongodb', 'nodejs']
        ];
        
        $bonus = 0;
        foreach ($valuable_combinations as $combo) {
            $has_first = false;
            $has_second = false;
            
            foreach ($skill_names as $skill) {
                if (strpos($skill, $combo[0]) !== false) $has_first = true;
                if (strpos($skill, $combo[1]) !== false) $has_second = true;
            }
            
            if ($has_first && $has_second) {
                $bonus += 2;
            }
        }
        
        return min(5, $bonus);
    }
    
    /**
     * Experience level analysis
     */
    private function calculateExperienceScore($candidate, $filters) {
        $score = 0;
        $experience_level = !empty($filters['experience_level']) ? $filters['experience_level'] : '';
        
        // 1. Job Role Level (0-12 points)
        if (!empty($candidate['job_role'])) {
            $role = strtolower($candidate['job_role']);
            $role_level = $this->getRoleLevel($role);
            
            // Base score based on role level
            $score += $role_level * 3;
            
            // Match experience level filter
            if ($experience_level) {
                $required_level = $this->getExperienceLevelValue($experience_level);
                if ($role_level >= $required_level) {
                    $score += 4; // Bonus for meeting/exceeding requirement
                }
            }
            
            // Company reputation bonus
            if (!empty($candidate['job_company'])) {
                $company = trim($candidate['job_company']);
                if (strlen($company) > 3) {
                    $score += 2;
                    // Bonus for known companies or multinationals
                    if (strlen($company) > 15 || preg_match('/\b(inc|corp|llc|gmbh|pte|ltd)\b/i', $company)) {
                        $score += 1;
                    }
                }
            }
        }
        
        // 2. Experience Duration Estimation (0-5 points)
        if (!empty($candidate['start_year'])) {
            $current_year = date("Y");
            $experience_years = $current_year - $candidate['start_year'];
            
            if ($experience_years >= 5) $score += 5;
            elseif ($experience_years >= 3) $score += 4;
            elseif ($experience_years >= 1) $score += 3;
            else $score += 1;
        }
        
        // 3. Career Progression Indicator (0-3 points)
        if (!empty($candidate['job_role']) && !empty($candidate['course'])) {
            $role_level = $this->getRoleLevel($candidate['job_role']);
            $edu_level = $this->getEducationLevel($candidate['course']);
            
            if ($role_level > $edu_level) {
                $score += 3; // Indicates career progression
            } elseif ($role_level == $edu_level) {
                $score += 1;
            }
        }
        
        // 4. Match current status filter
        if (!empty($filters['now_status'])) {
            $status = $filters['now_status'];
            $current_status = $this->getCurrentStatus($candidate);
            
            if ($status === $current_status) {
                $score += 3;
            } elseif (($status === 'work' && $current_status === 'intern') ||
                     ($status === 'intern' && $current_status === 'work')) {
                $score += 1; // Partial match
            }
        }
        
        return min(20, $score);
    }
    
    private function getRoleLevel($role) {
        $role_lower = strtolower($role);
        
        if (preg_match('/(senior|lead|principal|manager|director|head|chief|vp|vice president)/', $role_lower)) return 4;
        if (preg_match('/(mid|experienced|professional|specialist|consultant|architect)/', $role_lower)) return 3;
        if (preg_match('/(junior|associate|assistant|entry level|trainee)/', $role_lower)) return 2;
        if (preg_match('/(intern|apprentice|student)/', $role_lower)) return 1;
        
        // Default based on keywords
        if (preg_match('/(developer|engineer|analyst|designer)/', $role_lower)) return 3;
        
        return 2; // Default mid-level
    }
    
    private function getExperienceLevelValue($level) {
        $levels = [
            'executive' => 4,
            'senior' => 4,
            'mid' => 3,
            'junior' => 2,
            'intern' => 1,
            'entry' => 2
        ];
        return $levels[$level] ?? 2;
    }
    
    private function getCurrentStatus($candidate) {
        if (!empty($candidate['job_role'])) {
            $role_lower = strtolower($candidate['job_role']);
            if (strpos($role_lower, 'intern') !== false) {
                return 'intern';
            }
            return 'work';
        } elseif (!empty($candidate['school'])) {
            return 'study';
        }
        return 'free';
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
        
        // Work experience details (5 points)
        if (!empty($candidate['job_role'])) {
            $completeness += 3;
            if (!empty($candidate['job_company'])) {
                $completeness += 2;
            }
        }
        
        // Skills (4 points)
        if (!empty($skills)) {
            $skill_points = min(4, count($skills) * 0.5);
            $completeness += $skill_points;
        }
        
        // Contact/Social presence (3 points)
        $social_count = 0;
        if (!empty($candidate['linkedin'])) $social_count++;
        if (!empty($candidate['github'])) $social_count++;
        if (!empty($candidate['blog'])) $social_count++;
        if (!empty($candidate['facebook'])) $social_count++;
        $completeness += min(3, $social_count);
        
        // Additional info (2 points)
        if (!empty($candidate['study_year'])) $completeness += 1;
        if (!empty($candidate['start_year'])) $completeness += 1;
        
        return min(15, $completeness);
    }
    
    /**
     * Social presence and professional networking
     */
    private function calculateSocialScore($candidate) {
        $score = 0;
        
        // LinkedIn (most valuable - 5 points)
        if (!empty($candidate['linkedin'])) {
            if (filter_var($candidate['linkedin'], FILTER_VALIDATE_URL)) {
                $score += 5;
            } elseif (trim($candidate['linkedin']) !== '') {
                $score += 2;
            }
        }
        
        // GitHub (technical roles - 4 points)
        if (!empty($candidate['github'])) {
            if (filter_var($candidate['github'], FILTER_VALIDATE_URL)) {
                $score += 4;
            } elseif (trim($candidate['github']) !== '') {
                $score += 1;
            }
        }
        
        // Blog/Portfolio (3 points)
        if (!empty($candidate['blog'])) {
            if (filter_var($candidate['blog'], FILTER_VALIDATE_URL)) {
                $score += 3;
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
        
        // Education recency (0-4 points)
        if (!empty($candidate['start_year'])) {
            $current_year = date("Y");
            $years_ago = $current_year - $candidate['start_year'];
            
            if ($years_ago <= 2) $freshness += 4;
            elseif ($years_ago <= 5) $freshness += 3;
            elseif ($years_ago <= 10) $freshness += 2;
            else $freshness += 1;
        }
        
        // Profile activity indicators (0-3 points)
        $freshness += 2; // Base assumption
        
        // Social media presence as activity indicator (0-3 points)
        $social_count = 0;
        if (!empty($candidate['linkedin'])) $social_count++;
        if (!empty($candidate['github'])) $social_count++;
        if (!empty($candidate['blog'])) $social_count++;
        $freshness += min(3, $social_count);
        
        return min(10, $freshness);
    }
    
    /**
     * Job relevance based on role and skills
     */
    private function calculateJobRelevance($candidate, $skills, $filters) {
        $relevance = 0;
        
        // Role relevance (0-8 points)
        if (!empty($candidate['job_role'])) {
            $role = strtolower($candidate['job_role']);
            
            // Tech roles
            if (preg_match('/(developer|engineer|programmer|coder|architect)/', $role)) {
                $relevance += 8;
            }
            // Business roles
            elseif (preg_match('/(manager|analyst|consultant|specialist|advisor)/', $role)) {
                $relevance += 7;
            }
            // Creative roles
            elseif (preg_match('/(designer|creative|artist|writer)/', $role)) {
                $relevance += 6;
            }
            // Other professional roles
            else {
                $relevance += 5;
            }
        }
        
        // Skills relevance to common job categories (0-8 points)
        if (!empty($skills)) {
            $tech_skills = 0;
            $business_skills = 0;
            $creative_skills = 0;
            
            foreach ($skills as $skill) {
                $skill_name = strtolower($skill['skill_name']);
                $category = $skill['category'];
                
                // Count skills by category
                if (in_array($category, ['IT', 'Engineering', 'Data Science'])) {
                    $tech_skills++;
                } elseif (in_array($category, ['Business Finance', 'HND Management', 'HND Business Admin', 'HND Accountancy'])) {
                    $business_skills++;
                } elseif (strpos($skill_name, 'design') !== false || strpos($skill_name, 'creative') !== false) {
                    $creative_skills++;
                }
            }
            
            // Award points based on skill concentration
            if ($tech_skills >= 3) $relevance += 4;
            if ($business_skills >= 3) $relevance += 4;
            if ($creative_skills >= 2) $relevance += 3;
        }
        
        // Filter match relevance (0-4 points)
        if (!empty($filters['skill_filter'])) {
            $filter_skill = strtolower($filters['skill_filter']);
            $has_related_skill = false;
            
            if (!empty($skills)) {
                foreach ($skills as $skill) {
                    $skill_name = strtolower($skill['skill_name']);
                    if (strpos($skill_name, $filter_skill) !== false || 
                        $this->isRelatedSkill($skill_name, $filter_skill)) {
                        $has_related_skill = true;
                        break;
                    }
                }
            }
            
            if ($has_related_skill) {
                $relevance += 4;
            }
        }
        
        return min(16, $relevance);
    }
    
    /**
     * Calculate bonus points for filter matches
     */
    private function calculateFilterBonus($candidate, $skills, $filters) {
        $bonus = 0;
        
        // Skill filter bonus
        if (!empty($filters['skill_filter']) && !empty($skills)) {
            $filter_skill = strtolower($filters['skill_filter']);
            foreach ($skills as $skill) {
                $skill_name = strtolower($skill['skill_name']);
                if (strpos($skill_name, $filter_skill) !== false) {
                    $bonus += 5; // Exact match
                    break;
                } elseif ($this->isRelatedSkill($skill_name, $filter_skill)) {
                    $bonus += 3; // Related skill
                    break;
                }
            }
        }
        
        // Education year bonus
        if (!empty($filters['education_year']) && !empty($candidate['start_year'])) {
            if ($candidate['start_year'] == $filters['education_year']) {
                $bonus += 3;
            }
        }
        
        // Experience level bonus
        if (!empty($filters['experience_level']) && !empty($candidate['job_role'])) {
            $role_level = $this->getRoleLevel($candidate['job_role']);
            $required_level = $this->getExperienceLevelValue($filters['experience_level']);
            
            if ($role_level >= $required_level) {
                $bonus += 4;
            }
        }
        
        // Education level bonus
        if (!empty($filters['education_level']) && !empty($candidate['course'])) {
            $course_lower = strtolower($candidate['course']);
            $required_level = $filters['education_level'];
            
            $matches = false;
            switch ($required_level) {
                case 'phd':
                    $matches = strpos($course_lower, 'phd') !== false;
                    break;
                case 'masters':
                    $matches = strpos($course_lower, 'master') !== false || 
                              strpos($course_lower, 'msc') !== false ||
                              strpos($course_lower, 'mba') !== false;
                    break;
                case 'bachelors':
                    $matches = strpos($course_lower, 'bachelor') !== false ||
                              strpos($course_lower, 'degree') !== false ||
                              strpos($course_lower, 'bsc') !== false ||
                              strpos($course_lower, 'ba') !== false;
                    break;
                case 'diploma':
                    $matches = strpos($course_lower, 'diploma') !== false ||
                              strpos($course_lower, 'hnd') !== false;
                    break;
            }
            
            if ($matches) {
                $bonus += 3;
            }
        }
        
        return min(10, $bonus); // Cap the bonus
    }
}

// Initialize advanced matcher
$matcher = new AdvancedCandidateMatcher($conn, $user_id);

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
    FROM students fs
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
        $where[] = "w.title IS NOT NULL AND LOWER(w.title) NOT LIKE '%intern%'";
    } elseif ($now_status === 'study') {
        $where[] = "e.school IS NOT NULL AND w.title IS NULL";
    } elseif ($now_status === 'intern') {
        $where[] = "LOWER(w.title) LIKE '%intern%'";
    } elseif ($now_status === 'free') {
        $where[] = "e.school IS NULL AND w.title IS NULL";
    }
}

// Filter: Experience Level (handled in matching algorithm)

// Filter: Education Level (handled in matching algorithm)

// Skill filter will be applied after fetching

// Build WHERE clause
$whereSQL = "";
if (count($where) > 0) {
    $whereSQL = " WHERE " . implode(" AND ", $where);
}

// Get total count for optimization
$countQuery = "SELECT COUNT(*) as total FROM students fs" . $whereSQL;
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
    $query = $select . $whereSQL . " GROUP BY fs.id ORDER BY fs.username ASC LIMIT 250";
} else {
    $query = $select . $whereSQL . " GROUP BY fs.id ORDER BY priority ASC, fs.username ASC LIMIT 250";
}

$stmt = $conn->prepare($query);
if ($paramTypes && !empty($params)) {
    $stmt->bind_param($paramTypes, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$suggestions = [];
$filters = [
    'skill_filter' => $skill_filter,
    'education_year' => $education_year,
    'now_status' => $now_status,
    'experience_level' => $experience_level,
    'education_level' => $education_level
];

while ($row = $result->fetch_assoc()) {
    // Fetch skills for this person
    $skills_sql = "
        SELECT s.skill_name, s.category
        FROM active_student_skills fss
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
    $skill_filter_lower = strtolower($skill_filter);
    if ($skill_filter && !empty($row['skills'])) {
        $has_skill = false;
        foreach ($row['skills'] as $skill) {
            if (stripos($skill['skill_name'], $skill_filter_lower) !== false) {
                $has_skill = true;
                break;
            }
        }
        // Also check for related skills through ontology
        if (!$has_skill) {
            foreach ($matcher->skill_ontology as $related) {
                if (in_array($skill_filter_lower, $related)) {
                    foreach ($row['skills'] as $skill) {
                        if (in_array(strtolower($skill['skill_name']), $related)) {
                            $has_skill = true;
                            break 2;
                        }
                    }
                }
            }
        }
        if (!$has_skill) continue; // Skip if doesn't have required skill
    }
    
    // Calculate match score with all filters
    $matchResult = $matcher->calculateMatchScore($row, $row['skills'], $filters);
    $row['match_score'] = $matchResult['score'];
    $row['score_breakdown'] = $matchResult['breakdown'];
    $row['filter_bonus'] = $matchResult['filter_bonus'];
    
    $suggestions[] = $row;
}
$stmt->close();

// Sort suggestions by match score (highest first)
usort($suggestions, function($a, $b) {
    return $b['match_score'] - $a['match_score'];
});

// Limit to top candidates after sorting
$suggestions = array_slice($suggestions, 0, 150);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Advanced Candidate Matching - EduWide</title>
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

        /* Match Score */
        .match-score {
            position: absolute;
            top: 15px;
            right: 15px;
            color: white;
            padding: 8px 12px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.9rem;
            z-index: 10;
        }

        .score-excellent { 
            background: linear-gradient(135deg, #28a745, #20c997);
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }
        .score-good { 
            background: linear-gradient(135deg, #17a2b8, #0dcaf0);
            box-shadow: 0 4px 15px rgba(23, 162, 184, 0.3);
        }
        .score-average { 
            background: linear-gradient(135deg, #ffc107, #fd7e14);
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
        }
        .score-fair { 
            background: linear-gradient(135deg, #6c757d, #495057);
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
        }

        .advanced-badge {
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

        .match-insights {
            background: linear-gradient(135deg, #e3f2fd, #f3e5f5);
            border-left: 4px solid #667eea;
            padding: 10px 15px;
            margin: 10px 0;
            border-radius: 0 8px 8px 0;
        }
        
        .filter-match-badge {
            background: linear-gradient(135deg, #20c997, #28a745);
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 0.7rem;
            margin-left: 5px;
        }
        
        .matching-criteria {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #dee2e6;
        }
        
        .criteria-item {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }
        
        .criteria-item i {
            color: #667eea;
            margin-right: 10px;
            width: 20px;
        }
        
        .profile-img-container {
            position: relative;
            display: inline-block;
        }
        
        .availability-badge {
            position: absolute;
            bottom: -5px;
            right: -5px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid white;
        }
        
        .available { background-color: #28a745; }
        .unavailable { background-color: #dc3545; }
        .unknown { background-color: #6c757d; }
    </style>
</head>

<body>
<?php include_once("../includes/header.php"); ?>
<?php include_once("../includes/company-sidebar.php"); ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Advanced Candidate Matching <span class="advanced-badge">Smart System</span></h1>
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
                <h5 class="card-title"><i class="fas fa-filter me-2"></i>Advanced Candidate Filtering</h5>
                
                <!-- Matching Criteria Info -->
                <div class="matching-criteria mb-4">
                    <h6><i class="fas fa-info-circle me-2"></i>Matching Criteria:</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="criteria-item">
                                <i class="fas fa-graduation-cap"></i>
                                <span>Education Level & Institution</span>
                            </div>
                            <div class="criteria-item">
                                <i class="fas fa-code"></i>
                                <span>Technical & Soft Skills</span>
                            </div>
                            <div class="criteria-item">
                                <i class="fas fa-briefcase"></i>
                                <span>Work Experience & Role Level</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="criteria-item">
                                <i class="fas fa-user-check"></i>
                                <span>Profile Completeness</span>
                            </div>
                            <div class="criteria-item">
                                <i class="fas fa-share-alt"></i>
                                <span>Social & Professional Presence</span>
                            </div>
                            <div class="criteria-item">
                                <i class="fas fa-bolt"></i>
                                <span>Data Freshness & Relevance</span>
                            </div>
                        </div>
                    </div>
                </div>
                
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
                        <label for="experience_level" class="form-label">Experience Level</label>
                        <select name="experience_level" id="experience_level" class="form-select">
                            <option value="">Any Level</option>
                            <option value="intern" <?= ($experience_level === 'intern') ? 'selected' : '' ?>>Intern/Trainee</option>
                            <option value="junior" <?= ($experience_level === 'junior') ? 'selected' : '' ?>>Junior (0-2 yrs)</option>
                            <option value="mid" <?= ($experience_level === 'mid') ? 'selected' : '' ?>>Mid-Level (2-5 yrs)</option>
                            <option value="senior" <?= ($experience_level === 'senior') ? 'selected' : '' ?>>Senior (5+ yrs)</option>
                            <option value="executive" <?= ($experience_level === 'executive') ? 'selected' : '' ?>>Executive/Lead</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="education_level" class="form-label">Education Level</label>
                        <select name="education_level" id="education_level" class="form-select">
                            <option value="">Any Level</option>
                            <option value="diploma" <?= ($education_level === 'diploma') ? 'selected' : '' ?>>Diploma/HND</option>
                            <option value="bachelors" <?= ($education_level === 'bachelors') ? 'selected' : '' ?>>Bachelor's Degree</option>
                            <option value="masters" <?= ($education_level === 'masters') ? 'selected' : '' ?>>Master's Degree</option>
                            <option value="phd" <?= ($education_level === 'phd') ? 'selected' : '' ?>>PhD/Doctorate</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="skill_filter" class="form-label">Skill Search</label>
                        <input type="text" name="skill_filter" id="skill_filter" class="form-control" 
                               placeholder="e.g., javascript, python, project management" 
                               value="<?= htmlspecialchars($skill_filter) ?>">
                        <small class="form-text text-muted">Enter specific skills or keywords</small>
                    </div>

                    <div class="col-md-6 d-flex align-items-end">
                        <div class="d-grid gap-2 d-md-flex w-100">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-2"></i>Find Matches
                            </button>
                            <a href="?" class="btn btn-outline-secondary">
                                <i class="fas fa-redo me-1"></i>Reset
                            </a>
                        </div>
                    </div>
                </form>

                <!-- Active Filters Display -->
                <?php if ($education_year || $now_status || $skill_filter || $experience_level || $education_level): ?>
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
                        <?php if ($experience_level): ?>
                            <span class="filter-badge">
                                <i class="fas fa-briefcase"></i>
                                Experience: <?= ucfirst($experience_level) ?>
                            </span>
                        <?php endif; ?>
                        <?php if ($education_level): ?>
                            <span class="filter-badge">
                                <i class="fas fa-university"></i>
                                Education: <?= ucfirst($education_level) ?>
                            </span>
                        <?php endif; ?>
                        <?php if ($skill_filter): ?>
                            <span class="filter-badge">
                                <i class="fas fa-code"></i>
                                Skill: <?= htmlspecialchars($skill_filter) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Results Header -->
        <?php if (count($suggestions) > 0): ?>
        <div class="results-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="mb-1">🎯 Advanced-Matched <?= count($suggestions) ?> Candidates</h4>
                    <p class="mb-0 match-quality">
                        Multi-factor analysis • Smart ranking • Filter matching bonus applied
                    </p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="bg-white text-dark rounded-pill px-3 py-2 d-inline-block">
                        <small><strong>Match Quality:</strong> 
                            <span class="text-success">Excellent (80%+)</span> • 
                            <span class="text-info">Good (60-79%)</span> • 
                            <span class="text-warning">Average (40-59%)</span> •
                            <span class="text-secondary">Fair (Below 40%)</span>
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Advanced-Matched Results -->
        <div class="row">
            <?php if (count($suggestions) > 0): ?>
                <?php foreach ($suggestions as $person): 
                    $score_class = 'score-excellent';
                    if ($person['match_score'] < 80) $score_class = 'score-good';
                    if ($person['match_score'] < 60) $score_class = 'score-average';
                    if ($person['match_score'] < 40) $score_class = 'score-fair';
                    
                    // Determine availability status
                    $availability = 'unknown';
                    if (!empty($person['job_role'])) {
                        $availability = 'unavailable';
                    } elseif (empty($person['job_role']) && !empty($person['school'])) {
                        $availability = 'available'; // Student available for internship/part-time
                    } elseif (empty($person['job_role']) && empty($person['school'])) {
                        $availability = 'available'; // Fresh graduate available
                    }
                ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="modern-card">
                            <!-- Match Score -->
                            <div class="match-score <?= $score_class ?>" title="Advanced Match Score">
                                <?= $person['match_score'] ?>%
                                <?php if ($person['filter_bonus'] > 0): ?>
                                    <span class="filter-match-badge" title="Filter Match Bonus">+<?= $person['filter_bonus'] ?></span>
                                <?php endif; ?>
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
                                <div class="profile-img-container me-3">
                                    <img src="../<?= htmlspecialchars($person['profile_picture']) ?>" 
                                         alt="Profile" 
                                         class="profile-img"
                                         onerror="this.src='../uploads/profile_pictures/default.png'">
                                    <div class="availability-badge <?= $availability ?>" 
                                         title="<?= ucfirst($availability) ?>"></div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-1"><?= htmlspecialchars($person['full_name']) ?></h5>
                                    
                                    <!-- Study Year -->
                                    <?php if (!empty($person['study_year'])): ?>
                                        <div class="mt-1">
                                            <span class="study-year-badge">🎯 Batch: <?= htmlspecialchars($person['study_year']) ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <a href="student-profile.php?student_id=<?= $person['id']; ?>" 
                                       class="btn btn-sm btn-outline-primary mt-2" target="_blank">
                                        <i class="fas fa-external-link-alt me-1"></i>View Profile
                                    </a>
                                </div>
                            </div>

                            <!-- Match Insights -->
                            <?php if ($person['match_score'] >= 80): ?>
                                <div class="match-insights">
                                    <small><i class="fas fa-star me-1 text-warning"></i> 
                                    <strong>Match Insight:</strong> Excellent match! Strong technical skills and relevant experience.</small>
                                </div>
                            <?php elseif ($person['match_score'] >= 70): ?>
                                <div class="match-insights">
                                    <small><i class="fas fa-thumbs-up me-1 text-info"></i> 
                                    <strong>Match Insight:</strong> Strong candidate with good potential for your requirements.</small>
                                </div>
                            <?php elseif ($person['match_score'] >= 60): ?>
                                <div class="match-insights">
                                    <small><i class="fas fa-check-circle me-1 text-success"></i> 
                                    <strong>Match Insight:</strong> Good match with solid background and skills.</small>
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
                        <i class="fas fa-search"></i>
                        <h4>No matched candidates found</h4>
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
            if (e.target.tagName === 'A' || e.target.closest('a')) return;
            const profileLink = this.querySelector('a[href*="student-profile"]');
            if (profileLink) {
                window.open(profileLink.href, '_blank');
            }
        });
    });

    // Skill suggestions
    const skillInput = document.getElementById('skill_filter');
    const skillSuggestions = [
        'javascript', 'python', 'react', 'java', 'php', 'laravel',
        'nodejs', 'sql', 'mongodb', 'aws', 'docker', 'kubernetes',
        'machine learning', 'data analysis', 'project management',
        'communication', 'leadership', 'teamwork', 'problem solving'
    ];
    
    if (skillInput) {
        let datalist = document.createElement('datalist');
        datalist.id = 'skill-suggestions';
        skillSuggestions.forEach(skill => {
            let option = document.createElement('option');
            option.value = skill;
            datalist.appendChild(option);
        });
        skillInput.parentNode.appendChild(datalist);
        skillInput.setAttribute('list', 'skill-suggestions');
        
        skillInput.addEventListener('focus', function() {
            this.placeholder = 'Type to see suggestions or enter custom skill';
        });
        
        skillInput.addEventListener('blur', function() {
            this.placeholder = 'e.g., javascript, python, project management';
        });
    }
    
    // Experience level guidance tooltip
    const experienceSelect = document.getElementById('experience_level');
    if (experienceSelect) {
        experienceSelect.addEventListener('mouseenter', function() {
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip bs-tooltip-top';
            tooltip.innerHTML = `
                <div class="tooltip-arrow"></div>
                <div class="tooltip-inner">
                    <small>Select based on years of experience</small>
                </div>
            `;
            tooltip.style.position = 'absolute';
            tooltip.style.top = (this.offsetTop - 40) + 'px';
            tooltip.style.left = this.offsetLeft + 'px';
            tooltip.style.zIndex = '1000';
            document.body.appendChild(tooltip);
            
            this._tooltip = tooltip;
        });
        
        experienceSelect.addEventListener('mouseleave', function() {
            if (this._tooltip) {
                document.body.removeChild(this._tooltip);
                this._tooltip = null;
            }
        });
    }
    
    // Auto-submit form on filter change if there are already filters
    const filterSelects = document.querySelectorAll('select[name]');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            const form = this.closest('form');
            const hasActiveFilters = <?= json_encode($education_year || $now_status || $skill_filter || $experience_level || $education_level) ?>;
            
            if (hasActiveFilters) {
                form.submit();
            }
        });
    });
});
</script>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
</body>
</html>

<?php
$conn->close();
?>