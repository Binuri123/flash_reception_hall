<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>reports/reportmenu.php">Reports</a></li>
                <li class="breadcrumb-item active" aria-current="page">Income Report</li>
            </ol>
        </nav>
    </div>
    <?php
    extract($_POST);
    $total = 0;
    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "save") {
        $message = array();
        if (empty($reporttype)) {
            if (empty($startdate)) {
                $message['error_startdate'] = "Start Date should be selected..!";
            } elseif (empty($enddate)) {
                $message['error_enddate'] = "End Date should be selected..!";
            }
        } else {
            if ($reporttype == 1) {
                if (empty($startdate)) {
                    $message['error_startdate'] = "Start Date should be selected..!";
                }
            }
            if ($reporttype == 2) {
                if (empty($startdate)) {
                    $message['error_startdate'] = "Start Date should be selected..!";
                } elseif (empty($enddate)) {
                    $message['error_enddate'] = "End Date should be selected..!";
                }
            }
            if ($reporttype == 3) {
                if (empty($month)) {
                    $message['error_month'] = "Month should be selected..!";
                }
            }
            if ($reporttype == 4) {
                if (empty($year)) {
                    $message['error_year'] = "Year should be selected..!";
                }
            }
        }
        if (empty($message)) {
            $where = null;
            if (empty($reporttype)) {
                if (!empty($startdate) && !empty($enddate)) {
                    $where .= "AND paid_date BETWEEN '$startdate ' AND '$enddate' ";
                }
            } else {
                if ($reporttype == 1) {
                    $where .= "AND paid_date = '$startdate ' ";
                }
                if ($reporttype == 2) {
                    $where .= "AND paid_date BETWEEN '$startdate ' AND '$enddate' ";
                }
                if ($reporttype == 3) {
                    if (!empty($month)) {
                        $where .= "AND paid_date LIKE '%$month%' ";
                    }
                }
                if ($reporttype == 4) {
                    $where .= "AND YEAR(c.paid_date) = '$year' ";
                }
            }
            $db = dbConn();
            $sql2 = "SELECT c.reservation_no,c.paid_amount,c.paid_date FROM customer_payments c WHERE c.payment_status=2 $where";
            $result2 = $db->query($sql2);
        }
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
        <div class="row mb-3">
            <div class="col-md-3">
                <?php
                $db = dbConn();
                $sql = "SELECT * FROM reporttype";
                $result = $db->query($sql);
                ?>
                <select class="form-select" id="reporttype" name="reporttype" onchange="form.submit()" style="font-size:13px;">
                    <option value="">Select Report Type</option>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <option value=<?= $row['ReportTypeId']; ?> <?php if ($row['ReportTypeId'] == @$reporttype) { ?>selected <?php } ?>><?= $row['ReportTypeName'] ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
                <div class="text-danger"><?= @$message['error_reporttype'] ?></div>
            </div>
            <?php
            if (!empty($reporttype)) {
                if ($reporttype == 1) {
                    $mindate = date('2017-01-01');
                    $maxdate = date('Y-m-d')
                    ?>
                    <div class="col-md-3">
                        <input type="date" min="<?= $mindate ?>" max="<?= $maxdate ?>" class="form-control" placeholder="Start Date" name="startdate" value="<?= @$startdate ?>" style="font-size:13px;">
                        <div class="text-danger"><?= @$message['error_startdate'] ?></div>  
                    </div>
                    <?php
                } elseif ($reporttype == 2) {
                    $mindate = date('2017-01-01');
                    $maxdate = date('Y-m-d')
                    ?>
                    <div class="col-md-3">
                        <input type="date" min="<?= $mindate ?>" max="<?= $maxdate ?>" class="form-control" placeholder="Start Date" name="startdate" value="<?= @$startdate ?>" onchange="form.submit()" style="font-size:13px;">
                        <div class="text-danger"><?= @$message['error_startdate'] ?></div>  
                    </div>
                    <div class="col-md-3">
                        <?php
                        if (!empty($startdate)) {
                            $maxdate = date('Y-m-d', strtotime($startdate . ' +7 days'));
                        }
                        ?>
                        <input style="font-size:13px;" type="date" min="<?= $maxdate ?>" max="<?= $maxdate ?>" class="form-control" placeholder="End Date" name="enddate" value="<?= @$enddate ?>">
                        <div class="text-danger"><?= @$message['error_enddate'] ?></div>  
                    </div>
                    <?php
                } elseif ($reporttype == 3) {
                    ?>
                    <div class="col-md-3">
                        <input style="font-size:13px;" type="month" class="form-control" placeholder="Month" name="month" value="<?= @$month ?>">
                        <div class="text-danger"><?= @$message['error_month'] ?></div>  
                    </div>
                    <?php
                } elseif ($reporttype == 4) {
                    ?>
                    <div class="col-md-3">
                        <?php
                        $db = dbConn();
                        $sql = "SELECT * FROM tbl_year";
                        $result = $db->query($sql);
                        ?>
                        <select class="form-select" id="year" name="year" style="font-size:13px;">
                            <option value="">Select Year</optizson>

                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>

                                    <option value=<?= $row['Year']; ?> <?php if ($row['Year'] == @$year) { ?>selected <?php } ?>><?= $row['Year'] ?></option>

                                    <?php
                                }
                            }
                            ?>
                        </select> 
                        <div class="text-danger"><?= @$message['error_year'] ?></div>
                    </div>
                    <?php
                }
            } else {
                $mindate = date('2017-01-01');
                $maxdate = date('Y-m-d')
                ?>
                <div class="col-md-3">
                    <input style="font-size:13px;" type="date" min="<?= $mindate ?>" max="<?= $maxdate ?>" class="form-control" placeholder="Start Date" name="startdate" value="<?= @$startdate ?>" onchange="form.submit()">
                    <div class="text-danger"><?= @$message['error_startdate'] ?></div>  
                </div>
                <div class="col-md-3">
                    <input type="date" min="<?= $mindate ?>" max="<?= $maxdate ?>" class="form-control" placeholder="End Date" name="enddate" value="<?= @$enddate ?>">
                    <div class="text-danger"><?= @$message['error_enddate'] ?></div>  
                </div>
                <?php
            }
            ?>
            <div class="col">
                <button type="submit" class="btn btn-warning btn-sm" style="width:100px;font-size:13px;" name="action" value="save">Generate</button>
            </div>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-striped table-sm" style="font-size:13px;">
            <thead class="bg-secondary text-white">
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Reservation No</th>
                    <th scope="col">Paid Date</th>
                    <th scope="col" style="text-align:right;">Paid Amount(Rs.)</th>
                    <th scope="col" style="text-align:right;">Total Income(Rs.)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "save" && empty($message)) {
                    if ($result2->num_rows > 0) {
                        while ($row = $result2->fetch_assoc()) {
                            ?>
                            <tr>
                                <td></td>
                                <td><?= $row['reservation_no'] ?></td>
                                <td><?= $row['paid_date'] ?></td>
                                <td style="text-align:right;"><?= number_format($row['paid_amount'], 2) ?></td>
                                <td style="text-align:right;"><?= number_format($total+=$row['paid_amount'], '2') ?> </td>
                            </tr>
                            <?php
                        }
                    }
                }
                ?>
                <tr>
                    <td colspan="4"><h5 class="text-dark">Total (Rs.)</h5></td>
                    <td style="text-align:right;" colspan="4"><h5 class="text-dark"><?= number_format($total, '2') ?></h5></td>
                </tr>
            </tbody>
        </table>
    </div>
</main>
<?php include '../footer.php'; ?> 