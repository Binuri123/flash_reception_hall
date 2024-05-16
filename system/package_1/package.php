<?php
include '../header.php';
include '../menu.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Package</li>
            </ol>
        </nav>
        <?php
        if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '2') {
            ?>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>package/add.php"><i class="bi bi-plus-circle"></i> New Package</a>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
    extract($_POST);
    $message = array();
    $where = NULL;

    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'search') {
        //var_dump($_POST);
        $package_name = cleanInput($package_name);
        $min_price = cleanInput($min_price);
        $max_price = cleanInput($max_price);

        if (!empty($package_name)) {
            //Wild card serach perform using like and %% signs
            $where .= " package_name LIKE '%$package_name%' AND";
        }
        if (!empty($event_type)) {
            //Exact Search perform using = sign
            $where .= " p.event_id ='$event_type' AND";
        }

        if (!empty($min_price) && empty($price) || !empty($max_price) && empty($price) || !empty($min_price) && !empty($max_price_price) && empty($price)) {
            $message['error_price'] = "To Filter Through the Price You should Select the Price Category";
        } else {
            if (!empty($price) && $price == 'total_price') {
                if (!empty($min_price) && !empty($max_price)) {
                    $where.=" total_price BETWEEN '$min_price' AND '$max_price' AND";
                } elseif (!empty($min_price) && empty($max_price)) {
                    $where.=" total_price BETWEEN '$min_price' AND (SELECT MAX(total_price) FROM package) AND";
                } elseif (empty($min_price) && !empty($max_price)) {
                    $where.=" total_price BETWEEN (SELECT MIN(total_price) FROM package) AND '$max_price' AND";
                } elseif (empty($min_price) && empty($max_price)) {
                    $message['error_price'] = "To filter by the price Enter a Range";
                }
            }
            if (!empty($price) && $price == 'display_price') {
                if (!empty($min_price) && !empty($max_price)) {
                    $where.=" display_price BETWEEN '$min_price' AND '$max_price' AND";
                } elseif (!empty($min_price) && empty($max_price)) {
                    $where.=" display_price BETWEEN '$min_price' AND (SELECT MAX(display_price) FROM package) AND";
                } elseif (empty($min_price) && !empty($max_price)) {
                    $where.=" display_price BETWEEN (SELECT MIN(display_price) FROM package) AND '$max_price' AND";
                } elseif (empty($min_price) && empty($max_price)) {
                    $message['error_price'] = "To filter by the price Enter a Range";
                }
            }
            if (!empty($price) && $price == 'plate_price') {
                if (!empty($min_price) && !empty($max_price)) {
                    $where.=" plate_price BETWEEN '$min_price' AND '$max_price' AND";
                } elseif (!empty($min_price) && empty($max_price)) {
                    $where.=" plate_price BETWEEN '$min_price' AND (SELECT MAX(plate_price) FROM package) AND";
                } elseif (empty($min_price) && !empty($max_price)) {
                    $where.=" plate_price BETWEEN (SELECT MIN(plate_price) FROM package) AND '$max_price' AND";
                } elseif (empty($min_price) && empty($max_price)) {
                    $message['error_price'] = "To filter by the price Enter a Range";
                }
            }
        }
        if (!empty($availability)) {
            //Exact Search perform using = sign
            $where .= " availability ='$availability' AND";
        }

        if (!empty($where)) {
            $where = substr($where, 0, -3);
            $where = " WHERE $where";
        }
    }
    ?>
    <div class="row">
        <div class="col-md-12">
            <h3>Package List</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
                <div class="row">
                    <div class="mb-3 col-md-3">
                        <input type="text" class="form-control" placeholder="Name" name="package_name" value="<?= @$package_name ?>" style="font-size:13px;">
                    </div>
                    <div class="mb-3 col-md-3">
                        <select name="event_type" class="form-control form-select" style="font-size:13px;">
                            <option value="" style="text-align:center">-Event Type-</option>
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM event";
                            $result = $db->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['event_id'] ?>" <?php if ($row['event_id'] == @$event_type) { ?> selected <?php } ?>><?= $row['event_name'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3 col-md-3">
                        <select name="availability" class="form-control form-select" style="font-size:13px;">
                            <option value="" style="text-align:center">-Status-</option>
                            <option value="Available" <?php if (@$availability == 'Available') { ?> selected <?php } ?>>Available</option>
                            <option value="Unavailable" <?php if (@$availability == 'Unavailable') { ?> selected <?php } ?>>Unavailable</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-3">
                        <select name="price" class="form-control form-select" style="font-size:13px">
                            <option value="" style="text-align:center">-Price-</option>
                            <option value="total_price" <?php if (@$price == 'total_price') { ?> selected <?php } ?>>Total Price</option>
                            <option value="display_price" <?php if (@$price == 'display_price') { ?> selected <?php } ?>>Display Price</option>
                            <option value="per_person_price" <?php if (@$price == 'plate_price') { ?> selected <?php } ?>>Plate Price</option>
                        </select>
                        <div class="text-danger"><?= @$message["error_price"] ?></div>
                    </div>
                    <div class="mb-3 col-md-3">
                        <input type="text" class="form-control" placeholder="Min" name="min_price" value="<?= @$min_price ?>" style="font-size:13px">
                    </div>
                    <div class="mb-3 col-md-3">
                        <input type="text" class="form-control" placeholder="Max" name="max_price" value="<?= @$max_price ?>" style="font-size:13px">
                    </div>
                    <div class="mb-3 col-md-3">
                        <button type="submit" name="action" value="search" class="btn btn-warning btn-sm" style="font-size:13px;width:100px;"><i class="bi bi-search"></i> Search</button>
                        <a href="<?= SYSTEM_PATH ?>package/package.php" class="btn btn-info btn-sm" style="font-size:13px;width:100px;"><i class="bi bi-eraser"></i> Clear</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <?php
                $sql = "SELECT * FROM package p INNER JOIN event e ON e.event_id=p.event_id $where";
                //print_r($sql);
                $db = dbConn();
                $result = $db->query($sql);
                ?>
                <table class="table table-striped table-sm">
                    <thead class="bg-secondary">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Event Type</th>
                            <?php
                            if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '2') {
                                ?>
                                <th scope="col">Total Price</th>
                                <?php
                            }
                            ?>
                            <th scope="col">Display Price</th>
                            <th scope="col">Per Person Price</th>
                            <th scope="col">Availability</th>
                            <?php
                            if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '2') {
                                ?>
                                <th scope="col"></th>
                                <?php
                            }
                            ?>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            $i = 1;
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $row['package_name'] ?></td>
                                    <td><?= $row['event_name'] ?></td>
                                    <?php
                                    if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '2') {
                                        ?>
                                        <td><?= number_format($row['total_price'], '2', '.', ',') ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td><?= number_format($row['display_price'], '2', '.', ',') ?></td>
                                    <td><?= number_format($row['per_person_price'], '2', '.', ',') ?></td>
                                    <td><?= $row['availability'] ?></td>
                                    <?php
                                    if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '2') {
                                        ?>
                                        <td><a href="edit.php?package_id=<?= $row['package_id'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a></td>
                                        <?php
                                    }
                                    ?>
                                    <td><a href="view.php?package_id=<?= $row['package_id'] ?>" class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i></a></td>
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
    </div>
</main>

<?php include '../footer.php'; ?>
