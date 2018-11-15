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