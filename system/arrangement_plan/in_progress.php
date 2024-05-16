<?php
include '../header.php';
include '../menu.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>arrangement_plan/arrangement_plan.php">Arrangement Plans</a></li>
                <li class="breadcrumb-item active" aria-current="page">In Progress</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <h3>In Progress Plan List</h3>
        </div>
        <div class="col-md-2"></div>
    </div>
    <?php
    extract($_POST);
    //var_dump($_POST);
    $where = NULL;
    //echo 'outside';
    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'search') {
        //echo 'inside';
        $customer_no = cleanInput($customer_no);
        $reservation_no = cleanInput($reservation_no);

        if (!empty($customer_no)) {
            //Wild card serach perform using like and %% signs
            $where .= " ap.customer_no LIKE '%$customer_no%' AND";
        }

        if (!empty($reservation_no)) {
            //echo 'inside';
            //Wild card serach perform using like and %% signs
            $where .= " ap.reservation_no LIKE '%$reservation_no%' AND";
        }

        if (!empty($min_date) && !empty($max_date)) {
            $where .= " r.event_date BETWEEN '$min_date' AND '$max_date' AND";
        } elseif (!empty($min_date) && empty($max_date)) {
            $where .= " r.event_date = '$min_date' AND";
        } elseif (empty($min_date) && !empty($max_date)) {
            $where .= " r.event_date = '$max_date' AND";
        }

        if (!empty($where)) {
            $where = substr($where, 0, -3);
            $where = " AND $where";
        }
    }
    ?>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
                <div class="row">
                    <div class="mb-3 col-md-2">
                        <input type="text" class="form-control" placeholder="Customer No" name="customer_no" value="<?= @$customer_no ?>" style="font-size:13px;">
                    </div>
                    <div class="mb-3 col-md-2">
                        <input type="text" class="form-control" placeholder="Reservation No" name="reservation_no" value="<?= @$reservation_no ?>" style="font-size:13px;">
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="date" class="form-control" name="min_date" value="<?= @$min_date ?>" style="font-size:13px;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="date" class="form-control" name="max_date" value="<?= @$max_date ?>" style="font-size:13px;">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" name="action" value="search" class="btn btn-warning btn-sm" style="font-size:13px;width:100px;"><i class="bi bi-search"></i> Search</button>
                        <a href="<?= SYSTEM_PATH ?>arrangement_plan/in_progress.php" class="btn btn-info btn-sm" style="font-size:13px;width:100px;"><i class="bi bi-eraser"></i> Clear</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-1"></div>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="table-responsive">
                <table class="table table-striped table-sm" style="font-size:13px;">
                    <thead class="bg-secondary">
                        <tr>
                            <th>#</th>
                            <th scope="col">Customer No</th>
                            <th scope="col">Reservation No</th>
                            <th scope="col">Event Date</th>
                            <th scope="col">Hall</th>
                            <?php
                            if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '3' || $_SESSION['user_role_id'] == '6' || $_SESSION['user_role_id'] == '9') {
                                ?>
                                <th></th>
                                <th></th>
                                <?php
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM arrangement_plan ap "
                                . "LEFT JOIN reservation r ON r.reservation_no=ap.reservation_no "
                                . "LEFT JOIN hall h ON h.hall_id=r.hall_id "
                                . "WHERE ap.arrangement_status_id = '2' $where";
                        //print_r($sql);
                        $db = dbConn();
                        $result = $db->query($sql);
                        if ($result->num_rows > 0) {
                            $i = 1;
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr style="vertical-align:middle;">
                                    <td><?= $i ?></td>
                                    <td><?= $row['customer_no'] ?></td>
                                    <td><?= $row['reservation_no'] ?></td>
                                    <td><?= $row['event_date'] ?></td>
                                    <td><?= $row['hall_name'] ?></td>
                                    <?php
                                    if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '3' || $_SESSION['user_role_id'] == '6' || $_SESSION['user_role_id'] == '9') {
                                        ?>
                                        <td>
                                            <a href="<?= SYSTEM_PATH ?>arrangement_plan/re_assign.php?arr_plan_id=<?= $row['arrangement_plan_id'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-list-ul"></i></a></td>
                                        </td>
                                        <td><a href="<?= SYSTEM_PATH ?>arrangement_plan/view.php?arr_plan_id=<?= $row['arrangement_plan_id'] ?>" class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i></a></td>
                                        <?php
                                    }
                                    ?>
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
        <div class="col-md-2"></div>
    </div>
</main>

<?php include '../footer.php'; ?>
