<?php
include '../header.php';
include '../menu.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tax And Discounts</li>
            </ol>
        </nav>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>tax_and_discounts/add.php"><i class="bi bi-plus-circle"></i> New Tax</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <a href="<?= SYSTEM_PATH ?>tax_and_discounts/tax.php" style="text-decoration:none;color:white">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT tax_rate FROM tax where availability='Available'";
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $current_tax_rate = $row['tax_rate'];
                            ?>
                            <h4># Tax Rate (%)<br><?= $current_tax_rate ?></h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= SYSTEM_PATH ?>tax_and_discounts/discount.php" style="text-decoration:none;color:white">
                    <div class="card bg-warning text-white">
                        <div class="card-body text-center">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT discount_ratio FROM discount WHERE availability='Available'";
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $available_discount = $row['discount_ratio'];
                            ?>
                            <h4># Discount<br><?= $available_discount ?></h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</main>
<?php
include '../footer.php';
?>