<div class="col-md-5">
    <div class="card text-dark bg-transparent mb-3" style="max-width: 28rem;">
        <div class="card-header bg-secondary text-light">Additional Item</div>
        <div class="card-body bg-transparent">
            <div class="row mt-3 mb-2">
                <div class="table-responsive">
                    <?php
//                                   if(!empty(@$itemcategory)){
//    $sql = "SELECT * FROM tbl_menuitem m LEFT JOIN tbl_menuitem_category c ON c.MenuItemCategoryId=m.MenuItemCategoryId WHERE m.MenuItemCategoryId='$itemcategory'";
//   print_r($sql);
//                                    } else  {
//    echo 'table';
//  print_r($_SESSION['selecteditems']);
                    $sql = "SELECT * FROM tbl_menuitem m LEFT JOIN tbl_menuitem_category c ON c.MenuItemCategoryId=m.MenuItemCategoryId";
//  } 
                    $db = dbConn();
                    $result = $db->query($sql);
                    ?>

                    <table class="table table-sm">
                        <thead class="bg-transparent">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Item Category</th>
                                <th scope="col">Menu Item Name</th>
                                <th scope="col">Portion Price (Rs) </th>
                                <th scope="col">Select </th>

                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            if ($result->num_rows > 0) {
                                //  $totalmenuprice = 0;
                                while ($row = $result->fetch_assoc()) {
                                    // floatval(@$plateprice) += floatval($row['PortionPrice']);
                                    ?>

                                    <tr>
                                        <td></td>
                                        <td><?= $row['CategoryName'] ?></td>
                                        <td><?= $row['MenuItemName'] ?></td>
                                        <td><?= $row['PortionPrice'] ?></td> 
                                        <td> <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" onchange="form.submit()" id="<?= $row['MenuItemId'] ?>" name="item[]" value="<?= $row['MenuItemId'] ?>" <?php if (isset($item) && in_array($row['MenuItemId'], $item)) { ?> checked <?php } ?> >
                                                <label class="form-check-label" for="item"></label>
                                            </div>

                                        </td> 


                                    </tr>

                                    <?php
                                    // $db = dbConn();
                                    // if(!empty(@$item)){
                                    //   $sql2= "SELECT SUM(m.PortionPrice) FROM `tbl_mpitemlist` l INNER JOIN tbl_menuitem m ON m.MenuItemId=l.MenuItemId WHERE MenuPackageId='" . @$MenuPackageId . "'";
                                    //   @$plateprice = $db->query($sql2);
                                }
                            }

//}
                            ?>


                        </tbody>
                    </table>
                </div>


                <div class="col-md-12 mb-2 mt-3">
                    <label for="totaladditional" class="form-label">Total Additional Item Price (Rs)</label>
                    <input type="text" class="form-control" id="totaladditional" name="totaladditional" value="<?= @$totaladditional ?>">
                    <div class="text-danger">
                        <?= @$message['error_totaladditional'] ?>  
                    </div>

                </div>






            </div>    

        </div>
    </div>
</div>

<?php
if (!empty(@$item)) {
    @$plateprice = 0;
    foreach (@$item as $value) {
        $sql = "SELECT PortionPrice FROM tbl_menuitem WHERE MenuItemId='$value'";
        // print_r($sql);
        $db = dbConn();
        $result = $db->query($sql);
        $row = $result->fetch_assoc();

        @$plateprice = @$plateprice + $row['PortionPrice'];
    }
    //  print_r(@$plateprice); 
}
?>