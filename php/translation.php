<?php
if (isset($_COOKIE["lang"])) {
    $lang = $_COOKIE["lang"];
    $translationFile = $serverRoot.$projectRoot.'/lang/'.$_COOKIE["lang"].'.json';
    // $translationFile = '../lang/'.$_COOKIE["lang"].'.json';
    $translations = json_decode(file_get_contents($translationFile), true);
} else {
    //create cookie for one week, base value = browser's language
    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2); 
    // $translationFile = '../lang/'.$lang.'.json';
    $translationFile = $serverRoot.$projectRoot.'/lang/'.$_COOKIE["lang"].'.json';
    $translations = json_decode(file_get_contents($translationFile), true);

    setcookie("lang", $value, time() + (60 * 60 * 24 * 7),"/");   
}
