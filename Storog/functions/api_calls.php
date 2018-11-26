<?php
    function return_steam_game_info($appid){
        $steam_search = "https://store.steampowered.com/api/appdetails?appids=" . $appid;

        $json = json_decode( file_get_contents($steam_search), true );
        
        $data = $json[$appid]["data"];
        
        $game_data = array(
            "title" => $data["name"],
            "description" => $data["short_description"],
            "image" => $data["screenshots"]["0"]["path_thumbnail"],
            "header_image" => $data["header_image"],
            "is_free" => $data["is_free"],
            "released" => !$data["release_date"]["coming_soon"],
            "developers" => $data["developers"]
	);
        
        if (!$data["is_free"]){
            if (!$data["release_date"]["coming_soon"]){
                $game_data["price"] = $data["price_overview"]["final"];
            }
        }
        
        $game_data["release_date"] = $data["release_date"]["date"];

	return $game_data;
    }
    
    function get_steam_prices($steam_ids){
        $api = "https://store.steampowered.com/api/appdetails?filters=price_overview&appids=" . comma_seperate($steam_ids);
        $json = json_decode(file_get_contents($api), true);
        $prices = array();
        
        foreach ($steam_ids as $id){
            $success = $json[$id]["success"] && !empty($json[$id]["data"]);
            $game = array("success" => $success);
            
            if ($success){
                $data = $json[$id]["data"]["price_overview"];
                $game += ["price" => $data["final"] / 100];
            }
            
            $prices += [$id => $game];
        }
        
        return $prices;
    }
    
    function return_gog_game($game_name){
            $game_name = explode(" ", $game_name);

            $game_name = implode("%20", $game_name);

            $gog_search = "https://embed.gog.com/games/ajax/filtered?mediaType=game&search=" . $game_name;

            $json = json_decode( file_get_contents($gog_search), true );

            #print_r($json["products"]["0"]["price"]["finalAmount"]);

            $game_info = array(
                    "title" => $json["products"]["0"]["title"],
                    "price" => $json["products"]["0"]["price"]["finalAmount"],
                    "slug" => $json["products"]["0"]["slug"]
            );

            return $game_info; 
    }
?>