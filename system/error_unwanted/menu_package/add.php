<?php ob_start() ?>
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Menu</a></li>
                <li class="breadcrumb-item"><a href="#">Menu Packages</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add</li>
            </ol>
        </nav>
    </div>

    <?php
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
        }else if(validateTextFields($item_name)!=null){
            $message['error_item_name'] = validateTextFields($item_name);
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
                $message['error_item_price'] = "The Menu Item Price Invalid...";
            } elseif ($item_price < 0) {
                $message['error_item_price'] = "The Menu Item Price Cannot Be Negative...";
            }
        }
        if (!empty($portion_price)) {
            if (!is_numeric($portion_price)) {
                $message['error_portion_price'] = "The Menu Item Portion Price Invalid...";
            } elseif ($portion_price < 0) {
                $message['error_portion_price'] = "The Menu Item Portion Price Cannot Be Negative...";
            }
        }
        
        //Get the uploaded file
        if (empty($message)) {

            $item_image = uploadFiles("item_image",$item_name,"../../assets/images/menu_item_images/");
            //print_r($item_image);
            $item_image_name = $item_image['file_name'];
            if(!empty($item_image['error_message'])){
                $message['error_item_image'] = $item_image['error_message'];
            }
        }

        if (empty($message)) {
            $db = dbConn();
            //echo 'Connected..!';
            $userid = $_SESSION['userid'];
            $cDate = date('Y-m-d');
            $sql = "INSERT INTO menu_item(item_name,item_price,portion_price,category_id,description,availability,item_image,add_user,add_date)VALUES('$item_name','$item_price','$portion_price','$item_category','$description','$availability','$item_image_name','$userid','$cDate')";
            $db->query($sql);
            
            $new_item_id = $db->insert_id;
            header('Location:add_success.php?item_id='.$new_item_id);
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
                <label for="menu_name" class="form-label">Name</label>
                <input type="text" class="form-control" id="menu_name" name="menu_name" value="<?= @$menu_name ?>">
                <div class="text-danger"><?= @$message["error_menu_name"] ?></div>
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
            </div>
            <div class="mb-3 col-md-4"></div>
        </div>
        <div class="row">
            <div class="mb-3 col-md-4"></div>
            <div class="mb-3 col-md-4" style="text-align:right">
                <button type="submit" class="btn btn-success" style="width:100px;">Add</button>
                <button type="reset" class="btn btn-warning" style="width:100px;">Cancel</button>
            </div>
            <div class="mb-3 col-md-4"></div>
        </div>
    </form>
</main>

<?php include '../footer.php'; ?>
<?php
ob_end_flush()?>