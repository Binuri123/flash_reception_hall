<?php
include '../../header.php';
include '../../menu.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="btn-toolbar mb-2 mb-md-0">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>service/service.php">Service</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Service Category</li>
                </ol>
            </nav>
        </div>
        <?php
        if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '2' || $_SESSION['user_role_id'] == '3') {
            ?>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>service/service_category/add.php"><i class="bi bi-plus-circle"></i> New Category</a>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
    extract($_POST);
    $where = NULL;

    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'search') {

        //var_dump($_POST);
        $cat_name = cleanInput($cat_name);

        if (!empty($cat_name)) {
            //Wild card serach perform using like and %% signs
            $where .= " category_name LIKE '%$cat_name%' AND";
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
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h3>Category List</h3>
        </div>
        <div class="col-md-3"></div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
                <div class="row">
                    <div class="mb-3 col-md-4">
                        <input type="text" class="form-control" placeholder="Name" name="cat_name" value="<?= @$cat_name ?>" style="font-size:13px">
                    </div>
                    <div class="mb-3 col-md-3">
                        <select name="availability" class="form-control form-select" style="font-size:13px;">
                            <option value="" style="text-align:center">-Status-</option>
                            <option value="Available" <?php if (@$availability == 'Available') { ?> selected <?php } ?>>Available</option>
                            <option value="Unavailable" <?php if (@$availability == 'Unavailable') { ?> selected <?php } ?>>Unavailable</option>
                        </select>
                    </div>
                    <div class="mb-3 col-md-5">
                        <button type="submit" name="action" value="search" class="btn btn-warning" style="width:100px;font-size:13px"><i class="bi bi-search"></i> Search</button>
                        <a href="<?= SYSTEM_PATH ?>service/service_category/service_category.php" class="btn btn-info" style="width:100px;font-size:13px"><i class="bi bi-eraser"></i> Clear</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="table-responsive">
                <?php
                $sql = "SELECT * FROM service_category $where";
                //print_r($sql);
                $db = dbConn();
                $result = $db->query($sql);
                ?>
                <table class="table table-striped table-sm">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Availability</th>
                            <?php
                            if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '2' || $_SESSION['user_role_id'] == '3') {
                                ?>
                                <th scope="col"></th>
                                <?php
                            }
                            ?>
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
                                    <td><?= $row['availability'] ?></td>
                                    <?php
                                    if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '2' || $_SESSION['user_role_id'] == '3') {
                                        ?>
                                        <td><a href="<?= SYSTEM_PATH ?>service/service_category/edit.php?category_id=<?= $row['category_id'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a></td>
                                        <?php
                                    }
                                    ?>
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
        <div class="col-md-3"></div>
    </div>
</main>
<?php include '../../footer.php'; ?>
