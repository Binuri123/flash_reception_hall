<?php

$role=$_SESSION['userrole'];
$dashboard="customers/dashboard/$role.php";
include $dashboard;

?>