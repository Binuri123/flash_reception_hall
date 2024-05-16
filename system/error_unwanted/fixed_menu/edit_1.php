<?php ob_start() ?>
<?php include '../../header.php'; ?>
<?php include '../../menu.php'; ?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Menu</a></li>
                <li class="breadcrumb-item"><a href="#">Fixed Menu</a></li>
                <li class="breadcrumb-item active" aria-current="page">Update</li>
            </ol>
        </nav>
    </div>
    <?php
    if($_SERVER['REQUEST_METHOD'] == "GET"){
        extract($_GET);
        $menu_id = $_GET['menu_id'];
        
        $db = dbConn();
        $sql="SELECT * FROM menu WHERE menu_id='$menu_id'";
        $result = $db->query($sql);
        if($result->num_rows >0){
            while ($row=$result->fetch_assoc()){
                $menu_name = $row['menu_name'];
                $menu_type = $row['menu_type_id'];
                $vendor_price = $row['vendor_price'];
                $profit_ratio = $row['profit_ratio'];
                $availability = $row['availability'];
            }
        }
    }
    extract($_POST);
    //var_dump(@$item_id);
    //var_dump($_POST);
    if (!empty($item)) {
        foreach (@$item as $value) { 
            $db = dbConn();
            $sql = "SELECT m.item_id,m.item_name,m.item_price,mc.category_name,m.item_id,m.category_id FROM menu_item m INNER JOIN menu_item_category mc ON mc.category_id=m.category_id WHERE m.item_id='$value'";
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
            $_SESSION['selected_items'][$row['item_id']]=array('item_id'=>$row['item_id'],'item_name'=>$row['item_name'],'item_price'=>$row['item_price'],'category_id'=>$row['category_id'],'category_name'=>$row['category_name']);
        }
        print_r($_SESSION['selected_items']);
    }
    
    if (!empty($_SESSION['selected_items'])) {
    @$vendor_price = 0;
        foreach ($_SESSION['selected_items'] as $unit) {
            @$vendor_price += $unit['item_price'];
        }
    }
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'remove_item' && !empty(@$item_id)) {
        @$vendor_price -= $_SESSION['selected_items'][@$item_id]['item_price'];
        unset($_SESSION['selected_items'][$item_id]);
    }



