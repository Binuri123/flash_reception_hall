<?php
ob_start();
include '../header.php';
include '../menu.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="btn-toolbar mb-2 mb-md-0">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>terms_and_conditions/terms_and_conditions.php">Terms and Conditions</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add</li>
                </ol>
            </nav>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>terms_and_conditions/terms_and_conditions.php"><i class="bi bi-calendar"></i> Search Policy</a>
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
        $policy = cleanInput($policy);

        //Required Field and Input Format Validation
        $message = array();

        if (empty($policy)) {
            $message['error_policy'] = "The Policy Should Not Be Blank...";
        }
        if (empty($category)) {
            $message['error_category'] = "The Category Should Be Selected...";
        }
        //print_r($message);
        //Insert data into relevant database tables
        if (empty($message)) {
            $db = dbConn();
            //echo 'Connected..!';
            $userid = $_SESSION['userid'];
            $cDate = date('Y-m-d');
            $sql = "INSERT INTO policy(category_id,policy,add_user,add_date)VALUES('$category','$policy','$userid','$cDate')";
            $db->query($sql);
            print_r($sql);
            $policy_id = $db->insert_id;
            header('Location:add_success.php?policy_id='.$policy_id);
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
                            <h4>Add New Policy</h4>
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
                                <label for="category" class="form-label"><span class="text-danger">*</span> Category</label>
                            </div>
                            <div class="mt-3 mb-3 col-md-8">
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM condition_category";
                                $result = $db->query($sql);
                                ?>
                                <select name="category" class="form-control form-select" style="font-size:13px;">
                                    <option value="" style="text-align:center">-Category-</option>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <option value="<?= $row['condition_category_id'] ?>" <?php if ($row['condition_category_id'] == @$category) { ?> selected <?php } ?>><?= $row['condition_category'] ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <div class="text-danger"><?= @$message["error_category"] ?></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label class="form-label"><span class="text-danger">*</span> Policy</label>
                            </div>
                            <div class="mb-3 col-md-8">
                                <textarea class="form-control" name="policy" value='<?= @$policy ?>' id="policy" style="font-size:13px;"></textarea>
                                <div class="text-danger"><?= @$message["error_policy"] ?></div>
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
include '../footer.php';
ob_end_flush();
?>