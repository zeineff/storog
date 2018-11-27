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
    
    function search($title, $min, $max){
        $search_results = get_games_by_title($title);
        $games = create_game_objects($search_results);
        
        add_steam_prices($games);
        add_gog_prices($games);
        
        return filter_by_price($games, $min, $max);
    }
    
    function create_game_objects($search_results){
        $games = array();
        
        foreach ($search_results as $g){
            $id = $g["id"];
            $title = $g["title"];
            $steam_id = $g["steam_id"];
            $on_gog = $g["on_gog"];
            
            $game = new game();
            $game->id = $id;
            $game->title = $title;
            
            if (!is_null($steam_id)){
                $steam = new steam();
                $steam->steam_id = $steam_id;
                $game->steam = $steam;
            }
            
            if ($on_gog){
                $game->gog = new gog();
            }
            
            array_push($games, $game);
        }
        
        return $games;
    }
    
    function add_steam_prices($games){
        $steam_ids = array();
        
        foreach ($games as $g){
            $steam = $g->steam;
            
            if (!is_null($steam)){
                array_push($steam_ids, $steam->steam_id);
            }
        }
        
        $map = map_steam_ids_to_games($games);
        $api = "https://store.steampowered.com/api/appdetails?filters=price_overview&appids=" . comma_seperate($steam_ids);
        $json = json_decode(file_get_contents($api), true);
        
        foreach ($steam_ids as $id){
            $success = $json[$id]["success"] && !empty($json[$id]["data"]);
            
            if ($success){
                $price = $json[$id]["data"]["price_overview"]["final"] / 100;
                $map[$id]->steam->price = $price;
            }
        }
    }
    
    function add_gog_prices($games){
        $map = map_titles_to_games($games);
        
        foreach ($games as $g){
            if (!is_null($g->gog)){
                $title = $g->title;
                $api = "https://embed.gog.com/games/ajax/filtered?mediaType=game&search=" . $title;
                $json = json_decode(file_get_contents($api), true);
                $final_price = $json["products"][0]["price"]["finalAmount"];
                
                $map[$title]->gog->price = $final_price;
            }
        }
    }
    
    function map_steam_ids_to_games($games){
        $map = array();
        
        foreach ($games as $g){
            $steam = $g->steam;
            
            if (!is_null($steam)){
                $map[$steam->steam_id] = $g;
            }
        }
        
        return $map;
    }
    
    function map_titles_to_games($games){
        $map = array();
        
        foreach ($games as $g){
            $title = $g->title;
            
            $map[$title] = $g;
        }
        
        return $map;
    }
    
    function filter_by_price($games, $min, $max){
        $filtered = array();
        
        foreach ($games as $g){
            $valid = false;
            
            $steam = $g->steam;
            $gog = $g->gog;
            
            if (!is_null($steam)){
                $price = $steam->price;
                
                if ($price >= $min && $price <= $max){
                    $valid = true;
                }
            }
            
            if (!is_null($gog)){
                $price = $gog->price;
                
                if ($price >= $min && $price <= $max){
                    $valid = true;
                }
            }
            
            if ($valid){
                array_push($filtered, $g);
            }
        }
        
        return $filtered;
    }
    
    class game{
        public $id;
        public $title;
        public $steam;
        public $gog;
        
        function __construct(){
            
        }
    }
    
    class steam{
        public $steam_id;
        public $price;
        
        function __construct(){
            
        }
    }
    
    class gog{
        public $price;
        
        function __construct(){
            
        }
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

    function get_profile_comments($user_id){
        return search_table_equal("comments", "profile_id", $user_id);
    }