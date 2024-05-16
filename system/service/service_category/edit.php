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
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>service/service_category/service_category.php">Service Category</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Update</li>
                </ol>
            </nav>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>service/service_category/service_category.php"><i class="bi bi-calendar"></i> Search Category</a>
            </div>
        </div>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        extract($_GET);

        $db = dbConn();
        $sql = "SELECT * FROM service_category WHERE category_id = '$category_id'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $category_name = $row['category_name'];
                $availability = $row['availability'];
            }
        }
    }

    extract($_POST);
    //var_dump($_POST);
    //check the request method
    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'save_changes') {
        //extract the array
        // Assign cleaned values to the variables
        $category_name = cleanInput($category_name);

        //Required Validation
        $message = array();
        if (empty($category_name)) {
            $message['error_category_name'] = "The Category Name Should Not Be Blank...";
        }

        if (!isset($availability)) {
            $message['error_availability'] = "The Availability Should Be Selected...";
        }

        //Update data in relevant database tables
        if (empty($message)) {
            $db = dbConn();
            //echo 'Connected..!';
            //Get the previous data from the database
            $sql = "SELECT * FROM service_category WHERE category_id = '$category_id'";
            $result = $db->query($sql);
            $row = $result->fetch_assoc();

            //Get the updated fields by comparing the previous values and submitted form data
            $updated_fields = getUpdatedFields($row, $_POST);
            //var_dump($updated_fields);
            $updated_fields_string = implode(',', $updated_fields);

            $userid = $_SESSION['userid'];
            $cDate = date('Y-m-d');
            $sql = "UPDATE service_category SET category_name = '$category_name',availability = '$availability',update_user = '$userid',update_date = '$cDate' WHERE category_id = '$category_id'";
            $db->query($sql);
            //print_r($sql);

            header('Location:edit_success.php?category_id=' . $category_id . '&values=' . urlencode($updated_fields_string));
        }
    }
    ?>
    <div class="row">
        <div class="mb-3 col-md-4"></div>
        <div class="mb-3 col-md-4">
            <div class="card bg-light">
                <div class="card-header">
                    <h4>Update Category</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                        <div class="row">
                            <div class="mt-3 mb-3 col-md-4">
                                <label for="category_name" class="form-label">Name</label>
                            </div>
                            <div class="mt-3 mb-3 col-md-8">
                                <input type="text" class="form-control" id="category_name" name="category_name" value="<?= @$category_name ?>">
                                <div class="text-danger"><?= @$message["error_category_name"] ?></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label>Availability</label><br>
                            </div>
                            <div class="mb-3 col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-inline mt-3">
                                            <input class="form-check-input" type="radio" name="availability" id="category_available" value="Available" <?php if (isset($availability) && $availability == 'Available') { ?> checked <?php } ?>>
                                            <label class="form-check-label" for="category_available">Available</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-check-inline mt-3">
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
                                <input type="hidden" name="category_id" value="<?= @$category_id ?>">
                                <button type="submit" name="action" value="save_changes" class="btn btn-success">Save Changes</button>
                            </div>
                        </div>  
                    </form>
                </div>
            </div>
        </div>
        <div class="mb-3 col-md-4"></div>
    </div>
</main>

<?php include '../../footer.php'; ?>
<?php
ob_end_flush()?>