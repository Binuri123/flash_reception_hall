<?php ob_start() ?>
<?php include '../customer/header.php'; ?>
<?php include('../customer/sidebar.php') ?>
<?php

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        extract($_GET);
        $reservation_no = $_GET['reservation_no'];
        $db = dbConn();
        $sql = "SELECT package_id FROM reservation WHERE reservation_no='$reservation_no'";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();

        $package = $row['package_id'];
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        extract($_POST);
        var_dump($_POST);
        $package = $_POST['package'];

        $db = dbConn();
        //echo 'connected';
        $cDate = date('Y-m-d');
        $reservation_no = $_SESSION['reservation_details']['event_details']['reservation_no'];
        $sql = "UPDATE reservation SET package_id='$package' WHERE reservation_no='$reservation_no'";
        print_r($sql);
        $db->query($sql);
        $_SESSION['package_details'] = $package;
        header('Location:add_on.php?reservation_no='.$reservation_no);
    }
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Reservation</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10 tabs">
                <ul  class="nav nav-tabs">
                    <li  class="nav-item"><a class="nav-link" href="?tab=1">Event Details</a></li>
                    <li  class="nav-item"><a class="nav-link active" href="?tab=2">Package</a></li>
                    <li  class="nav-item"><a class="nav-link" href="?tab=3">Add-ons</a></li>
                    <li  class="nav-item"><a class="nav-link" href="?tab=4">Invoice</a></li>
                </ul>
                <div class="tab-pane container active">
                    <form  method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 mb-3 mt-3">
                                        <label class="form-label" for="reservation_no">Reservation No</label>
                                    </div>
                                    <div class="col-md-8 mb-3 mt-3">

                                        <input class="form-control" readonly type="text" name="reservation_no" id="reservation_no" value="<?= $_SESSION['reservation_details']['event_details']['reservation_no'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                            <?php
                            $db = dbConn();
                            $sql = "SELECT event_id FROM reservation WHERE reservation_no='$reservation_no'";
                            //print_r($sql);
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();

                            $event = $row['event_id'];

                            $sql = "SELECT * FROM package p WHERE p.event_id='$event' AND availability='Available'";
                            //print_r($sql);
                            $result = $db->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                ?>
                            <div class="row">
                                <div class="col-md-1 mt-2">
                                    <input type="radio" name="package" id="<?= $row['package_name'] ?>" value=<?= $row['package_id'] ?> <?php if (isset($package) && $package == $row['package_id']) { ?> checked <?php } ?>>
                                </div>
                                <div class="col-md-11">
                                    <div class="row" for="<?= $row['package_name'] ?>">
                                        <div class="col-md-12">
                                            <div class="card bg-warning text-dark mb-3">
                                                <div class="card-body">
                                                    <p><?= $row['package_name'] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6" style="text-align:right">
                                <a href="event_details.php?reservation_no='<?= @$reservation_no ?>'" class="btn btn-success" style="width:150px;"><i class="bi bi-arrow-left"></i> Back</a>
                                <button type="submit" name="action" value="package_details"  class="btn btn-success" style="width:150px;">Next<i class="bi bi-arrow-right"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include '../customer/footer.php';  ?>
<?php ob_end_flush() ?>