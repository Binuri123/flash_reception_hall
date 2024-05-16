<?php
ob_start();
include '../../header.php';
include '../../menu.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="btn-toolbar mb-2 mb-md-0">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>service/service.php">Service</a></li>
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>service/service_sample/service_sample.php">Service Samples</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add</li>
                </ol>
            </nav>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>service/service_sample/service_sample.php"><i class="bi bi-calendar"></i> Search Sample</a>
            </div>
        </div>
    </div>
    <?php
    //extract the array
    extract($_POST);
    //var_dump($_POST);
    //check the request method
    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'add') {

        // Assign cleaned values to the variables
        $sample_name = cleanInput($sample_name);

        //Required Validation
        $message = array();
        if (empty($sub_service)) {
            $message['error_sub_service'] = "The Sub Service Should be Selected...";
        }
        if (empty($service)) {
            $message['error_service'] = "The Service Should be Selected...";
        }
        if (empty($sample_name)) {
            $message['error_sample_name'] = "The Sample Name Should not Be Blank...";
        }
        if (!isset($availability)) {
            $message['error_availability'] = "The Service Status Should Be Selected...";
        }

        if (empty($message)) {
            if (!empty($_FILES['sample_image']['name'])) {
                $sample_img = uploadFiles("sample_image",uniqid(),"../../assets/images/service_sample/");
                //var_dump($employee_image);
                $sample_image_name = $sample_img['file_name'];
                if (!empty($sample_img['error_message'])) {
                    $message['error_sample_image'] = $$sample_img['error_message'];
                }
            }
        }
        
        if (empty($message)) {
            $db = dbConn();
            //echo 'Connected..!';
            $userid = $_SESSION['userid'];
            $cDate = date('Y-m-d');
            $sql = "INSERT INTO service_samples(sub_service_id,service_id,sample_name,sample_image,availability) "
                    . "VALUES('$sub_service','$service','$sample_name','$sample_image_name','$availability')";
            $db->query($sql);

            $new_sample_id = $db->insert_id;
            
            header('Location:add_success.php?sample_id=' . $new_sample_id);
        }
    }
    ?>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="card bg-light">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Add New Sample</h4>
                        </div>
                        <div class="col-md-6 text-danger" style="text-align:right">* Required</div>
                    </div>
                </div>
                <div class="card-body" style="font-size:13px;">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label for="sub_service" class="form-label"><span class="text-danger">*</span> Category</label>
                            </div>
                            <div class="mb-3 col-md-8">                      
                                <select class="form-control form-select" id="sub_service" name="sub_service" style="font-size:13px;" onchange="form.submit()">
                                    <option value="">-Select a Category-</option>
                                    <?php
                                    $db = dbConn();
                                    $sql = "SELECT * from sub_service";
                                    $result = $db->query($sql);
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <option value=<?= $row['sub_service_id'] ?> <?php if ($row['sub_service_id'] == @$sub_service) { ?>selected <?php } ?>><?= $row['sub_service_name'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <div class="text-danger"><?= @$message["error_sub_service"] ?></div>
                            </div>
                        </div>
                        <?php
                        if (!empty($sub_service)) {
                            ?>
                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label for="service" class="form-label"><span class="text-danger">*</span> Service</label>
                                </div>
                                <div class="mb-3 col-md-8">                      
                                    <select class="form-control form-select" id="service" name="service" style="font-size:13px;">
                                        <option value="">-Select a Service-</option>
                                        <?php
                                        $db = dbConn();
                                        $sql = "SELECT * from service WHERE sub_service_id='$sub_service'";
                                        $result = $db->query($sql);
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <option value=<?= $row['service_id'] ?> <?php if ($row['service_id'] == @$service) { ?>selected <?php } ?>><?= $row['service_name'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <div class="text-danger"><?= @$message["error_service"] ?></div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label for="sample_name" class="form-label"><span class="text-danger">*</span> Sample Name</label>
                            </div>
                            <div class="mb-3 col-md-8">
                                <input type="text" class="form-control" id="service_price" name="sample_name" value="<?= @$sample_name ?>" style="font-size:13px;">
                                <div class="text-danger"><?= @$message["error_sample_name"] ?></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label for="sample_image" class="form-label"><span class="text-danger">*</span> Sample Image</label>
                            </div>
                            <div class="mb-3 col-md-8">
                                <input type="file" class="form-control" id="sample_image" name="sample_image" value="<?= @$sample_image ?>" style="font-size:13px;">
                                <div class="text-danger"><?= @$message["error_sample_image"] ?></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label"><span class="text-danger">*</span> Availability</label>
                            </div>
                            <div class="col-md-8 mb-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="availability" id="available" value="Available" <?php if (isset($availability) && $availability == 'Available') { ?> checked <?php } ?>>
                                    <label class="form-check-label" for="available">Available</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="availability" id="unavailable" value="Unavailable" <?php if (isset($availability) && $availability == 'Unavailable') { ?> checked <?php } ?>>
                                    <label class="form-check-label" for="unavailable">Unavailable</label>
                                </div>
                                <div class="text-danger"><?= @$message["error_availability"] ?></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-12" style="text-align:right">
                                <button type="submit" name="action" value="add" class="btn btn-success btn-sm" style="width:100px;">Add</button>
                                <a href="<?= SYSTEM_PATH ?>service/service_sample/add.php" class="btn btn-warning btn-sm" style="width:100px;">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</main>

<?php
include '../../footer.php';
ob_end_flush();
?>