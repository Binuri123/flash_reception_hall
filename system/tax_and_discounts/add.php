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
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>tax_and_discounts/tax.php">Tax</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add</li>
                </ol>
            </nav>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>tax_and_discounts/tax.php"><i class="bi bi-calendar"></i> Search Tax</a>
            </div>
        </div>
    </div>
    <?php
    extract($_POST);
    //var_dump($_POST);
    //echo 'outside';
    //check the request method
    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'add') {
        //echo 'inside';
        //extract the array
        // Assign cleaned values to the variables
        $tax_rate = cleanInput($tax_rate);
        $amount = cleanInput($amount);

        //Required Field and Input Format Validation
        $message = array();

        if (empty($tax_rate)) {
            $message['error_tax_rate'] = "The tax rate Should Not Be Blank...";
        } elseif ($tax < 0) {
            $message['error_tax_rate'] = "The tax rate Cannot be negative...";
        }
        
        if (empty($amount)) {
            $message['error_limit'] = "The limit Should Not Be Blank...";
        } elseif ($amount < 0) {
            $message['error_limit'] = "The limit Cannot be negative...";
        }
        
        //print_r($message);
        //Insert data into relevant database tables
        if (empty($message)) {
            $db = dbConn();
            //echo 'Connected..!';
            $userid = $_SESSION['userid'];
            $cDate = date('Y-m-d');
            $sql = "INSERT INTO tax(tax_rate,amount,add_user,add_date)VALUES('$tax_rate','$amount','$userid','$cDate')";
            $db->query($sql);
            header('Location:tax.php');
        }
    }
    ?>
    <div class="row">
        <div class="mb-3 col-md-3"></div>
        <div class="mb-3 col-md-6">
            <div class="card bg-light">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Add New Tax Rate</h4>
                        </div>
                        <div class="col-md-6" style="text-align:right">
                            <p class="text-danger text-right">* Required</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
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
                        <div class="row" style="text-align: right">
                            <div class="mb-3 col-md-12">
                                <button type="submit" name="action" value="add" class="btn btn-success btn-sm">Add</button>
                            </div>
                        </div>  
                    </form>
                </div>
            </div>
        </div>
        <div class="mb-3 col-md-3"></div>
    </div>
</main>
<?php
include '../footer.php';
ob_end_flush();
?>