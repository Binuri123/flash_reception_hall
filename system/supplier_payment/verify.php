<?php
ob_start();
include '../header.php';
include '../menu.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Received Payments</li>
            </ol>
        </nav>
    </div>
    <div class="row table-responsive">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <table class="table table-warning table-striped">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Reservation</th>
                        <th>Paid Date</th>
                        <th>Paid Amount</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $db = dbConn();
                    $sql = "SELECT * FROM customer_payments WHERE payment_status=2";
                    $result = $db->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?= $row['customer_no'] ?></td>
                                <td><?= $row['reservation_no'] ?></td>
                                <td><?= $row['add_date'] ?></td>
                                <td><?= $row['paid_amount'] ?></td>
                                <td><a href="<?= SYSTEM_PATH ?>customer_payment/view.php?payment_id=<?= $row['payment_id']?>" class="btn btn-info btn-sm"><span data-feather="eye" class="align-text-bottom"></span></a></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-1"></div>
    </div>
</main>
<?php
include '../footer.php';
ob_end_flush()
?>