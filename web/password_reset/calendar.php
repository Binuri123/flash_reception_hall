<?php
//$disabledDates = array(
//  '2023-06-30',
//  '2023-07-05',
//  '2023-07-10'
//);
//
//// Generate options for the date field
//$options = '';
//$currentDate = date('Y-m-d');
//$endDate = date('Y-m-d', strtotime('+1 year'));
//$interval = new DateInterval('P1D');
//$period = new DatePeriod(new DateTime($currentDate), $interval, new DateTime($endDate));
//
//foreach ($period as $date) {
//  $dateString = $date->format('Y-m-d');
//
//  // Check if the date is disabled
//  if (!in_array($dateString, $disabledDates)) {
//    $options .= "<option value=\"$dateString\">$dateString</option>";
//  }
//}
?>

<!-- Generate the date field -->
<!--<select name="dateField">-->
  <?php //echo $options; ?>
<!--</select>-->
<?php
$disabledDates = array(
  '2023-06-30',
  '2023-07-05',
  '2023-07-10'
);

// Get the current date and the one year later date
$currentDate = date('Y-m-d');
$endDate = date('Y-m-d', strtotime('+1 year'));

// Generate the min and max dates for the input field
$minDate = $currentDate;
$maxDate = $endDate;

foreach ($disabledDates as $disabledDate) {
  // Check if the disabled date is greater than the current minimum date
  if ($disabledDate >= $minDate) {
    // Set the minimum date to the day after the disabled date
    $minDate = date('Y-m-d', strtotime($disabledDate . '+1 day'));
  }

  // Check if the disabled date is less than the current maximum date
  if ($disabledDate <= $maxDate) {
    // Set the maximum date to the day before the disabled date
    $maxDate = date('Y-m-d', strtotime($disabledDate . '-1 day'));
  }
}
?>

<!-- Generate the date field -->
<input type="date" name="dateField" min="<?php echo $minDate; ?>" max="<?php echo $maxDate; ?>">
