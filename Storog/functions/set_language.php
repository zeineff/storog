<?php
    require_once("session.php");
    
    $lang = filter_input(INPUT_POST, "lang", FILTER_SANITIZE_STRING);
    
    if (in_array($lang, $languages)){
        $_SESSION["lang"] = $lang;
        $w = $lang_link[$lang];
        echo "true";
    }else{
        echo "false";
    }
    