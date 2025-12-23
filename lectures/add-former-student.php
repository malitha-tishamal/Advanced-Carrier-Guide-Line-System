<?php
session_start();
require_once '../includes/db-conn.php';

// Redirect if not logged in
if (!isset($_SESSION['lecturer_id'])) {
    header("Location: ../index.php");
    exit();
}

// Fetch user details
$user_id = $_SESSION['lecturer_id'];
$sql = "SELECT username, email, nic, mobile, profile_picture FROM lectures WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Fetch courses for dropdown
$course_query = "SELECT id, name FROM hnd_courses ORDER BY name ASC";
$course_result = $conn->query($course_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Add Former Student - Eduwide</title>

  <?php include_once("../includes/css-links-inc.php"); ?>

  <style>
    .popup-message {
      position: fixed;
      top: 20px;
      left: 50%;
      transform: translateX(-50%);
      padding: 15px 30px;
      background-color: #28a745;
      color: white;
      font-weight: bold;
      border-radius: 8px;
      display: none;
      z-index: 9999;
    }

    .error-popup {
      background-color: #dc3545;
    }

    .btn-primary {
      width: 250px; /* widened submit button */
      font-weight: 600;
    }
  </style>

  <?php if (isset($_SESSION['status'])): ?>
    <div class="popup-message <?php echo ($_SESSION['status'] == 'success') ? '' : 'error-popup'; ?>" id="popup-alert">
      <?php echo $_SESSION['message']; ?>
    </div>

    <script>
      document.addEventListener("DOMContentLoaded", () => {
        const popup = document.getElementById('popup-alert');
        popup.style.display = 'block';
        setTimeout(() => popup.style.display = 'none', 2500);
      });
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
      <h1>Add Former Student</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item">Former Student</li>
          <li class="breadcrumb-item active">Add Former Student</li>
        </ol>
      </nav>
    </div>

    <section class="section">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body pt-4">

              <form action="former-student-register-process2.php" method="POST" class="needs-validation" novalidate>

                <div class="row mb-3">
                  <label class="col-lg-3 col-form-label">Name</label>
                  <div class="col-lg-9">
                    <input type="text" class="form-control" name="username" required>
                    <div class="invalid-feedback">Please enter the name</div>
                  </div>
                </div>
                  
                  <div class="row mb-3">
                  <label class="col-lg-3 col-form-label">Course</label>
                  <div class="col-lg-9">
                    <select class="form-control" name="course_id" required>
                      <option value="" disabled selected>-- Select Course --</option>
                      <?php while ($course = $course_result->fetch_assoc()): ?>
                        <option value="<?= $course['id'] ?>"><?= htmlspecialchars($course['name']) ?></option>
                      <?php endwhile; ?>
                    </select>
                    <div class="invalid-feedback">Please select a course</div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-lg-3 col-form-label">Registration ID</label>
                  <div class="col-lg-9">
                    <input type="text" class="form-control" name="reg_id" placeholder="e.g. GAL/IT/20xx/xxxx" required>
                    <div class="invalid-feedback">Please enter the Registration ID</div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-lg-3 col-form-label">NIC Number</label>
                  <div class="col-lg-9">
                    <input type="text" class="form-control" name="nic" oninput="this.value=this.value.toUpperCase();" required>
                    <div class="invalid-feedback">Please enter a valid NIC number</div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-lg-3 col-form-label">Email</label>
                  <div class="col-lg-9">
                    <input type="email" class="form-control" name="email" required>
                    <div class="invalid-feedback">Please enter a valid email address</div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-lg-3 col-form-label">Mobile Number</label>
                  <div class="col-lg-9">
                    <div class="input-group">
                      <span class="input-group-text">+94</span>
                      <input type="tel" class="form-control" name="mobile" placeholder="712345678" required>
                      <div class="invalid-feedback">Please enter the mobile number</div>
                    </div>
                  </div>
                </div>


                <div class="row mb-3">
                  <label class="col-lg-3 col-form-label">Study Year</label>
                  <div class="col-lg-9">
                    <select class="form-control" id="year" name="study_year" required>
                      <option value="" disabled selected>-- Select Year --</option>
                    </select>
                    <div class="invalid-feedback">Please select your academic year</div>
                  </div>
                </div>

                <script>
                  let currentYear = new Date().getFullYear();
                  let startYear = 2000;
                  let endYear = currentYear + 2;
                  let yearSelect = document.getElementById("year");
                  for (let year = startYear; year <= endYear; year++) {
                    let option = document.createElement("option");
                    option.value = year;
                    option.textContent = year;
                    yearSelect.appendChild(option);
                  }
                </script>

                <div class="row mb-3">
                  <label class="col-lg-3 col-form-label">Now Full Time Status</label>
                  <div class="col-lg-9">
                    <div class="form-check form-check-inline">
                      <input type="radio" name="nowstatus" value="study" class="form-check-input" required>
                      <label class="form-check-label">Still Study</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input type="radio" name="nowstatus" value="work" class="form-check-input">
                      <label class="form-check-label">Work</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input type="radio" name="nowstatus" value="intern" class="form-check-input">
                      <label class="form-check-label">Intern</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input type="radio" name="nowstatus" value="free" class="form-check-input">
                      <label class="form-check-label">Free</label>
                    </div>
                  </div>
                </div>

                <div class="row mb-4">
                  <label class="col-lg-3 col-form-label">Password</label>
                  <div class="col-lg-9">
                    <div class="input-group">
                      <input type="password" class="form-control" id="password" name="password" required>
                      <span class="input-group-text">
                        <i class="bx bxs-show" style="cursor:pointer;" onclick="togglePasswordVisibility('password', this)"></i>
                      </span>
                      <div class="invalid-feedback">Please enter a password</div>
                    </div>
                  </div>
                </div>

                <div class="row mb-4">
                  <div class="text-center">
                    <input type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmSubmitModal" value="Create Account">
                  </div>
                </div>

                <!-- Confirmation Modal -->
                <div class="modal fade" id="confirmSubmitModal" tabindex="-1">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>
                      <div class="modal-body">Are you sure you want to create the account?</div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <input type="submit" class="btn btn-primary" value="Yes">
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

  <script>
    function togglePasswordVisibility(id, icon) {
      const input = document.getElementById(id);
      if (input.type === "password") {
        input.type = "text";
        icon.classList.replace("bxs-show", "bxs-hide");
      } else {
        input.type = "password";
        icon.classList.replace("bxs-hide", "bxs-show");
      }
    }
  </script>

</body>
</html>
