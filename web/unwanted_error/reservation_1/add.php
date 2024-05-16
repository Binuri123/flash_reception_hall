<?php ob_start() ?>
<?php include '../customer/header.php'; ?>
<?php include('../customer/sidebar.php') ?>

<?php
    //extract($_GET);
                            
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Reservation</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
        <?php echo @$tab;?>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10 tabs">
                <ul  class="nav nav-tabs">
                    <li  class="nav-item"><a class="nav-link <?= isset($_GET['tab'])&&($_GET['tab']!= 1)? '':'active' ?>" href="?tab=1">Event Details</a></li>
                    <li  class="nav-item"><a class="nav-link <?= isset($_GET['tab'])&&($_GET['tab']== 2) || (isset($_POST['action']) && $_POST['action']=='event_details')? 'active':'' ?>" href="?tab=2">Package</a></li>
                    <li  class="nav-item"><a class="nav-link <?= isset($_GET['tab'])&&($_GET['tab']== 3) || (isset($_POST['action']) && $_POST['action']=='package_details')? 'active':'' ?>" href="?tab=3">Add-ons</a></li>
                    <li  class="nav-item"><a class="nav-link <?= isset($_GET['tab'])&&($_GET['tab']== 4) || (isset($_POST['action']) && $_POST['action']=='add_on_details')? 'active':'' ?>" href="?tab=4">Invoice</a></li>
                </ul>
                <div class="tab-container">
                    <?php
                        if(isset($_GET['tab'])){
                            $tab = $_GET['tab'];
                        }else{
                            $tab = 1;
                        }
                        
                        switch ($tab){
                            case 1:
                                include 'event_details.php';
                                break;
                            case 2:
                                include 'package.php';
                                break;
                            case 3:
                                include 'add_on.php';
                                break;
                            case 4:
                                include 'invoice.php';
                                break;
                            default:
                                include 'event_details.php';
                                break;
                        }
                    ?>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </section>
</main>
<?php include('../customer/footer.php') ?>
<?php ob_end_flush() ?>