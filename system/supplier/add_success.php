<?php include '../header.php';?>
<?php include '../menu.php';?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="mt-3 pagetitle">
        <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
            <h1 class="h4 m-0">Add New Supplier</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>supplier/add.php"><i class="bi bi-plus-circle"></i> New Supplier</a>
                <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>supplier/supplier.php"><i class="bi bi-calendar"></i> Search Supplier</a>
                </div>
            </div>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>supplier/supplier.php">Supplier</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>supplier/add.php">Add</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Success</li>
            </ol>
        </nav>
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
                    <div class="table-responsive">
                        <table class="table table-striped table-sm table-bordered border-secondary">
                            <thead class="bg-secondary-light border-dark text-center">
                                <tr>
                                    <th colspan="2">Registered Supplier Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Registration Number</td>
                                    <td><?= $row['supplier_no'] ?></td>
                                </tr>
                                <tr>
                                    <td>Title</td>
                                    <td><?= $row['title'] ?></td>
                                </tr>
                                <tr>
                                    <td>Full Name</td>
                                    <td><?= $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'] ?></td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td><?= $row['no'] . "," . $row['street_name'] . "," . $row['city'] . "," . $row['district_name'] ?></td>
                                </tr>
                                <tr>
                                    <td>Contact Number</td>
                                    <td><?= $row['contact_number'] ?></td>
                                </tr>
                                <?php
                                if($row['alternate_number']!=null){
                                ?>
                                <tr>
                                    <td>Alternate Number</td>
                                    <td><?= $row['alternate_number'] ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                                <tr>
                                    <td>Email</td>
                                    <td><?= $row['email'] ?></td>
                                </tr>
                                <tr>
                                    <td>NIC</td>
                                    <td><?= $row['nic'] ?></td>
                                </tr>
                                <tr>
                                    <td>Agreement Start Date</td>
                                    <td><?= $row['agreement_start_date'] ?></td>
                                </tr>
                                <tr>
                                    <td>Agreement End Date</td>
                                    <td><?= $row['agreement_end_date'] ?></td>
                                </tr>
                                <tr>
                                    <td>Agreement Status</td>
                                    <td><?= $row['agreement_status'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
                                        . "LEFT JOIN service s ON ss.service_id=s.service_id "
                                        . "WHERE ss.supplier_id='".$row['supplier_id']."'";
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