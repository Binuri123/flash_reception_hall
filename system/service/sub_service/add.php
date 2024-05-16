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
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>service/sub_service/sub_service.php">Sub Service</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add</li>
                </ol>
            </nav>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>service/sub_service/sub_service.php"><i class="bi bi-calendar"></i> Search Sample</a>
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
        $sub_service_name = cleanInput($sub_service_name);

        //Required Validation
        $message = array();
        if (empty($sub_service_name)) {
            $message['error_sub_service_name'] = "The Sub Service Name Should not Be Blank...";
        }

        if (empty($message)) {
            $db = dbConn();
            //echo 'Connected..!';
            $userid = $_SESSION['userid'];
            $cDate = date('Y-m-d');
            $sql = "INSERT INTO sub_service(sub_service_name) VALUES('$sub_service_name')";
            $db->query($sql);

            $new_sub_service_id = $db->insert_id;

            header('Location:' . SYSTEM_PATH . 'service/sub_service/sub_service.php');
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
                                <label for="sub_service_name" class="form-label"><span class="text-danger">*</span> Sub Service Name</label>
                            </div>
                            <div class="mb-3 col-md-8">
                                <input type="text" class="form-control" id="sub_service_name" name="sub_service_name" value="<?= @$sub_service_name ?>" style="font-size:13px;">
                                <div class="text-danger"><?= @$message["error_sub_service_name"] ?></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-12" style="text-align:right">
                                <button type="submit" name="action" value="add" class="btn btn-success btn-sm" style="width:100px;">Add</button>
                                <a href="<?= SYSTEM_PATH ?>service/sub_service/add.php" class="btn btn-warning btn-sm" style="width:100px;">Cancel</a>
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