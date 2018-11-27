<?php
    require_once("lang.php");

    session_start();
    
    if (!isset($_SESSION["id"])){
        $_SESSION["id"] = -1;
    }
    
    if (!isset($_SESSION["lang"])){
        $_SESSION["lang"] = "en";
    }
    
    $w = $lang_link[$_SESSION["lang"]];