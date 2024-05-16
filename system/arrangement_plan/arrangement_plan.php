<?php
include '../header.php';
include '../menu.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Arrangement Plan</li>
            </ol>
        </nav>
    </div>
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-3">
                <a href="<?= SYSTEM_PATH ?>arrangement_plan/requests.php" style="text-decoration:none;color:white">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <?php
                            $db = dbConn();
                                $sql = "SELECT count(*) as request_count FROM arrangement_plan WHERE arrangement_status_id='1'";
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $request_count = $row['request_count'];
                            ?>
                            <h4># Requests<br><?= $request_count ?></h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= SYSTEM_PATH ?>arrangement_plan/in_progress.php" style="text-decoration:none;color:white">
                    <div class="card bg-warning text-white">
                        <div class="card-body text-center">
                            <?php
                            $db = dbConn();
                                $sql = "SELECT count(*) as pending_count FROM arrangement_plan WHERE arrangement_status_id='2'";
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $pending_count = $row['pending_count'];
                            ?>
                            <h4># In Progress<br><?= $pending_count ?></h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= SYSTEM_PATH ?>arrangement_plan/completed.php" style="text-decoration:none;color:white">
                    <div class="card bg-info text-white">
                        <div class="card-body text-center">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT count(*) as completed_count FROM arrangement_plan WHERE arrangement_status_id='3'";
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $completed_count = $row['completed_count'];
                            ?>
                            <h4># Completed<br><?= $completed_count ?></h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</main>

<?php include '../footer.php'; ?>
