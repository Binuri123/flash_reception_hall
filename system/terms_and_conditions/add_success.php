<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="btn-toolbar mb-2 mb-md-0">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>terms_and_conditions/terms_and_conditions.php">Terms and Conditions</a></li>
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>terms_and_conditions/add.php">Add</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Success</li>
                </ol>
            </nav>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a class="btn btn-sm btn-outline-success" href="<?=SYSTEM_PATH?>terms_and_conditions/add.php"><i class="bi bi-plus-circle"></i> New Policy</a>
                <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>terms_and_conditions/terms_and_conditions.php"><i class="bi bi-calendar"></i> Search Policy</a>
            </div>
        </div>
    </div>

    <?php
    //check the request method
    if ($_SERVER['REQUEST_METHOD'] == "GET") {

        //extract the array
        extract($_GET);
        //var_dump($_GET);
        $policy_id = $_GET['policy_id'];

        if (!empty($policy_id)) {
            $db = dbConn();
            $sql = "SELECT c.condition_category,p.policy FROM policy p LEFT JOIN condition_category c ON c.condition_category_id=p.category_id WHERE p.policy_id='$policy_id'";
            //print_r($sql);
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                ?>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="alert alert-success col-md-6" role="alert">
                        <div class="row">
                            <div class="col-md-12" style="text-align:center">
                                <h4><strong>Successfully Added...!!!</strong></h4><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10" style="text-align:left">
                                <h5>Policy Details</h5>
                                <p style="font-weight:bold;margin:0;">Category: <?= $row['condition_category'] ?></p>
                                <p style="font-weight:bold;margin:0;">Policy: <?= $row['policy'] ?></p>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <?php
            }
        }
    }
    ?>
</main>

<?php include '../footer.php'; ?>