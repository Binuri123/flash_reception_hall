<?php
    $role = str_replace(" ","_",$_SESSION['user_role']);
    $role = strtolower($role);
    $menu = "users/menu/$role.php";
    include $menu;
?>