<?php date_default_timezone_set('Asia/Colombo') ?>
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>reports/reportmenu.php">Reports</a></li>
                <li class="breadcrumb-item active" aria-current="page">Reservation Chart</li>
            </ol>
        </nav>
    </div>
    <?php

    $startmonth = isset($_REQUEST['start_month']) ? cleanInput($_REQUEST['start_month']) : null;
    $endmonth = isset($_REQUEST['end_month']) ? cleanInput($_REQUEST['end_month']) : null;

    if ($startmonth == null || $endmonth == null) {
        $year = date('Y');
        $month = date('m');

        $startmonth = ($year - 1) . '-' . $month;
        $endmonth = $year . '-' . (($month - 1) > 9 ? ($month - 1) : '0' . ($month - 1));
    }

    $sql = "SELECT substring(add_date,1,7) as month, count(*) as count FROM `reservation` "
        . "WHERE substring(add_date,1,7) between '$startmonth' and '$endmonth' "
        . "GROUP BY month ORDER by month ASC";
    $db = dbConn();
    $result = $db->query($sql);

    $start = new DateTime($startmonth);
    $end = new DateTime($endmonth);
    $end->modify('first day of next month');

    $interval = new DateInterval('P1M');
    $period = new DatePeriod($start, $interval, $end);

    $allMonths = [];
    $formattedMonths = [];
    foreach ($period as $dt) {
        $allMonths[] = $dt->format('Y-m');
        $formattedMonths[] = $dt->format('M Y');
    }

    $reservations = [];
    while ($row = $result->fetch_assoc()) {
        $reservations[$row['month']] = $row['count'];
    }

    $months = [];
    $counts = [];
    foreach ($allMonths as $month) {
        $months[] = $month;
        $counts[] = isset($reservations[$month]) ? $reservations[$month] : 0;
    }

    ?>
    <form method="get" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="row mb-3">
            <div class="col-md-3">
                <input type="month" value="<?= $startmonth ?>" required class="form-control" name="start_month" style="font-size:13px;">
            </div>
            <div class="col-md-3">
                <input type="month" value="<?= $endmonth ?>" required class="form-control" name="end_month" style="font-size:13px;">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-warning btn-sm"><i class="bi bi-search"> Generate</i></button>
            </div>
        </div>
    </form>
    <div>
        <h3 class="mb-4">Reservation Chart</h3>
        <div style="max-width: min(700px, 100%);">
            <canvas id="reservationChart"></canvas>
        </div>
    </div>
</main>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const reservationChart = document.getElementById('reservationChart');
        const context = reservationChart.getContext('2d');

        const data = {
            labels: <?= json_encode($formattedMonths) ?>,
            datasets: [{
                data: <?= json_encode($counts) ?>,
                borderColor: '#ff0000',
                backgroundColor: '#009900',
                tension: 0
            }]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: false,
                }
            },
        };

        new Chart(context, config);

    });
</script>
<?php include '../footer.php'; ?>