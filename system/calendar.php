<?php
include 'header.php';
include 'menu.php';

// Set the current month and year
$month = date('n'); // Current month (1-12)
$year = date('Y'); // Current year

// Get the number of days in the month
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

// Get the first day of the month
$firstDay = date('N', strtotime("{$year}-{$month}-01")); // 1 (for Monday) to 7 (for Sunday)

// Create the calendar grid
echo "<table class='table table-bordered'>";
echo "<caption>".date('F Y', strtotime("{$year}-{$month}-01"))."</caption>"; // Display the month and year

// Display the days of the week (headers)
echo "<tr>";
echo "<th>Mon</th>";
echo "<th>Tue</th>";
echo "<th>Wed</th>";
echo "<th>Thu</th>";
echo "<th>Fri</th>";
echo "<th>Sat</th>";
echo "<th>Sun</th>";
echo "</tr>";

// Display the calendar grid
echo "<tr>";
$dayOfWeek = 1; // Start with Monday (1)
for ($day = 1; $day <= $daysInMonth; $day++) {
    if ($dayOfWeek == $firstDay) {
        break; // Break the loop when reaching the first day of the month
    }
    echo "<td style='height:200px'></td>"; // Display empty cells before the first day
    $dayOfWeek++;
}

for ($day = 1; $day <= $daysInMonth; $day++) {
    echo "<td>{$day}"
    . "<ul>"
            . "<li>event 1</li>"
            . "<li>event 2</li>"
            . "<li>event 3</li>"
            . "<li>event 4</li>"
            . "</ul>"
            . "</td>"; // Display the day

    if ($dayOfWeek == 7) {
        echo "</tr><tr>"; // Start a new row for the next week
        $dayOfWeek = 1; // Reset the day of the week
    } else {
        $dayOfWeek++;
    }
}

// Complete any remaining empty cells at the end of the month
while ($dayOfWeek <= 7) {
    echo "<td></td>";
    $dayOfWeek++;
}

echo "</tr>";
echo "</table>";
?>

<?php include 'footer.php'; ?>