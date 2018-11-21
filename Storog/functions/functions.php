<?php
    require_once("db.php");
	
    // Returns true if each field in '$fields' has a value ready in POST
    function check_fields($fields){
        foreach ($fields as $field){
            $a = filter_input(INPUT_POST, $field);
            
            if ($a === null || !isset($a) || empty($a)){
                return false;
            }
        }
        
        return true;
    }
    
    // Sets the current session variables to be those of $user
    function set_session($user){
        $_SESSION["id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
    }
    
    function comma_seperate($steam_ids){
        $s = "";
        
        foreach($steam_ids as $id){
            $s .= ',' . $id;
        }
        
        return substr($s, 1, strlen($s));
    }
    
    function map_acronyms($title){
        $acronyms = array("cod" => "Call of Duty", "tes" => "The Elder Scroll");
        
        if (isset($acronyms[$title])){
            return $acronyms[$title];
        }else{
            return $title;
        }
    }
    
    
    
    
    
    // Customizable select query. Compares using =
    function search_table_equal($table, $field, $value, $order = "1", $direction = "DESC"){
        global $db;
        
        $string = "SELECT * FROM " . $table . " WHERE " . $field . " = '" . $value . "' ORDER BY " . $order . " " . $direction . ";";
        $query = $db -> prepare($string);
        $query -> execute();
        $results = $query -> fetchAll();
        $query -> closeCursor();
        
        return $results;
    }
    
    // Customizable select query. Compares using LIKE
    function search_table_like($table, $field, $value, $order = "1", $direction = "DESC"){
        global $db;
        
        $string = "SELECT * FROM " . $table . " WHERE " . $field . " LIKE '%" . $value . "%' ORDER BY " . $order . " " . $direction;
        $query = $db -> prepare($string);
        $query -> execute();
        $threads = $query -> fetchAll();
        $query -> closeCursor();
        
        return $threads;
    }
    
    // Returns a single row from a table
    function get_unique_field($table, $field, $value){
       $results = search_table_equal($table, $field, $value);
       
        if (sizeof($results) === 1){
            return $results[0];
        }else{
            return null;
        }
    }
    
    // Returns multiple rows from a table using a LIKE comparison
    function get_like_field($table, $field, $value){
        return search_table_like($table, $field, $value);
    }
    
    
    
    function get_user_by_unique_field($field, $value){
        return get_unique_field("users", $field, $value);
    }
    
    function get_user_by_username($username){
        return get_user_by_unique_field("username", $username);
    }
	
    function get_user_by_id($user_id){
        return get_user_by_unique_field("id", $user_id);
    }
    
    function user_field_taken($field, $value){
        return get_user_by_unique_field($field, $value) !== null;
    }
    
    function username_taken($username){
        return user_field_taken("username", $username);
    }
    
    function create_user($username, $password){
        global $db;
        
        $string = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $query = $db -> prepare($string);
        $query -> bindValue(":username", $username);
        $query -> bindValue(":password", password_hash($password, PASSWORD_DEFAULT));
        $query -> execute();
        $query -> closeCursor();
        
        return get_user_by_username($username);
    }   
    
	
	
    function get_game_by_unique_field($field, $value){
        return get_unique_field("games", $field, $value);
    }
    
    function get_games_by_unique_field($field, $value){
        return get_like_field("games", $field, $value);
    }
    
    function get_game_by_id($game_id){
        return get_game_by_unique_field("id", $game_id);
    }
    
    function get_games_by_title($title){
        return get_games_by_unique_field("title", $title);
    }
	
    function get_user_name($user_id){
        global $db;
        $string = "SELECT username FROM users WHERE id =  " . $user_id;
        $query = $db -> prepare($string);
        $query -> execute();
        $username = $query -> fetch();
        $query -> closeCursor();
        return $username;
    }
    
    
    
    function format_steam_price($s){
        return floatval($s / 100);
    }