<?php
include 'header.php';
include 'sidebar.php';
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>customer/dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card text-dark bg-light" style="font-size:13px;">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h1 class="h4">My Profile</h1>
                            </div>
                            <div class="col-md-6" style="text-align:right;">
                                <a href="<?= WEB_PATH ?>customer/edit_profile.php" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        $db = dbConn();
                        $sql = "SELECT * FROM customer c LEFT JOIN customer_titles ct ON c.title_id=ct.title_id LEFT JOIN district d ON c.district_id=d.district_id WHERE user_id=" . $_SESSION['userid'];
                        $result = $db->query($sql);
                        $row = $result->fetch_assoc();
                        ?>
                        <div class="row">
                            <div class="col-md-4 mt-3">
                                <label class="form-label"><strong>Title</strong></label>
                            </div>
                            <div class="col-md-8 mt-3">
                                <p><?= $row['title_name'] ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label"><strong>Full Name</strong></label>
                            </div>
                            <div class="col-md-8">
                                <p><?= $row['first_name'] . " " . $row['last_name'] ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label"><strong>Address</strong></label>
                            </div>
                            <div class="col-md-8">
                                <p><?= $row['house_no'] . ", " . $row['street'] . ", " . $row['city'] . ", " . $row['district_name'] ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label"><strong>Mobile Number</strong></label>
                            </div>
                            <div class="col-md-8">
                                <p><?= $row['contact_number'] ?></p>
                            </div>
                        </div>
                        <?php
                        if (!empty($row['alternate_number'])) {
                            ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label"><strong>Land Number</strong></label>
                                </div>
                                <div class="col-md-8">
                                    <p><?= $row['alternate_number'] ?></p>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label"><strong>Email</strong></label>
                            </div>
                            <div class="col-md-8">
                                <p><?= $row['email'] ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label"><strong>NIC</strong></label>
                            </div>
                            <div class="col-md-8">
                                <p><?= $row['nic'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </section>
</main>
<?php
include 'footer.php';
?>