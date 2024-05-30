<div class="card bg-primary text-primary" style="--bs-bg-opacity: .1;">
    <div class="card-body text-center">
        <?php
        $db = dbConn();
        $year = date('Y');
        $sql_expense = "SELECT SUM(refundable_amount) as total_expense FROM refund_request WHERE YEAR(issued_date) = '$year'";
        $result_expense = $db->query($sql_expense);
        $row_expense = $result_expense->fetch_assoc();
        $total_expense = $row_expense['total_expense'];
        ?>
        <h6>Expenses (LKR)<br>(<?= $year ?>)<br><?= number_format($total_expense, '2', '.', ',') ?></h6>
    </div>
</div>