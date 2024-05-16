<?php ob_start() ?>
<?php include '../customer/header.php'; ?>
<?php include('../customer/sidebar.php') ?>
<?php
extract($_POST);
?>
<main id="main" class="main">
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card bg-light">
                    <div class="card-header bg-light">
                        <ul class="nav nav-tabs card-header-tabs nav-justified">
                            <li class="nav-item"><a class="nav-link" href="">Event Details</a></li>
                            <li class="nav-item"><a class="nav-link" href="">Package</a></li>
                            <li class="nav-item"><a class="nav-link active" href="?tab=add_ons">Add-ons</a></li>
                            <li class="nav-item"><a class="nav-link" href="">Invoice</a></li>
                        </ul>
                    </div>
                    <div class="card-body py-2">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mt-3 mb-3">
                                    <div class="card-body">
                                        <div class="tab-container active">
                                            <form  method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th style="width:200px;text-align: center">Item Name</th>
                                                                    <th style="width:200px;text-align: center">Portion Price</th>
                                                                    <th style="width:50px"></th>
                                                                    <th style="width:100px">Quantity</th>
                                                                    <th style="width:200px">Total Portion Price</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $db = dbConn();
                                                                $sql = "SELECT item_id,item_name,portion_price FROM menu_item WHERE allowed_extra='allowed'";
                                                                //print_r($sql);
                                                                $result = $db->query($sql);
                                                                $i = 1;
                                                                while ($row = $result->fetch_assoc()) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><?= $i ?></td>
                                                                        <td style="width:200px"><?= $row['item_name'] ?></td>
                                                                        <td style="width:200px;text-align: center"><?= $row['portion_price'] ?></td>
                                                                        <td style="width:50px">
                                                                            <!--Create array of selected items-->
                                                                            <!--Check box-->
                                                                            <input class="form-check-input" type="checkbox" id="<?= $row['item_id'] ?>" name="item[]" value="<?= $row['item_id'] ?>" <?php if (isset($item) && in_array($row['item_id'], $item)) { ?>checked <?php } ?>>
                                                                        </td>
                                                                        <td style="width:100px">
                                                                            <!--Enter the necessary quantity of the item-->
                                                                            <!--The total portion price should be calculated while the quantity field is changing
                                                                            so that there should be a onchange attribute in the qty field-->
                                                                            <!--To perform the calculation we should write a function-->
                                                                            <!--this.value will get the inputed value of the input field-->
                                                                            <input type="number"class="form-control" onchange="updatePrice(<?= $row['item_id'] ?>,<?= $row['portion_price']?>,this.value)">
                                                                        </td>
                                                                        <td style="width:200px">
                                                                            <!--Calculated total portion price by item-->
                                                                            <!--The updated price should be shown in this input field 
                                                                            so the calculated price should append to the input tag,
                                                                            To the purpose of identifying the tag we use an id-->
                                                                            <!--The amount should be calculated and displayed relevantly to the selected item in the row
                                                                            so that we should concatenate the item id to the id of the input tag-->
                                                                            <input type="text" class="form-control" readonly id="amount<?= $row['item_id'] ?>">
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                    $i++;
                                                                }
                                                                ?>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td></td>
                                                                    <td style="text-align:right" colspan="4"><strong>Total</strong></td>
                                                                    <td></td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6"></div>
                                                    <div class="col-md-6" style="text-align:right">
                                                        <a href="package.php" class="btn btn-success" style="width:150px;"><i class="bi bi-arrow-left"></i> Back</a>
                                                        <button type="submit" name="action" value="add_on"  class="btn btn-success" style="width:150px;">Next <i class="bi bi-arrow-right"></i></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </section>
</main>
<?php include('../customer/footer.php') ?>
<script>
    function updatePrice(item_id,portion_price,qty){
        //Now we can access the input field using the Id
        //While calling the function we need to pass the relevant id as a parameter
        //to calculate the total portion price we need to get the portion price and the qty in the row
        $('#amount'+item_id).val(portion_price*qty);
    }
</script>
<?php ob_end_flush() ?>