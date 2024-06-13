<?php
include '../header.php';
include '../menu.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>customer_payment/customer_payment.php">Customer Payment</a></li>
                <li class="breadcrumb-item active" aria-current="page">Received</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <h3>Verified Payments List</h3>
        </div>
        <div class="col-md-1"></div>
    </div>

    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="table-responsive">
                <table class="table table-striped table-sm" style="font-size:13px;">
                    <thead class="bg-secondary">
                        <tr>
                            <th>#</th>
                            <th scope="col">Receipt No</th>
                            <th scope="col">Reservation NO</th>
                            <th scope="col">Customer No</th>
                            <th scope="col">Paid Date</th>
                            <th scope="col">Paid Amount</th>
                            <th scope="col">Pay Slip</th>
                            <th scope="col">Verified Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM customer_payments cp WHERE cp.payment_status = '2' "
                                . "OR cp.payment_status = '4'";
                        //print_r($sql);
                        $db = dbConn();
                        $result = $db->query($sql);
                        if ($result->num_rows > 0) {
                            $i = 1;
                            while ($row = $result->fetch_assoc()) {
                                ?>
                        <tr style="vertical-align:middle;">
                                    <td><?= $i ?></td>
                                    <td><?= $row['receipt_no'] ?></td>
                                    <td><?= $row['reservation_no'] ?></td>
                                    <td><?= $row['customer_no'] ?></td>
                                    <td><?= $row['paid_date'] ?></td>
                                    <td><?= $row['paid_amount'] ?></td>
                                    <td>
                                        <img src="../../web/assets/img/pay_slip/customer/<?= $row['pay_slip'] ?>" style="width:60px;height:60px;">
                                    </td>
                                    <td><?= $row['verified_date'] ?></td>
                                    <td><a href="<?=SYSTEM_PATH?>customer_payment/view.php?payment_id=<?= $row['payment_id'] ?>" class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i></a></td>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
</main>

<?php include '../footer.php'; ?>
