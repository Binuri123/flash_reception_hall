<?php
include 'header.php';
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Terms and Conditions</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Terms and Conditions</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card bg-white" style="font-size:13px;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <h5>Bookings and Payment</h5>
                                <ol>
                                    <?php
                                    $db = dbConn();
                                    $sql = "SELECT * FROM policy WHERE category_id = '1'";
                                    $result = $db->query($sql);
                                    while($row=$result->fetch_assoc()){
                                        ?>
                                    <li><?=$row['policy']?></li>
                                    <?php
                                    }
                                    ?>
                                </ol>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Cancellation and Refund</h5>
                                <ol>
                                    <?php
                                    $db = dbConn();
                                    $sql = "SELECT * FROM policy WHERE category_id = '2'";
                                    $result = $db->query($sql);
                                    while($row=$result->fetch_assoc()){
                                        ?>
                                    <li><?=$row['policy']?></li>
                                    <?php
                                    }
                                    ?>
                                </ol>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Damage and Additional Purchases</h5>
                                <ol>
                                    <?php
                                    $db = dbConn();
                                    $sql = "SELECT * FROM policy WHERE category_id = '3'";
                                    $result = $db->query($sql);
                                    while($row=$result->fetch_assoc()){
                                        ?>
                                    <li><?=$row['policy']?></li>
                                    <?php
                                    }
                                    ?>
                                </ol>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Reservation Updates</h5>
                                <ol>
                                    <?php
                                    $db = dbConn();
                                    $sql = "SELECT * FROM policy WHERE category_id = '4'";
                                    $result = $db->query($sql);
                                    while($row=$result->fetch_assoc()){
                                        ?>
                                    <li><?=$row['policy']?></li>
                                    <?php
                                    }
                                    ?>
                                </ol>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Compliance with the Laws</h5>
                                <ol>
                                    <?php
                                    $db = dbConn();
                                    $sql = "SELECT * FROM policy WHERE category_id = '5'";
                                    $result = $db->query($sql);
                                    while($row=$result->fetch_assoc()){
                                        ?>
                                    <li><?=$row['policy']?></li>
                                    <?php
                                    }
                                    ?>
                                </ol>
                            </div>
                        </div>
                        <div class="row"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </section>
</main>
<?php
include 'footer.php';
?>