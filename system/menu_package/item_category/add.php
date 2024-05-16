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
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>menu_package/menu.php">Menu</a></li>
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>menu_package/item_category/item_category.php">Item Category</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add</li>
                </ol>
            </nav>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>menu_package/item_category/item_category.php"><i class="bi bi-calendar"></i> Search Category</a>
            </div>
        </div>
    </div>
    <?php
    extract($_POST);
    //var_dump($_POST);
    //echo 'outside';
    //check the request method
    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'add') {
        //echo 'inside';
        //extract the array
        // Assign cleaned values to the variables
        $category_name = cleanInput($category_name);

        //Required Field and Input Format Validation
        $message = array();

        if (empty($category_name)) {
            $message['error_category_name'] = "The Category Name Should Not Be Blank...";
        } elseif (validateTextFields($category_name)) {
            $message['error_category_name'] = "Invalid Input...";
        }
        if (!isset($availability)) {
            $message['error_availability'] = "The Availability Should Be Selected...";
        }
        //print_r($message);
        //Insert data into relevant database tables
        if (empty($message)) {
            $db = dbConn();
            //echo 'Connected..!';
            $userid = $_SESSION['userid'];
            $cDate = date('Y-m-d');
            $sql = "INSERT INTO item_category(category_name,availability,add_user,add_date)VALUES('$category_name','$availability','$userid','$cDate')";
            $db->query($sql);
            //print_r($sql);
            $category_id = $db->insert_id;
            header('Location:add_success.php?category_id=' . $category_id);
        }
    }
    ?>
    <div class="row">
        <div class="mb-3 col-md-3"></div>
        <div class="mb-3 col-md-6">
            <div class="card bg-light">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Add New Category</h4>
                        </div>
                        <div class="col-md-6" style="text-align:right">
                            <p class="text-danger text-right">* Required</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                        <div class="row">
                            <div class="mt-3 mb-3 col-md-4">
                                <label for="category_name" class="form-label"><span class="text-danger">*</span> Name</label>
                            </div>
                            <div class="mt-3 mb-3 col-md-8">
                                <input type="text" class="form-control" id="category_name" name="category_name" value="<?= @$category_name ?>">
                                <div class="text-danger"><?= @$message["error_category_name"] ?></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label class="form-label"><span class="text-danger">*</span> Availability</label>
                            </div>
                            <div class="mb-3 col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="availability" id="category_available" value="Available" <?php if (isset($availability) && $availability == 'Available') { ?> checked <?php } ?>>
                                            <label class="form-check-label" for="category_available">Available</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="availability" id="category_unavailable" value="Unavailable" <?php if (isset($availability) && $availability == 'Unavailable') { ?> checked <?php } ?>>
                                            <label class="form-check-label" for="category_unavailable">Unavailable</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-danger"><?= @$message["error_availability"] ?></div>
                            </div>
                        </div>
                        <div class="row" style="text-align: right">
                            <div class="mb-3 col-md-12">
                                <button type="submit" name="action" value="add" class="btn btn-success btn-sm">Add</button>
                            </div>
                        </div>  
                    </form>
                </div>
            </div>
        </div>
        <div class="mb-3 col-md-3"></div>
    </div>
</main>
<?php
include '../../footer.php';
ob_end_flush();
?>