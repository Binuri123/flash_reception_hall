<?php include '../../header.php';?>
<?php include '../../menu.php';?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="btn-toolbar mb-2 mb-md-0">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>menu_package/menu_item/menu_item.php">Menu Item</a></li>
                    <li class="breadcrumb-item active" aria-current="page">View</li>
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
    //check the request method
    if($_SERVER['REQUEST_METHOD']== "GET"){
        //extract the array
        extract($_GET);
        //var_dump($_GET);
        $category_id = $_GET['category_id'];
        
        if(!empty($category_id)){
            $db = dbConn();
            $sql = "SELECT * FROM item_category WHERE category_id='$category_id'";
            //print_r($sql);
            $result = $db->query($sql);
            if($result->num_rows>0){
                $row = $result->fetch_assoc();
                //var_dump($row);
    ?>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="card bg-light col-md-6">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-sm table-bordered border-secondary">
                        <thead class="bg-secondary border-dark text-center">
                            <tr>
                                <th scope="col">Field</th>
                                <th scope="col">Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Category</td>
                                <td><?= $row['category_name']?></td>
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

 <?php include '../../footer.php';?>