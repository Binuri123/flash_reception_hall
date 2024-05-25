<?php
include 'config.php';
include 'function.php';
include 'assets/phpmail/mail.php';
date_default_timezone_set('Asia/Colombo');
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <title>Flash Reception Hall</title>
        <meta content="" name="description">
        <meta content="" name="keywords">

        <!-- Check Availability Modal -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Favicons -->
        <link href="<?= WEB_PATH ?>assets/img/flash/logo_with_background.png" rel="icon">
        <link href="<?= WEB_PATH ?>assets/img/apple-touch-icon.png" rel="apple-touch-icon">

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Amatic+SC:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

        <!-- Vendor CSS Files -->
        <link href="<?= WEB_PATH ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= WEB_PATH ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
        <link href="<?= WEB_PATH ?>assets/vendor/aos/aos.css" rel="stylesheet">
        <link href="<?= WEB_PATH ?>assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
        <link href="<?= WEB_PATH ?>assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

        <!-- Template Main CSS File -->
        <link href="<?= WEB_PATH ?>assets/css/main.css" rel="stylesheet">
    </head>
    <body>
        <!-- ======= Header ======= -->
        <header id="header" class="header fixed-top d-flex align-items-center">
            <div class="container d-flex align-items-center justify-content-between">
                <a href="<?= WEB_PATH ?>index.php" class="logo d-flex align-items-center me-auto me-lg-0">
                    <!-- Uncomment the line below if you also wish to use an image logo -->
                    <img src="<?= WEB_PATH ?>assets/img/flash/logo_with_background.png" alt="" height="150">
                    <h1>Flash</h1>
                </a>
                <nav id="navbar" class="navbar">
                    <ul>
                        <li><a href="<?= WEB_PATH ?>index.php">Home</a></li>
                        <li><a href="<?= WEB_PATH ?>index.php?#about">About</a></li>
                        <li><a href="<?= WEB_PATH ?>index.php?#why-us">Why Us</a></li>
                        <li><a href="<?= WEB_PATH ?>index.php?#gallery">Gallery</a></li>
                        <li class="dropdown"><a href="#"><span>Facilities</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                            <ul>
                                <li><a href="<?= WEB_PATH ?>hall/hall.php">Halls</a></li>
                                <li><a href="<?= WEB_PATH ?>menu_package/menu_package.php">Menu Packages</a></li>
                                <li><a href="<?= WEB_PATH ?>service/service.php">Services</a></li>
                                <li><a href="<?= WEB_PATH ?>package/package.php">Packages</a></li>
                            </ul>
                        </li>
                        <li><a href="<?= WEB_PATH ?>index.php?#contact">Contact</a></li>
                        <li><a href="<?= WEB_PATH ?>review/add.php">Reviews</a></li>
                    </ul>
                </nav><!-- .navbar -->
                <div>
                    <?php
                    $reg_customer_url = $_SERVER['REQUEST_URI'];
                    if (strpos($_SERVER['REQUEST_URI'], '/customer/register_customer.php') != FALSE OR strpos($_SERVER['REQUEST_URI'], 'customer/register_success.php') != FALSE) {
                        ?>

                        <a class="btn btn-danger btn-sm" style="width:100px;font-size:14px;" href="<?= WEB_PATH ?>customer/login.php"><strong>Login</strong></a>
                        <a class="btn btn-dark btn-sm" style="width:150px;font-size:13px;" href="<?= WEB_PATH ?>check_availability/availability_check.php"><strong>Check Availability</strong></a>
                        <?php
                    } else {
                        ?>
                        <a class="btn btn-dark btn-sm" style="width:100px;font-size:14px;" href="<?= WEB_PATH ?>customer/register_customer.php">Register</a>
                        <a class="btn btn-dark btn-sm" style="width:100px;font-size:14px;" href="<?= WEB_PATH ?>customer/login.php">Login</a>
                        <div>
                            <?php
                        }
                        ?>
                        <div>
                            <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
                            <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
                        </div>
                        </header><!-- End Header -->