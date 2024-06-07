<?php
    date_default_timezone_set('Asia/Colombo');
    $db = dbConn();
    $sql = "SELECT substring(add_date,1,7) as month, count(*) FROM `reservation` "
            . "WHERE substring(add_date,1,7) between '2023-01' and '2023-12' "
            . "GROUP BY month ORDER by month DESC";
    
?>
<div class="row">
    <div class=""></div>
</div>
Hello world