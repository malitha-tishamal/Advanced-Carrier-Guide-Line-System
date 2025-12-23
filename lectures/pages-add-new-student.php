<?php
session_start();
require_once '../includes/db-conn.php';

// Redirect if not logged in
if (!isset($_SESSION['lecturer_id'])) {
    header("Location: ../index.php");
    exit();
}

// Fetch admin user details
$user_id = $_SESSION['lecturer_id'];
$sql = "SELECT username, email, nic, mobile, profile_picture FROM lectures WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Fetch HND courses
$hnd_courses_query = "SELECT id, name FROM hnd_courses ORDER BY name ASC";
$hnd_courses_result = $conn->query($hnd_courses_query);
$hnd_courses = [];
if ($hnd_courses_result->num_rows > 0) {
    while ($row = $hnd_courses_result->fetch_assoc()) {
        $hnd_courses[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Add Active Student - EduWide</title>

    <?php include_once("../includes/css-links-inc.php"); ?>

    <style>
        /* Popup styling */
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
            display: none;
            z-index: 9999;
        }

        .error-popup {
            background-color: #dc3545;
        }
    </style>

    <?php if (isset($_SESSION['status'])): ?>
        <div class="popup-message <?php echo ($_SESSION['status'] == 'success') ? '' : 'error-popup'; ?>" id="popup-alert">
            <?php echo $_SESSION['message']; ?>
        </div>

        <script>
            document.getElementById('popup-alert').style.display = 'block';
            setTimeout(function() {
                const popupAlert = document.getElementById('popup-alert');
                if (popupAlert) popupAlert.style.display = 'none';
            }, 1000);

            <?php if ($_SESSION['status'] == 'success'): ?>
                setTimeout(function() {
                    window.location.href = 'pages-add-lecture.php';
                }, 1000);
            <?php endif; ?>
        </script>

        <?php
        unset($_SESSION['status']);
        unset($_SESSION['message']);
        ?>
    <?php endif; ?>
</head>

<body>
    <?php include_once("../includes/header.php") ?>
    <?php include_once("../includes/lectures-sidebar.php") ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Add Active Student</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">Active Student</li>
                    <li class="breadcrumb-item active">Add Active Student</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body pt-4">
                            <form action="student-register-process2.php" method="POST" class="needs-validation" novalidate>

                                <!-- Name -->
                                <div class="row mb-3">
                                    <label for="name" class="col-lg-3 col-md-4 col-sm-4 col-form-label">Name</label>
                                    <div class="col-lg-9 col-md-8 col-sm-8">
                                        <input type="text" class="form-control" id="name" name="username" required>
                                        <div class="invalid-feedback" style="font-size:14px;">Please enter the name</div>
                                    </div>
                                </div>

                                <!-- HND Course -->
                                <div class="row mb-3">
                                    <label for="course" class="col-lg-3 col-md-4 col-sm-4 col-form-label">HND Course</label>
                                    <div class="col-lg-9 col-md-8 col-sm-8">
                                        <select class="form-control" id="course" name="course_id" required>
                                            <option value="" disabled selected>-- Select Course --</option>
                                            <?php foreach($hnd_courses as $course): ?>
                                                <option value="<?php echo $course['id']; ?>"><?php echo $course['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback" style="font-size:14px;">Please select a course</div>
                                    </div>
                                </div>

                                <!-- Registration ID -->
                                <div class="row mb-3">
                                    <label for="reg_id" class="col-lg-3 col-md-4 col-sm-4 col-form-label">Registration ID</label>
                                    <div class="col-lg-9 col-md-8 col-sm-8">
                                        <input type="text" class="form-control" id="reg_id" name="reg_id" placeholder="e.g : GAL/IT/20xx/xxxx" required>
                                        <div class="invalid-feedback" style="font-size:14px;">Please enter the Registration ID</div>
                                    </div>
                                </div>

                                <!-- NIC Number -->
                                <div class="row mb-3">
                                    <label for="nicNumber" class="col-lg-3 col-md-4 col-sm-4 col-form-label">NIC Number</label>
                                    <div class="col-lg-9 col-md-8 col-sm-8">
                                        <input type="text" class="form-control" id="nicNumber" name="nic" oninput="this.value = this.value.toUpperCase();" required>
                                        <div class="invalid-feedback" style="font-size:14px;">Please enter the NIC number</div>
                                    </div>
                                </div>

                                <!-- Study Year -->
                                <div class="row mb-3">
                                    <label for="year" class="col-lg-3 col-md-4 col-sm-4 col-form-label">Study Year</label>
                                    <div class="col-lg-9 col-md-8 col-sm-8">
                                        <select class="form-control" id="year" name="study_year" required>
                                            <option value="" disabled selected>-- Select Year --</option>
                                        </select>
                                        <div class="invalid-feedback" style="font-size:14px;">Please Select Your Academic Year</div>
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
                                <div class="row mb-3">
                                    <label for="email" class="col-lg-3 col-md-4 col-sm-4 col-form-label">Email</label>
                                    <div class="col-lg-9 col-md-8 col-sm-8">
                                        <input type="email" class="form-control" id="email" name="email" required>
                                        <div class="invalid-feedback" style="font-size:14px;">Please enter the email address</div>
                                    </div>
                                </div>

                                <!-- Mobile -->
                                <div class="row mb-3">
                                    <label for="mobileNumber" class="col-lg-3 col-md-4 col-sm-4 col-form-label">Mobile Number</label>
                                    <div class="col-lg-9 col-md-8 col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-text">+94</span>
                                            <input type="tel" class="form-control" id="mobileNumber" name="mobile" placeholder="712345678" required>
                                            <div class="invalid-feedback" style="font-size:14px;">Please enter the mobile number</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="row mb-4">
                                    <label for="password" class="col-lg-3 col-md-4 col-sm-4 col-form-label">Password</label>
                                    <div class="col-lg-9 col-md-8 col-sm-8">
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password" name="password" required>
                                            <span class="input-group-text">
                                                <i class="password-toggle-icon1 bx bxs-show" onclick="togglePasswordVisibility('password', 'password-toggle-icon1')"></i>
                                            </span>
                                            <div class="invalid-feedback" style="font-size:14px;">Please enter password</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit -->
                               <div class="row mb-2">
    <input type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#confirmSubmitModal" value="Create Account">
</div>


                                <!-- Confirmation Modal -->
                                <div class="modal fade" id="confirmSubmitModal" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Confirmation</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you want to create the account?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                <input type="submit" class="btn btn-primary" name="create_account" value="Yes">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include_once("../includes/footer.php") ?>
    <?php include_once("../includes/js-links-inc.php") ?>
</body>
</html>
