<?php
include '../header.php';
include '../menu.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
        <div class="btn-toolbar mb-2 mb-md-0">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>users/users.php">User</a></li>
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>customer/customer.php">Customer</a></li>
                    <li class="breadcrumb-item active" aria-current="page">View</li>
                </ol>
            </nav>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>customer/customer.php"><i class="bi bi-calendar"></i> Search Customer</a>
            </div>
        </div>
    </div>
    <?php
    //check the request method
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        //extract the array
        extract($_GET);
        //var_dump($_GET);
        $customer_id = $_GET['customer_id'];

        if (!empty($customer_id)) {
            $db = dbConn();
            $sql = "SELECT c.customer_no,t.title_name,c.first_name,c.last_name,c.house_no,c.street,"
                    . "c.city,d.district_name,c.contact_number,c.alternate_number,c.email,c.nic,c.add_date,c.acceptance,u.user_status "
                    . "FROM customer c LEFT JOIN customer_titles t ON t.title_id=c.title_id "
                    . "LEFT JOIN district d ON d.district_id=c.district_id "
                    . "LEFT JOIN user u ON u.user_id=c.user_id WHERE c.customer_id='$customer_id'";
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
                                            <th colspan="2">Customer Details</th>
                                        </tr>
                                        <tr>
                                            <th scope="col">Field</th>
                                            <th scope="col">Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <tr>
                                            <td>Customer No</td>
                                            <td><?= $row['customer_no'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Customer Name</td>
                                            <td><?= $row['title_name'] . ". " . $row['first_name'] . " " . $row['last_name'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Address</td>
                                            <td><?= $row['house_no'] . ",<br>" . $row['street'] . ",<br>" . $row['city'] . ",<br>" . $row['district_name'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Contact Number</td>
                                            <td><?= $row['contact_number'] ?></td>
                                        </tr>
                                        <?php
                                            if($row['alternate_number'] != NULL){
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
                                            <td>Registered Date</td>
                                            <td><?= $row['add_date'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Agreed to Terms and Conditions</td>
                                            <td><?= $row['acceptance'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>User Status</td>
                                            <td><?= $row['user_status'] ?></td>
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