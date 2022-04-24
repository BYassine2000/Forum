<?php

require('core/Autoloader.php');
require('core/Helpers.php');

Autoloader::register();
$session = new Session();

require('core/Functions.php');
require('core/Constants.php');

$bdd = connectBDD(HOSTNAME, DATABASE, USERNAME, PASSWORD);

$helper = new Helpers();

if (!isset($_GET['p']) || $_GET['p'] == "") {
    $page = "controllers/homeControllers.php";
} else {
    if ($_GET['p'] == "admin-panel") {
        $page = "admin/login.php";
    } elseif ($_GET['p'] == "admin-panel/users") {
        $page = "admin/users.php";
    } elseif ($_GET['p'] == "admin-panel/category") {
    	$page = "admin/category.php";
    } elseif ($_GET['p'] == "admin-panel/topics") {
        $page = "admin/topics.php";
    } elseif ($_GET['p'] == "admin-panel/contact") {
        $page = "admin/contact.php";
    } elseif ($_GET['p'] == "admin-panel/profile") {
        $page = "admin/profile.php";
    } elseif ($_GET['p'] == "admin-panel/logout") {
        $page = "admin/logout.php";
    } elseif (file_exists("controllers/".$_GET['p']."Controllers.php")) {
        $page = "controllers/".$_GET['p']."Controllers.php";
    } else {
        $page = "controllers/404Controllers.php";
    }
}

ob_start();
    require $page;
    $contents = ob_get_contents();
ob_get_clean();

require('template.php');

?>