<?php include 'header.php'; ?>
<?php include 'menu.php'; ?>

<main id="main">
    <section>
       <div class='alert alert-secondary' role='alert'>

        <h1 class="text-center">  You have Successfully Registered! </h1>
        
       </div>
        
        <div class="row">
        
        <div class="col-md-3"></div>
        <div class="col-md-6">
             <div class="table-responsive">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                extract($_GET);
                //  var_dump($_GET);

                $regno = $_GET['regno'];

                $sql = "SELECT * FROM tbl_customers c LEFT JOIN tbl_customer_title t ON t.TitleId=c.TitleId"
                        . "                           LEFT JOIN tbl_gender g ON g.GenderId=c.GenderId"
                        . "                           LEFT JOIN tbl_district d ON d.DistrictId=c.DistrictId"
                        . "                           LEFT JOIN tbl_users u ON u.UserId=c.UserId  WHERE RegNo='$regno'";
              //  print_r($sql);
                $db = dbConn();
                $result = $db->query($sql);
                
                    ?> 
            
            <h3 class="text-lg-center text-warning">Your Profile Details</h3>
                    <table class="table table-striped table-sm">
                        <thead class="bg-secondary text-lg" >
                            <tr>
                                <th scope="col">Field</th>
                                <th scope="col">Value</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                             if ($result->num_rows > 0) {
                               $row = $result->fetch_assoc() ;
                        ?>  
                            <tr>
                                <td>Reg No</td>
                                <td><?= $row['RegNo'] ?></td>

                            </tr>
                            
                            <tr>
                                <td>Title</td>
                                <td><?= $row['TitleName'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>First Name</td>
                                <td><?= $row['FirstName'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>Last Name</td>
                                <td><?= $row['LastName'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>NIC</td>
                                <td><?= $row['NIC'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>Gender</td>
                                <td><?= $row['Name'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>District</td>
                                <td><?= $row['DistrictName'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>House No</td>
                                <td><?= $row['HouseNo'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>Street Name</td>
                                <td><?= $row['StreetName'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>City</td>
                                <td><?= $row['Area'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>Contact No</td>
                                <td><?= $row['ContactNo'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>Contact No (Optional)</td>
                                <td><?= $row['Contact2'] ?></td>

                            </tr>
                            
                           
                             <tr>
                                <td>Email</td>
                                <td><?= $row['Email'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>User Name</td>
                                <td><?= $row['UserName'] ?></td>

                            </tr>
                            
                            
                            
                             <tr>
                                <td>Password</td>
                                <td><?= $row['Password'] ?></td>

                            </tr>
                            
                            
                             <?php
                            
            } } ?>
                            
                        </tbody>
                    </table>
                </div>

            
        </div>
        <div class="col-md-3"></div>
        
         <div class="row">
        <div class="col-md-8"></div>
       
        <div class="col-md-4"> <a href="register_customer.php" class="btn btn-danger btn-sm">
                       Close <i class="fa fa-close" style="font-size:15px"></i> </a></div>
    </div>
        
       

            </div>
        
        
      
    </section>
    
    
    
    
</main>


<?php include 'footer.php'; ?> 
