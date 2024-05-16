<?php
include '../../header.php';
include '../../menu.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>service/service.php">Service</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sub Service</li>
            </ol>
        </nav>
        <?php
        if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '6' || $_SESSION['user_role_id'] == '2' || $_SESSION['user_role_id'] == '3') {
            ?>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>service/sub_service/add.php"><i class="bi bi-plus-circle"></i> New Sub Service</a>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <h3>Sub Service List</h3>
        </div>
        <div class="col-md-4"></div>
    </div>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="table-responsive">
                <table class="table table-striped table-sm" style="font-size:13px;">
                    <thead class="bg-secondary text-white">
                        <tr style="text-align:left;">
                            <th>#</th>
                            <th scope="col">Sub Service Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM sub_service";
                        //print_r($sql);
                        $db = dbConn();
                        $result = $db->query($sql);
                        if ($result->num_rows > 0) {
                            $i = 1;
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td style="text-align:left;"><?= $row['sub_service_name'] ?></td>
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
<?php include '../../footer.php'; ?>
