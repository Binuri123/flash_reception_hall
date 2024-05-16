<?php
ob_start();
session_start();
include '../header.php';
?>
<main id="main">
    <section style="margin-top:20px;font-size:13px;">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="card bg-light" style="font-size:13px;">
                    <div class="card-body">
                        <p style="text-align:center"><strong><i>Thank You for Your Response. We will be in touch with you in a while.</i></strong></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </section>
</main>
<?php
include '../footer.php';
ob_end_flush();
?>
