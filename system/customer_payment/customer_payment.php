<?php
include '../header.php';
include '../menu.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="mt-3 pagetitle">
        <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
            <h1 class="h4 m-0">Customer Payments</h1>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Customer Payment</li>
            </ol>
        </nav>
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <a href="<?= SYSTEM_PATH ?>customer_payment/pending.php" style="text-decoration:none;color:white">
                    <div class="card bg-primary text-primary" style="--bs-bg-opacity: .1;">
                        <div class="card-body text-center">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT count(*) as pending FROM reservation r LEFT JOIN customer_payments p ON p.reservation_no=r.reservation_no "
                                    . "where ((r.reservation_status_id = '1' AND r.reservation_payment_status_id = '1') "
                                    . "OR (r.reservation_status_id = '1' AND r.reservation_payment_status_id = '1' AND p.payment_status = '1') "
                                    . "OR (r.reservation_status_id = '1' AND r.reservation_payment_status_id = '1' AND p.payment_status = '3') "
                                    . "OR (r.reservation_status_id = '2' AND r.reservation_payment_status_id = '6' AND p.payment_status = '2') "
                                    . "OR (r.reservation_status_id = '2' AND r.reservation_payment_status_id = '6' AND p.payment_status = '1') "
                                    . "OR (r.reservation_status_id = '2' AND r.reservation_payment_status_id = '6' AND p.payment_status = '3') "
                                    . "OR (r.reservation_status_id = '2' AND r.reservation_payment_status_id = '2' AND p.payment_status = '2') "
                                    . "OR (r.reservation_status_id = '2' AND r.reservation_payment_status_id = '2' AND p.payment_status = '1') "
                                    . "OR (r.reservation_status_id = '2' AND r.reservation_payment_status_id = '2' AND p.payment_status = '3') "
                                    . "OR (r.reservation_status_id = '2' AND r.reservation_payment_status_id = '6' AND p.payment_status = '1') "
                                    . "OR (r.reservation_status_id = '2' AND r.reservation_payment_status_id = '6' AND p.payment_status = '3'))";
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $pending = $row['pending'];
                            ?>
                            <h4># Pending<br><?= $pending ?></h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="<?= SYSTEM_PATH ?>customer_payment/received.php" style="text-decoration:none;color:white">
                    <div class="card bg-warning text-warning" style="--bs-bg-opacity: .1;">
                        <div class="card-body text-center">
                            <?php
                            $db = dbConn();
                            if ($_SESSION['user_role_id'] == '2') {
                                $sql = "SELECT count(*) as received FROM customer_payments WHERE payment_status='1'";
                            } elseif ($_SESSION['user_role_id'] == '4') {
                                $sql = "SELECT count(*) as received FROM customer_payments WHERE payment_status='1' AND payment_method_id !='1'";
                            }elseif ($_SESSION['user_role_id'] == '1'){
                                $sql = "SELECT count(*) as received FROM customer_payments WHERE payment_status='1'";
                            }
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $received = $row['received'];
                            ?>
                            <h4># Received<br><?= $received ?></h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="<?= SYSTEM_PATH ?>customer_payment/verified.php" style="text-decoration:none;color:white">
                    <div class="card bg-success text-success" style="--bs-bg-opacity: .1;">
                        <div class="card-body text-center">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT count(*) as verified FROM customer_payments WHERE payment_status='2' OR payment_status='4'";
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $verified = $row['verified'];
                            ?>
                            <h4># Verified<br><?= $verified ?></h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="<?= SYSTEM_PATH ?>customer_payment/unsuccessful.php" style="text-decoration:none;color:white">
                    <div class="card bg-danger text-danger" style="--bs-bg-opacity: .1;">
                        <div class="card-body text-center">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT count(*) as unsuccessful FROM customer_payments WHERE payment_status=3";
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $unsuccessful = $row['unsuccessful'];
                            ?>
                            <h4># Unsuccessful<br><?= $unsuccessful ?></h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</main>
<?php include '../footer.php'; ?>
