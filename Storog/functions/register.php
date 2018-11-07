<?php
    require_once("session.php");
    require_once("functions.php");
    
    $fields = array("reg_username", "reg_password_01", "reg_password_02");
    
    // If all required fields are set
    if (check_fields($fields)){
        $username = filter_input(INPUT_POST, "reg_username", FILTER_SANITIZE_STRING);
        $password_01 = filter_input(INPUT_POST, "reg_password_01", FILTER_SANITIZE_STRING);
        $password_02 = filter_input(INPUT_POST, "reg_password_02", FILTER_SANITIZE_STRING);
        
        // If password match and the username and email are not taken
        if ($password_01 === $password_02 && !username_taken($username)){
            $user = create_user($username, $password_01);
            
            set_session($user);
        }
    }
    
    header("Location:" . $_SESSION["last_page"]);