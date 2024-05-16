<?php ob_start() ?>
<?php include '../../header.php'; ?>
<?php include '../../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Menu Item</a></li>
                <li class="breadcrumb-item active" aria-current="page">Update</li>
            </ol>
        </nav>
    </div>

    <?php
    if($_SERVER['REQUEST_METHOD'] == "GET"){
        extract($_GET);
        //var_dump($_GET);
        $db = dbConn();
        $sql = "SELECT * FROM menu_item WHERE item_id = '$item_id'";
        $result = $db->query($sql);
        
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                var_dump($row);
                $item_name = $row['item_name'];
                $item_price = $row['item_price'];
                $portion_price = $row['portion_price'];
                $item_category = $row['category_id'];
                $description = $row['description'];
                $availability = $row['availability'];
                $item_image = $row['item_image'];
                
            }
        }
    }
    //check the request method
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        //extract the array
        extract($_POST);
        // Assign cleaned values to the variables
        $item_name = cleanInput($item_name);
        $item_price = cleanInput($item_price);
        $portion_price = cleanInput($portion_price);
        $description = cleanInput($description);

        //Required Validation
        $message = array();
        if (empty($item_name)) {
            $message['error_item_name'] = "The Menu Item Name Should Not Be Blank...";
        }
        if (empty($item_price)) {
            $message['error_item_price'] = "The Menu Item Quantity Should Not Be Blank...";
        }
        if (empty($portion_price)) {
            $message['error_portion_price'] = "The Menu Item Price Should Not Be Blank...";
        }
        if (empty($item_category)) {
            $message['error_item_category'] = "The Menu Item Category Should Not Be Blank...";
        }
        if (!isset($availability)) {
            $message['error_availability'] = "The Menu Item Status Should Be Select...";
        }
        //if(!isset($item_image)){
        //  $message['error_item_image'] = "The Menu Item Image Should Be Select...";
        //}
        //Advance Validation
        if (!empty($item_price)) {
            if (!is_numeric($item_price)) {
                $message['error_item_price'] = "The Item Price Invalid...";
            } elseif ($item_price < 0) {
                $message['error_item_price'] = "The Item Price Cannot Be Negative...";
            }
        }
        if (!empty($portion_price)) {
            if (!is_numeric($portion_price)) {
                $message['error_portion_price'] = "The Portion Price Invalid...";
            } elseif ($portion_price < 0) {
                $message['error_portion_price'] = "The Portion Price Cannot Be Negative...";
            }
        }
        //var_dump($_POST);
        //var_dump($_FILES);
        //Get the uploaded file
        if (empty($message) && !empty($_FILES['item_image']['name']) && $_FILES['item_image']['name'] != $prv_image) {

            $item_image = uploadFiles("item_image",$item_name,"../../assets/images/menu_item_images/");
            //print_r($item_image);
            $item_image_name = $item_image['file_name'];
            if(!empty($item_image['error_message'])){
                $message['error_item_image'] = $item_image['error_message'];
            }
        }else{
            $item_image_name = $prv_image;
        }

        if (empty($message)) {
            $db = dbConn();
            //echo 'Connected..!';
            $sql = "SELECT * FROM menu_item WHERE item_id = '$item_id'";
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
            
            $updated_fields = getUpdatedFields($row,$_POST);
            //var_dump($updated_fields);
            $updated_fields_string = implode(',',$updated_fields);
            $userid = $_SESSION['userid'];
            $cDate = date('Y-m-d');
            $sql = "UPDATE menu_item SET item_name = '$item_name',item_price = '$item_price',portion_price = '$portion_price',category_id = '$item_category',description = '$description',availability = '$availability',item_image = '$item_image_name',update_user = '$userid',update_date = '$cDate' WHERE item_id='$item_id'";
            $db->query($sql);
            print_r($sql);
            
            header('Location:edit_success.php?item_id='.$item_id. '&values=' . urlencode($updated_fields_string));
        }
    }
    ?>
    <div class="row">
        <div class="mb-3 col-md-4"></div>
        <div class="mb-3 col-md-4">
            <h2>Add New Menu Item</h2>
        </div>
        <div class="mb-3 col-md-4"></div>
    </div>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
        <div class="row">
            <div class="mb-3 col-md-4"></div>
            <div class="mb-3 col-md-4">
                <label for="item_name" class="form-label">Name</label>
                <input type="text" class="form-control" id="item_name" name="item_name" value="<?= @$item_name ?>">
                <div class="text-danger"><?= @$message["error_item_name"] ?></div>
            </div>
            <div class="mb-3 col-md-4"></div>
        </div>
        <div class="row">
            <div class="mb-3 col-md-4"></div>
            <div class="mb-3 col-md-4">
                <label for="item_price" class="form-label">Price</label>
                <input type="text" class="form-control" id="item_price" name="item_price" value="<?= @$item_price ?>">
                <div class="text-danger"><?= @$message["error_item_price"] ?></div>
            </div>
            <div class="mb-3 col-md-4"></div>
        </div>
        <div class="row">
            <div class="mb-3 col-md-4"></div>
            <div class="mb-3 col-md-4">
                <label for="portion_price" class="form-label">Portion Price</label>
                <input type="text" class="form-control" id="portion_price" name="portion_price" value="<?= @$portion_price ?>">
                <div class="text-danger"><?= @$message["error_portion_price"] ?></div>
            </div>
            <div class="mb-3 col-md-4"></div>
        </div>
        <div class="row">
            <div class="mb-3 col-md-4"></div>
            <div class="mb-3 col-md-4">
                <label for="item_category" class="form-label">Category</label>                            
                <select class="form-control form-select" id="item_category" name="item_category">
                    <option value="" disabled>-Select a Category-</option>
                    <?php
                    $db = dbConn();
                    $sql1 = "SELECT * from menu_item_category";
                    $result = $db->query($sql1);
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <option value=<?= $row['category_id']; ?> <?php if ($row['category_id'] == @$item_category) { ?>selected <?php } ?>><?= $row['category_name'] ?></option>
                        <?php
                    }
                    ?>
                </select>
                <div class="text-danger"><?= @$message["error_item_category"] ?></div>
            </div>
            <div class="mb-3 col-md-4"></div>
        </div>
        <div class="row">
            <div class="mb-3 col-md-4"></div>
            <div class="mb-3 col-md-4">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description"><?= @$description ?></textarea>
            </div>
            <div class="mb-3 col-md-4"></div>
        </div>
        <div class="row">
            <div class="mb-3 col-md-4"></div>
            <div class="mb-3 col-md-4">
                <label>Availability</label><br>
                <div class="mt-3 form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="availability" id="category_available" value="1" <?php if (isset($availability) && $availability == '1') { ?> checked <?php } ?>>
                    <label class="form-check-label" for="category_available">Available</label>
                </div>
                <div class="mt-3 form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="availability" id="category_unavailable" value="0" <?php if (isset($availability) && $availability == '0') { ?> checked <?php } ?>>
                    <label class="form-check-label" for="category_unavailable">Unavailable</label>
                </div>
                <div class="text-danger"><?= @$message["error_availability"] ?></div>
            </div>
            <div class="mb-3 col-md-4"></div>
        </div>
        <div class="row">
            <div class="mb-3 col-md-4"></div>
            <div class="mb-3 col-md-4">
                <label for="item_image" class="form-label">Image</label>
                <input type="file" name="item_image" id="item_image" class="form-control">
                <div class="text-danger"><?= @$message["error_item_image"] ?></div>
                <input type="hidden" name="prv_image" value="<?= empty($item_image)?"noimage.jpg":$item_image ?>">
            </div>
            <div class="mb-3 col-md-4"></div>
        </div>
        <div class="row">
            <div class="mb-3 col-md-4"></div>
            <div class="mb-3 col-md-4">
                <img class="img-fluid" width="200" src="../../assets/images/menu_item_images/<?= empty($item_image)?"noimage.jpg":$item_image ?>">
            </div>
            <div class="mb-3 col-md-4"></div>
        </div>
        <div class="row">
            <div class="mb-3 col-md-4"></div>
            <div class="mb-3 col-md-4" style="text-align:right">
                <input type="hidden" name="item_id" value="<?= $item_id ?>">
                <button type="submit" class="btn btn-success" style="width:100px;">Add</button>
                <button type="reset" class="btn btn-warning" style="width:100px;">Cancel</button>
            </div>
            <div class="mb-3 col-md-4"></div>
        </div>
    </form>
</main>

<?php include '../../footer.php'; ?>
<?php
ob_end_flush()?>