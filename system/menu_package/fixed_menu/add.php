<?php 
ob_start();
include '../../header.php';
include '../../menu.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>menu_package/menu.php">Menu</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>menu_package/menu_package.php">Menu Package</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>menu_package/fixed_menu/fixed_menu.php">Fixed Menu</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add</li>
            </ol>
        </nav>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>menu_package/fixed_menu/fixed_menu.php"><i class="bi bi-calendar"></i> Search Menu</a>
            </div>
        </div>
    </div>
    <?php
    extract($_POST);
    //var_dump(@$item_id);
    //var_dump($_POST);
    //echo @$action;
    $array_action = explode(".", @$action);
    //echo @$action =$array_action[0];

    //Store selected item data in a session
    @$item_id = $array_action[1];
    if (!empty($item)) {
        foreach (@$item as $value) {
            $db = dbConn();
            $sql = "SELECT i.item_id,i.item_name,i.portion_price,mc.category_name,i.category_id FROM menu_item i INNER JOIN item_category mc ON mc.category_id=i.category_id WHERE i.item_id='$value'";
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
            $_SESSION['selected_items'][$row['item_id']] = array('item_id' => $row['item_id'], 'item_name' => $row['item_name'], 'portion_price' => $row['portion_price'], 'category_id' => $row['category_id'], 'category_name' => $row['category_name']);
        }
        //print_r($_SESSION['selected_items']);
    }

    //Calculate the total price of the selected items
    if (!empty($_SESSION['selected_items'])) {
        @$total_price = 0;
        foreach ($_SESSION['selected_items'] as $unit) {
            @$total_price += $unit['portion_price'];
        }
    }
    
    //check the request method to recognize the data removal from the selected item table
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'remove_item' && !empty(@$item_id)) {
        //echo "remove item";
        //echo @$profit_ratio;
        @$total_price -= $_SESSION['selected_items'][@$item_id]['portion_price'];
        unset($_SESSION['selected_items'][$item_id]);
    }
    
    //check the request method to recognize the data insertion to the database
    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'save') {
        //var_dump($_POST);
        
        //Clean the received inputs before entering the database
        $menu_name = cleanInput($menu_name);
        $profit_ratio = cleanInput($profit_ratio);
        
        //Required Field Validation
        $message = array();
        if (empty($menu_name)) {
            $message['error_menu_name'] = "The Menu Name Should Not Be Blank...";
        }
        if (empty($profit_ratio)) {
            $message['error_profit_ratio'] = "The Profit Ratio Should Not Be Blank...";
        }
        if (!isset($availability)) {
            $message['error_availability'] = "The Service Status Should Be Selected...";
        }
        //var_dump($message);
        
        //Insert data into relevant database tables
        if (empty($message)) {
            $db = dbConn();
            //echo 'Connected..!';
            
            //remove the thousand seperator from the price values before insert into the database
            $total_price = str_replace(',', '', $total_price);
            $final_price = str_replace(',', '', $final_price);
            $userid = $_SESSION['userid'];
            $cDate = date('Y-m-d');
            $sql = "INSERT INTO menu_package(menu_package_name,menu_type_id,total_price,profit_ratio,final_price,availability,add_user,add_date)VALUES('$menu_name','1','$total_price','$profit_ratio','$final_price','$availability','$userid','$cDate')";
            $db->query($sql);

            $menu_package_id = $db->insert_id;
            foreach ($_SESSION['selected_items'] as $units) {
                $item_category_id = $units['category_id'];
                $menu_item_id = $units['item_id'];
                $sql = "INSERT INTO menu_package_item(menu_package_id,category_id,item_id)VALUES('$menu_package_id','$item_category_id','$menu_item_id')";
                //print_r($sql);
                $db->query($sql);
            }

            header('Location:add_success.php?menu_package_id='.$menu_package_id);
            unset($_SESSION['selected_items']);
        }
    }
    ?>
    <div class="row">
        <div class="col-md-1 mb-3"></div>
        <div class="col-md-10 mb-3">
            <div class="card bg-light">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Add a New Menu</h4>
                        </div>
                        <div class="col-md-6" style="text-align:right;">
                            <p class="text-danger text-right">* Required</p>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="font-size:13px;">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="menu_name" class="form-label"><span class="text-danger">*</span> Name</label>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <input type="text" class="form-control" id="menu_name" name="menu_name" value="<?= @$menu_name ?>">
                                        <div class="text-danger"><?= @$message["error_menu_name"] ?></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <?php
                                        if (!empty(@$total_price)) {
                                            $total_price = number_format($total_price, '2', '.', ',');
                                        }
                                        ?>
                                        <label for="total_price" class="form-label">Total Price (Rs.)</label>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <input type="text" readonly class="form-control" id="total_price" name="total_price" value="<?= @$total_price ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="profit_ratio" class="form-label"><span class="text-danger">*</span> Profit Ratio (%)</label>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <?php
                                        @$profit_ratio = number_format($profit_ratio, '2');
                                        ?>
                                        <input type="number" min="0" max="100" class="form-control" id="profit_ratio" name="profit_ratio" onchange="form.submit()" value="<?= @$profit_ratio ?>">
                                        <div class="text-danger"><?= @$message["error_profit_ratio"] ?></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="final_price" class="form-label"> Final Price (Rs.)</label>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <?php
                                        if (!empty(@$total_price) && !empty(@$profit_ratio)) {
                                            $tprice = str_replace(',','',$total_price);
                                            $final_price = $tprice + $tprice * @$profit_ratio / 100;
                                            $final_price = floatval($final_price);
                                            $final_price = number_format($final_price, '2', '.', ',');
                                        }
                                        ?>
                                        <input type="text" class="form-control" id="final_price" name="final_price" value="<?= @$final_price ?>" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label"><span class="text-danger">*</span> Availability</label><br>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="availability" id="available" value="Available" <?php if (isset($availability) && $availability == 'Available') { ?> checked <?php } ?>>
                                                    <label class="form-check-label" for="available">Available</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="availability" id="unavailable" value="Unavailable" <?php if (isset($availability) && $availability == 'Unavailable') { ?> checked <?php } ?>>
                                                    <label class="form-check-label" for="unavailable">Unavailable</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-danger"><?= @$message["error_availability"] ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label for="menu_category" class="form-label"><span class="text-danger">*</span> Category</label>
                                        <select class="form-control form-select" id="menu_category" name="menu_category" onchange="form.submit()" style="font-size:13px;">
                                            <option value="" disabled selected >-Select a Category-</option>
                                            <?php
                                            $db = dbConn();
                                            $sql = "SELECT * from item_category";
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
                                    <div class="col-md-7">
                                        <?php
                                        $item = array();
                                        if (!empty(@$menu_category)) {
                                            $db = dbConn();
                                            $sql = "SELECT item_id,item_name,portion_price FROM menu_item WHERE category_id=$menu_category";
                                            $result = $db->query($sql);

                                            while ($row = $result->fetch_assoc()) {
                                                ?>
                                                <div class="form-check form-check">
                                                    <input class="form-check-input" type="checkbox" id="<?= $row['item_id'] ?>" name="item[]" value="<?= $row['item_id'] ?>" <?php if (isset($item) && in_array($row['item_id'], $item)) { ?>checked <?php } ?>>
                                                    <label class="form-check-label" for="<?= $row['item_id'] ?>" style="font-size:13px;"><?= $row['item_name'] . "-" . $row['portion_price'] ?></label>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
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
                                                if ($_SERVER['REQUEST_METHOD'] == 'POST' && (@$action == 'add_item' || !empty(@$menu_category))) {
                                                    if (!empty($_SESSION['selected_items'])) {
                                                        foreach ($_SESSION['selected_items'] as $unit) {
                                                            ?>

                                                            <tr>
                                                                <td></td>
                                                                <td><?= $unit['category_name'] ?></td>
                                                                <td><?= $unit['item_name'] ?></td>
                                                                <td><?= $unit['portion_price'] ?></td>
                                                                <td>
                                                                    <button type="submit" class="btn btn-sm" onclick="form.submit()" name="action" value="remove_item.<?= $unit['item_id'] ?>"><span data-feather="trash-2"></span></button>
                                                                </td>
                                                            </tr>

                                                            <?php
                                                        }
                                                    }
                                                } else if ($_SERVER['REQUEST_METHOD'] == 'POST' && (@$action == 'remove_item' || !empty(@$menu_category)) && !empty(@$item_id)) {
                                                    //@$vendor_price -= $_SESSION['selected_items'][@$item_id]['item_price'];
                                                    //unset($_SESSION['selected_items'][$item_id]);
                                                    if (!empty($_SESSION['selected_items'])) {
                                                        foreach ($_SESSION['selected_items'] as $unit) {
                                                            ?>
                                                            <tr>
                                                                <td></td>
                                                                <td><?= $unit['category_name'] ?></td>
                                                                <td><?= $unit['item_name'] ?></td>
                                                                <td><?= $unit['portion_price'] ?></td>
                                                                <td>
                                                                    <button type="submit" class="btn btn-sm" onclick="form.submit()" name="action" value="remove_item.<?= $unit['item_id'] ?>"><span data-feather="trash-2"></span></button>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                } else {
                                                    if (!empty($_SESSION['selected_items'])) {
                                                        foreach ($_SESSION['selected_items'] as $unit) {
                                                            ?>
                                                            <tr>
                                                                <td></td>
                                                                <td><?= $unit['category_name'] ?></td>
                                                                <td><?= $unit['item_name'] ?></td>
                                                                <td><?= $unit['portion_price'] ?></td>
                                                                <td>
                                                                    <button type="submit" class="btn btn-sm" onclick="form.submit()" name="action" value="remove_item.<?= $unit['item_id'] ?>"><span data-feather="trash-2"></span></button>
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
                        <div class="row">
                            <div class="col-md-12" style="text-align:right">
                                <button type="submit" class="btn btn-success" style="width:100px;" name="action" value="save">Add</button>
                                <a href="<?= SYSTEM_PATH ?>menu_package/fixed_menu/add.php" class="btn btn-warning" style="width:100px;">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-1 mb-3"></div>
    </div>

</main>
<?php
include '../../footer.php';
ob_end_flush();
?>