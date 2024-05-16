<?php include '../customer/header.php'; ?>
<?php include('../customer/sidebar.php') ?>

<?php

?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Dashboard</li>
                <li class="breadcrumb-item active">Reservation</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#home">Reservation</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#menu1">Package</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#menu2">Additional/Extras</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#menu3">Invoice</a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div id="home" class="container tab-pane active"><br>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="customer_no" class="form-label">Registration No</label>
                                        </div>
                                        <div class="col-md-8 mb-3">
                                            <?php
                                            $db = dbConn();
                                            $sql = "SELECT reg_no FROM customers WHERE customer_id=" . $_SESSION['customer_id'];
                                            //print_r($sql);
                                            $result = $db->query($sql);
                                            $row = $result->fetch_assoc();
                                            $customer_no = $row['reg_no'];
                                            ?>
                                            <input type="text" class="form-control" readonly name="customer_no" value="<?= @$customer_no ?>">
                                            <div class="text-danger"><?= @$message["error_customer_no"] ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="customer_no" class="form-label">Name</label>
                                        </div>
                                        <div class="col-md-8 mb-3">
                                            <input type="text" class="form-control" readonly name="customer_name" value="<?= $_SESSION['title'] . " " . $_SESSION['first_name'] . " " . $_SESSION['last_name'] ?>">
                                            <div class="text-danger"><?= @$message["error_customer_name"] ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="mb-3 col-md-4">
                                            <label for="event" class="form-label">Event</label>
                                        </div>
                                        <div class="col-md-8 mb-3">
                                            <select class="form-control" id="event" name="event">
                                                <option value="" disabled selected>-Select an Event-</option>
                                                <?php
                                                $db = dbConn();
                                                $sql = "SELECT * FROM event";
                                                $result = $db->query($sql);
                                                while ($row = $result->fetch_assoc()) {
                                                    ?>
                                                    <option value=<?= $row['event_id']; ?> <?php if ($row['event_id'] == @$event) { ?> selected <?php } ?>><?= $row['event_name'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <div class="text-danger"><?= @$message["error_event"] ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="mb-3 col-md-4">
                                            <label for="reservation_date" class="form-label">Date</label>
                                        </div>
                                        <div class="col-md-8 mb-3">
                                            <input type="date" class="form-control" id="reservation_date" name="reservation_date" value="<?= @$reservation_date ?>" min="<?php echo date('Y-m-d') ?>" max="<?php date('Y-m-d', strtotime('+1 year', strtotime(date('Y-m-d')))) ?>">
                                            <div class="text-danger"><?= @$message["error_reservation_date"] ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="start_time" class="form-label">Start Time</label>
                                        </div>
                                        <div class="col-md-8 mb-3">
                                            <?php
                                            if (!empty(@$reservation_date) && @$reservation_date == date('Y-m-d')) {
                                                $min_time = date('H:i:s');
                                                $min_time = $min_time->format('H:i');
                                            } else {
                                                $min_time = "";
                                            }
                                            ?>
                                            <input type="time" class="form-control" id="start_time" name="start_time" value="<?= @$start_time ?>">
                                            <div class="text-danger"><?= @$message["error_start_time"] ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="end_time" class="form-label">End Time</label>
                                        </div>
                                        <div class="col-md-8 mb-3">
                                            <input type="time" class="form-control" id="end_time" name="end_time" value="<?= @$end_time ?>">
                                            <div class="text-danger"><?= @$message["error_end_time"] ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="guest_count" class="form-label">Guest Count</label>
                                        </div>
                                        <div class="col-md-8 mb-3">
                                            <input type="number" class="form-control" id="guest_count" name="guest_count" value="<?= @$guest_count ?>">
                                            <div class="text-danger"><?= @$message["error_guest_count"] ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="hall" class="form-label">Hall</label>
                                        </div>
                                        <div class="col-md-8 mb-3">
                                            <select class="form-control" id="event" name="hall">
                                                <option value="" selected>-Select a Hall-</option>
                                                <?php
                                                $db = dbConn();
                                                $sql = "SELECT * FROM hall";
                                                $result = $db->query($sql);
                                                while ($row = $result->fetch_assoc()) {
                                                    ?>
                                                    <option value=<?= $row['hall_id']; ?> <?php if ($row['hall_id'] == @$hall) { ?> selected <?php } ?>><?= $row['hall_name'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <div class="text-danger"><?= @$message["error_hall"] ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row text-right">
                                <div class="col-md-6"></div>
                                <div class="col-md-6">
                                    <a href="#menu1">NEXT</a>
                                </div>
                            </div>
                    </div>
                    <div id="menu1" class="container tab-pane fade"><br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="package" class="form-label">Package</label>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <select class="form-control" id="event" name="package">
                                            <option value="" selected>-Select a Package-</option>
                                            <?php
                                            $db = dbConn();
                                            $sql = "SELECT * FROM package";
                                            $result = $db->query($sql);
                                            while ($row = $result->fetch_assoc()) {
                                                ?>
                                                <option value=<?= $row['package_id']; ?> <?php if ($row['package_id'] == @$package) { ?> selected <?php } ?>><?= $row['package_name'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <div class="text-danger"><?= @$message["error_package"] ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="remarks" class="form-label">Remarks</label>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <textarea class="form-control" id="remarks" name="remarks" value="<?= @$remarks ?>"></textarea>
                                        <div class="text-danger"><?= @$message["error_remarks"] ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="menu2" class="container tab-pane active"><br>
                        
                    </div>
                    <div id="menu3" class="container tab-pane fade"><br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="total" class="form-label">Total</label>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <input type="text" id="total" class="form-control" name="total" readonly value="<?= @$total ?>">
                                        <div class="text-danger"><?= @$message["error_total"] ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="tax" class="form-label">Tax</label>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <input type="text" readonly class="form-control" id="tax" name="tax" value="<?= @$tax ?>">
                                        <div class="text-danger"><?= @$message["error_tax"] ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="discount" class="form-label">Discount</label>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <input type="text" readonly class="form-control" name="discount" id="discount" value="<?= @$discount ?>">
                                        <div class="text-danger"><?= @$message["error_discount"] ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="remarks" class="form-label">Remarks</label>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <textarea class="form-control" id="remarks" name="remarks" value="<?= @$remarks ?>"></textarea>
                                        <div class="text-danger"><?= @$message["error_remarks"] ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="status" class="form-label">Status</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" readonly name="status" value="<?= @$status ?>">
                                        <div class="text-danger"><?= @$message["error_status"] ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row text-right">
                                    <div class="col-md-6"></div>
                                    <div class="col-md-6">
                                        <button type="submit" name="action" value="reserve" class="btn btn-success btn-sm">Reserve</button>
                                        <button type="reset" class="btn btn-warning btn-sm">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </section>
</main>
<?php include('../customer/footer.php') ?>