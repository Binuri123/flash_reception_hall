<?php ob_start() ?>
<?php
include '../header.php';
include '../menu.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Halls</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add</li>
            </ol>
        </nav>
    </div>

    <?php
    //check the request method
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        //extract the array
        extract($_POST);
        // Assign cleaned values to the variables
        $hall_name = cleanInput($hall_name);
        $min_cap = cleanInput($min_cap);
        $max_cap = cleanInput($max_cap);
        $facilities = cleanInput($facilities);

        //Required Validation
        $message = array();
        if (empty($hall_name)) {
            $message['error_hall_name'] = "The Hall Name Should Not Be Blank...";
        }
        if (empty($min_cap)) {
            $message['error_min_cap'] = "The Minimum Capacity Should Not Be Blank...";
        }
        if (empty($max_cap)) {
            $message['error_max_cap'] = "The Maximum Capacity Should Not Be Blank...";
        }
        if (!isset($availability)) {
            $message['error_availability'] = "The Availability Should Be Selected...";
        }
        
        if (empty($message)) {

            $hall_image = uploadFiles("hall_image",$hall_name,"../assets/images/hall/");
            //print_r($item_image);
            $hall_image_name = $hall_image['file_name'];
            if(!empty($hall_image['error_message'])){
                $message['error_hall_image'] = $hall_image['error_message'];
            }
        }
        
        if (empty($message)) {
            $db = dbConn();
            echo 'Connected..!';
            $userid = $_SESSION['userid'];
            $cDate = date('Y-m-d');
            $sql = "INSERT INTO hall(hall_name,min_capacity,max_capacity,facilities,hall_image,availability,add_user,add_date)VALUES('$hall_name','$min_cap','$max_cap','$facilities','$hall_image_name','$availability','$userid','$cDate')";
            $db->query($sql);
            print_r($sql);
            $hall_id = $db->insert_id;
            print_r($hall_id);
            header('Location:add_success.php?hall_id='.$hall_id);
            
        }
    }
    ?>
    <div class="row">
        <div class="mb-3 col-md-4"></div>
        <div class="mb-3 col-md-4">
            <h2>Add New Hall</h2>
        </div>
        <div class="mb-3 col-md-4"></div>
    </div>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
        <div class="row">
            <div class="mb-3 col-md-4"></div>
            <div class="mb-3 col-md-4">
                <label for="hall_name" class="form-label">Hall Name</label>
                <input type="text" class="form-control" id="hall_name" name="hall_name" value="<?= @$hall_name ?>">
                <div class="text-danger"><?= @$message["error_hall_name"] ?></div>
            </div>
            <div class="mb-3 col-md-4"></div>
        </div>
        <div class="row">
            <div class="mb-3 col-md-4"></div>
            <div class="mb-3 col-md-2">
                <label for="min_cap" class="form-label">Minimum Capacity</label>
                <input type="number" min="0" class="form-control" id="min_cap" name="min_cap" value="<?= @$min_cap ?>">
                <div class="text-danger"><?= @$message["error_min_cap"] ?></div>
            </div>
            <div class="mb-3 col-md-2">
                <label for="max_cap" class="form-label">Maximum Capacity</label>
                <input type="number" min="0" class="form-control" id="max_cap" name="max_cap" value="<?= @$max_cap ?>">
                <div class="text-danger"><?= @$message["error_max_cap"] ?></div>
            </div>
            <div class="mb-3 col-md-4"></div>
        </div>
        <div class="row">
            <div class="mb-3 col-md-4"></div>
            <div class="mb-3 col-md-4">
                <label for="facilities" class="form-label">Facilities</label>
                <textarea class="form-control" id="facilities" name="facilities"><?= @$facilities ?></textarea>
            </div>
            <div class="mb-3 col-md-4"></div>
        </div>
        <div class="row">
            <div class="mb-3 col-md-4"></div>
            <div class="mb-3 col-md-4">
                <label for="hall_image" class="form-label">Image</label>
                <input type="file" name="hall_image" id="hall_image" class="form-control">
            </div>
            <div class="mb-3 col-md-4"></div>
        </div>
        <div class="row">
            <div class="mb-3 col-md-4"></div>
            <div class="mb-3 col-md-4">
                <label>Availability</label><br>
                <div class="form-check form-check-inline mt-3">
                    <input class="form-check-input" type="radio" name="availability" id="hall_available" value="1" <?php if (isset($availability) && $availability == 'Yes') { ?> checked <?php } ?>>
                    <label class="form-check-label" for="hall_available">Available</label>
                </div>
                <div class="form-check form-check-inline mt-3">
                    <input class="form-check-input" type="radio" name="availability" id="hall_unavailable" value="0" <?php if (isset($availability) && $availability == 'No') { ?> checked <?php } ?>>
                    <label class="form-check-label" for="hall_unavailable">Unavailable</label>
                </div>
                <div class="text-danger"><?= @$message["error_availability"] ?></div>
            </div>
            <div class="mb-3 col-md-4"></div>
        </div>
        <div class="row">
            <div class="mb-3 col-md-4"></div>
            <div class="mb-3 col-md-4" style="text-align:right">
                <button type="submit" class="btn btn-success">Submit</button>
                <button type="reset" class="btn btn-warning">Cancel</button>
            </div>
            <div class="mb-3 col-md-4"></div>
        </div>
        
    </form>
</main>

<?php include '../footer.php'; ?>
<?php ob_end_flush()?>