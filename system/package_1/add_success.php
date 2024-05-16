<?php include '../header.php';?>
<?php include '../menu.php';?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>package/package.php">Package</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>package/add.php">Add</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Success</li>
            </ol>
        </nav>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>package/package.php"><i class="bi bi-calendar"></i> Search Package</a>
            </div>
        </div>
    </div>
  <?php
    //check the request method
    if($_SERVER['REQUEST_METHOD']== "GET"){
        
        //extract the array
        extract($_GET);
        //var_dump($_GET);
        $package_id = $_GET['package_id'];
        
        if(!empty($package_id)){
            $db = dbConn();
            $sql = "SELECT p.package_name,e.event_name,m.menu_package_name,p.pax_count,p.total_price,p.service_charge,p.final_price,p.display_price,p.per_person_price,p.availability "
                    . "FROM package p INNER JOIN event e ON e.event_id=p.event_id "
                    . "INNER JOIN menu_package m ON m.menu_package_id=p.menu_package_id "
                    . "WHERE p.package_id='$package_id'";
            //print_r($sql);
            $result = $db->query($sql);
            if($result->num_rows>0){
                $row = $result->fetch_assoc();
                //var_dump($row);
    ?>
    <div class="row">
        <div class="mb-3 col-md-3"></div>
        <div class="alert alert-success col-md-6" role="alert">
            <div class="row">
                <div class="col-md-12" style="text-align:center">
                    <h4>Successfully Added...!!!</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h5>Package Details</h5>
                    <p style="font-weight:bold;margin:0;">Package Name: <?= $row['package_name'] ?></p>
                    <p style="font-weight:bold;margin:0;">Event: <?= $row['event_name'] ?></p>
                    <?php
//                        $db = dbConn();
//                        $sql = "SELECT item_name FROM menu_item mi INNER JOIN menu_category_item mci ON mci.item_id=mi.item_id WHERE mci.category_id ="
//                    ?>
                    <p style="font-weight:bold;margin:0;">Menu: <?= $row['menu_package_name'] ?></p>
                    <p style="font-weight:bold;margin:0;">Services:</p>
                    <ul>
                    <?php
                        $sql_1 = "SELECT service_name FROM package_services ps INNER JOIN service s ON ps.service_id=s.service_id WHERE ps.package_id=$package_id";
                        $result_1 = $db->query($sql_1);
                        if($result_1->num_rows>0){
                            while($row_1 = $result_1->fetch_assoc()){
                    ?>
                        <li><?= $row_1['service_name']?></li>
                    <?php
                            }
                        }
                    ?>
                    </ul>
                    <p style="font-weight:bold;margin:0;">Total Price(Rs.): <?= number_format($row['total_price'],'2','.',',') ?></p>
                    <p style="font-weight:bold;margin:0;">Service Charge(%): <?= number_format($row['service_charge'],'2') ?></p>
                    <p style="font-weight:bold;margin:0;">Final Price(Rs.): <?= number_format($row['final_price'],'2','.',',') ?></p>
                    <p style="font-weight:bold;margin:0;">Display Price(Rs.): <?= number_format($row['display_price'],'2','.',',') ?></p>
                    <p style="font-weight:bold;margin:0;">Per Person Price(Rs.): <?= number_format($row['per_person_price'],'2','.',',') ?></p>
                    <p style="font-weight:bold;margin:0;">Availability: <?= $row['availability'] ?></p>
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

 <?php include '../footer.php';?>