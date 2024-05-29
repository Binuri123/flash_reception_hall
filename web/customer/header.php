<?php
session_start();
if (!isset($_SESSION['userid']) && $_SESSION['user_role_id'] != '7') {
    header("Location:" . WEB_PATH . "customer/login.php");
}
include '../config.php';
include '../function.php';
include '../assets/phpmail/mail.php';
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <title>Dashboard</title>
        <meta content="" name="description">
        <meta content="" name="keywords">

        <!-- Favicons -->
        <link href="<?= WEB_PATH ?>assets/img/flash/logo_with_background.png" rel="icon">
        <link href="<?= WEB_PATH ?>assets/dashboard_assets/img/apple-touch-icon.png" rel="apple-touch-icon">

        <!-- Google Fonts -->
        <link href="https://fonts.gstatic.com" rel="preconnect">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

        <!--Font Awesome-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>

        <!-- Vendor CSS Files -->
        <link href="<?= WEB_PATH ?>assets/dashboard_assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= WEB_PATH ?>assets/dashboard_assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
        <link href="<?= WEB_PATH ?>assets/dashboard_assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
        <link href="<?= WEB_PATH ?>assets/dashboard_assets/vendor/quill/quill.snow.css" rel="stylesheet">
        <link href="<?= WEB_PATH ?>assets/dashboard_assets/vendor/quill/quill.bubble.css" rel="stylesheet">
        <link href="<?= WEB_PATH ?>assets/dashboard_assets/vendor/remixicon/remixicon.css" rel="stylesheet">
        <link href="<?= WEB_PATH ?>assets/dashboard_assets/vendor/simple-datatables/style.css" rel="stylesheet">

        <!--Sweet Alert-->
        <script src="<?= WEB_PATH ?>assets/js/sweetalert2.all.js" type="text/javascript"></script>

        <!-- Template Main CSS File -->
        <link href="<?= WEB_PATH ?>assets/dashboard_assets/css/style.css" rel="stylesheet">

        <!-- Reservation -->
        <link href="<?= WEB_PATH ?>assets/dashboard_assets/css/reservation.css" rel="stylesheet">
        <link href="<?= WEB_PATH ?>assets/dashboard_assets/css/dashboard.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <!-- ======= Header ======= -->
        <header id="header" class="header fixed-top d-flex align-items-center">

            <div class="d-flex align-items-center justify-content-between">
                <a href="dashboard.php" class="logo d-flex align-items-center">
                    <img src="<?= WEB_PATH ?>assets/img/flash/logo_with_background.png" alt="">
                    <span class="d-none d-lg-block">Flash Reception</span>
                </a>
                <i class="bi bi-list toggle-sidebar-btn"></i>
            </div><!-- End Logo -->

            <nav class="header-nav ms-auto">
                <ul class="d-flex align-items-center">
                    <li class="nav-item dropdown pe-3">
                        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                            <div class="circle">
                                <?php
                                $first_name = $_SESSION['first_name'];
                                $first_letter = substr($first_name, 0, 1);
                                $last_name = $_SESSION['last_name'];
                                $last_letter = substr($last_name, 0, 1);
                                ?>
                                <span class="circle-letter"><?= $first_letter . $last_letter ?></span>
                            </div>
                            <span class="d-none d-md-block dropdown-toggle ps-2">My Account</span>
                        </a><!-- End Profile Iamge Icon -->

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                            <li class="dropdown-header">
                                <h6>My Account</h6>
                                <span><?= $_SESSION['title'] . " " . $_SESSION['first_name'] . " " . $_SESSION['last_name'] ?></span>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="<?= WEB_PATH ?>customer/profile.php">
                                    <i class="bi bi-person"></i>
                                    <span>My Profile</span>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="<?= WEB_PATH ?>customer/edit_profile.php">
                                    <i class="bi bi-gear"></i>
                                    <span>Edit Profile</span>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="<?= WEB_PATH ?>customer/change_password.php">
                                    <i class="bi bi-lock"></i>
                                    <span>Change Password</span>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="<?= WEB_PATH ?>customer/logout.php">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Sign Out</span>
                                </a>
                            </li>

                        </ul><!-- End Profile Dropdown Items -->
                    </li><!-- End Profile Nav -->

                </ul>
            </nav><!-- End Icons Navigation -->

        </header><!-- End Header -->