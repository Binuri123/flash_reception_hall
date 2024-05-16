<?php
include '../customer/header.php';
include '../customer/sidebar.php';
?>
<main id="main">
    <section>
        <div class="pagetitle">
            <div class="row">
                <div class="col-md-6">
                    <h1>Refunds</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>customer/dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Refunds</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6" style="text-align:right">
                    <a href="<?=WEB_PATH?>reservation/canceled_reservations.php" class="btn btn-info-light btn-outline-success btn-sm" style="font-size:13px;"><i class="bi bi-plus-circle"></i> Refund Request</a>
                </div>
            </div>
        </div><!-- End Page Title -->
        <div class="row">
            <div class="col-md-3 mt-3 mb-3">
                <a href="<?= WEB_PATH ?>refund/refunded.php">
                    <div class="card bg-success text-white">
                        <div class="card-body mt-4" style="text-align:center;vertical-align:middle">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT COUNT(*) as refunded FROM refund_request "
                                    . "WHERE customer_no =(SELECT customer_no FROM customer "
                                    . "WHERE customer_id=" . $_SESSION['customer_id'] . ") "
                                    . "AND refund_status_id = '5'";
                            //print_r($sql);
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $refunded = $row['refunded']
                            ?>
                            <h5># Refunded<br><?= @$refunded ?></h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 mt-3 mb-3">
                <a href="<?= WEB_PATH ?>refund/refund_requests.php">
                    <div class="card bg-secondary text-white">
                        <div class="card-body mt-4" style="text-align:center;vertical-align:middle">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT COUNT(*) as refund_requests FROM refund_request "
                                    . "WHERE customer_no =(SELECT customer_no FROM customer "
                                    . "WHERE customer_id=" . $_SESSION['customer_id'] . ") "
                                    . "AND refund_status_id = '2'";
                            //print_r($sql);
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $refund_requests = $row['refund_requests']
                            ?>
                            <h5># Requests<br><?= @$refund_requests ?></h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 mt-3 mb-3">
                <a href="<?= WEB_PATH ?>refund/refund_pending.php">
                    <div class="card bg-warning text-white">
                        <div class="card-body mt-4" style="text-align:center;vertical-align:middle">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT COUNT(*) as refund_pending FROM refund_request "
                                    . "WHERE customer_no =(SELECT customer_no FROM customer "
                                    . "WHERE customer_id=" . $_SESSION['customer_id'] . ") "
                                    . "AND refund_status_id = '3'";
                            //print_r($sql);
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $refund_pending = $row['refund_pending']
                            ?>
                            <h5># Pending<br><?= @$refund_pending ?></h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 mt-3 mb-3">
                <a href="<?= WEB_PATH ?>refund/refund_approved.php">
                    <div class="card bg-info text-white">
                        <div class="card-body mt-4" style="text-align:center;vertical-align:middle">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT COUNT(*) as refund_approved FROM refund_request "
                                    . "WHERE customer_no =(SELECT customer_no FROM customer "
                                    . "WHERE customer_id=" . $_SESSION['customer_id'] . ") "
                                    . "AND refund_status_id = '4'";
                            //print_r($sql);
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $refund_approved = $row['refund_approved']
                            ?>
                            <h5># Approved<br><?= @$refund_approved ?></h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>
</main>
<?php include('../customer/footer.php') ?>