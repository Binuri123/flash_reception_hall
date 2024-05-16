<?php
include '../header.php';
include '../menu.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>tax_and_discounts/tax_and_discounts.php">Tax and Discounts</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tax</li>
            </ol>
        </nav>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>tax_and_discounts/add.php"><i class="bi bi-plus-circle"></i> New Tax</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <h3>Tax</h3>
        </div>
        <div class="col-md-4"></div>
    </div>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="table-responsive">
                <?php
                $sql = "SELECT * FROM tax";
                //print_r($sql);
                $db = dbConn();
                $result = $db->query($sql);
                ?>
                <table class="table table-striped table-sm">
                    <thead class="bg-secondary">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tax Rate</th>
                            <th scope="col">Limit</th>
                            <?php
                            if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '6' || $_SESSION['user_role_id'] == '4') {
                                ?>
                                <th></th>
                                <?php
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            //Load the data accordingly to the query
                            $i = 1;
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $row['tax_rate'] ?></td>
                                    <td><?= $row['amount'] ?></td>
                                    <?php
                                    if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '6' || $_SESSION['user_role_id'] == '4') {
                                        ?>
                                        <td><a href="<?= SYSTEM_PATH ?>tax_and_discounts/tax_edit.php?tax_id=<?= $row['tax_id'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a></td>
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
        <div class="col-md-4"></div>
    </div>
</main>
<?php
include '../footer.php';
?>