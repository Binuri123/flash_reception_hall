<div class="card bg-info text-info"  style="--bs-bg-opacity: .05;">
    <div class="card-body text-center">
        <?php
        $db = dbConn();
        $year = date('Y');
        $sql = "SELECT count(*) as total_customers FROM customer WHERE YEAR(add_date) = '$year'";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $total_customers = $row['total_customers'];
        ?>
        <h6># Customers<br>(<?= $year ?>)<br><?= $total_customers ?></h6>
    </div>
</div>