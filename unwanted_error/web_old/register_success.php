<?php include 'header.php';?>
<?php include 'menu.php';?>

<main id="main">
    <section>
        <?php
        //check the request method
        if ($_SERVER['REQUEST_METHOD'] == "GET") {

            //extract the array
            extract($_GET);
            //var_dump($_GET);
            $reg_no = $_GET['reg_no'];

            if (!empty($reg_no)) {
                $db = dbConn();
                $sql = "SELECT * FROM customers c LEFT JOIN district d ON d.district_id=c.district_id "
                        . "LEFT JOIN customer_titles t ON t.title_id=c.title_id WHERE c.reg_no='$reg_no'";
                print_r($sql);
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    ?>
                    <div class="row">
                        <div class="mb-3 col-md-2"></div>
                        <div class="alert alert-success d-flex align-items-center col-md-8" role="alert">
                            <div class="row">
                                <div>
                                    <h4 class="alert-heading" style="text-indent:150px;">Successfully Registered...!!!</h4>
                                    <h5 class="text-center" style="text-indent:150px;">Registered Details</h5>
                                    <p style="text-indent:200px; font-weight:bold;">Registration Number: <?= $row['reg_no'] ?></p>
                                    <p style="text-indent:200px; font-weight:bold;">Name: <?= $row['title_name'] . " " . $row['first_name'] . " " . $row['last_name'] ?></p>
                                    <p style="text-indent:200px; font-weight:bold;">Address: <?= $row['house_no'] . "," . $row['street'] . "," . $row['city'] . "," . $row['district_name'] ?></p>
                                    <p style="text-indent:200px; font-weight:bold;">Mobile Number: <?= $row['mobile'] ?></p>
                                    <p style="text-indent:200px; font-weight:bold;">Land Number [Optional]: <?= $row['land'] ?></p>
                                    <p style="text-indent:200px; font-weight:bold;">Email: <?= $row['email'] ?></p>
                                    <p style="text-indent:200px; font-weight:bold;">NIC: <?= $row['nic'] ?></p>
                                    <p>You will receive an email for the confirmation of the registration.Confirm the registration through the link attached.</p>
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
    </section>      
</main>

 <?php include 'footer.php';?>