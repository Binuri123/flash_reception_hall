<?php include('header.php') ?>
<?php include('menu.php') ?>

<main id="main">
    <section id="book-a-table" class="book-a-table">
        <div class="container" data-aos="fade-up">
            <div class="section-header" style="margin-top:50px;">
                <h2>Book A Date</h2>
                <p>Book <span>Your Special Day</span> With Us</p>
            </div>
            <div class="row">
                <div class="col-md-4 reservation-img" style="background-image: url(assets/img/reservation.jpg);" data-aos="zoom-out" data-aos-delay="200"></div>
                <div class="col-md-8">
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="customer_no" class="form-label">Customer No</label>
                            </div>
                            <div class="col-md-8 mb-3">
                                <?php
//                                    $db= dbConn();
//                                    $sql = "SELECT reg_no FROM customer WHERE customer_id=".$_SESSION['customer_id'];
//                                    $result = $db->query($sql);
//                                    $row = $result->fetch_assoc();
//                                    $customer_no = $row['reg_no'];
                                ?>
                                <input type="text" class="form-control" readonly name="customer_no" value="<?= @$customer_no ?>">
                                <div class="text-danger"><?= @$message["error_customer_no"] ?></div>
                            </div>
                        </div>
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
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label for="reservation_date" class="form-label">Reservation Date</label>
                            </div>
                            <div class="col-md-8 mb-3">
                                <input type="date" class="form-control" id="reservation_date" name="reservation_date" value="<?= @$reservation_date ?>" min="<?php echo date('Y-m-d') ?>" max="<?php date('Y-m-d', strtotime('+1 year', strtotime(date('Y-m-d')))) ?>">
                                <div class="text-danger"><?= @$message["error_reservation_date"] ?></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="start_time" class="form-label">Start Time</label>
                            </div>
                            <div class="col-md-8 mb-3">
                                <?php
                                    if(!empty(@$reservation_date) && @$reservation_date == date('Y-m-d')){
                                        $min_time = date('H:i:s');
                                        $min_time = $min_time->format('H:i');
                                    }else{
                                        $min_time = "";
                                    }
                                ?>
                                <input type="time" class="form-control" id="start_time" name="start_time" value="<?= @$start_time ?>">
                                <div class="text-danger"><?= @$message["error_start_time"] ?></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="end_time" class="form-label">End Time</label>
                            </div>
                            <div class="col-md-8 mb-3">
                                <input type="time" class="form-control" id="end_time" name="end_time" value="<?= @$end_time ?>">
                                <div class="text-danger"><?= @$message["error_end_time"] ?></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="guest_count" class="form-label">Guest Count</label>
                            </div>
                            <div class="col-md-8 mb-3">
                                <input type="number" class="form-control" id="guest_count" name="guest_count" value="<?= @$guest_count ?>">
                                <div class="text-danger"><?= @$message["error_guest_count"] ?></div>
                            </div>
                        </div>
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
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="remarks" class="form-label">Remarks</label>
                            </div>
                            <div class="col-md-8 mb-3">
                                <textarea class="form-control" id="remarks" name="remarks" value="<?= @$remarks ?>"></textarea>
                                <div class="text-danger"><?= @$message["error_remarks"] ?></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="status" class="form-label">Status</label>
                            </div>
                            <div class="col-md-8 mb-3">
                                <input type="text" class="form-control" readonly name="status" value="<?= @$status ?>">
                                <div class="text-danger"><?= @$message["error_status"] ?></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include('footer.php') ?>