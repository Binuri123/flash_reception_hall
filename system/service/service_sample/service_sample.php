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
                <li class="breadcrumb-item active" aria-current="page">Service Samples</li>
            </ol>
        </nav>
        <?php
        if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '6' || $_SESSION['user_role_id'] == '2' || $_SESSION['user_role_id'] == '3') {
            ?>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>service/service_sample/add.php"><i class="bi bi-plus-circle"></i> New Sample</a>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3>Sample List</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped table-sm" style="font-size:13px;">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <th>#</th>
                            <th scope="col">Service</th>
                            <th scope="col">Sample Name</th>
                            <th scope="col">Sample Image</th>
                            <th scope="col">Availability</th>
                            <?php
                            if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '6' || $_SESSION['user_role_id'] == '2' || $_SESSION['user_role_id'] == '3') {
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
                        $sql = "SELECT * FROM service_samples ss "
                                . "LEFT JOIN service s ON s.service_id=ss.service_id "
                                . "LEFT JOIN sub_service sc ON sc.sub_service_id=ss.sub_service_id "
                                . "ORDER BY sc.sub_service_id ASC";
                        //print_r($sql);
                        $db = dbConn();
                        $result = $db->query($sql);
                        if ($result->num_rows > 0) {
                            $i = 1;
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $row['service_name'] ?></td>
                                    <td><?= $row['sample_name'] ?></td>
                                    <td>
                                        <img src="../../assets/images/service_sample/<?= $row['sample_image'] ?>" style="width:100px;height:100px;">
                                    </td>
                                    <td><?= $row['availability'] ?></td>
                                    <?php
                                    if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '6') {
                                        ?>
                                        <td><a href="edit.php?sample_id=<?= $row['service_sample_id'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a></td>
                                        <?php
                                    }
                                    ?>
                                    <td><a href="view.php?sample_id=<?= $row['service_sample_id'] ?>" class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i></a></td>
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
<?php include '../../footer.php'; ?>
