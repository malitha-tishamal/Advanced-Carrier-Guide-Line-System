<?php
session_start();
require_once 'includes/db-conn.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['student_id'];

$sql2 = "SELECT * FROM students WHERE id = ?";
$stmt = $conn->prepare($sql2);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc(); 

$user_id = $_SESSION['student_id'];
$summary = "";
$about_text = '';

// Fetch summary from the separate table
$sql = "SELECT summary FROM students_summaries WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($summary);
$stmt->fetch();
$stmt->close();

// Fetch about_text
$sql = "SELECT about_text FROM students_about WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($about_text);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Your Career Path | EduWide – Best Career Guideline System by Malitha Tishamal</title>
    <meta name="description" content="Build your career path on EduWide – the best carrier guide line system by Malitha Tishamal. Add your experience, education, skills, and get matched with top companies.">
    <meta name="keywords" content="malithatishamal, carrier guide line system, career path builder, student profile, HND career, eduwide">
    <meta name="author" content="Malitha Tishamal">
    <meta name="robots" content="noindex, follow">
    <?php include_once("includes/css-links-inc.php"); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script> 
    <style>
        .profile-header {
            background-color: #0073b1;
            color: white;
            padding: 30px;
        }
        .profile-header img {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            margin-right: 20px;
        }
        .profile-header h1 {
            margin-top: 20px;
        }
        .section-header {
            font-size: 1.5em;
            margin-top: 30px;
            margin-bottom: 20px;
        }
        .list-group-item {
            border: none;
            cursor: grab;
        }
        .card-body p {
            margin: 5px 0;
        }
        .btn-custom {
            background-color: #0073b1;
            color: white;
            border-radius: 20px;
        }
        .btn-custom:hover {
            background-color: #005f8c;
        }
        .experience-section, .education-section, .skills-section, .interests-section {
            margin-top: 30px;
        }
        #work-experience-list .list-group-item {
            user-select: none; 
        }
        .summary-card {
            border-radius: 10px;
            background-color: #fff;
        }
        .summary-icon {
            background-color: #e6f0ff;
            border-radius: 8px;
            display: inline-block;
        }
        .badge + .badge {
            margin-left: 0.25rem;
        }

        /* Work Experience Section */
        #experience-list {
            padding: 0;
        }

        .experience-card {
            background-color: #f9f9f9;
            border: 1px solid #e1e4e8;
            width: 60%;
            border-radius: 5px;
            padding: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .experience-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .experience-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #0073b1;
        }

        .experience-company {
            font-size: 1rem;
            color: #444;
        }

        .experience-details {
            margin-top: 10px;
            font-size: 0.9rem;
            color: #555;
        }

        .experience-location,
        .experience-dates {
            margin-right: 20px;
        }

        .experience-description {
            margin-top: 10px;
            font-size: 1rem;
            color: #333;
        }

        .experience-footer {
            margin-top: 10px;
            font-size: 0.9rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .experience-type,
        .experience-source {
            color: #888;
        }

        .experience-type {
            font-weight: bold;
        }

        #education-list .education-card {
            border-radius: 8px;
            background-color: #f9f9f9;
            border: 1px solid #dfe3e8;
            width: 60%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        #education-list .education-card:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        #education-list .card-title {
            font-size: 1.25rem;
            color: #0073b1;
            font-weight: bold;
        }

        #education-list .card-subtitle {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 0.5rem;
        }

        #education-list .education-details {
            font-size: 0.875rem;
            color: #495057;
        }

        #education-list .education-details span {
            margin-right: 1rem;
        }

        #education-list .education-description p {
            font-size: 1rem;
            color: #495057;
            line-height: 1.5;
            margin-top: 0.2rem;
        }
    </style>
