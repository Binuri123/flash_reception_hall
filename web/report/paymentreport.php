<?php
include '../customer/header.php';
include '../customer/sidebar.php';
?>

<main id="main">
    <section>
        <div class="pagetitle">
            <div class="row">
                <div class="col-md-6">
                    <h1>Payment Report</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>customer/dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>report/report.php">Reports</a></li>
                            <li class="breadcrumb-item active">Payment Report</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div><!-- End Page Title -->
        <?php
        $where = null;
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            extract($_POST);
            if (!empty($minpaiddate) && !empty($maxpaiddate)) {
                $where .= " paid_date BETWEEN '$minpaiddate' AND '$maxpaiddate' AND";
            }
            if (!empty($where)) {
                $where = substr($where, 0, -3);
                $where = "AND $where";
            }
            $userid = $_SESSION['userid'];
            $sql2 = "SELECT SUM(c.paid_amount) AS TotalPaidAmount,c.reservation_no,MAX(c.paid_date) as LastPaymentDate FROM customer_payments c WHERE c.add_user='$userid' AND (payment_status='2' OR payment_status='4') $where GROUP BY c.reservation_no ";
            $db = dbConn();
            $result2 = $db->query($sql2);
        }
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="row mb-3" style="font-size:13px;">
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-2">
                            <label class="form-label">From</label>
                        </div>
                        <div class="col-md-10">
                            <input type="date" class="form-control" placeholder="Date" name="minpaiddate" style="font-size:13px;">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-2">
                            <label class="form-label">To</label>
                        </div>
                        <div class="col-md-10">
                            <input type="date" class="form-control" placeholder="Date" name="maxpaiddate" style="font-size:13px;">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-warning btn-sm" style="font-size:13px;"><i class="bi bi-search"> Search</i></button>
                </div>
            </div>
    </form>
        <div class="row">
            <div class="col-md-6">
                <div class="table-responsive">
                    <table class="table table-striped table-sm" style="font-size:13px;">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Reservation No</th>
                                <th scope="col">Paid Date</th>
                                <th scope="col" style="text-align: right">Paid Amount(Rs.)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                                if ($result2->num_rows > 0) {
                                    $total = 0;
                                    while ($row = $result2->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td></td>
                                            <td><?= $row['reservation_no'] ?></td>
                                            <td><?= $row['LastPaymentDate'] ?></td>
                                            <td style="text-align: right"><?= number_format($row['TotalPaidAmount'], 2) ?></td> 
                                            <?php $total += $row['TotalPaidAmount'] ?>
                                        </tr>
                                        <?php
                                    }
                                }
                            }
                            ?>
                            <tr>
                                <td colspan="3"><h5 class="text-dark">Total Amount (Rs.)</h5></td>
                                <td style="text-align: right"><h5 class="text-dark"><?= number_format(@$total, 2) ?></h5></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>



    </section>

</main>

<?php include '../customer/footer.php'; ?> 