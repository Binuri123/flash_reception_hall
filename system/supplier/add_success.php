<?php include '../header.php';?>
<?php include '../menu.php';?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>supplier/supplier.php">Supplier</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>supplier/add.php">Add</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Success</li>
            </ol>
        </nav>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>supplier/add.php"><i class="bi bi-plus-circle"></i> New Supplier</a>
                <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>supplier/supplier.php"><i class="bi bi-calendar"></i> Search Supplier</a>
            </div>
        </div>
    </div>
  <?php
    //check the request method
    if($_SERVER['REQUEST_METHOD']== "GET"){
        
        //extract the array
        extract($_GET);
        //var_dump($_GET);
        $supplier_no = $_GET['supplier_no'];
        
        if(!empty($supplier_no  )){
            $db = dbConn();
            $sql = "SELECT * FROM supplier sp LEFT JOIN district d ON d.district_id=sp.district_id "
                    . "LEFT JOIN agreement_status a ON a.agreement_status_id=sp.agreement_status_id "
                    . "WHERE sp.supplier_no='$supplier_no'";
            //print_r($sql);
            $result = $db->query($sql);
            if($result->num_rows>0){
                $row = $result->fetch_assoc();
    ?>
    <div class="row">
        <div class="mb-3 col-md-2"></div>
        <div class="alert alert-success col-md-8" role="alert">
            <div class="row">
                <div class="col-md-12" style="text-align:center;">
                    <h4>Successfully Added...!!!</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <h5 style="font-weight:bold;margin:0;">Registered Supplier Details</h5>
                    <p style="font-weight:bold;margin:0;">Registration Number: <?= $row['supplier_no'] ?></p>
                    <p style="font-weight:bold;margin:0;">Title: <?= $row['title'] ?></p>
                    <p style="font-weight:bold;margin:0;">Full Name: <?= $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'] ?></p>
                    <p style="font-weight:bold;margin:0;">Address: <?= $row['no'] . "," . $row['street_name'] . "," . $row['city'] . "," . $row['district_name'] ?></p>
                    <p style="font-weight:bold;margin:0;">Contact Number: <?= $row['contact_number'] ?></p>
                    <p style="font-weight:bold;margin:0;">Alternate Number: <?= $row['alternate_number'] ?></p>
                    <p style="font-weight:bold;margin:0;">Email: <?= $row['email'] ?></p>
                    <p style="font-weight:bold;margin:0;">NIC: <?= $row['nic'] ?></p>
                    <p style="font-weight:bold;margin:0;">Agreement Start Date: <?= $row['agreement_start_date'] ?></p>
                    <p style="font-weight:bold;margin:0;">Agreement End Date: <?= $row['agreement_end_date'] ?></p>
                    <p style="font-weight:bold;margin:0;">Agreement Status: <?= $row['agreement_status'] ?></p>
                </div>
                <div class="col-md-4">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-light">
                            <thead>
                                <tr style="text-align:center;">
                                    <th scope="col">Services</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_services = "SELECT * FROM supplier_service ss "
                                        . "LEFT JOIN service s ON ss.service_id=s.service_id WHERE ss.supplier_id='".$row['supplier_id']."'";
                                $result_services = $db->query($sql_services);
                                while ($row_services=$result_services->fetch_assoc()){
                                    ?>
                                <tr>
                                    <td><?=$row_services['service_name']?></td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <div class="mb-3 col-md-2"></div>
        </div>
    </div>
    <?php
            }
        }
    }    
  ?>       
</main>
 <?php include '../footer.php';?>