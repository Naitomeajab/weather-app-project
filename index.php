<?php
$serverRoot = $_SERVER['DOCUMENT_ROOT'];
$projectRoot = "/weather-app-project";
session_start();
if(isset($_SESSION["error"])){
    echo $_SESSION["error"];
    $_SESSION["error"] = "";
}
//translation handling
require("php/translation.php");
?>
<?php require('includes/header.php') ?>
    <main>

    </main>
<?php require('includes/footer.php') ?>