<?php
include '../header.php';
?>
<main id="main">
    <section>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            extract($_GET);
            //var_dump($_GET);
            $db = dbConn();
            $sql = "SELECT s.service_name,s.service_type,s.final_price,s.addon_status "
                    . "FROM service s "
                    . "WHERE s.category_id='$category_id' AND s.availability='Available'";
            $result = $db->query($sql);
        }
        ?>
        <div class="row mt-4">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body" style="font-size:15px;">
                        <div class="card bg-light col-md-12">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-sm table-bordered border-secondary">
                                                <thead class="bg-secondary-light border-dark text-center">
                                                    <tr>
                                                        <th colspan="4">Services Details</th>
                                                    </tr>
                                                    <tr>
                                                        <th scope="col">Service Name</th>
                                                        <th scope="col">Service Type</th>
                                                        <th scope="col">Service Price</th>
                                                        <th scope="col">Add - on Service</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            ?>
                                                            <tr>
                                                                <td><?= $row['service_name'] ?></td>
                                                                <td><?= ($row['service_type']=='outsource')?'Payable':'FREE' ?></td>
                                                                <td style="text-align:right;"><?= ($row['service_type']=='outsource')?number_format($row['final_price'],'2','.',','):'-' ?></td>
                                                                <td><?= $row['addon_status'] ?></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </section>
</main>
<?php
include '../footer.php';
?>