<?php
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
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>service/service_category/add.php">Add</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Success</li>
                </ol>
            </nav>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>service/service_category/add.php"><i class="bi bi-plus-circle"></i> New Category</a>
                <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>service/service_category/service_category.php"><i class="bi bi-calendar"></i> Search Category</a>
            </div>
        </div>
    </div>

    <?php
    //check the request method
    if ($_SERVER['REQUEST_METHOD'] == "GET") {

        //extract the array
        extract($_GET);
        //var_dump($_GET);
        $category_id = $_GET['category_id'];

        if (!empty($category_id)) {
            $db = dbConn();
            $sql = "SELECT * FROM service_category WHERE category_id='$category_id'";
            //print_r($sql);
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                ?>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="alert alert-success col-md-6" role="alert">
                        <div class="row">
                            <div class="col-md-12" style="text-align:center">
                                <h4><strong>Successfully Added...!!!</strong></h4><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6" style="text-align:left">
                                <h5>Category Details</h5>
                                <p style="font-weight:bold;margin:0;">Category Name: <?= $row['category_name'] ?></p>
                                <p style="font-weight:bold;margin:0;">Availability: <?= $row['availability'] ?></p>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <?php
            }
        }
    }
    ?>
</main>
<?php include '../../footer.php'; ?>