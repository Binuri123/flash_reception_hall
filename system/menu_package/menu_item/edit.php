<?php
ob_start();
include '../../header.php';
include '../../menu.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="btn-toolbar mb-2 mb-md-0">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>menu_package/menu.php">Menu</a></li>
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>menu_package/menu_item/menu_item.php">Menu Item</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Update</li>
                </ol>
            </nav>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>menu_package/menu_item/menu_item.php"><i class="bi bi-calendar"></i> Search Item</a>
            </div>
        </div>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        extract($_GET);
        //var_dump($_GET);
        $db = dbConn();
        $sql = "SELECT mc.category_id,i.item_name,i.availability,i.item_price,i.profit_ratio,i.portion_price,i.item_image,i.addon_status,a.additional_ratio,a.addon_price "
                . "FROM menu_item i LEFT JOIN item_category mc ON mc.category_id=i.category_id LEFT JOIN additional_allowed_item a ON a.item_id=i.item_id WHERE i.item_id = '$item_id'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                //var_dump($row);
                $item_category = $row['category_id'];
                $item_name = $row['item_name'];
                $availability = $row['availability'];
                $item_price = $row['item_price'];
                $profit_ratio = $row['profit_ratio'];
                $portion_price = $row['portion_price'];
                $item_image = $row['item_image'];
                $addon_status = $row['addon_status'];
                $additional_ratio = $row['additional_ratio'];
                $addon_price = $row['addon_price'];
            }
        }
    }

    extract($_POST);

    //check the request method
    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'save_changes') {
        //extract the array
        // Assign cleaned values to the variables
        $item_name = cleanInput($item_name);
        $item_price = cleanInput($item_price);
        $profit_ratio = cleanInput($profit_ratio);
        $portion_price = cleanInput($portion_price);
        $additional_ratio = cleanInput($additional_ratio);
        $addon_price = cleanInput($addon_price);

        //Required Field and Input Format Validation
        $message = array();
        if (empty($item_category)) {
            $message['error_item_category'] = "The Menu Item Category Should be Selected...";
        }
        if (empty($item_name)) {
            $message['error_item_name'] = "The Menu Item Name Should not be Blank...";
        }
        if (!isset($availability)) {
            $message['error_availability'] = "The Menu Item Status Should be Selected...";
        }
        if (empty($item_price)) {
            $message['error_item_price'] = "The Menu Item Price Should not be Blank...";
        }
        if (empty($profit_ratio)) {
            $message['error_profit_ratio'] = "The Profit Ratio Should not be Blank...";
        }
        if (!isset($addon_status)) {
            $message['error_addon_status'] = "The Addon Status Should be Selected...";
        } elseif ($addon_status == 'Yes') {
            if (empty($additional_ratio)) {
                $message['error_additional_ratio'] = "The Additional Ratio Should not be Blank...";
            } else {
                if ($additional_ratio < 0) {
                    $message['error_additional_ratio'] = "The Additional Ratio Cannot be Negative";
                }
            }

            if (!empty($addon_price)) {
                $addon_price = str_replace(',', '', $addon_price);
            }
        }

        //Advance Validation
        if (!empty($item_price)) {
            if (!is_numeric($item_price)) {
                $message['error_item_price'] = "The Menu Item Price Invalid...";
            } elseif ($item_price < 0) {
                $message['error_item_price'] = "The Menu Item Price Cannot be Negative...";
            }
        }

        if (!empty($profit_ratio)) {
            if ($profit_ratio < 0) {
                $message['error_profit_ratio'] = "The profit Ratio Cannot be Negative";
            }
        }

        $item_price = str_replace(',', '', $item_price);
        $portion_price = str_replace(',', '', $portion_price);

        //Get the uploaded file
        if (empty($message)) {
            if (!empty($_FILES['item_image']['name'])) {
                $item_image = uploadFiles("item_image", $item_name . uniqid(), "../../assets/images/menu_item_images/");
                $item_image_name = $item_image['file_name'];
                if (!empty($item_image['error_message'])) {
                    $message['error_item_image'] = $item_image['error_message'];
                }
            } else {
                $item_image_name = $prev_image;
            }
        }

        if (empty($message)) {
            $db = dbConn();
            //echo 'Connected..!';
            $sql = "SELECT mc.category_id,i.item_name,i.availability,i.item_price,i.profit_ratio,i.portion_price,i.item_image,i.addon_status,a.additional_ratio,a.addon_price "
                    . "FROM menu_item i LEFT JOIN item_category mc ON mc.category_id=i.category_id LEFT JOIN additional_allowed_item a ON a.item_id=i.item_id WHERE i.item_id = '$item_id'";
            $result = $db->query($sql);
            $row = $result->fetch_assoc();

            $updated_fields = getUpdatedFields($row, $_POST);
            //var_dump($updated_fields);
            $updated_fields_string = implode(',', $updated_fields);

            $userid = $_SESSION['userid'];
            $cDate = date('Y-m-d');
            $sql = "UPDATE menu_item SET category_id='$item_category',item_name='$item_name',availability='$availability',item_price='$item_price',profit_ratio='$profit_ratio',portion_price='$portion_price',item_image='$item_image_name',addon_status='$addon_status',update_user='$userid',update_date='$cDate' WHERE item_id='$item_id'";
            $db->query($sql);

            if ($addon_status == 'Yes') {
                $sql = "UPDATE additional_allowed_item SET item_id = '$item_id',additional_ratio='$additional_ratio',addon_price='$addon_price')";
                $db->query($sql);
            } elseif ($addon_status == 'No') {
                $sql = "DELETE FROM additional_allowed_item WHERE item_id='$item_id'";
                $db->query($sql);
            }
            header('Location:edit_success.php?item_id=' . $item_id . '&values=' . urlencode($updated_fields_string));
        }
    }
    ?>
    <div class="row">
        <div class="mb-3 col-md-1"></div>
        <div class="mb-3 col-md-10">
            <div class="card bg-light">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Update Item</h4>
                        </div>
                        <div class="col-md-6" style="text-align:right">
                            <p class="text-danger text-right">* Required</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label for="item_category" class="form-label"><span class="text-danger">*</span> Category</label>
                                    </div>
                                    <div class="mb-3 col-md-8">  
                                        <select class="form-control form-select" id="item_category" name="item_category" style="font-size:13px;">
                                            <option value="">-Select a Category-</option>
