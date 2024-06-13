<?php include '../header.php';?>
<?php include '../menu.php';?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="mt-3 pagetitle">
        <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
            <h1 class="h4 m-0">Hall</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>hall/hall.php"><i class="bi bi-calendar"></i> Search Hall</a>
                </div>
            </div>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>hall/hall.php">Halls</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>hall/add.php">Add</a></li>
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
        $hall_id = $_GET['hall_id'];
        
        if(!empty($hall_id)){
            $db = dbConn();
            $sql = "SELECT * FROM hall WHERE hall_id='$hall_id'";
            //print_r($sql);
            $result = $db->query($sql);
            if($result->num_rows>0){
                $row = $result->fetch_assoc();
    ?>
    <div class="row">
        <div class="mb-3 col-md-3"></div>
        <div class="alert alert-success col-md-6" role="alert">
            <div class="row">
                <div class="col-md-12">
                    <h4 style="text-align:center;">Hall Successfully Added...!!!</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h5>Hall Details</h5>
                    <p style="font-weight:bold;margin:0;">Hall No: <?= $row['hall_no'] ?></p>
                    <p style="font-weight:bold;margin:0;">Hall Name: <?= $row['hall_name'] ?></p>
                    <p style="font-weight:bold;margin:0;">Minimum Capacity: <?= $row['min_capacity'] ?></p>
                    <p style="font-weight:bold;margin:0;">Maximum Capacity: <?= $row['max_capacity'] ?></p>
                    <p style="font-weight:bold;margin:0;">Facilities:</p>
                    <?php
                    
                        if($row['facilities']){
                            $facilities_list = explode(",",$row['facilities']);
                            echo "<ul>";
                            foreach($facilities_list as $value){
                                echo "<li>".$value."</li>";
                            }
                            echo "</ul>";
                        }
                    ?>
                    <p style="font-weight:bold;margin:0;">Allowed Events:</p>
                    <?php
                        $sql_events = "SELECT event_name FROM hall_event he INNER JOIN event e ON e.event_id=he.event_id WHERE hall_id ='$hall_id'";
                        $result_events = $db->query($sql_events);
                        echo '<ul>';
                        while($row_events = $result_events->fetch_assoc()){
                            echo '<li>'.$row_events['event_name'].'</li>';
                        }
                        echo '</ul>';
                    ?>
                    <p style="font-weight:bold;margin:0;">Image:</p>
                    <img class="img-fluid" src="../assets/images/hall/<?= empty($row['hall_image'])?"noimage.jpg":$row['hall_image'] ?>" style="width:150px;height:100px">
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