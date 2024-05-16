<?php
    $role = str_replace(" ","_",$_SESSION['user_role']);
    $role = strtolower($role);
    $dashboard = "users/dashboard/$role.php";
    include $dashboard;
?>