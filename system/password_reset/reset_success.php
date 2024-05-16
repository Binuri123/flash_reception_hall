<?php
session_start();
include '../function.php';
include '../config.php';
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Reset Password-Flash Reception Hall</title>
        <link href="<?= WEB_PATH ?>assets/img/flash/logo_with_background.png" rel="icon">
        <link href="<?= WEB_PATH ?>assets/dashboard_assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="<?= WEB_PATH ?>customer/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
        <link href="<?= WEB_PATH ?>/assets/dashboard_assets/css/login.css" rel="stylesheet">
        <script src="<?= WEB_PATH ?>assets/js/sweetalert2.all.js" type="text/javascript"></script>
    </head>
    <body class="text-center" style="background-color: rgba(0, 0, 0, 0.8);">
        <section class="vh-100 gradient-custom">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-md-4 h-90 mt-3">
                        <div class="card bg-white text-dark h-90" style="border-radius:10px;">
                            <div class="card-body text-center">
                                <h3>Success</h3>
                                <p><strong><i>You Have Successfully Reseted Your Password.You can now log in with the new password</i></strong></p>
                                <div>
                                    <a href="<?= WEB_PATH ?>customer/login.php" class="text-dark-50 btn btn-success">Login</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>