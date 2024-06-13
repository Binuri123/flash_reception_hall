<?php
include '../header.php';
include '../menu.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="mt-3 pagetitle">
        <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
            <h1 class="h4 m-0">Cancel Reservation</h1>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>reservation/reservation.php">Reservations</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>reservation/past_due_reservation.php">Past Due</a></li>
                <li class="breadcrumb-item active" aria-current="page">Cancel Reservation</li>
            </ol>
        </nav>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                    extract($_GET);
                    $db = dbConn();
                    $sql = "SELECT * FROM reservation WHERE reservation_no = '$reservation_no'";
                    $result = $db->query($sql);
                    $row = $result->fetch_assoc();
                }
                ?>
                <div class="card bg-light">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5 mt-3 mb-3" style="text-align:center;">
                                <div class="table-responsive">
                                    <table class="table table-striped table-light table-bordered" style="font-size:13px;">
                                        <thead>
                                            <tr>
                                                <th colspan="2">Reservation Details</th>
                                            </tr>
                                        </thead>
                                        <tbody style="text-align:left;">
                                            <tr>
                                                <td>Reservation No</td>
                                                <td><?= $row['reservation_no'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Event</td>
                                                <?php
                                                $sql_event = "SELECT event_name FROM event WHERE event_id=" . $row['event_id'];
                                                $result_event = $db->query($sql_event);
                                                $row_event = $result_event->fetch_assoc();
                                                ?>
                                                <td><?= $row_event['event_name'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Event Date</td>
                                                <td><?= $row['event_date'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Function Mode</td>
                                                <td><?= $row['function_mode'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Time</td>
                                                <td><?= $row['start_time'] . '-' . $row['end_time'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Guest Count</td>
                                                <td><?= $row['guest_count'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Hall</td>
                                                <?php
                                                $sql_hall = "SELECT hall_name FROM hall WHERE hall_id=" . $row['hall_id'];
                                                $result_hall = $db->query($sql_hall);
                                                $row_hall = $result_hall->fetch_assoc();
                                                ?>
                                                <td><?= $row_hall['hall_name'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Selected Package</td>
                                                <?php
                                                $sql_package = "SELECT package_name FROM package WHERE package_id=" . $row['package_id'];
                                                $result_package = $db->query($sql_package);
                                                $row_package = $result_package->fetch_assoc();
                                                $per_person_price = number_format($row['per_person_price'], '2', '.', ',');
                                                ?>
                                                <td><?= $row_package['package_name'] . '( Rs.' . $per_person_price . ')' ?></td>
                                            </tr>
                                            <tr>
                                                <td>Reservation Status</td>
                                                <?php
                                                $sql_res_status = "SELECT reservation_status FROM reservation_status WHERE reservation_status_id=" . $row['reservation_status_id'];
                                                $result_res_status = $db->query($sql_res_status);
                                                $row_res_status = $result_res_status->fetch_assoc();
                                                ?>
                                                <td><?= $row_res_status['reservation_status'] ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-5 mt-3 mb-3" style="text-align:center;">
                                
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
    </section>
</main>
<?php
include '../footer.php';
?>