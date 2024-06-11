<?php 
include '../header.php';
include '../menu.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="mt-3 pagetitle">
        <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
            <h1 class="h4 m-0">Confirmed Reservations</h1>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>reservation/reservation.php">Reservations</a></li>
                <li class="breadcrumb-item active" aria-current="page">Confirmed</li>
            </ol>
        </nav>
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
        $min_date = cleanInput($min_date);
        $max_date = cleanInput($max_date);
        $min_price = cleanInput($min_price);
        $max_price = cleanInput($max_price);

        if (!empty($customer_no)) {
            //Wild card serach perform using like and %% signs
            $where .= " r.customer_no LIKE '%$customer_no%' AND";
        }
        
        if (!empty($reservation_no)) {
            //Wild card serach perform using like and %% signs
            $where .= " r.reservation_no LIKE '%$reservation_no%' AND";
        }
        
        if (!empty($min_date) && !empty($max_date)) {
            $where .= " r.event_date BETWEEN '$min_date' AND '$max_date' AND";
        }elseif(!empty($min_date) && empty($max_date)){
            $where .= " r.event_date = '$min_date' AND";
        }elseif(empty($min_date) && !empty($max_date)){
            $where .= " r.event_date = '$max_date' AND";
        }
        
        if (!empty($min_price) && !empty($max_price)) {
            $where .= " r.discounted_price BETWEEN '$min_price' AND '$max_price' AND";
        }elseif(!empty($min_price) && empty($max_price)){
            $where .= " r.discounted_price >= '$min_price' AND";
        }elseif(empty($min_price) && !empty($max_price)){
            $where .= " r.discounted_price <= '$max_price' AND";
        }
        
        if (!empty($where)) {
            $where = substr($where, 0, -3);
            $where = " AND $where";
        }
    }
    ?>
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
                <div class="row mb-3 align-items-end">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Customer No" name="customer_no" value="<?= @$customer_no ?>" style="font-size:13px;font-style:italic;">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Reservation No" name="reservation_no" value="<?= @$reservation_no ?>" style="font-size:13px;font-style:italic;">
                    </div>
                    <div class="col">
                        <input type="date" class="form-control" name="min_date" value="<?= @$min_date ?>" style="font-size:13px;font-style:italic;">
                    </div>
                    <div class="col">
                        <input type="date" class="form-control" name="max_date" value="<?= @$max_date ?>" style="font-size:13px;font-style:italic;">
                    </div>
                </div>
                <div class="row mb-3 align-items-end">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Min Price" name="min_price" value="<?= @$min_price ?>" style="font-size:13px;font-style:italic;">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Max Price" name="max_price" value="<?= @$max_price ?>" style="font-size:13px;font-style:italic;">
                    </div>
                    <div class="col d-flex">
                        <button type="submit" name="action" value="search" class="btn btn-warning btn-sm flex-grow-1" style="font-size:13px;font-style:italic;"><i class="bi bi-search"></i> Search</button>
                        <a href="<?= $_SERVER['PHP_SELF']?>" class="btn btn-info btn-sm flex-grow-1 ms-2" style="font-size:13px;font-style:italic;"><i class="bi bi-eraser"></i> Clear</a>
                    </div>
                    <div class="col"></div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table modified table-striped table-sm" style="font-size:13px;">
                    <thead class="bg-secondary text-white" style="font-size:13px;text-align:center;vertical-align:middle;">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Customer No</th>
                            <th scope="col">Reservation No</th>
                            <th scope="col">Event Date</th>
                            <th scope="col">Event Time</th>
                            <th scope="col">Event</th>
                            <th scope="col">Reservation Price(Rs.)</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM reservation r LEFT JOIN event e ON e.event_id=r.event_id "
                                . " WHERE r.reservation_status_id = '2' $where ORDER BY r.add_date DESC";
                        //print_r($sql);
                        $db = dbConn();
                        $result = $db->query($sql);
                        if ($result->num_rows > 0) {
                            $i = 1;
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $row['customer_no'] ?></td>
                                    <td><?= $row['reservation_no'] ?></td>
                                    <td><?= $row['event_date'] ?></td>
                                    <td><?= $row['start_time'] . " - " . $row['end_time'] ?></td>
                                    <td><?= $row['event_name'] ?></td>
                                    <td><?= number_format($row['discounted_price'],'2','.',',') ?></td>
                                    <td style="text-align:center;"><a href="<?= SYSTEM_PATH ?>reservation/view.php?reservation_no=<?= $row['reservation_no'] ?>" class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i></a></td>
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
    </div>
</main>

<?php include '../footer.php'; ?>
