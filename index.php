<?php
session_start();
if(isset($_SESSION["error"])){
    echo $_SESSION["error"];
    $_SESSION["error"] = "";
}
//translation handling
if (isset($_COOKIE["lang"])) {
    $translationFile = 'lang/'.$_COOKIE["lang"].'.json';
    $translations = json_decode(file_get_contents($translationFile), true);
} else {
    //create cookie for one week, base value = browser's language
    $value = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2); 
    $translationFile = 'lang/'.$value.'.json';
    $translations = json_decode(file_get_contents($translationFile), true);

    setcookie("lang", $value, time() + (60 * 60 * 24 * 7),"/");
}
?>
<?php require('includes/header.php') ?>
    <main>

    </main>
<?php require('includes/footer.php') ?>