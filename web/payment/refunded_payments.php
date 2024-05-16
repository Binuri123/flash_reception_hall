<?php 
include '../customer/header.php';
include '../customer/sidebar.php';
?>
<main id="main">
    <section>
        <div class="pagetitle">
        <h1>Payments</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=WEB_PATH?>customer/dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?=WEB_PATH?>payment/payment.php">Payments</a></li>
                <li class="breadcrumb-item active">Payment History</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped bg-light" style="font-size:13px;">
                        <thead>
                            <tr>
                                <th>Bill No</th>
                                <th>Reservation No</th>
                                <th>Total Amount</th>
                                <th>Payment</th>
                                <th>Paid Amount</th>
                                <th>Paid Date</th>
                                <th>Payment Method</th>
                                <th>Payment Status</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $db = dbConn();
                                $sql = "SELECT p.receipt_no,p.reservation_no,r.discounted_price,pc.payment_category_name,"
                                        . "p.paid_amount,p.paid_date,pm.method_name,ps.status_name FROM customer_payments p "
                                        . "LEFT JOIN reservation r ON r.reservation_no=p.reservation_no "
                                        . "LEFT JOIN payment_category pc ON pc.payment_category_id=p.payment_category_id "
                                        . "LEFT JOIN payment_method pm ON pm.method_id=p.payment_method_id "
                                        . "LEFT JOIN payment_status ps ON ps.payment_status_id=p.payment_status "
                                        . "WHERE p.customer_no=(SELECT customer_no FROM customer WHERE customer_id=".$_SESSION['customer_id'].")";
                                //print_r($sql);
                                $result = $db->query($sql);
                                if($result->num_rows>0){
                                    while($row=$result->fetch_assoc()){
                            ?>
                            <tr style="font-size:13px;vertical-align:middle">
                                <td><?= $row['receipt_no'] ?></td>
                                <td><?= $row['reservation_no'] ?></td>
                                <td><?= $row['discounted_price'] ?></td>
                                <td><?= $row['payment_category_name'] ?></td>
                                <td><?= $row['paid_amount'] ?></td>
                                <td><?= $row['paid_date'] ?></td>
                                <td><?= $row['method_name'] ?></td>
                                <td><?= $row['status_name'] ?></td>
                                <td>
                                    <a href="<?=WEB_PATH?>payment/view.php?receipt_no=<?= $row['receipt_no'] ?>" class="btn btn-info btn-sm" style="text-align:center;vertical-align:middle;margin:0;padding:2px 5px;"><i class="bi bi-eye-fill"></i></a>
                                </td>
                            </tr>
                            <?php
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include('../customer/footer.php') ?>