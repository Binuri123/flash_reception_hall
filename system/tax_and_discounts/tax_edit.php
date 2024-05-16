<?php
ob_start();
include '../header.php';
include '../menu.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="btn-toolbar mb-2 mb-md-0">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>tax_and_discounts/tax_and_discounts.php">Tax and Discount</a></li>
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>tax_and_discounts/tax.php">Tax</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Update</li>
                </ol>
            </nav>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>tax_and_discounts/tax.php"><i class="bi bi-calendar"></i> View Tax</a>
            </div>
        </div>
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        extract($_GET);
        $db = dbConn();
        $sql = "SELECT tax_rate,amount FROM tax WHERE tax_id='$tax_id'";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $tax_rate = $row['tax_rate'];
        $amount = $row['amount'];
    }

    extract($_POST);
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'save_changes') {
        $tax_rate = cleanInput($tax_rate);
        $amount = cleanInput($amount);

        //Required Field and Input Format Validation
        $message = array();

        if (empty($tax_rate)) {
            $message['error_tax_rate'] = "The tax rate Should Not Be Blank...";
        } elseif ($tax_rate < 0) {
            $message['error_tax_rate'] = "The tax rate Cannot be negative...";
        }
        
        if (empty($amount)) {
            $message['error_limit'] = "The limit Should Not Be Blank...";
        } elseif ($amount < 0) {
            $message['error_limit'] = "The limit Cannot be negative...";
        }

        if (empty($message)) {
            $db = dbConn();
            $cDate = date('Y-m-d');
            $user_id = $_SESSION['userid'];
            echo $sql = "UPDATE tax SET tax_rate='$tax_rate',amount='$amount',update_user='$user_id',update_date='$cDate' WHERE tax_id='$tax_id'";
            $db->query($sql);
            header('location:tax.php');
        }
    }
    ?>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Update Tax</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="font-size:13px;">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label"><span class="text-danger">*</span> Tax Rate (%)</label>
                            </div>
                            <div class="col-md-8 mb-3">
                                <input type="number" min="0" max="100" name="tax_rate" value="<?= @$tax_rate ?>" class="form-control" style="font-size:13px;">
                                <div class="text-danger"><?= @$message['error_tax_rate'] ?></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mt-3 mb-3 col-md-4">
                                <label for="limit" class="form-label"><span class="text-danger">*</span> Limit</label>
                            </div>
                            <div class="mt-3 mb-3 col-md-8">
                                <input type="number" class="form-control" id="amount" name="amount" value="<?= @$amount ?>">
                                <div class="text-danger"><?= @$message["error_limit"] ?></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="text-align:right;">
                                <input type="hidden" name="tax_id" value="<?= @$tax_id ?>">
                                <button type="submit" name="action" value="save_changes" class="btn btn-success btn-sm" style="font-size:13px;width:150px;">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>
</main>
<?php
include '../footer.php';
ob_end_flush();
?>