<?php
require     "authentication.php";
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
$user_role = $_SESSION['user_role'];
if ($user_id == Null || $security_key == Null) {
    header('Location:index.php');
}
if ($user_role != 1) {
    header('Location:task-info.php');
}

$page_name = "Cron";
include("include/sidebar.php");

?>
<div>
    hello world
</div>