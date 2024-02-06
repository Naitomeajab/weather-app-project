<?php
session_start();
if(isset($_SESSION["error"])){
    echo $_SESSION["error"];
    $_SESSION["error"] = "";
}
?>
<?php require('includes/header.php') ?>
    <main>

    </main>
<?php require('includes/footer.php') ?>