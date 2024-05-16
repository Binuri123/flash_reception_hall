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
                <li class="breadcrumb-item active">Pending Payments</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped bg-light" style="font-size:13px;">
                        <thead style="font-size:13px;text-align:center;vertical-align:middle;" class="bg-secondary">
                            <tr style="vertical-align:middle">
                                <th>Reservation No</th>
                                <th>Date</th>
                                <th>Reservation Status</th>
                                <th>Final Amount</th>
<!--                                <th>Reservation<br>Payment Status</th>-->
                                <th>Payment</th>
                                <th>Payment Status</th>
                                <th>Make Payment</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody style="text-align:center;">
                            <?php
                                $db = dbConn();
//                                $sql = "SELECT r.reservation_id,r.reservation_no,r.event_date,r.start_time,r.end_time,"
//                                        . "r.discounted_price,rs.reservation_status,rps.payment_status FROM reservation r "
//                                        . "LEFT JOIN reservation_status rs ON r.reservation_status_id=rs.reservation_status_id "
//                                        . "LEFT JOIN reservation_payment_status rps ON rps.payment_status_id=r.reservation_payment_status_id "
//                                        . "WHERE customer_no=(SELECT customer_no FROM customer "
//                                        . "WHERE customer_id=".$_SESSION['customer_id'].") "
//                                        . "AND (r.reservation_payment_status_id='1' OR r.reservation_payment_status_id='2') "
//                                        . "AND (r.reservation_status_id = '1' OR r.reservation_status_id ='2')";
                                
//                                $sql = "SELECT r.reservation_no,r.event_date,r.start_time,r.end_time,"
//                                        . "r.reservation_status_id,r.discounted_price,r.reservation_payment_status_id,"
//                                        . "cp.payment_status,cp.payment_id FROM reservation r "
//                                        . "LEFT JOIN customer_payments cp ON cp.reservation_no=r.reservation_no "
//                                        . "WHERE cp.customer_no = (SELECT customer_no FROM customer WHERE customer_id=".$_SESSION['customer_id'].") AND (r.reservation_payment_status_id != '3' "
//                                        . "AND r.reservation_payment_status_id != '4' "
//                                        . "AND r.reservation_payment_status_id != '5') "
//                                        . "AND (r.reservation_status_id = '1' "
//                                        . "OR r.reservation_status_id = '2') AND (cp.payment_status = '1' OR cp.payment_status = '3')";
                                
//                                $sql = "SELECT r.reservation_no,r.event_date,r.start_time,r.end_time,"
//                                        . "r.reservation_status_id,r.discounted_price,r.reservation_payment_status_id,"
//                                        . "cp.payment_status,cp.payment_id FROM reservation r "
//                                        . "LEFT JOIN customer_payments cp ON cp.reservation_no=r.reservation_no "
//                                        . "WHERE r.customer_no =(SELECT customer_no FROM customer WHERE customer_id =".$_SESSION['customer_id'].") AND ";
                                $sql = "SELECT r.reservation_no,r.event_date,r.discounted_price,cp.payment_status,ps.status_name,"
                                        . "r.reservation_status_id,rs.reservation_status,"
                                        . "r.reservation_payment_status_id,rps.payment_status FROM reservation r "
                                        . "LEFT JOIN customer_payments cp ON r.reservation_no=cp.reservation_no "
                                        . "LEFT JOIN payment_status ps ON cp.payment_status=ps.payment_status_id "
                                        . "LEFT JOIN reservation_status rs ON r.reservation_status_id=rs.reservation_status_id "
                                        . "LEFT JOIN reservation_payment_status rps ON r.reservation_payment_status_id=rps.payment_status_id "
                                        . "WHERE (r.reservation_no NOT IN (SELECT reservation_no FROM customer_payments WHERE payment_status = '2') "
                                        . "AND (r.reservation_status_id = 1 OR r.reservation_status_id = '2')) "
                                        . "OR (r.reservation_no NOT IN (SELECT reservation_no FROM customer_payments) AND r.reservation_status_id != 3)";
                                
                                print_r($sql);
                                $result = $db->query($sql);
                                if($result->num_rows>0){
                                    while($row=$result->fetch_assoc()){
                                        //var_dump($row);
                            ?>
                            <tr style="font-size:13px;vertical-align:middle">
                                <td><?= $row['reservation_no'] ?></td>
                                <td><?= $row['event_date'] ?></td>
                                <?php
                                $db = dbConn();
                                $sql_res_status = "SELECT reservation_status FROM reservation_status WHERE reservation_status_id=".$row['reservation_status_id'];
                                $result_res_status = $db->query($sql_res_status);
                                $row_res_status = $result_res_status->fetch_assoc();
                                $reservation_status = $row_res_status['reservation_status'];
                                ?>
                                <td><?= $reservation_status ?></td>
                                <td><?= $row['discounted_price'] ?></td>
                                <?php
                                $db = dbConn();
                                $sql_res_pay_status = "SELECT payment_status FROM reservation_payment_status WHERE payment_status_id=".$row['reservation_payment_status_id'];
                                $result_res_pay_status = $db->query($sql_res_pay_status);
                                $row_res_pay_status = $result_res_pay_status->fetch_assoc();
                                $reservation_pay_status = $row_res_pay_status['payment_status'];
                                ?>
                                <?php
                                $db = dbConn();
                                if(!empty($row['payment_id'])){
                                $sql_pay_category = "SELECT payment_category_name FROM payment_category WHERE payment_category_id= (SELECT payment_category_id FROM customer_payments WHERE payment_id=".$row['payment_id'].")";
                                $result_pay_category = $db->query($sql_pay_category);
                                $row_pay_category = $result_pay_category->fetch_assoc();
                                $pay_category = $row_pay_category['payment_category_name'];
                                }else{
                                    $pay_category = 'Not Yet Paid';
                                }
                                ?>
                                <td><?= $pay_category ?></td>
                                <?php
                                $db = dbConn();
                                if(!empty($row['payment_status'])){
                                $sql_pay_status = "SELECT status_name FROM payment_status WHERE payment_status_id=".$row['payment_status'];
                                //print_r($sql_pay_status);
                                $result_pay_status = $db->query($sql_pay_status);
                                $row_pay_status = $result_pay_status->fetch_assoc();
                                $pay_status = $row_pay_status['status_name'];
                                }else{
                                    $pay_status = 'Not Yet Paid';
                                }
                                ?>
                                <td><?= $pay_status ?></td>
                                <td>
                                    <a href="<?=WEB_PATH?>payment/add.php?reservation_no=<?= $row['reservation_no'] ?>" class="btn btn-success btn-sm" style="text-align:center;vertical-align:middle;margin:0;padding:2px 5px;"><i class="bi bi-currency-dollar"></i></a>
                                </td>
                                <td>
                                    <a href="<?=WEB_PATH?>payment/edit.php?reservation_no=<?= $row['reservation_no'] ?>" class="btn btn-warning btn-sm" style="text-align:center;vertical-align:middle;margin:0;padding:2px 5px;"><i class="bi bi-pencil-square"></i></a>
                                </td>
                                <td>
                                    <a href="<?=WEB_PATH?>payment/view.php?reservation_no=<?= $row['reservation_no'] ?>" class="btn btn-info btn-sm" style="text-align:center;vertical-align:middle;margin:0;padding:2px 5px;"><i class="bi bi-eye-fill"></i></a>
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