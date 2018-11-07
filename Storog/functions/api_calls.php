<?php
    function return_steam_game_info($appid){
        $steam_search = "https://store.steampowered.com/api/appdetails?appids=" . $appid;

        $json = json_decode( file_get_contents($steam_search), true );

	$price = $json[$appid]["data"]["price_overview"]["initial"];

        $game_data = array(
            "title" => $json[$appid]["data"]["name"],
            "description" => $json[$appid]["data"]["short_description"],
            "price" => $price,
            "image" => $json[$appid]["data"]["header_image"]
	);

	return $game_data;
    }