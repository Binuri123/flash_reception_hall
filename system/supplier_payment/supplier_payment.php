<?php
include '../header.php';
include '../menu.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Supplier Payment</li>
            </ol>
        </nav>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <a href="<?= SYSTEM_PATH ?>supplier_payment/pending.php" style="text-decoration:none;color:white">
                    <div class="card bg-warning text-white">
                        <div class="card-body text-center">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT count(*) as received FROM customer_payments WHERE payment_status=1";
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $received = $row['received'];
                            ?>
                            <h4># Pending<br><?= $received ?></h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= SYSTEM_PATH ?>supplier_payment/approved.php" style="text-decoration:none;color:white">
                    <div class="card bg-info text-white">
                        <div class="card-body text-center">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT count(*) as verified FROM customer_payments WHERE payment_status=2";
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $verified = $row['verified'];
                            ?>
                            <h4># Approved<br><?= $verified ?></h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= SYSTEM_PATH ?>supplier_payment/paid.php" style="text-decoration:none;color:white">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT count(*) as unsuccessful FROM customer_payments WHERE payment_status=3";
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $unsuccessful = $row['unsuccessful'];
                            ?>
                            <h4># Paid<br><?= $unsuccessful ?></h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= SYSTEM_PATH ?>supplier_payment/unsucessful.php" style="text-decoration:none;color:white">
                    <div class="card bg-danger text-white">
                        <div class="card-body text-center">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT count(*) as transferred FROM reservation WHERE reservation_status_id=3";
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $transferred = $row['transferred'];
                            ?>
                            <h4># Unsuccessful<br><?= $transferred ?></h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</main>

<?php include '../footer.php'; ?>
