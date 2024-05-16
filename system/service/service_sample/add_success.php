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
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>service/service_sample/service_sample.php">Service Samples</a></li>
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>service/service_sample/add.php">Add</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Success</li>
                </ol>
            </nav>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>service/service_sample/add.php"><i class="bi bi-plus-circle"></i> New Sample</a>
                <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>service/service_sample/service_sample.php"><i class="bi bi-calendar"></i> Search Sample</a>
            </div>
        </div>
    </div>
    <?php
    //check the request method
    if ($_SERVER['REQUEST_METHOD'] == "GET") {

        //extract the array
        extract($_GET);
        //var_dump($_GET);
        $sample_id = $_GET['sample_id'];

        if (!empty($sample_id)) {
            $db = dbConn();
            $sql = "SELECT s.service_name,ss.sample_name,ss.availability,ss.sample_image FROM service_samples ss "
                    . "LEFT JOIN service s ON s.service_id=ss.service_id WHERE service_sample_id='$sample_id'";
            //print_r($sql);
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                //var_dump($row);
                ?>
                <div class="row">
                    <div class="mb-3 col-md-3"></div>
                    <div class="alert alert-success col-md-6" role="alert">
                        <div class="row">
                            <div class="col-md-12" style="text-align:center">
                                <h4><strong>Successfully Added...!!!</strong></h4><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Service Details</h5>
                                <p style="font-weight:bold;margin:0;">Service Name: <?= $row['service_name'] ?></p>
                                <p style="font-weight:bold;margin:0;">Service Name: <?= $row['sample_name'] ?></p>
                                <p style="font-weight:bold;margin:0;">Availability: <?= $row['availability'] ?></p>
                                <p style="font-weight:bold;margin:0;">Sample Image: </p>
                                <img src="../../assets/images/service_sample/<?= $row['sample_image']?>" style="width:100px;height:100px;">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col-md-3"></div>
                </div>
                <?php
            }
        }
    }
    ?>
</main>
<?php include '../../footer.php'; ?>