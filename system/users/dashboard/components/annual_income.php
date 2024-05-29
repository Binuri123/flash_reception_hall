<div class="card bg-success text-success" style="--bs-bg-opacity: .05;" >
    <div class="card-body text-center">
        <?php
        $db = dbConn();
        $year = date('Y');
        $sql_income = "SELECT SUM(paid_amount) as total_income FROM customer_payments "
                        . "WHERE YEAR(verified_date) = '$year'";
        $result_income = $db->query($sql_income);
        $row_income = $result_income->fetch_assoc();
        $total_income = $row_income['total_income'];
        ?>
        <h6>Income (LKR)<br>(<?= $year ?>)<br><?= number_format($total_income, '2', '.', ',') ?></h6>
    </div>
</div>