<?php
$db = dbConn();
$sql1 = "SELECT category_id,category_name from item_category WHERE availability = 'Available'";
$result = $db->query($sql1);
while ($row = $result->fetch_assoc()) {
    ?>
                                                <option value=<?= $row['category_id']; ?> <?php if ($row['category_id'] == @$item_category) { ?>selected <?php } ?>><?= $row['category_name'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <div class="text-danger"><?= @$message["error_item_category"] ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label for="item_name" class="form-label"><span class="text-danger">*</span> Name</label>
                                    </div>
                                    <div class="mb-3 col-md-8">
                                        <input type="text" class="form-control" id="item_name" name="item_name" value="<?= @$item_name ?>">
                                        <div class="text-danger"><?= @$message["error_item_name"] ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label"><span class="text-danger">*</span> Availability</label><br>
                                    </div>
                                    <div class="mb-3 col-md-8">
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
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label for="item_price" class="form-label"><span class="text-danger">*</span> Price (Rs.)</label>
                                    </div>
                                    <div class="mb-3 col-md-8">
<?php
if (!empty($item_price)) {
    $item_price = number_format($item_price, '2', '.', ',');
}
?>
                                        <input type="text" class="form-control" id="item_price" name="item_price" value="<?= @$item_price ?>">
                                        <div class="text-danger"><?= @$message["error_item_price"] ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class=" mb-3 col-md-4">
                                        <label class="form-label" for="profit_ratio"><span class="text-danger">*</span> Profit Ratio (%)</label>
                                    </div>
                                    <div class="mb-3 col-md-8">
<?php
if (!empty($profit_ratio)) {
    $profit_ratio = number_format($profit_ratio, '2');
}
?>
                                        <input type="number" min="0" max="100" class="form-control" name="profit_ratio" value="<?= @$profit_ratio ?>" id="profit_ratio" onchange="form.submit()">
                                        <div class="text-danger"><?= @$message["error_profit_ratio"] ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label for="portion_price" class="form-label">Portion Price (Rs.)</label>
                                    </div>
                                    <div class="mb-3 col-md-8">
<?php
if (!empty($item_price) && is_numeric($profit_ratio)) {
    $portion_price = $item_price + ($item_price * $profit_ratio) / 100;
    $portion_price = number_format($portion_price, '2', '.', ',');
}
?>
                                        <input type="text" class="form-control" id="portion_price" name="portion_price" value="<?= @$portion_price ?>">
                                        <div class="text-danger"><?= @$message["error_portion_price"] ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label for="item_image" class="form-label">Image</label>
                                    </div>
                                    <div class="mb-3 col-md-8">
                                        <input type="file" name="item_image" id="item_image" class="form-control">
<?php
if (!empty($item_image)) {
    $prev_image = $item_image;
} elseif (!empty($prev_image)) {
    $prev_image = $prev_image;
} else {
    $prev_image = 'noImage.png';
}
?>
                                        <input type="hidden" name="prev_image" value="<?= @$prev_image ?>">
                                        <div>Upload png, jpg, jpeg files only. (Maximum 2MB)</div>
                                        <div class="text-danger"><?= @$message["error_item_image"] ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label"><span class="text-danger">*</span> Approved as Additional</label>
                                    </div>
                                    <div class="mb-3 col-md-8">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="mt-3 form-check form-check-inline">
                                                    <input class="form-check-input" onchange="form.submit()" type="radio" name="addon_status" id="approved" value="Yes" <?php if (isset($addon_status) && $addon_status == 'Yes') { ?> checked <?php } ?>>
                                                    <label class="form-check-label" for="approved">Yes</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mt-3 form-check form-check-inline">
                                                    <input class="form-check-input" onchange="form.submit()" type="radio" name="addon_status" id="unapproved" value="No" <?php if (isset($addon_status) && $addon_status == 'No') { ?> checked <?php } ?>>
                                                    <label class="form-check-label" for="unapproved">No</label>
                                                </div>
                                            </div>
                                            <div class="mb-3 col-md-6"></div>
                                        </div>
                                        <div class="text-danger"><?= @$message["error_addon_status"] ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
<?php
if (!empty($addon_status) && @$addon_status == 'Yes') {
    ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label" for="additional_ratio"><span class="text-danger">*</span> Additional Ratio (%)</label>
                                        </div>
                                        <div class="mb-3 col-md-8">
    <?php
    if (!empty($additional_ratio)) {
        $additional_ratio = number_format($additional_ratio, '2');
    }
    ?>
                                            <input type="number" min="0" max="100" class="form-control" name="additional_ratio" value="<?= @$additional_ratio ?>" id="additional_ratio" onchange="form.submit()">
                                            <div class="text-danger"><?= @$message["error_additional_ratio"] ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label" for="addon_price">Price As an Addon (Rs.)</label>
                                        </div>
                                        <div class="mb-3 col-md-8">
    <?php
    if (!empty($portion_price) && !empty($additional_ratio) && is_numeric($additional_ratio)) {
        $addon_price = $portion_price + ($portion_price * $additional_ratio) / 100;
        $addon_price = number_format($addon_price, '2', '.', ',');
    }
    ?>
                                            <input type="text" class="form-control" name="addon_price" value="<?= @$addon_price ?>" id="addon_price" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
    <?php
}
?>
                        <div class="row">
                            <div class="mb-3 col-md-12" style="text-align:right">
                                <input type="hidden" name="item_id" value="<?= @$item_id ?>">
                                <button type="submit" name="action" value="save_changes" class="btn btn-success" style="width:150px;">Save Changes</button>
                                <a href="<?= SYSTEM_PATH ?>menu_package/menu_item/edit.php?item_id=<?= @$item_id ?>" class="btn btn-warning" style="width:150px;">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="mb-3 col-md-1"></div>
    </div>
</main>

<?php include '../../footer.php'; ?>
<?php
ob_end_flush()?>