<div class="card bg-danger text-danger"  style="--bs-bg-opacity: .1;">
    <div class="card-body text-center">
        <?php
        if ($total_income == 0) {
            $profit = 0;
        } else {
            $profit = ($total_income - $total_expense) * 100 / $total_income;
            $profit = number_format($profit,2);
        }
        ?>
        <h6>Profit<br>(<?= $year ?>)<br><?= $profit . "%" ?></h6>
    </div>
</div>