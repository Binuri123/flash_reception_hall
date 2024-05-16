<?php ob_start() ?>
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Services</a></li>
                <li class="breadcrumb-item active" aria-current="page">Update</li>
            </ol>
        </nav>
    </div>

    <?php
    if($_SERVER['REQUEST_METHOD'] == "GET"){
        extract($_GET);
        //var_dump($_GET);
        $db = dbConn();
        $sql = "SELECT * FROM service WHERE service_id = '$service_id'";
        $result = $db->query($sql);
        
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                var_dump($row);
                $service_name = $row['service_name'];
                $service_price = $row['service_price'];
                $item_category = $row['category_id'];
                $availability = $row['availability'];
            }
        }
    }
    //check the request method
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        //extract the array
        extract($_POST);
        // Assign cleaned values to the variables
        $service_name = cleanInput($service_name);
        $service_price = cleanInput($service_price);

        //Required Validation
        $message = array();
        if (empty($service_name)) {
            $message['error_service_name'] = "The Service Name Should Not Be Blank...";
        }
        if (empty($service_price)) {
            $message['error_service_price'] = "The Service Price Should Not Be Blank...";
        }
        if (!isset($availability)) {
            $message['error_availability'] = "The Service Status Should Be Select...";
        }

        //Advance Validation
        if (!empty($service_price)) {
            if (!is_numeric($service_price)) {
                $message['error_service_price'] = "The Service Price Invalid...";
            } elseif ($service_price < 0) {
                $message['error_service_price'] = "The Service Price Cannot Be Negative...";
            }
        }
        
        if (empty($message)) {
            $db = dbConn();
            //echo 'Connected..!';
            $sql = "SELECT * FROM service WHERE service_id = '$service_id'";
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
            
            $updated_fields = getUpdatedFields($row,$_POST);
            //var_dump($updated_fields);
            $updated_fields_string = implode(',',$updated_fields);
            $userid = $_SESSION['userid'];
            $cDate = date('Y-m-d');
            $sql = "UPDATE service SET service_name = '$service_name',service_price = '$service_price',category_id = '$service_category',availability = '$availability',update_user = '$userid',update_date='$cDate' WHERE service_id='$service_id'";
            $db->query($sql);
            
            header('Location:edit_success.php?service_id='.$service_id.'&values=' . urlencode($updated_fields_string));
        }
    }
    ?>
    <div class="row">
        <div class="mb-3 col-md-4"></div>
        <div class="mb-3 col-md-4">
            <h2>Update Service</h2>
        </div>
        <div class="mb-3 col-md-4"></div>
    </div>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
        <div class="row">
            <div class="mb-3 col-md-4"></div>
            <div class="mb-3 col-md-4">
                <label for="service_name" class="form-label">Name</label>
                <input type="text" class="form-control" id="service_name" name="service_name" value="<?= @$service_name ?>">
                <div class="text-danger"><?= @$message["error_service_name"] ?></div>
            </div>
            <div class="mb-3 col-md-4"></div>
        </div>
        <div class="row">
            <div class="mb-3 col-md-4"></div>
            <div class="mb-3 col-md-4">
                <label for="service_price" class="form-label">Price</label>
                <input type="text" class="form-control" id="service_price" name="service_price" value="<?= @$service_price ?>">
                <div class="text-danger"><?= @$message["error_service_price"] ?></div>
            </div>
            <div class="mb-3 col-md-4"></div>
        </div>
        <div class="row">
            <div class="mb-3 col-md-4"></div>
            <div class="mb-3 col-md-4">
                <label for="service_category" class="form-label">Category</label>                            
                <select class="form-control form-select" id="service_category" name="service_category">
                    <option value="" disabled >-Select a Category-</option>
                    <?php
                    $db = dbConn();
                    $sql1 = "SELECT * from service_category";
                    $result = $db->query($sql1);
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <option value=<?= $row['category_id']; ?> <?php if ($row['category_id'] == @$service_category) { ?>selected <?php } ?>><?= $row['category_name'] ?></option>
                        <?php
                    }
                    ?>
                </select>
                <div class="text-danger"><?= @$message["error_service_category"] ?></div>
            </div>
            <div class="mb-3 col-md-4"></div>
        </div>
        <div class="row">
            <div class="mb-3 col-md-4"></div>
            <div class="mb-3 col-md-4">
                <label>Availability</label><br>
                <div class="mt-3 form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="availability" id="service_available" value="1" <?php if (isset($availability) && $availability == '1') { ?> checked <?php } ?>>
                    <label class="form-check-label" for="service_available">Available</label>
                </div>
                <div class="mt-3 form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="availability" id="service_unavailable" value="0" <?php if (isset($availability) && $availability == '0') { ?> checked <?php } ?>>
                    <label class="form-check-label" for="service_unavailable">Unavailable</label>
                </div>
                <div class="text-danger"><?= @$message["error_availability"] ?></div>
            </div>
            <div class="mb-3 col-md-4"></div>
        </div>
        <div class="row">
            <div class="mb-3 col-md-4"></div>
            <div class="mb-3 col-md-4" style="text-align:right">
                <input type="hidden" name="service_id" value="<?= $service_id ?>">
                <button type="submit" class="btn btn-success" style="width:100px;">Add</button>
                <button type="reset" class="btn btn-warning" style="width:100px;">Cancel</button>
            </div>
            <div class="mb-3 col-md-4"></div>
        </div>
    </form>
</main>

<?php include '../footer.php'; ?>
<?php ob_end_flush()?>