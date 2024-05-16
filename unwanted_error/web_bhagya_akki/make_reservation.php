<?php
ob_start();
?>
<?php include 'header.php'; ?>
<?php include 'menu.php'; ?>

<main id="main" class="col-md-10 ms-sm-auto col-lg-11 px-md-4">
    <section>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Reservation Management </h1>
           
        </div>

    


        <div class="tabs">
            <ul class="nav nav-tabs"> 
                <li class="nav-item"><a class="nav-link" href="?tab=1">Reservation Details</a></li>
                <li class="nav-item"><a class="nav-link" href="?tab=2">Package Details</a></li>
                <li class="nav-item"><a class="nav-link" href="?tab=3">Payment Details</a></li>
            </ul>
            
            <div class="tab-container"> 
                <?php 
                if(isset($_GET["tab"])){
                    $tab=$_GET["tab"];
                } else {
                  $tab= 1;  
                } 
                switch ($tab){
                    case 1:
                        include 'tab1reservation.php';
                        break;
                    
                    case 2:
                        include 'tab2package.php';
                        break;
                    
                     case 3:
                        include 'tab3payment.php';
                        break;
                    
                    default : include 'tab1reservation.php';
                        break;
                }
                
                ?>
            </div>
        </div>
        

    </section>

</main>



<?php include 'footer.php'; ?> 
<?php ob_end_flush() ?> 