if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'save') {
        $menu_name = cleanInput($menu_name);
        $vendor_price = cleanInput($vendor_price);
        $profit_ratio = cleanInput($profit_ratio);
        $invoice_price = cleanInput($invoice_price);
        
        $message = array();
        if (empty($menu_name)) {
            $message['error_menu_name'] = "The Menu Name Should Not Be Blank...";
        }
        if (!isset($menu_type)) {
            $message['error_menu_type'] = "The Menu Type Should Be Selected...";
        }
        if (empty($vendor_price)) {
            $message['error_vendor_price'] = "The Vendor Price Should Not Be Blank...";
        }
        if (empty($profit_ratio)) {
            $message['error_profit_ratio'] = "The Profit Ratio Should Not Be Blank...";
        }
        if (!isset($availability)) {
            $message['error_availability'] = "The Service Status Should Be Selected...";
        }
        if (!empty($vendor_price)) {
            if (!is_numeric($vendor_price)) {
                $message['error_vendor_price'] = "The Vendor Price Invalid...";
            } elseif ($vendor_price < 0) {
                $message['error_vendor_price'] = "The Vendor Price Cannot Be Negative...";
            }
        }

        if (empty($message)) {
            $db = dbConn();
            //echo 'Connected..!';
            $sql = "SELECT * FROM menu WHERE menu_id = '$menu_id'";
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
            
            $updated_fields_menu = getUpdatedFields($row,$_POST);
            //var_dump($updated_fields);
            $updated_fields_menu_string = implode(',',$updated_fields_menu);
            
            $sql = "SELECT mi.item_id,mi.item_name,mi.item_price,mc.category_id,mc.category_name FROM menu_category_item mci "
                    . "INNER JOIN menu_item mi ON mci.item_id=mi.item_id "
                    . "INNER JOIN menu_item_category mc ON mc.category_id=mci.category_id WHERE menu_id = '$menu_id'";
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
            $updated_items_list = '';
            foreach($_SESSION['selecetd_items'] as $unit){
                $updated_items = getUpdatedFields($row,$unit);
                //var_dump($updated_fields);
                $updated_items_string = implode(',',$updated_items);
                $updated_items_list .= ",".$updated_items_string;
            }
            
            $userid = $_SESSION['userid'];
            $cDate = date('Y-m-d');
            $sql = "UPDATE menu SET menu_name='$menu_name',menu_type_id='$menu_type',vendor_price='$vendor_price',profit_ratio='$profit_ratio',availability='$availability',update_user='$userid',update_date='$cDate' WHERE menu_id='$menu_id'";
            $db->query($sql);

            $sql = "DELETE FROM menu_category_item WHERE menu_id='$menu_id'";
            foreach($_SESSION['selected_items'] as $units){
                $item_category_id = $units['category_id'];
                $menu_item_id = $units['item_id'];
                $sql = "INSERT INTO menu_category_item(menu_id,category_id,item_id)VALUES('$menu_id','$item_category_id','$menu_item_id')";
                print_r($sql);
                $db->query($sql);
            }
            
            header('Location:edit_success.php?menu_id='.$menu_id.'&menu_updated=' . urlencode($updated_fields_menu_string).'&item_updated=' . urlencode($updated_items_list));
            unset($_SESSION['selected_items']);
        }
    }
    ?>
    <div class="row">
        <h2>Create Menu</h2>
    </div>
    <div class="row">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
            <div class="card text-dark mb-3">
                <div class="card-body bg-light">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="menu_name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="menu_name" name="menu_name" value="<?= @$menu_name ?>">
                                    <div class="text-danger"><?= @$message["error_menu_name"] ?></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="menu_type" class="form-label"><span class="text-danger">*</span>Menu Type</label>
                                    <select class="form-control form-select" id="menu_type" name="menu_type">
                                        <option value="" selected >-Select a Type-</option>
                                        <?php
                                        $db = dbConn();
                                        $sql = "SELECT * from menu_type";
                                        $result = $db->query($sql);
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <option value=<?= $row['menu_type_id']; ?> <?php if ($row['menu_type_id'] == @$menu_type) { ?> selected <?php } ?>><?= $row['menu_type'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <div class="text-danger"><?= @$message["error_menu_type"] ?></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="vendor_price" class="form-label">Vendor Price</label>
                                    <input type="text" readonly class="form-control" id="vendor_price" name="vendor_price" value="<?= @$vendor_price ?>">
                                    <div class="text-danger"><?= @$message["error_vendor_price"] ?></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="profit_ratio" class="form-label">Profit Ratio</label>
                                    <input type="number" step="0.01" min="0.00" max="100.00" class="form-control" id="profit_ratio" name="profit_ratio" onchange="form.submit()" value="<?= @$profit_ratio ?>">
                                    <div class="text-danger"><?= @$message["error_profit_ratio"] ?></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="invoice_price" class="form-label">Invoice Price</label>
                                    <?php
                                    if(!empty(@$vendor_price) && !empty(@$profit_ratio)){
                                        @$invoice_price = @$vendor_price + @$vendor_price*@$profit_ratio/100;
                                        @$invoice_price = floatval(@$invoice_price);
                                    }
                                    ?>
                                    <input type="text" class="form-control" id="invoice_price" name="invoice_price" value="<?= @$invoice_price ?>" readonly>
                                    <div class="text-danger"><?= @$message["error_invoice_price"] ?></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label>Availability</label><br>
                                    <div class="mt-3 form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="availability" id="available" value="Available" <?php if (isset($availability) && $availability == 'Available') { ?> checked <?php } ?>>
                                        <label class="form-check-label" for="available">Available</label>
                                    </div>
                                    <div class="mt-3 form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="availability" id="unavailable" value="Unavailable" <?php if (isset($availability) && $availability == 'Unavailable') { ?> checked <?php } ?>>
                                        <label class="form-check-label" for="unavailable">Unavailable</label>
                                    </div>
                                    <div class="text-danger"><?= @$message["error_availability"] ?></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="text-align:right">
                                    <input type="hidden" name="menu_id" value="<?= $menu_id?>">
                                    <button type="submit" class="btn btn-success" style="width:100px;" name="action" value="save">Save Changes</button>
                                    <button type="reset" class="btn btn-warning" style="width:100px;">Cancel</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-5">
                                    <label for="menu_category" class="form-label"><span class="text-danger">*</span>Category</label>
                                    <select class="form-control form-select" id="menu_category" name="menu_category" onchange="form.submit()">
                                        <option value="" disabled selected >-Select a Category-</option>
                                        <?php
                                        $db = dbConn();
                                        $sql = "SELECT * from menu_item_category";
                                        //print_r($sql);
                                        $result = $db->query($sql);
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <option value=<?= $row['category_id']; ?> <?php if ($row['category_id'] == @$menu_category) { ?> selected <?php } ?>><?= $row['category_name'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <div class="text-danger"><?= @$message["error_menu_category"] ?></div>
                                </div>
                                <div class="col-md-5">
                                    <?php
                                    $item = array();
                                    if (!empty(@$menu_category)) {
                                        $db = dbConn();
                                        $sql = "SELECT item_id,item_name,item_price FROM menu_item WHERE category_id=$menu_category";
                                        $result = $db->query($sql);
                                        
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <div class="form-check form-check">
                                                <input class="form-check-input" type="checkbox" id="<?= $row['item_id'] ?>" name="item[]" value="<?= $row['item_id'] ?>" <?php if (isset($item) && in_array($row['item_id'], $item)) { ?>checked <?php } ?>>
                                                <label class="form-check-label" for="<?= $row['item_id'] ?>"><?= $row['item_name'] . "-" . $row['item_price'] ?></label>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-10 mb-3" style="text-align:right">
                                    <button type="submit" name="action" value="add_item" class="btn btn-sm btn-success" onclick="form.submit()">Add</button>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-10 table-responsive">
                                    <table class="table table-striped table-secondary">
                                        <thead class="bg-secondary">
                                            <tr>
                                                <th>#</th>
                                                <th>Category</th>
                                                <th>Item</th>
                                                <th>Price</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            
                                            if($_SERVER['REQUEST_METHOD'] == 'POST' && (@$action == 'add_item' || !empty(@$menu_category))){
                                                if(!empty($_SESSION['selected_items'])){
                                                    foreach($_SESSION['selected_items'] as $unit){
                                            ?>
                                            
                                            <tr>
                                                <td></td>
                                                <td><?= $unit['category_name']?></td>
                                                <td><?= $unit['item_name']?></td>
                                                <td><?= $unit['item_price']?></td>
                                                <td>
                                                    <form method="post">
                                                        <input type="hidden" name="item_id" value=<?= $unit['item_id'] ?>>
                                                        <button type="submit" class="btn btn-sm" onclick="form.submit()" name="action" value="remove_item"><span data-feather="trash-2"></span></button>
                                                    </form>
                                                </td>
                                            </tr>
                                            
                                            <?php
                                                    }
                                                }
                                            }else if($_SERVER['REQUEST_METHOD'] == 'POST' && (@$action == 'remove_item' || !empty (@$menu_category)) && !empty(@$item_id)){
                                                //@$vendor_price -= $_SESSION['selected_items'][@$item_id]['item_price'];
                                                //unset($_SESSION['selected_items'][$item_id]);
                                                if(!empty($_SESSION['selected_items'])){
                                                    foreach($_SESSION['selected_items'] as $unit){
                                                       ?>
                                            <tr>
                                                <td></td>
                                                <td><?= $unit['category_name']?></td>
                                                <td><?= $unit['item_name']?></td>
                                                <td><?= $unit['item_price']?></td>
                                                <td>
                                                    <form method="post">
                                                        <input type="hidden" name="item_id" value=<?= $unit['item_id'] ?>>
                                                        <button type="submit" class="btn btn-sm" onclick="form.submit()" name="action" value="remove_item"><span data-feather="trash-2"></span></button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php
                                                    }
                                                }
                                            }else{
                                                if(!empty($_SESSION['selected_items'])){
                                                    foreach($_SESSION['selected_items'] as $unit){
                                            ?>
                                                <tr>
                                                    <td></td>
                                                    <td><?= $unit['category_name']?></td>
                                                    <td><?= $unit['item_name']?></td>
                                                    <td><?= $unit['item_price']?></td>
                                                    <td>
                                                        <form method="post">
                                                            <input type="hidden" name="item_id" value=<?= $unit['item_id'] ?>>
                                                            <button type="submit" class="btn btn-sm" onclick="form.submit()" name="action" value="remove_item"><span data-feather="trash-2"></span></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                        </div>
                    </div>     
                </div>
            </div>
        </form>
    </div>
</main>
<?php include '../../footer.php'; ?>
<?php ob_end_flush()?>