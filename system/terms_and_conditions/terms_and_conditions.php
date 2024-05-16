<?php
include '../header.php';
include '../menu.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Terms and Conditions</li>
            </ol>
        </nav>
        <?php
        if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '2' || $_SESSION['user_role_id'] == '6') {
            ?>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>terms_and_conditions/add.php"><i class="bi bi-plus-circle"></i> New Policy</a>
                </div>
            </div>
            <?php
        }
        ?>

    </div>
    <?php
    extract($_POST);
    //var_dump($_POST);
    $where = NULL;

    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'search') {
        $policy = cleanInput($policy);

        if (!empty($policy)) {
            //Wild card serach perform using like and %% signs
            $where .= " policy LIKE '%$policy%' AND";
        }

        if (!empty($condition_category)) {
            //Exact Search perform using = sign
            $where .= " category_id ='$condition_category' AND";
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
            <h3>Terms & Conditions</h3>
        </div>
        <div class="col-md-1"></div>
    </div>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
                <div class="row">
                    <div class="mb-3 col-md-4">
                        <input type="text" name="policy" value="<?= @$policy ?>" class="form-control" style="font-size:13px;" placeholder="Enter a Quote From the Policy...">
                    </div>
                    <div class="mb-3 col-md-3">
                        <?php
                        $db = dbConn();
                        $sql = "SELECT * FROM condition_category";
                        $result = $db->query($sql);
                        ?>
                        <select name="condition_category" class="form-control form-select" style="font-size:13px;">
                            <option value="" style="text-align:center">-Category-</option>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['condition_category_id'] ?>" <?php if ($row['condition_category_id'] == @$designation) { ?> selected <?php } ?>><?= $row['condition_category'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3 col-md-3">
                        <button type="submit" class="btn btn-warning btn-sm" name="action" value="search" style="width:100px;font-size:13px;"><i class="bi bi-search"></i> Search</button>
                        <a href="<?= SYSTEM_PATH ?>terms_and_conditions/terms_and_conditions.php" class="btn btn-info btn-sm" style="width:100px;font-size:13px;"><i class="bi bi-eraser"></i> Clear</a>
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
                $sql = "SELECT c.condition_category_id,c.condition_category,p.policy FROM policy p LEFT JOIN condition_category c ON c.condition_category_id = p.category_id $where ORDER BY p.category_id ASC";
                //print_r($sql);
                $db = dbConn();
                $result = $db->query($sql);
                ?>
                <table class="table table-striped table-sm">
                    <thead class="bg-secondary">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Category</th>
                            <th scope="col">Policy</th>
                            <?php
                            if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '2' || $_SESSION['user_role_id'] == '6') {
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
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $row['condition_category'] ?></td>
                                    <td><?= $row['policy'] ?></td>
                                    <?php
                                    if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '2' || $_SESSION['user_role_id'] == '6') {
                                        ?>
                                        <td><a href="<?= SYSTEM_PATH ?>terms_and_conditionsedit.php?hall_id=<?= $row['condition_category_id'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a></td>
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
        <div class="col-md-1"></div>
    </div>
</main>
<?php
include '../footer.php';
?>
