<?php
include '../customer/header.php';
include '../customer/sidebar.php';
?>

<main id="main">
    <section>
        <div class="pagetitle">
            <div class="row">
                <div class="col-md-6">
                    <h1>Reports</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>customer/dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Reports</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div><!-- End Page Title -->
        <div class="row mt-4">
            <div class="col-xxl-4 col-md-4">
                <div class="card info-card sales-card bg-success-light text-center text-white">
                    <div class="card-body text-center">
                        <h3 class="card-title text-center"> Reservation Report </h3>
                        <div class="row">
                            <div class="col-md-3"></div>  
                            <div class="col-md-6">
                                <h1 class="text-center text-dark"><i class="bi bi-calendar"></i> </h1> 
                            </div>
                            <div class="col-md-2"></div>  
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <a href="reservationreport.php" class="btn btn-outline-dark" style="width: 200px">View</a> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-md-4">
                <div class="card info-card sales-card bg-danger-light text-center text-white">
                    <div class="card-body text-center">
                        <h3 class="card-title text-center"> Payment Report </h3>
                        <div class="row">
                            <div class="col-md-3"></div>  
                            <div class="col-md-6">
                                <h1 class="text-center text-dark"><i class="bi bi-coin"></i> </h1> 
                            </div>
                            <div class="col-md-2"></div>  
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <a href="paymentreport.php" class="btn btn-outline-dark" style="width: 200px">View</a> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-md-4">
                <div class="card info-card sales-card bg-primary-light text-center text-white">
                    <div class="card-body text-center">
                        <h3 class="card-title text-center">Refund Payment Report </h3>
                        <div class="row">
                            <div class="col-md-3"></div>  
                            <div class="col-md-6">
                                <h1 class="text-center text-dark"><i class="bi bi-currency-exchange"></i> </h1> 
                            </div>
                            <div class="col-md-2"></div>  
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <a href="refundpaymentreport.php" class="btn btn-outline-dark" style="width: 200px">View</a> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include '../customer/footer.php'; ?>
