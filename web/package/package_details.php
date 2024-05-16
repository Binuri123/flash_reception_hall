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
            $sql = "SELECT p.package_name,p.pax_count,e.event_name,m.menu_package_name,m.menu_package_id,p.total_price,p.service_charge,p.final_price,p.display_price,p.per_person_price,p.availability "
                    . "FROM package p INNER JOIN event e ON e.event_id=p.event_id "
                    . "INNER JOIN menu_package m ON m.menu_package_id=p.menu_package_id "
                    . "WHERE p.package_id='$package_id'";
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
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
                                                        <th colspan="2">Package Details</th>
                                                    </tr>
                                                    <tr>
                                                        <th scope="col">Field</th>
                                                        <th scope="col">Value</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Package Name</td>
                                                        <td><?= $row['package_name'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Event Type</td>
                                                        <td><?= $row['event_name'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Menu Package Name</td>
                                                        <td><?= $row['menu_package_name'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Availability</td>
                                                        <td><?= $row['availability'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Display Price(Rs.)</td>
                                                        <td><?= number_format($row['display_price'], '2', '.', ',') ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Minimum Pax Count</td>
                                                        <td><?= $row['pax_count'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Per Person Price(Rs.)</td>
                                                        <td><?= number_format($row['per_person_price'], '2', '.', ',') ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-sm border-secondary">
                                                <thead class="bg-secondary-light border-dark text-center">
                                                    <tr>
                                                        <th colspan="2">Menu Package Inclusives</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Category</th>
                                                        <th>Items</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $db = dbConn();
                                                    $sql_inclusive = "SELECT mc.category_name,mc.category_id,mi.item_name "
                                                            . "FROM menu_package m INNER JOIN menu_package_item mpi ON mpi.menu_package_id=m.menu_package_id "
                                                            . "INNER JOIN item_category mc ON mc.category_id=mpi.category_id "
                                                            . "INNER JOIN menu_item mi ON mi.item_id=mpi.item_id "
                                                            . "WHERE m.menu_package_id=" . $row['menu_package_id'] . " ORDER BY mc.category_id ASC";
                                                    $result_inclusive = $db->query($sql_inclusive);
                                                    while ($row_inclusive = $result_inclusive->fetch_assoc()) {
                                                        ?>
                                                        <tr>
                                                            <td><?= $row_inclusive['category_name'] ?></td>
                                                            <td><?= $row_inclusive['item_name'] ?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-sm border-secondary">
                                                <thead class="bg-secondary-light border-dark text-center">
                                                    <tr>
                                                        <th colspan="2">Service Inclusives</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Category</th>
                                                        <th>Services</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $db = dbConn();
                                                    $sql_inclusive = "SELECT sc.category_name,sc.category_id,s.service_name,ps.service_price "
                                                            . "FROM package_services ps INNER JOIN service s ON s.service_id=ps.service_id "
                                                            . "INNER JOIN service_category sc ON sc.category_id=ps.category_id "
                                                            . "WHERE ps.package_id='$package_id' ORDER BY sc.category_id ASC";
                                                    $result_inclusive = $db->query($sql_inclusive);
                                                    while ($row_inclusive = $result_inclusive->fetch_assoc()) {
                                                        ?>
                                                        <tr>
                                                            <td><?= $row_inclusive['category_name'] ?></td>
                                                            <td><?= $row_inclusive['service_name'] ?></td>
                                                        </tr>
                                                        <?php
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