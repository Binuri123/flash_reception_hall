<?php
include '../header.php';
include '../menu.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="btn-toolbar mb-2 mb-md-0">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>service/service.php">Service</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Services</li>
                </ol>
            </nav>
        </div>
        <?php
        if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '2' || $_SESSION['user_role_id'] == '3') {
            ?>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>service/add.php"><i class="bi bi-plus-circle"></i> New Service</a>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
    extract($_POST);
    //var_dump($_POST);
    $message = array();
    $where = NULL;

    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'search') {
        $service_name = cleanInput($service_name);
        $min_price = cleanInput($min_price);
        $max_price = cleanInput($max_price);

        if (!empty($service_name)) {
            //Wild card serach perform using like and %% signs
            $where .= " s.service_name LIKE '%$service_name%' AND";
        }
        if (!empty($availability)) {
            //Exact Search perform using = sign
            $where .= " s.availability ='$availability' AND";
        }
        if (!empty($addon_status)) {
            //Exact Search perform using = sign
            $where .= " s.addon_status ='$addon_status' AND";
        }
        if (!empty($category)) {
            $where .= " sc.category_id ='$category' AND";
        }

        if (!empty($min_price) && empty($price) || !empty($max_price) && empty($price) || !empty($min_price) && !empty($max_price_price) && empty($price)) {
            $message['error_price'] = "To Filter Through the Price You should Select the Price Category";
        } else {
            if (!empty($price) && $price == 'service_price') {
                if (!empty($min_price) && !empty($max_price)) {
                    $where.=" service_price BETWEEN '$min_price' AND '$max_price' AND";
                } elseif (!empty($min_price) && empty($max_price)) {
                    $where.=" service_price BETWEEN '$min_price' AND (SELECT MAX(service_price) FROM service) AND";
                } elseif (empty($min_price) && !empty($max_price)) {
                    $where.=" service_price BETWEEN (SELECT MIN(service_price) FROM service) AND '$max_price' AND";
                } elseif (empty($min_price) && empty($max_price)) {
                    $message['error_price'] = "To filter by the price Enter a Range";
                }
            }
            if (!empty($price) && $price == 'final_price') {
                if (!empty($min_price) && !empty($max_price)) {
                    $where.=" final_price BETWEEN '$min_price' AND '$max_price' AND";
                } elseif (!empty($min_price) && empty($max_price)) {
                    $where.=" final_price BETWEEN '$min_price' AND (SELECT MAX(final_price) FROM service) AND";
                } elseif (empty($min_price) && !empty($max_price)) {
                    $where.=" final_price BETWEEN (SELECT MIN(final_price) FROM service) AND '$max_price' AND";
                } elseif (empty($min_price) && empty($max_price)) {
                    $message['error_price'] = "To filter by the price Enter a Range";
                }
            }
        }

        if (!empty($where)) {
            $where = substr($where, 0, -3);
            $where = " WHERE $where";
        }
    }
    ?>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <h3>Services List</h3>
        </div>
        <div class="col-md-1"></div>
    </div>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
                <div class="row">
                    <div class="mb-3 col-md-3">
                        <input type="text" class="form-control" placeholder="Name" name="service_name" value="<?= @$service_name ?>" style="font-size:13px">
                    </div>
                    <div class="mb-3 col-md-3">
                        <select name="availability" class="form-control form-select" style="font-size:13px">
                            <option value="" style="text-align:center">-Availability Status-</option>
                            <option value="Available" <?php if (@$availability == 'Available') { ?> selected <?php } ?>>Available</option>
                            <option value="Unavailable" <?php if (@$availability == 'Unavailable') { ?> selected <?php } ?>>Unavailable</option>
                        </select>
                    </div>
                    <div class="mb-3 col-md-3">
                        <select name="addon_status" class="form-control form-select" style="font-size:13px">
                            <option value="" style="text-align:center">-Additional Status-</option>
                            <option value="Yes" <?php if (@$addon_status == 'Yes') { ?> selected <?php } ?>>Approved</option>
                            <option value="No" <?php if (@$addon_status == 'No') { ?> selected <?php } ?>>Unapproved</option>
                        </select>
                    </div>
                    <div class="mb-3 col-md-3">
                        <select name="category" class="form-control form-select" style="font-size:13px">
                            <option value="" style="text-align:center">-Category-</option>
                            <?php
                            $db = dbConn();
                            $sql_sc = "SELECT * FROM service_category";
                            $result_sc = $db->query($sql_sc);
                            while ($row_sc = $result_sc->fetch_assoc()) {
                                ?>
                                <option value=<?= $row_sc['category_id']; ?> <?php if ($row_sc['category_id'] == @$category) { ?> selected <?php } ?>><?= $row_sc['category_name'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-4">
                        <select name="price" class="form-control form-select" style="font-size:13px">
                            <option value="" style="text-align:center">-Price-</option>
                            <option value="service_price" <?php if (@$price == 'service_price') { ?> selected <?php } ?>>Service Price</option>
                            <option value="final_price" <?php if (@$price == 'final_price') { ?> selected <?php } ?>>Final Price</option>
                        </select>
                        <div class="text-danger"><?= @$message["error_price"] ?></div>
                    </div>
                    <div class="mb-3 col-md-2">
                        <input type="text" class="form-control" placeholder="Min" name="min_price" value="<?= @$min_price ?>" style="font-size:13px">
                    </div>
                    <div class="mb-3 col-md-2">
                        <input type="text" class="form-control" placeholder="Max" name="max_price" value="<?= @$max_price ?>" style="font-size:13px">
                    </div>
                    <div class="mb-3 col-md-4">
                        <button type="submit" name="action" value="search" class="btn btn-warning btn-sm" style="width:100px;font-size:13px"><i class="bi bi-search"></i> Search</button>
                        <a href="<?= SYSTEM_PATH ?>service/services.php" class="btn btn-info btn-sm" style="width:100px;font-size:13px"><i class="bi bi-eraser"></i> Clear</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-1"></div>
    </div>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="table-responsive">
                <?php
                $sql = "SELECT s.service_id, s.service_name,s.addon_status, s.service_price, s.profit_ratio, s.final_price, s.availability, sc.category_name, sc.category_id "
                        . "FROM service s LEFT JOIN service_category sc ON sc.category_id=s.category_id $where ORDER BY s.category_id";
                //print_r($sql);
                $db = dbConn();
                $result = $db->query($sql);
                ?>
                <table class="table table-striped table-sm" style="font-size:13px;">
                    <thead class="bg-secondary text-white">
                        <tr style="text-align:center;">
                            <th scope="col">#</th>
                            <th scope="col">Category</th>
                            <th scope="col">Service Name</th>
                            <th scope="col">Addon Approved</th>
                            <?php
                            if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '2' || $_SESSION['user_role_id'] == '3') {
                                ?>
                                <th scope="col" style="text-align:right;">Service Price(Rs.)</th>
                                <?php
                            }
                            ?>

                            <th scope="col" style="text-align:right;">Final Price(Rs.)</th>
                            <th scope="col">Availability</th>
                            <?php
                            if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '2' || $_SESSION['user_role_id'] == '3') {
                                ?>
                                <th></th>
                                <?php
                            }
                            ?>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            $i = 1;
                            while ($row = $result->fetch_assoc()) {
                                //var_dump($row);
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $row['category_name'] ?></td>
                                    <td><?= $row['service_name'] ?></td>
                                    <td style="text-align:center;"><?= $row['addon_status'] ?></td>
                                    <?php
                                    if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '2' || $_SESSION['user_role_id'] == '3') {
                                        ?>
                                        <td style="text-align:right;"><?= number_format($row['service_price'],'2','.',',') ?></td>
                                        <?php
                                    }
                                    ?>
                                    
                                        <td style="text-align:right;"><?= number_format($row['final_price'],'2','.',',') ?></td>
                                    <td style="text-align:center;"><?= $row['availability'] ?></td>
                                    <?php
                                    if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '2' || $_SESSION['user_role_id'] == '3') {
                                        ?>
                                        <td><a href="<?= SYSTEM_PATH ?>service/edit.php?service_id=<?= $row['service_id'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a></td>
                                        <?php
                                    }
                                    ?>
                                    
                                    <td><a href="<?= SYSTEM_PATH ?>service/view.php?service_id=<?= $row['service_id'] ?>" class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i></a></td>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
</main>
<?php include '../footer.php'; ?>
