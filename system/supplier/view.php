<?php
include '../header.php';
include '../menu.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="mt-3 pagetitle">
        <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
            <h1 class="h4 m-0">Supplier Details</h1>
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
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>supplier/supplier.php">Suppliers</a></li>
                <li class="breadcrumb-item active" aria-current="page">View</li>
            </ol>
        </nav>
    </div>
    <?php
    //check the request method
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        //extract the array
        extract($_GET);
        //var_dump($_GET);
        $supplier_id = $_GET['supplier_id'];

        if (!empty($supplier_id)) {
            $db = dbConn();
            $sql = "SELECT * FROM supplier s "
                    . "LEFT JOIN district d ON d.district_id=s.district_id "
                    . "LEFT JOIN agreement_status a ON a.agreement_status_id=s.agreement_status_id WHERE s.supplier_id='$supplier_id'";
            //print_r($sql);
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                //var_dump($row);
                ?>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="card bg-light col-md-6">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm table-bordered border-secondary">
                                    <thead class="bg-secondary-light border-dark text-center">
                                        <tr>
                                            <th colspan="2">Supplier Details</th>
                                        </tr>
                                        <tr>
                                            <th scope="col">Field</th>
                                            <th scope="col">Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Supplier No</td>
                                            <td><?= $row['supplier_no'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Supplier Name</td>
                                            <td><?= $row['title'] . ". " . $row['first_name'] . " " . $row['last_name'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Address</td>
                                            <td><?= $row['no'] . ",<br>" . $row['street_name'] . ",<br>" . $row['city'] . ",<br>" . $row['district_name'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Contact Number</td>
                                            <td><?= $row['contact_number'] ?></td>
                                        </tr>
                                        <?php
                                            if($row['alternate_number']!= null){
                                        ?>
                                        <tr>
                                            <td>Alternate Contact Number</td>
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
                                            <td>Company Name</td>
                                            <td><?= $row['company_name'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Company Registration No</td>
                                            <td><?= $row['company_reg_no'] ?></td>
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
                    </div>
                    <div class=" col-md-3"></div>
                </div>
                <?php
            }
        }
    }
    ?>
</main>
<?php include '../footer.php'; ?>