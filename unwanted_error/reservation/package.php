<?php
ob_start();
include '../customer/header.php';
include'../customer/sidebar.php';
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Reservation</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=WEB_PATH?>customer/dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Reservation</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <?php
    if($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_SESSION['reservation_details']['package_details'])){
        $package_id = $_SESSION['reservation_details']['package_details']['package_id'];
    }
    extract($_POST);
    //var_dump($_POST);
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'package_details') {
        $message = array();
        if (empty($package_id)) {
            $message['error_package'] = "A package should be Selected...";
        }

        if (empty($message)) {
            $per_person_price = str_replace(',','',$per_person_price);
            $total_package_price = str_replace(',','',$total_package_price);
            $_SESSION['reservation_details']['package_details'] = array('package_id'=>$package_id,'per_person_price'=>$per_person_price,'total_package_price'=>$total_package_price);
            header('Location:add_on.php');
        }
    }
    ?>
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card bg-light">
                    <div class="card-header bg-light">
                        <ul class="nav nav-tabs card-header-tabs nav-justified" style="font-size:14px;">
                            <li class="nav-item"><a class="nav-link" href="?tab=event_details">Event Details</a></li>
                            <li class="nav-item"><a class="nav-link active" href="?tab=package">Package</a></li>
                            <li class="nav-item"><a class="nav-link" href="?tab=add_ons">Add-ons</a></li>
                            <li class="nav-item"><a class="nav-link" href="?tab=service">Service</a></li>
                            <li class="nav-item"><a class="nav-link" href="?tab=invoice">Invoice</a></li>
                        </ul>
                    </div>
                    <div class="card-body py-2">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mt-3 mb-3">
                                    <div class="card-body" style="font-size:13px;">
                                        <div class="tab-container active">
                                            <form  method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                                <div class="row">
                                                    <div class="col-md-12 mt-3">
                                                        <p style="margin:0;color:lightseagreen;"><strong><i>Here are the packages you can selected for your reservation.</i></strong></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mt-2 mb-3">
                                                        <label class="form-label" for="package_id"><strong><i>Package</i></strong></label>
                                                        <select class="form-control form-select" id="package_id" name="package_id" style="font-size:13px;" onchange="form.submit();">
                                                            <option value="">-Select a Package-</option>
                                                            <?php
                                                            $db = dbConn();
                                                            $event = $_SESSION['reservation_details']['event_details']['event'];
                                                            $sql = "SELECT * FROM package p WHERE p.event_id='$event' AND availability='Available'";
                                                            $result = $db->query($sql);
                                                            while ($row = $result->fetch_assoc()) {
                                                                ?>
                                                                <option value=<?= $row['package_id']; ?> <?php if ($row['package_id'] == @$package_id) { ?> selected <?php } ?>><?= $row['package_name'] ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <div class="text-danger"><?= @$message['error_package_id'] ?></div>
                                                    </div>
                                                    <?php
                                                    if (!empty($package_id)) {
                                                        $db = dbConn();
                                                        $sql = "SELECT per_person_price FROM package WHERE package_id='$package_id'";
                                                        $result = $db->query($sql);
                                                        $row = $result->fetch_assoc();
                                                        $per_person_price = $row['per_person_price'];
                                                        //var_dump($per_person_price);
                                                        $guest_count = $_SESSION['reservation_details']['event_details']['guest_count'];
                                                        //var_dump($guest_count);
                                                        $total_package_price = $row['per_person_price'] * $guest_count;
                                                        $per_person_price = number_format($per_person_price, '2', '.', ',');
                                                        $total_package_price = number_format($total_package_price, '2', '.', ',');
                                                        ?>
                                                        <div class="col-md-3 mt-2 mb-3">
                                                            <label class="form-label" for="per_person_price"><strong><i>Per Person Price (Rs.)</i></strong></label>
                                                            <div style="text-align:center;"><strong><i><?= $per_person_price ?></i></strong></div>
                                                            <input type="hidden" name="per_person_price" value="<?= @$per_person_price ?>">
                                                        </div>
                                                        <div class="col-md-2 mt-2 mb-3">
                                                            <label class="form-label" for="guest_count"><strong><i>Guest Count</i></strong></label>
                                                            <div style="text-align:center;"><strong><i><?= $guest_count ?></i></strong></div>
                                                            <input type="hidden" name="guest_count" value="<?= @$guest_count ?>">
                                                        </div>
                                                        <div class="col-md-3 mt-2 mb-3">
                                                            <label class="form-label" for="total_package_price"><strong><i>Total Package Price (Rs.)</i></strong></label>
                                                            <div style="text-align:center;"><strong><i><?= $total_package_price ?></i></strong></div>
                                                            <input type="hidden" name="total_package_price" value="<?= @$total_package_price ?>">
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <?php
                                                if (!empty($package_id)) {
                                                    $db = dbConn();
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="table-responsive">
                                                                <table class="table table-striped table-light table-sm table-bordered border-secondary">
                                                                    <thead style="text-align:center;">
                                                                        <tr>
                                                                            <?php
                                                                            $sql = "SELECT menu_package_id,menu_package_name FROM menu_package WHERE menu_package_id = (SELECT menu_package_id FROM package WHERE package_id='$package_id')";
                                                                            $result = $db->query($sql);
                                                                            $row = $result->fetch_assoc();
                                                                            ?>
                                                                            <th colspan="2"><?= $row['menu_package_name'] . " Package" ?></th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="col">Category</th>
                                                                            <th scope="col">Items</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $sql_category = "SELECT * FROM item_category";
                                                                        $result_category = $db->query($sql_category);
                                                                        if ($result_category->num_rows > 0) {
                                                                            while ($row_category = $result_category->fetch_assoc()) {
                                                                                $sql_item = "SELECT mi.item_id,mi.item_name FROM menu_package_item mpi "
                                                                                        . "LEFT JOIN menu_item mi ON mi.item_id=mpi.item_id WHERE mpi.menu_package_id=" . $row['menu_package_id'] . " AND mpi.category_id=" . $row_category['category_id'];
                                                                                $result_item = $db->query($sql_item);
                                                                                if ($result_item->num_rows > 0) {
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td><?= $row_category['category_name'] ?></td>
                                                                                        <td>
                                                                                            <ul>
                                                                                                <?php
                                                                                                while ($row_item = $result_item->fetch_assoc()) {
                                                                                                    ?>
                                                                                                    <li><?= $row_item['item_name'] ?></li>
                                                                                                    <?php
                                                                                                }
                                                                                                ?>
                                                                                            </ul>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="table-responsive">
                                                                <table class="table table-striped table-light table-sm table-bordered border-secondary">
                                                                    <thead style="text-align:center;">
                                                                        <tr>
                                                                            <th colspan="2">Included Services</th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="col">#</th>
                                                                            <th scope="col">Service</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $sql_service = "SELECT s.service_id,s.service_name FROM package_services ps "
                                                                                . "LEFT JOIN service s ON s.service_id=ps.service_id WHERE ps.package_id='$package_id'";
                                                                        $result_service = $db->query($sql_service);
                                                                        if ($result_service->num_rows > 0) {
                                                                            $i = 1;
                                                                            while ($row_service = $result_service->fetch_assoc()) {
                                                                                ?>
                                                                                <tr>
                                                                                    <td><?= $i ?></td>
                                                                                    <td><?= $row_service['service_name'] ?></td>
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
                                                    <?php
                                                }
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-6" style="text-align:left;">
                                                        <a href="<?=WEB_PATH?>reservation/event_details.php" class="btn btn-success btn-sm" style="width:100px;font-size:13px;"><i class="bi bi-arrow-left"></i> Back</a>
                                                    </div>
                                                    <div class="col-md-6" style="text-align:right">
                                                        <button type="submit" name="action" value="package_details"  class="btn btn-success btn-sm" style="width:100px;font-size:13px;">Next <i class="bi bi-arrow-right"></i></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>

        <?php
//        if($_SERVER['REQUEST_METHOD']=='GET'){
//            extract($_GET);
//            $package_id = $_GET['package_id'];
//            $db = dbConn();
//            $sql = "SELECT * FROM package WHERE package_id='$package_id'";
//            $result = $db->query($sql);
//            $row = $result->fetch_assoc();
        ?>
        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Package Details</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        Modal body..
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
        <?php
        //}
        ?>
    </section>
</main>
<?php include('../customer/footer.php') ?>
<?php ob_end_flush() ?>