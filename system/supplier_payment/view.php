<?php
include '../header.php';
include '../menu.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>customer_payments/verify.php">Received Payments</a></li>
                <li class="breadcrumb-item active" aria-current="page">View Payment</li>
            </ol>
        </nav>
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        extract($_GET);
        $payment_id = $_GET['payment_id'];
        $db = dbConn();
        $sql = "SELECT * FROM customer_payments WHERE payment_id='$payment_id'";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        //var_dump($row);
        ?>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3" id="pay_slip">
                                <a href="../../web/assets/img/pay_slip/customer/<?= $row['pay_slip'] ?>"><img src="../../web/assets/img/pay_slip/customer/<?= $row['pay_slip'] ?>" width="200" height="200"></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
        <?php
    }
    ?>
</main>
<?php
include '../footer.php';
?>