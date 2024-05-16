<?php include '../../header.php';?>
<?php include '../../menu.php';?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="btn-toolbar mb-2 mb-md-0">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>menu_package/menu.php">Menu</a></li>
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>menu_package/menu_package.php">Menu Package</a></li>
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>menu_package/menu_item/menu_item.php">Menu Item</a></li>
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>menu_package/menu_item/add.php">Add</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Success</li>
                </ol>
            </nav>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a class="btn btn-sm btn-outline-success" href="<?=SYSTEM_PATH?>menu_package/menu_item/add.php"><i class="bi bi-plus-circle"></i> New Item</a>
                <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>menu_package/menu_item/menu_item.php"><i class="bi bi-calendar"></i> Search Item</a>
            </div>
        </div>
    </div>

  <?php
  //Recognize the request method GET and capture the newly added item id to show the inserted data to the database
    //check the request method
    if($_SERVER['REQUEST_METHOD']== "GET"){
        //extract the array
        extract($_GET);
        //var_dump($_GET);
        $item_id = $_GET['item_id'];
        
        if(!empty($item_id)){
            $db = dbConn();
            $sql = "SELECT category_name,item_name,i.availability,item_price,profit_ratio,portion_price,item_image,addon_status,additional_ratio,addon_price "
                    . "FROM menu_item i LEFT JOIN item_category mc ON mc.category_id=i.category_id "
                    . "LEFT JOIN additional_allowed_item a ON a.item_id=i.item_id WHERE i.item_id='$item_id'";
            //print_r($sql);
            $result = $db->query($sql);
            if($result->num_rows>0){
                $row = $result->fetch_assoc();
                //var_dump($row);
    ?>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="alert alert-success col-md-6" role="alert">
            <div class="row">
                <div class="col-md-12" style="text-align:center">
                    <h4><strong>Successfully Added...!!!</strong></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-6" style="text-align:left">
                    <h5>Category Details</h5>
                    <p style="font-weight:bold;margin:0;">Item Category: <?= $row['category_name'] ?></p>
                    <p style="font-weight:bold;margin:0;">Item Name: <?= $row['item_name'] ?></p>
                    <p style="font-weight:bold;margin:0;">Availability: <?= $row['availability'] ?></p>
                    <p style="font-weight:bold;margin:0;">Price(Rs.): <?= $row['item_price'] ?></p>
                    <p style="font-weight:bold;margin:0;">Profit Ratio(%): <?= $row['profit_ratio'] ?></p>
                    <p style="font-weight:bold;margin:0;">Portion Price(Rs.): <?= $row['portion_price'] ?></p>
                    <p style="font-weight:bold;margin:0;">Image:</p>
                    <img class="img-fluid" width="100" src="../../assets/images/menu_item_images/<?= empty($row['item_image'])?"noimage.jpg":$row['item_image'] ?>">
                    <p style="font-weight:bold;margin:0;">Approved as Additional: <?= $row['addon_status'] ?></p>
                    <?php
                    if($row['addon_status']=='Yes'){
                     ?>
                    <p style="font-weight:bold;margin:0;">Additional Ratio(%): <?= $row['additional_ratio'] ?></p>
                    <p style="font-weight:bold;margin:0;">Price as an Addon(Rs.): <?= $row['addon_price'] ?></p>
                    <?php
                    }
                    ?>
                </div>
                <div class="col-md-4"></div>
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

 <?php include '../../footer.php';?>