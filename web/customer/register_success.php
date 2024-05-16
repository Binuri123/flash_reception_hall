<?php include '../header.php'; ?>

<main id="main">
    <section>
        <?php
        //check the request method
        if ($_SERVER['REQUEST_METHOD'] == "GET") {

            //extract the array
            extract($_GET);
            //var_dump($_GET);
            $customer_no = $_GET['customer_no'];
            $password_length = $_GET['password_length'];

            if (!empty($customer_no)) {
                $db = dbConn();
                $sql = "SELECT * FROM customer c LEFT JOIN district d ON d.district_id=c.district_id "
                        . "LEFT JOIN customer_titles t ON t.title_id=c.title_id LEFT JOIN user u ON c.user_id=u.user_id "
                        . "WHERE c.customer_no='$customer_no'";
                //print_r($sql);
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    //var_dump($row);
                    ?>
                    <div class="row" style="margin-top:50px">
                        <div class="mb-3 col-md-3"></div>
                        <div class="alert alert-success col-md-5" role="alert">
                            <div class="row">
                                <div class="col-md-12" style="text-align:center;">
                                    <h4>You have Successfully Registered...!!!</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="text-align:left">
                                    <h5>Registration Details</h5>
                                    <p style="font-weight:bold;margin:0;">Registration Number: <?= $row['customer_no'] ?></p>
                                    <p style="font-weight:bold;margin:0;">Name: <?= $row['title_name'] . " " . $row['first_name'] . " " . $row['last_name'] ?></p>
                                    <p style="font-weight:bold;margin:0;">Address: <?= $row['house_no'] . "," . $row['street'] . "," . $row['city'] . "," . $row['district_name'] ?></p>
                                    <p style="font-weight:bold;margin:0;">Contact Number: <?= $row['contact_number'] ?></p>
                                    <?php
                                    if (!empty($row['alternate_number'])) {
                                        ?>
                                        <p style="font-weight:bold;margin:0;">Alternate Number [Optional]: <?= $row['alternate_number'] ?></p>
                                        <?php
                                    }
                                    ?>
                                    <p style="font-weight:bold;margin:0;">Email: <?= $row['email'] ?></p>
                                    <p style="font-weight:bold;margin:0;">NIC: <?= $row['nic'] ?></p>
                                    <p style="font-weight:bold;margin:0;">Username: <?= $row['username'] ?></p>
                                    <p style="font-weight:bold;margin:0;">Password: <?= str_repeat('&#8226;', intval($password_length)) ?></p>
                                    <p style="text-align: justify">
                                        <strong>
                                            <i>
                                                You will receive an email as a confirmation of the registration.
                                                You can logged into the account using your username and password
                                                <?php
                                                if (!empty($check_availability_id)) {
                                                    ?>
                                                    <a href="<?= WEB_PATH ?>customer/login.php?check_availability_id=<?= $check_availability_id ?>&hall_id=<?= $hall_id ?>" style="color:blue;text-decoration:underline">Login</a>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <a href="<?= WEB_PATH ?>customer/login.php" style="color:blue;text-decoration:underline">Login</a>
                                                    <?php
                                                }
                                                ?>
                                            </i>
                                        </strong>
                                    </p>


                                </div>
                            </div>
                            <div class="mb-1 col-md-3"></div>
                        </div>
                    </div>
                    <?php
                }
            }
        }
        ?>
    </section>      
</main>

<?php include '../footer.php'; ?>