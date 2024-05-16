<?php
include '../header.php';
?>
<div class="mb-3">
            <div class="col-lg-12">
                <label for="" class="form-label">Select using vehicles</label>
                <div id="row">
                    <div class="input-group m-3">
                        <div class="input-group-prepend">
                            <button class="btn btn-danger"
                                    id="DeleteRow" type="button">
                                <i class="bi bi-trash"></i>
                                Delete
                            </button>
                        </div>

                        <?php
                        
                        $sql = "SELECT v.vehicleid,v.vehicleimage,v.color,v.brandid,v.modelid,b.brandid,b.brandname,m.modelid,m.modelname,v.deletestatus FROM tbl_centervehicles v INNER JOIN tbl_brands b ON v.brandid=b.brandid INNER JOIN tbl_models m ON v.modelid=m.modelid WHERE v.deletestatus='1'";
                        $db = dbConn();
                        $result = $db->query($sql);
                         
                        ?>

                       
                        <select class="form-select w-75 border-dark" name="vehicle[]" id="vehicleid">
                            <option value="">--</option>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>

                                    <option value="<?php echo $row['vehicleid']; ?>" <?php if (isset($vehicle) && in_array($row['vehicleid'], $vehicle)) { ?> selected <?php } ?>>

                                        <?php echo $row['brandname'] . "-" . $row['modelname'] . "-" . $row['color']; ?>


                                    </option>



                                    <?php
                                }
                            }
                            ?>
                        </select>


                    </div>
                </div>

                <div id="newinput"></div>
                <button id="rowAdder" type="button" class="btn btn-dark">
                    <span class="bi bi-plus-square-dotted">
                    </span> ADD
                </button>
               
            </div>
       
         <div class="text-danger"><?php echo @$messages['error_vehicles']; ?></div>    
  </div>
<?php
                            include '../footer.php';
?>
<script type="text/javascript">

    $("#rowAdder").click(function () {
        newRowAdd =
                '<?php
$sql = "SELECT v.vehicleid,v.vehicleimage,v.color,v.brandid,v.modelid,b.brandid,b.brandname,m.modelid,m.modelname,v.deletestatus FROM tbl_centervehicles v INNER JOIN tbl_brands b ON v.brandid=b.brandid INNER JOIN tbl_models m ON v.modelid=m.modelid WHERE v.deletestatus='1'";
$db = dbConn();
$result = $db->query($sql);
?>' +
                '<div id="row"> <div class="input-group m-3">' +
                '<div class="input-group-prepend">' +
                '<button class="btn btn-danger" id="DeleteRow" type="button">' +
                '<i class="bi bi-trash"></i>Delete</button> </div>' +
                '<select class="form-select w-75 border-dark" name="vehicle[]" id="vehicleid">' +
                '  <option value="">--</option>' +
                ' <?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        ?>' +
                        '<option value="<?php echo $row['vehicleid']; ?>" <?php if (isset($vehicle) && in_array($row['vehicleid'], $vehicle)) { ?> selected <?php } ?>><?php echo $row['brandname'] . "-" . $row['modelname'] . "-" . $row['color']; ?></option>' +
                        '<?php
    }
}
?> </select>';

        $('#newinput').append(newRowAdd);

        $res = $("#result1").val();

    });

    $("body").on("click", "#DeleteRow", function () {
        $(this).parents("#row").remove();
    })
</script>