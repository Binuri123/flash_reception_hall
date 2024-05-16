<?php include '../../header.php'; ?>
<?php include '../../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Item Category</li>
            </ol>
        </nav>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>menu_package/item_category/add.php"><span data-feather="plus-circle" class="align-text-bottom"></span>New Category</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <h2>Category List</h2>
        </div>
        <div class="col-md-2"></div>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <?php
            $where = NULL;

            extract($_POST);
            //var_dump($_POST);

            if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'search') {

                if (!empty($category_name)) {
                    $where .= " category_id='$category_name' AND";
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
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
                <div class="row">
                    <div class="mb-3 col-md-4">
                        <select class="form-control form-select" name="category_name">
                            <option value="">- Select a Category -</option>
                            <?php
                            $db = dbConn();
                            $sql1 = "SELECT category_id,category_name FROM item_category";
                            $result1 = $db->query($sql1);
                            if ($result1->num_rows > 0) {
                                while ($row1 = $result1->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row1['category_id'] ?>"  <?php if ($row1['category_id'] == @$category_name) { ?> selected <?php } ?>><?= $row1['category_name'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3 col-md-4">
                        <select name="availability" class="form-control form-select">
                            <option value="">- Status -</option>
                            <option value="Available" <?php if (@$availability == 'Available') { ?> selected <?php } ?>>Available</option>
                            <option value="Unavailable" <?php if (@$availability == 'Unavailable') { ?> selected <?php } ?>>Unavailable</option>
                        </select>
                    </div>
                    <div class="mb-3 col-md-4" style="text-align:left">
                        <button type="submit" name="action" value="search" class="btn btn-warning btn-sm" style="width:100px;"><i class="bi bi-search"></i> Search</button>
                        <button type="submit" name="action" value="clear" class="btn btn-info btn-sm" style="width:100px;"><i class="bi bi-eraser"></i> Clear</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-2"></div>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="table-responsive">
                <?php
                $sql = "SELECT * FROM item_category $where";
                //print_r($sql);
                $db = dbConn();
                $result = $db->query($sql);
                ?>
                <table class="table table-striped table-sm">
                    <thead class="bg-secondary">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Availability</th>
                            <th scope="col"></th>
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
                                    <td><?= $row['category_name'] ?></td>
                                    <td><?= $row['availability'] ?></td>
                                    <td><a href="edit.php?category_id=<?= $row['category_id'] ?>" class="btn btn-warning btn-sm"><span data-feather="edit" class="align-text-bottom"></span></a></td>
                                    <td><a href="view.php?category_id=<?= $row['category_id'] ?>" class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i></a></td>
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
        <div class="col-md-2"></div>
    </div>
</main>

<?php include '../../footer.php'; ?>
