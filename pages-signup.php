<?php
// Start session to access session variables
session_start();

// Include database connection to fetch courses
require_once 'includes/db-conn.php';

// Fetch HND courses
$courses = [];
$courseQuery = "SELECT id, name FROM hnd_courses ORDER BY name ASC";
if ($result = $conn->query($courseQuery)) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- ===== PRIMARY SEO META ===== -->
    <title>Student Registration | EduWide – Best Career Guideline System by Malitha Tishamal</title>
    <meta name="description" content="Create your EduWide student account – the best career guideline system by Malitha Tishamal. Join thousands of students getting AI-powered career guidance and company connections.">
    <meta name="keywords" content="malithatishamal, carrier guide line system, student registration, career guidance, HND student, eduwide signup, best career platform">
    <meta name="author" content="Malitha Tishamal">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://malithatishamal.42web.io/pages-signup.php">

    <!-- ===== OPEN GRAPH ===== -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://malithatishamal.42web.io/pages-signup.php">
    <meta property="og:title" content="Join EduWide – Best Career Guideline System | Malitha Tishamal">
    <meta property="og:description" content="Register on EduWide, the best carrier guide line system by malithatishamal. Get AI-powered career matches, connect with companies and unlock your career potential.">
    <meta property="og:image" content="https://malithatishamal.42web.io/assets/images/logos/eduwide-logo.png">
    <meta property="og:site_name" content="EduWide Career Guideline System">

    <?php include_once ("includes/css-links-inc.php"); ?>
    <style>
        /* Styling for the popup */
        .popup-message {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 15px;
            background-color: #28a745;
            color: white;
            font-weight: bold;
            border-radius: 5px;
            display: none; /* Hidden by default */
            z-index: 9999;
        }

        .error-popup {
            background-color: #dc3545;
        }
    </style>
</head>