</head>
<body>

    <?php include_once("includes/header.php") ?>
    <?php include_once("includes/students-sidebar.php") ?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Home</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item"><a href="">Details</a></li>
                    <li class="breadcrumb-item"><a href="">Your Path</a></li>
                </ol>
            </nav>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div>
                                <!-- About Section -->
                                <div class="about-section">
                                    <h3 class="section-header d-flex justify-content-between align-items-center">
                                        About
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editAboutModal">Edit</button>
                                    </h3>
                                    <div id="about-text" class="shadow p-3 mb-3 bg-white rounded w-75">
                                        <?= !empty($about_text) ? nl2br(htmlspecialchars($about_text)) : 'Click edit to add your About section.' ?>
                                    </div>
                                </div>

                                <div class="modal fade" id="editAboutModal" tabindex="-1" aria-labelledby="editAboutModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form class="modal-content" id="edit-about-form">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editAboutModalLabel">Edit About</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <textarea id="about-input" class="form-control w-100" rows="5"><?= htmlspecialchars($about_text) ?></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <script>
                                    document.getElementById('edit-about-form').addEventListener('submit', function (e) {
                                        e.preventDefault();
                                        let updatedText = document.getElementById('about-input').value;

                                        fetch('update_students_about.php', {
                                            method: 'POST',
                                            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                                            body: 'about=' + encodeURIComponent(updatedText)
                                        })
                                        .then(response => response.text())
                                        .then(data => {
                                            if (data.trim() === 'success') {
                                                document.getElementById('about-text').innerHTML = updatedText.replace(/\n/g, '<br>');
                                                let modalEl = document.getElementById('editAboutModal');
                                                let modalInstance = bootstrap.Modal.getInstance(modalEl);
                                                modalInstance.hide();
                                                if (window.innerWidth <= 768) {
                                                    location.reload(); 
                                                }
                                            } else {
                                                location.reload(); 
                                            }
                                        })
                                        .catch(error => {
                                            console.error("Error updating About:", error);
                                            alert("Something went wrong.");
                                        });
                                    });
                                </script>

                                <!-- Summary Section -->
                                <div class="container">
                                    <div class="summary-card shadow p-3 mb-3 bg-white rounded w-75">
                                        <div class="d-flex align-items-start">
                                            <div class="summary-icon me-3">
                                                <?php 
                                                $profilePic = !empty($user['profile_picture']) ? $user['profile_picture'] : 'default-profile.jpg';
                                                echo "<img src='$profilePic?" . time() . "' alt='Profile Picture' class='img-thumbnail mb-1' style='width: 100px;'>";
                                                ?>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-bold">Write a summary about your personality or academic experience</h6>
                                                <p class="text-muted"><?= !empty($summary) ? htmlentities($summary) : 'No summary added yet.' ?></p>
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addSummaryModal">
                                                    <?= !empty($summary) ? 'Edit Summary' : 'Add Summary' ?>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="addSummaryModal" tabindex="-1" aria-labelledby="addSummaryModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form id="summary-form">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Add Summary</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="text-muted mb-2">You can write about your academic experience, skills, or achievements.</p>
                                                    <textarea class="form-control" name="summary" rows="5" required><?= htmlentities($summary) ?></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary" id="save-summary">Save</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <script>
                                    document.getElementById("summary-form").addEventListener("submit", function(event) {
                                        event.preventDefault();
                                        let summary = document.querySelector("textarea[name='summary']").value;

                                        fetch("save_students_summary.php", {
                                            method: "POST",
                                            headers: { "Content-Type": "application/x-www-form-urlencoded" },
                                            body: "summary=" + encodeURIComponent(summary)
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.status === "success") {
                                                alert("Summary updated successfully!");
                                                location.reload();
                                            } else {
                                                alert("Error: " + data.message);
                                            }
                                        })
                                        .catch(error => console.error("Fetch error:", error));
                                    });
                                </script>

                                <!-- Experience Section -->
                                <div class="experience-section">
                                    <h3 class="section-header">Experience</h3>
                                    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#experienceModal">Add Experience</button>

                                    <div id="experience-list" class="mt-4">
                                        <?php
                                        // Fetch experience data from the database
                                        $query = "SELECT * FROM students_experiences WHERE user_id = ?";
                                        $stmt = $conn->prepare($query);
                                        $stmt->bind_param('i', $user_id);
                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $currently_working = $row['currently_working'] ? 'Currently Working' : 'Ended';
                                                $end_date = $row['currently_working'] ? 'Present' : $row['end_month'] . ' ' . $row['end_year'];

                                                echo '
                                                <div class="experience-card mb-4" id="experience-' . $row['id'] . '">
                                                    <div class="experience-header">
                                                        <h4 class="experience-title">' . $row['title'] . '</h4>
                                                        <span class="experience-company">' . $row['company'] . '</span>
                                                    </div>
                                                    <div class="experience-details">
                                                        <span class="experience-location">' . $row['location'] . '</span>
                                                        <span class="experience-dates">' . $row['start_month'] . ' ' . $row['start_year'] . ' - ' . $end_date . '</span>
                                                    </div>
                                                    <div class="experience-description">
                                                        <p>' . nl2br($row['description']) . '</p>
                                                    </div>
                                                    <div class="experience-footer">
                                                        <span class="experience-type">' . $row['employment_type'] . '</span>
                                                        <span class="experience-source">Source: ' . $row['job_source'] . '</span>
                                                    </div>
                                                    <div class="experience-actions">
                                                        <a href="edit_students_experience.php?id=' . $row['id'] . '" class="btn btn-warning btn-sm">Edit</a>
                                                        <button class="btn btn-danger btn-sm delete-experience-btn" data-id="' . $row['id'] . '">Delete</button>
                                                    </div>
                                                </div>';
                                            }
                                        } else {
                                            echo '<p>No experience added yet.</p>';
                                        }
                                        $stmt->close();
                                        ?>
                                    </div>
                                </div>

                                <!-- Experience Modal -->
                                <div class="modal fade" id="experienceModal" tabindex="-1" aria-labelledby="experienceModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <form class="modal-content" method="POST" id="experience-form">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="experienceModalLabel">Add Experience</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body row g-3">
                                                <div class="col-md-6">
                                                    <label for="title" class="form-label">Title*</label>
                                                    <input type="text" class="form-control" id="title" name="title" required>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="employment_type" class="form-label">Employment type</label>
                                                    <select class="form-select" id="employment_type" name="employment_type">
                                                        <option value="">Please select</option>
                                                        <option value="Full-time">Full-time</option>
                                                        <option value="Part-time">Part-time</option>
                                                        <option value="Internship">Internship</option>
                                                        <option value="Freelance">Freelance</option>
                                                        <option value="Volunteer">Volunteer</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-12">
                                                    <label for="company" class="form-label">Company or organization*</label>
                                                    <input type="text" class="form-control" id="company" name="company" required>
                                                </div>

                                                <div class="col-md-12 form-check">
                                                    <input class="form-check-input" type="checkbox" value="1" id="currentlyWorking" name="currently_working">
                                                    <label class="form-check-label" for="currentlyWorking">I am currently working in this role</label>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="start_month" class="form-label">Start Month*</label>
                                                    <select class="form-select" id="start_month" name="start_month" required>
                                                        <option value="">Month</option>
                                                        <option>January</option><option>February</option><option>March</option>
                                                        <option>April</option><option>May</option><option>June</option>
                                                        <option>July</option><option>August</option><option>September</option>
                                                        <option>October</option><option>November</option><option>December</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="start_year" class="form-label">Start Year*</label>
                                                    <input type="number" class="form-control" id="start_year" name="start_year" required>
                                                </div>

                                                <div id="end-date-group" class="row">
                                                    <div class="col-md-3">
                                                        <label for="end_month" class="form-label">End Month</label>
                                                        <select class="form-select" id="end_month" name="end_month">
                                                            <option value="">Month</option>
                                                            <option>January</option><option>February</option><option>March</option>
                                                            <option>April</option><option>May</option><option>June</option>
                                                            <option>July</option><option>August</option><option>September</option>
                                                            <option>October</option><option>November</option><option>December</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="end_year" class="form-label">End Year</label>
                                                        <input type="number" class="form-control" id="end_year" name="end_year">
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <label for="location" class="form-label">Location</label>
                                                    <input type="text" class="form-control" id="location" name="location">
                                                </div>

                                                <div class="col-md-12">
                                                    <label for="description" class="form-label">Description</label>
                                                    <textarea class="form-control" id="description" name="description" rows="3" maxlength="2000"
                                                        placeholder="Describe your responsibilities and achievements"></textarea>
                                                    <div class="form-text">0/2000</div>
                                                </div>

                                                <div class="col-md-12">
                                                    <label for="job_source" class="form-label">How did you find this opportunity?</label>
                                                    <select class="form-select" id="job_source" name="job_source">
                                                        <option value="">Please select</option>
                                                        <option value="University">University</option>
                                                        <option value="Referral">Referral</option>
                                                        <option value="Online">Online</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <script>
                                    // Character count for description
                                    const description = document.getElementById("description");
                                    const charCount = description.nextElementSibling;

                                    description.addEventListener("input", function () {
                                        const currentLength = description.value.length;
                                        charCount.textContent = `${currentLength}/2000`;
                                        if (currentLength > 2000) {
                                            description.classList.add("is-invalid");
                                        } else {
                                            description.classList.remove("is-invalid");
                                        }
                                    });

                                    // Experience form submission
                                    document.getElementById("experience-form").addEventListener("submit", function (event) {
                                        event.preventDefault();
                                        let isValid = true;
                                        this.querySelectorAll(".is-invalid").forEach(el => el.classList.remove("is-invalid"));

                                        const title = document.getElementById("title");
                                        const company = document.getElementById("company");
                                        const startMonth = document.getElementById("start_month");
                                        const startYear = document.getElementById("start_year");
                                        const endMonth = document.getElementById("end_month");
                                        const endYear = document.getElementById("end_year");
                                        const currentlyWorking = document.getElementById("currentlyWorking");

                                        // Required field validation
                                        [title, company, startMonth, startYear].forEach(field => {
                                            if (!field.value.trim()) {
                                                field.classList.add("is-invalid");
                                                isValid = false;
                                            }
                                        });

                                        // Conditional validation for end dates
                                        if (!currentlyWorking.checked) {
                                            if (!endMonth.value.trim()) {
                                                endMonth.classList.add("is-invalid");
                                                isValid = false;
                                            }
                                            if (!endYear.value.trim()) {
                                                endYear.classList.add("is-invalid");
                                                isValid = false;
                                            }
                                        }

                                        if (description.value.length > 2000) {
                                            description.classList.add("is-invalid");
                                            isValid = false;
                                        }

                                        if (!isValid) {
                                            alert("Please fill all required fields correctly.");
                                            return;
                                        }

                                        const formData = new FormData(this);
                                        const params = new URLSearchParams();
                                        for (const [key, value] of formData) {
                                            params.append(key, value);
                                        }

                                        fetch('save_students_experience.php', {
                                            method: "POST",
                                            headers: { "Content-Type": "application/x-www-form-urlencoded" },
                                            body: params.toString()
                                        })
                                        .then(res => res.json())
                                        .then(data => {
                                            if (data.status === "success") {
                                                alert("Experience added!");
                                                location.reload();
                                            } else {
                                                alert("Error: " + data.message);
                                            }
                                        })
                                        .catch(err => {
                                            console.error("Error:", err);
                                            alert("Something went wrong.");
                                        });
                                    });

                                    // Toggle end date fields
                                    const currentlyWorking = document.getElementById("currentlyWorking");
                                    const endDateGroup = document.getElementById("end-date-group");
                                    const endMonth = document.getElementById("end_month");
                                    const endYear = document.getElementById("end_year");

                                    function toggleEndDateFields() {
                                        if (currentlyWorking.checked) {
                                            endDateGroup.style.display = "none";
                                            endMonth.disabled = true;
                                            endYear.disabled = true;
                                        } else {
                                            endDateGroup.style.display = "flex";
                                            endMonth.disabled = false;
                                            endYear.disabled = false;
                                        }
                                    }

                                    currentlyWorking.addEventListener("change", toggleEndDateFields);
                                    window.addEventListener("DOMContentLoaded", toggleEndDateFields);

                                    // Delete experience
                                    document.querySelectorAll('.delete-experience-btn').forEach(button => {
                                        button.addEventListener('click', function() {
                                            let experienceId = this.getAttribute('data-id');
                                            if (confirm('Are you sure you want to delete this experience?')) {
                                                fetch('delete_students_experience.php', {
                                                    method: 'POST',
                                                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                                                    body: 'id=' + encodeURIComponent(experienceId)
                                                })
                                                .then(response => response.json())
                                                .then(data => {
                                                    if (data.status === 'success') {
                                                        document.getElementById('experience-' + experienceId).remove();
                                                        alert('Experience deleted successfully!');
                                                    } else {
                                                        alert('Error: ' + data.message);
                                                    }
                                                })
                                                .catch(error => console.error('Error:', error));
                                            }
                                        });
                                    });
                                </script>

                                <!-- Education Section -->
                                <div class="education-section">
                                    <h3 class="section-header">Education</h3>
                                    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#educationModal">Add Education</button>

                                    <div>
                                        <ul class="list-group" id="education-list">
                                            <?php
                                            // Fetch education data from the database
                                            $query = "SELECT * FROM students_education WHERE user_id = ?";
                                            $stmt = $conn->prepare($query);
                                            $stmt->bind_param('i', $user_id);
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo '
                                                    <li class="list-group-item border-0">
                                                        <div class="education-card card mb-4 shadow-sm">
                                                            <div class="card-body p-4">
                                                                <h5 class="card-title mb-2 font-weight-bold">' . htmlspecialchars($row['degree']) . ' <span class="">&emsp; From &emsp; </span> <font color="red">' . htmlspecialchars($row['school']) . '</font></h5>
                                                                <h6 class="card-subtitle mb-3 text-muted">' . htmlspecialchars($row['field_of_study']) . '</h6>
                                                                <div class="education-details mb-3">
                                                                    <span class="text-muted">' . htmlspecialchars($row['start_month']) . ' ' . $row['start_year'] . ' - ' . htmlspecialchars($row['end_month']) . ' ' . $row['end_year'] . '</span>
                                                                    <span class="ml-3 text-muted">Grade: ' . htmlspecialchars($row['grade']) . '</span>
                                                                </div>
                                                                <p class="card-text mb-2"><strong>Activities & Societies:</strong> ' . htmlspecialchars($row['activities']) . '</p>
                                                                <div class="education-description">
                                                                    <p>' . nl2br(htmlspecialchars($row['description'])) . '</p>
                                                                </div>

                                                                <!-- Edit and Delete buttons -->
                                                                <div class="education-actions mt-3">
                                                                    <a href="edit_education.php?id=' . $row['id'] . '" class="btn btn-warning btn-sm">Edit</a>
                                                                    <button class="btn btn-danger btn-sm delete-btn" data-id="' . $row['id'] . '">Delete</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>';
                                                }
                                            } else {
                                                echo '<p>No education information added yet.</p>';
                                            }
                                            $stmt->close();
                                            ?>
                                        </ul>
                                    </div>
                                </div>

                                <script>
                                    document.querySelectorAll('.delete-btn').forEach(function (button) {
                                        button.addEventListener('click', function () {
                                            var educationId = this.getAttribute('data-id');

                                            if (confirm('Are you sure you want to delete this education record?')) {
                                                var xhr = new XMLHttpRequest();
                                                xhr.open('POST', 'delete_education.php', true);
                                                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                                xhr.onload = function () {
                                                    if (xhr.status === 200) {
                                                        var response = JSON.parse(xhr.responseText);
                                                        if (response.status === 'success') {
                                                            alert(response.message);
                                                            location.reload();
                                                        } else {
                                                            alert(response.message);
                                                        }
                                                    } else {
                                                        alert('An error occurred while deleting the record.');
                                                    }
                                                };
                                                xhr.send('education_id=' + educationId);
                                            }
                                        });
                                    });
                                </script>

                                <!-- Education Modal -->
                                <div class="modal fade" id="educationModal" tabindex="-1" aria-labelledby="educationModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <form class="modal-content" id="education-form" method="POST" action="save_education.php">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="educationModalLabel">Add Education</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body row g-3">
                                                <!-- Basic Education Inputs -->
                                                <div class="col-md-6">
                                                    <label for="school" class="form-label">School*</label>
                                                    <input type="text" class="form-control" id="school" name="school" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="degree" class="form-label">Degree</label>
                                                    <input type="text" class="form-control" id="degree" name="degree">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="field" class="form-label">Field of Study</label>
                                                    <input type="text" class="form-control" id="field" name="field">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="start-month" class="form-label">Start Month</label>
                                                    <select class="form-select" id="start-month" name="start_month">
                                                        <option value="">--Month--</option>
                                                        <option value="January">January</option>
                                                        <option value="February">February</option>
                                                        <option value="March">March</option>
                                                        <option value="April">April</option>
                                                        <option value="May">May</option>
                                                        <option value="June">June</option>
                                                        <option value="July">July</option>
                                                        <option value="August">August</option>
                                                        <option value="September">September</option>
                                                        <option value="October">October</option>
                                                        <option value="November">November</option>
                                                        <option value="December">December</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="start-year" class="form-label">Start Year</label>
                                                    <input type="number" class="form-control" id="start-year" name="start_year">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="end-month" class="form-label">End Month</label>
                                                    <select class="form-select" id="end-month" name="end_month">
                                                        <option value="">--Month--</option>
                                                        <option value="January">January</option>
                                                        <option value="February">February</option>
                                                        <option value="March">March</option>
                                                        <option value="April">April</option>
                                                        <option value="May">May</option>
                                                        <option value="June">June</option>
                                                        <option value="July">July</option>
                                                        <option value="August">August</option>
                                                        <option value="September">September</option>
                                                        <option value="October">October</option>
                                                        <option value="November">November</option>
                                                        <option value="December">December</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="end-year" class="form-label">End Year</label>
                                                    <input type="number" class="form-control" id="end-year" name="end_year">
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="grade" class="form-label">Grade</label>
                                                    <input type="text" class="form-control" id="grade" name="grade">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="activities" class="form-label">Activities and Societies</label>
                                                    <input type="text" class="form-control" id="activities" name="activities" maxlength="500">
                                                </div>
                                                <div class="col-12">
                                                    <label for="edu-description" class="form-label">Description</label>
                                                    <textarea class="form-control" id="edu-description" name="description" rows="3" maxlength="1000"></textarea>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include_once("includes/footer.php") ?>
    <?php include_once("includes/js-links-inc.php") ?>
    
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
</body>
</html>
<?php
$conn->close();
?>