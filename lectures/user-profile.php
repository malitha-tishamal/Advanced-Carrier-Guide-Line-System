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
$sql = "SELECT * FROM lectures WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>User Profile - Eduwide</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <?php include_once ("../includes/css-links-inc.php"); ?>
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

    <!-- Displaying the message from the session -->
    <?php if (isset($_SESSION['status'])): ?>
        <div class="popup-message <?php echo ($_SESSION['status'] == 'success') ? '' : 'error-popup'; ?>" id="popup-alert">
            <?php echo $_SESSION['message']; ?>
        </div>

        <script>
            // Display the popup message
            document.getElementById('popup-alert').style.display = 'block';

            // Automatically hide the popup after 10 seconds
            setTimeout(function() {
                const popupAlert = document.getElementById('popup-alert');
                if (popupAlert) {
                    popupAlert.style.display = 'none';
                }
            }, 1000);

            // If success message, redirect to index.php after 10 seconds
            <?php if ($_SESSION['status'] == 'success'): ?>
                setTimeout(function() {
                    window.location.href = 'user-profile.php'; // Redirect after 10 seconds
                }, 1000); // Delay 10 seconds before redirecting
            <?php endif; ?>
        </script>

        <?php
        // Clear session variables after showing the message
        unset($_SESSION['status']);
        unset($_SESSION['message']);
        ?>
    <?php endif; ?>

    <?php include_once ("../includes/header.php") ?>
    <?php include_once ("../includes/lectures-sidebar.php") ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Profile</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </nav>
        </div>

        <section class="section profile">
            <div class="row">
                <div class="">
                    <div class="card">
                        <div class="card-body pt-3">
                            <ul class="nav nav-tabs nav-tabs-bordered">
                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade show active profile-overview pt-3" id="profile-overview">
                                   <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Profile Picture</div>
                                        <div class="col-lg-9 col-md-8">
                                            <?php 
                                            // Display profile picture with timestamp to force refresh
                                            echo "<img src='$profilePic?" . time() . "' alt='Profile Picture' class='img-thumbnail mb-1' style='width: 200px; height: 200px; border-radius:50%;'>";
                                            ?>
                                            
                                            <form action="update-profile-picture.php" method="POST" enctype="multipart/form-data">
                                                <div class="d-flex">
                                                    <input type="file" name="profile_picture" class="form-control form-control-sm w-25" accept="image/*" required>
                                                    &nbsp;&nbsp;
                                                    <input type="submit" name="submit" value="Update Picture" class="btn btn-primary btn-sm">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="container">
                                        <form action="update-profile.php" method="POST">
                                            <!-- Full Name -->
                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">Full Name</div>
                                                <div class="col-lg-9 col-md-8">
                                                    <input type="text" name="username" class="form-control w-75" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                                                </div>
                                            </div>

                                            <!-- Email -->
                                            <div class="row mt-3">
                                                <div class="col-lg-3 col-md-4 label">Email</div>
                                                <div class="col-lg-9 col-md-8">
                                                    <input type="email" name="email" class="form-control w-75" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                                </div>
                                            </div>

                                            <!-- NIC -->
                                            <div class="row mt-3">
                                                <div class="col-lg-3 col-md-4 label">NIC</div>
                                                <div class="col-lg-9 col-md-8">
                                                    <input type="text" name="nic" class="form-control w-75" value="<?php echo htmlspecialchars($user['nic']); ?>" required>
                                                </div>
                                            </div>

                                            <!-- Mobile Number -->
                                            <div class="row mt-3">
                                                <div class="col-lg-3 col-md-4 label">Mobile Number</div>
                                                <div class="col-lg-9 col-md-8">
                                                    <input type="text" name="mobile" class="form-control w-75" value="<?php echo htmlspecialchars($user['mobile']); ?>" required>
                                                </div>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="row mt-4">
                                                <div class="col-lg-12 text-center">
                                                    <input type="submit" name="submit" value="Update Profile Data" class="btn btn-primary btn-sm">
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="container">
                                        <form action="update-socialmedia.php" method="POST">
                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">LinkedIn <i class="bi bi-linkedin"></i></div>
                                                <div class="col-lg-9 col-md-8">
                                                    <input type="text" name="linkedin" class="form-control w-75" placeholder="e.g. : https://www.linkedin.com/username" value="<?php echo htmlspecialchars($user['linkedin']); ?>">
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-lg-3 col-md-4 label">Personal Blog <i class="bi bi-globe"></i></div>
                                                <div class="col-lg-9 col-md-8">
                                                    <div class="d-flex">
                                                        <input type="test" name="blog" class="form-control w-75" placeholder="e.g.: https://www.domain.com" value="<?php echo htmlspecialchars($user['blog']); ?>">
                                                    </div>
                                                </div>
                                            </div>                                       

                                            <div class="row mt-3">
                                                <div class="col-lg-3 col-md-4 label">Github <i class="bi bi-github"></i></div>
                                                <div class="col-lg-9 col-md-8">
                                                    <input type="text" name="github" class="form-control w-75" placeholder="e.g. : https://www.githb.io/username" value="<?php echo htmlspecialchars($user['github']); ?>">
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-lg-3 col-md-4 label">Facebook <i class="bi bi-facebook"></i></div>
                                                <div class="col-lg-9 col-md-8">
                                                    <input type="text" name="facebook" class="form-control w-75" placeholder="e.g. : https://www.facebook.com/username" value="<?php echo htmlspecialchars($user['facebook']); ?>">
                                                </div>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="row mt-4">
                                                <div class="col-lg-12 text-center">
                                                    <input type="submit" name="submit" value="Update Social Media" class="btn btn-primary btn-sm">
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>

                                <!-- Change Password Form -->
                                <div class="tab-pane fade pt-2" id="profile-change-password">
                                    <form action="change-password.php" method="POST" class="needs-validation" novalidate>
                                        <div class="row mb-3">
                                            <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <div class="input-group">
                                                    <input type="password" class="form-control" id="myPassword" name="current_password" required>
                                                    <span class="input-group-text" id="inputGroupPrepend">
                                                        <i class="password-toggle-icon1 bx bxs-show" onclick="togglePasswordVisibility('myPassword', 'password-toggle-icon1')"></i>
                                                    </span>
                                                    <div class="invalid-feedback">Please enter your current password.</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <div class="input-group">
                                                    <input type="password" class="form-control" id="newPassword" name="new_password" required>
                                                    <span class="input-group-text" id="inputGroupPrepend">
                                                        <i class="password-toggle-icon2 bx bxs-show" onclick="togglePasswordVisibility('newPassword', 'password-toggle-icon2')"></i>
                                                    </span>
                                                    <div class="invalid-feedback">Please enter your new password.</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="confirmPassword" class="col-md-4 col-lg-3 col-form-label">Confirm New Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <div class="input-group">
                                                    <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required>
                                                    <span class="input-group-text" id="inputGroupPrepend">
                                                        <i class="password-toggle-icon3 bx bxs-show" onclick="togglePasswordVisibility('confirmPassword', 'password-toggle-icon3')"></i>
                                                    </span>
                                                    <div class="invalid-feedback">Please confirm your new password.</div>
                                                </div>
                                                <div style="color:red; font-size:14px;" id="confirmNewPasswordErrorMessage"></div>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <input type="submit" class="btn btn-primary" name="submit" value="Change Password">
                                        </div>
                                    </form>
                                </div>

                            </div> 
                        </div> 
                    </div> 
                </div> 
            </div> 
        </section>
    </main>

    <?php include_once ("../includes/footer.php") ?>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <?php include_once ("../includes/js-links-inc.php") ?>
    <script>
        $(document).ready(function() {
            // On form submit
            $("#signup-form").submit(function(event) {
                event.preventDefault(); // Prevent form submission

                $.ajax({
                    url: "user-profile.php", // Send form data to register.php
                    type: "POST",
                    data: $(this).serialize(), // Serialize the form data
                    dataType: "json", // Expect JSON response
                    success: function(response) {
                        let popupAlert = $("#popup-alert");

                        // Set the message class and text based on the response status
                        if (response.status === "success") {
                            popupAlert.removeClass("alert-error").addClass("alert-success").html(response.message);
                        } else {
                            popupAlert.removeClass("alert-success").addClass("alert-error").html(response.message);
                        }

                        // Show the alert
                        popupAlert.show();

                        // Hide the alert after 10 seconds
                        setTimeout(function() {
                            popupAlert.fadeOut();
                        }, 1000);

                        // If success, redirect after message disappears
                        if (response.status === "success") {
                            setTimeout(function() {
                                window.location.href = "user-profile.php"; // Change this to your target redirect URL
                            }, 1000); // Same 10 seconds delay before redirect
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("AJAX Error: " + xhr.responseText); // Handle AJAX error
                    }
                });
            });
        });
    </script>
    <script>
    $(document).ready(function() {
        $('#profilePicForm').submit(function(event) {
            event.preventDefault();  // Prevent default form submission

            var formData = new FormData(this);  // Create a new FormData object to handle the file upload
            
            $.ajax({
                url: 'update-profile-picture.php',  // The PHP script that will handle the upload
                type: 'POST',
                data: formData,
                contentType: false,  // Let jQuery figure out the content type for the FormData
                processData: false,  // Prevent jQuery from trying to convert the form data
                success: function(response) {
                    // Handle the success response (should return the new profile picture filename)
                    if (response.status === "success") {
                        // Update the profile picture in real time
                        $('#profilePic').attr('src', '../uploads/' + response.newProfilePic);
                        $('#message').html('<div class="alert alert-success">Profile picture updated successfully!</div>');
                    } else {
                        $('#message').html('<div class="alert alert-danger">Error: ' + response.message + '</div>');
                    }
                },
                error: function(xhr, status, error) {
                    $('#message').html('<div class="alert alert-danger">AJAX Error: ' + xhr.responseText + '</div>');
                }
            });
        });
    });
    </script>


</body>
</html>
