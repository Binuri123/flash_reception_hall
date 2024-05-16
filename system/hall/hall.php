<?php
include '../header.php';
include '../menu.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Hall</li>
            </ol>
        </nav>
        <?php
        if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '3') {
            ?>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>hall/add.php"><span data-feather="plus-circle" class="align-text-bottom"></span>New Hall</a>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
    $where = NULL;

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        extract($_POST);
        //var_dump($_POST);
        $hall_name = cleanInput($hall_name);
        $min_cap = cleanInput($min_cap);
        $max_cap = cleanInput($max_cap);

        if (!empty($hall_name)) {
            //Wild card serach perform using like and %% signs
            $where .= " hall_name LIKE '%$hall_name%' AND";
        }
        if (!empty($min_cap) && !empty($max_cap)) {
            $where.=" min_capacity BETWEEN '$min_cap' AND '$max_cap' AND";
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
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <h3>Halls</h3>
        </div>
        <div class="col-md-1"></div>
    </div>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
                <div class="row">
                    <div class="mb-3 col-md-2">
                        <input type="text" class="form-control" placeholder="Name" name="hall_name" value="<?= @$hall_name ?>" style="font-size:13px;">
                    </div>
                    <div class="mb-3 col-md-2">
                        <input type="text" class="form-control" placeholder="Min" name="min_cap" value="<?= @$min_cap ?>" style="font-size:13px;">
                    </div>
                    <div class="mb-3 col-md-2">
                        <input type="text" class="form-control" placeholder="Max" name="max_cap" value="<?= @$max_cap ?>" style="font-size:13px;">
                    </div>
                    <div class="mb-3 col-md-2">
                        <select name="availability" class="form-control form-select" style="font-size:13px;">
                            <option value="" style="text-align:center;">-Status-</option>
                            <option value="Available" <?php if (@$availability == 'Available') { ?> selected <?php } ?>>Available</option>
                            <option value="Unavailable" <?php if (@$availability == 'Unavailable') { ?> selected <?php } ?>>Unavailable</option>
                        </select>
                    </div>
                    <div class="mb-3 col-md-4">
                        <button type="submit" class="btn btn-warning" style="width:100px;font-size:13px;"><i class="bi bi-search"></i> Search</button>
                        <a href="<?= SYSTEM_PATH ?>hall/hall.php" class="btn btn-info" style="width:100px;font-size:13px;"><i class="bi bi-eraser"></i> Clear</a>
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
                $sql = "SELECT * FROM hall $where";
                //print_r($sql);
                $db = dbConn();
                $result = $db->query($sql);
                ?>
                <table class="table table-striped table-sm">
                    <thead class="bg-secondary">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Min Capacity</th>
                            <th scope="col">Max Capacity</th>
                            <th scope="col">Facilities</th>
                            <th scope="col">Availability</th>
                            <?php
                            if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '3') {
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
                                    <td><?= $row['hall_name'] ?></td>
                                    <td><?= $row['min_capacity'] ?></td>
                                    <td><?= $row['max_capacity'] ?></td>
                                    <td>
                                        <?php
                                        if ($row['facilities']) {
                                            echo "<ul>";
                                            $facilities_list = explode(",", $row['facilities']);
                                            foreach ($facilities_list as $value) {
                                                echo "<li>" . $value . "</li>";
                                            }
                                            echo "</ul>";
                                        }
                                        ?>
                                    </td>
                                    <td><?= $row['availability'] ?></td>
                                    <?php
                                    if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '3') {
                                        ?>
                                        <td><a href="edit.php?hall_id=<?= $row['hall_id'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a></td>
                                        <?php
                                    }
                                    ?>
                                    <td><a href="view.php?hall_id=<?= $row['hall_id'] ?>" class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i></a></td>
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
