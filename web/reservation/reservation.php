<?php
include '../customer/header.php';
include '../customer/sidebar.php';
?>
<main id="main">
    <section>
        <div class="pagetitle">
            <div class="row">
                <div class="col-md-6">
                    <h1>Reservation</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>customer/dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Reservation</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6" style="text-align:right">
                    <a href="<?=WEB_PATH?>customer/dashboard.php" class="btn btn-info-light btn-outline-success btn-sm" style="font-size:13px;"><i class="bi bi-plus-circle"></i> Make Reservation</a>
                </div>
            </div>
        </div><!-- End Page Title -->
        <div class="row">
            <div class="col-md-3 mt-3 mb-3">
                <a href="<?= WEB_PATH ?>reservation/reservation_history.php">
                    <div class="card bg-secondary text-white">
                        <div class="card-body mt-4" style="text-align:center;vertical-align:middle">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT COUNT(*) as total_reservations FROM reservation WHERE customer_no =(SELECT customer_no FROM customer WHERE customer_id=" . $_SESSION['customer_id'] . ")";
                            //print_r($sql);
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $total_reservations = $row['total_reservations']
                            ?>
                            <h5># Total Reservations<br><?= @$total_reservations ?></h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 mt-3 mb-3">
                <a href="<?= WEB_PATH ?>reservation/pending_reservations.php">
                    <div class="card bg-warning text-white">
                        <div class="card-body mt-4" style="text-align:center;vertical-align:middle">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT COUNT(*) as pending_reservations FROM reservation WHERE customer_no =(SELECT customer_no FROM customer WHERE customer_id=" . $_SESSION['customer_id'] . ") AND reservation_status_id= 1";
                            //print_r($sql);
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $pending_reservations = $row['pending_reservations']
                            ?>
                            <h5># Pending<br><?= @$pending_reservations ?></h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 mt-3 mb-3">
                <a href="<?= WEB_PATH ?>reservation/confirmed_reservations.php">
                    <div class="card bg-info text-white">
                        <div class="card-body mt-4" style="text-align:center;vertical-align:middle">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT COUNT(*) as confirmed_reservations FROM reservation WHERE customer_no =(SELECT customer_no FROM customer WHERE customer_id=" . $_SESSION['customer_id'] . ") AND reservation_status_id= 2";
                            //print_r($sql);
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $confirmed_reservations = $row['confirmed_reservations']
                            ?>
                            <h5># Confirmed<br><?= @$confirmed_reservations ?></h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 mt-3 mb-3">
                <a href="<?= WEB_PATH ?>reservation/canceled_reservations.php">
                    <div class="card bg-danger text-white">
                        <div class="card-body mt-4" style="text-align:center;vertical-align:middle">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT COUNT(*) as canceled_reservations FROM reservation WHERE customer_no =(SELECT customer_no FROM customer WHERE customer_id=" . $_SESSION['customer_id'] . ") AND reservation_status_id= 3";
                            //print_r($sql);
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $canceled_reservations = $row['canceled_reservations']
                            ?>
                            <h5># Canceled<br><?= @$canceled_reservations ?></h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 mt-3 mb-3">
                <a href="<?= WEB_PATH ?>reservation/completed_reservations.php">
                    <div class="card bg-success text-white">
                        <div class="card-body mt-4" style="text-align:center;vertical-align:middle">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT COUNT(*) as completed_reservations FROM reservation WHERE customer_no =(SELECT customer_no FROM customer WHERE customer_id=" . $_SESSION['customer_id'] . ") AND reservation_status_id= 5";
                            //print_r($sql);
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $completed_reservations = $row['completed_reservations']
                            ?>
                            <h5># Completed<br><?= @$completed_reservations ?></h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 mt-3 mb-3">
                <a href="<?= WEB_PATH ?>reservation/refunded_reservations.php">
                    <div class="card bg-primary text-white">
                        <div class="card-body mt-4" style="text-align:center;vertical-align:middle">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT COUNT(*) as refunded_reservations FROM reservation WHERE customer_no =(SELECT customer_no FROM customer WHERE customer_id=" . $_SESSION['customer_id'] . ") AND reservation_status_id='3' AND reservation_payment_status_id = '4'";
                            //print_r($sql);
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $refunded_reservations = $row['refunded_reservations']
                            ?>
                            <h5># Refunded<br><?= @$refunded_reservations ?></h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 mt-3 mb-3">
                <a href="<?= WEB_PATH ?>reservation/rejected_reservations.php">
                    <div class="card bg-light text-dark">
                        <div class="card-body mt-4" style="text-align:center;vertical-align:middle">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT COUNT(*) as rejected_reservations FROM reservation WHERE customer_no =(SELECT customer_no FROM customer WHERE customer_id=" . $_SESSION['customer_id'] . ") AND reservation_status_id='4' AND reservation_payment_status_id = '7'";
                            //print_r($sql);
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $rejected_reservations = $row['rejected_reservations']
                            ?>
                            <h5># Rejected<br><?= @$rejected_reservations ?></h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>
</main>
<?php 
    include('../customer/footer.php') 
?>