<body>
    <!-- 2026 Cyberpunk Floating Background Orbs -->
    <div class="cyber-orb cyber-orb-1"></div>
    <div class="cyber-orb cyber-orb-2"></div>
    <div class="cyber-orb cyber-orb-3"></div>

    <!-- Displaying the message from the session -->
    <?php if (isset($_SESSION['status'])): ?>
        <div class="popup-message <?php echo ($_SESSION['status'] == 'success') ? '' : 'error-popup'; ?>" id="popup-alert">
            <?php echo $_SESSION['message']; ?>
        </div>

        <script>
            // Display the popup message
            document.getElementById('popup-alert').style.display = 'block';

            // Automatically hide the popup after 1 second
            setTimeout(function() {
                const popupAlert = document.getElementById('popup-alert');
                if (popupAlert) {
                    popupAlert.style.display = 'none';
                }
            }, 1000);
        </script>

        <?php
        unset($_SESSION['status']);
        unset($_SESSION['message']);
        ?>
    <?php endif; ?>

    <main>
        <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                            <div class="d-flex justify-content-center py-4">
                                <a href="" class="logo d-flex align-items-center w-auto">
                                    <img src="assets/images/logos/eduwide-logo.png" alt="" style="max-height:130px;">
                                </a>
                            </div>

                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Create Active Student Account</h5>
                                    </div>

                                    <form id="signup-form" action="register.php" method="POST" class="row g-3 needs-validation" novalidate>
                                        <!-- Name -->
                                        <div class="col-12">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="name" name="username" required>
                                            <div class="invalid-feedback" style="font-size:14px;">
                                                Please enter the name
                                            </div>
                                        </div>
                                        
                                         <div class="col-12">
                                            <label for="course" class="form-label">Select Course</label>
                                            <select class="form-control" id="course" name="course_id" required>
                                                <option value="" disabled selected>-- Select Course --</option>
                                                <?php foreach($courses as $course): ?>
                                                    <option value="<?php echo $course['id']; ?>">
                                                        <?php echo htmlspecialchars($course['name']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="invalid-feedback" style="font-size:14px;">
                                                Please select a course
                                            </div>
                                        </div>

                                        <!-- Registration ID -->
                                        <div class="col-12">
                                            <label for="reg_id" class="form-label">Registration ID</label>
                                            <input type="text" class="form-control" id="reg_id" name="reg_id" placeholder="e.g: GAL/IT/20xx/xxxx" required>
                                            <div class="invalid-feedback" style="font-size:14px;">
                                                Please enter your Registration ID
                                            </div>
                                        </div>

                                        <!-- NIC -->
                                        <div class="col-12">
                                            <label for="nicNumber" class="form-label">NIC Number</label>
                                            <input type="text" class="form-control" id="nicNumber" name="nic" placeholder="" oninput="this.value = this.value.toUpperCase();" required>
                                            <div class="invalid-feedback" style="font-size:14px;">
                                                Please enter the NIC number
                                            </div>
                                        </div>

                                        <!-- Study Year -->
                                        <div class="col-12">
                                            <label for="year" class="form-label">Select Study Year</label>
                                            <select class="form-control" id="year" name="study_year" required>
                                                <option value="" disabled selected>-- Select Year --</option>
                                            </select>
                                            <div class="invalid-feedback" style="font-size:14px;">
                                                Please select your academic year
                                            </div>
                                        </div>
                                        <script>
                                            let currentYear = new Date().getFullYear();
                                            let startYear = 2022;
                                            let endYear = currentYear + 2;
                                            let yearSelect = document.getElementById("year");
                                            for (let year = startYear; year <= endYear; year++) {
                                                let option = document.createElement("option");
                                                option.value = year;
                                                option.textContent = year;
                                                yearSelect.appendChild(option);
                                            }
                                        </script>

                                        <!-- Email -->
                                        <div class="col-12">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                            <div class="invalid-feedback" style="font-size:14px;">
                                                Please enter the email address
                                            </div>
                                        </div>

                                        <!-- Mobile -->
                                        <div class="col-12">
                                            <label for="mobileNumber" class="form-label">Mobile Number</label>
                                            <div class="input-group">
                                                <span class="input-group-text">+94</span>
                                                <input type="tel" class="form-control" id="mobileNumber" name="mobile" placeholder="712345678" required>
                                                <div class="invalid-feedback" style="font-size:14px;">
                                                    Please enter the mobile number
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Password -->
                                        <div class="col-12">
                                            <label for="password" class="form-label">Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="password" name="password" required>
                                                <span class="input-group-text" id="inputGroupPrepend">
                                                    <i class="password-toggle-icon1 bx bxs-show" onclick="togglePasswordVisibility('password', 'password-toggle-icon1')"></i>
                                                </span>
                                                <div class="invalid-feedback" style="font-size:14px;">
                                                    Please enter password
                                                </div>
                                            </div>
                                        </div>

                                        <!-- HND Course Select -->
                                       

                                        <!-- Submit -->
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Create Account</button>
                                        </div>

                                        <!-- Links -->
                                        <div class="col-12">
                                            <p class="small mb-0">Create Former Students account? <a href="oddstudents/pages-signup.php">Click</a></p>
                                            <p class="small mb-0">Create Lecture account? <a href="../lectures/pages-signup.php">Click</a></p>
                                            <p class="small mb-0">Create Admin account? <a href="admin/pages-signup.php">Click</a></p>
                                            <p class="small mb-0">Already have an account? <a href="index.php">Log in</a></p>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <?php include_once ("includes/footer3.php") ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Simple password toggle
        function togglePasswordVisibility(inputId, iconClass) {
            const input = document.getElementById(inputId);
            const icon = document.querySelector(`.${iconClass}`);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("bxs-show");
                icon.classList.add("bxs-hide");
            } else {
                input.type = "password";
                icon.classList.remove("bxs-hide");
                icon.classList.add("bxs-show");
            }
        }

        // Optional: You can add form validation here
    </script>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <?php include_once ("includes/js-links-inc.php") ?>
</body>

</html>
