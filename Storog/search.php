<?php
    include_once("functions/functions.php");
    include_once("functions/api_calls.php");
    
    $title = filter_input(INPUT_GET, "query", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $min_price = filter_input(INPUT_GET, "min_price", FILTER_SANITIZE_NUMBER_FLOAT);
    $max_price = filter_input(INPUT_GET, "max_price", FILTER_SANITIZE_NUMBER_FLOAT);
    
    if (empty($min_price)){
        $min_price = 0;
    }
    
    if (empty($max_price)){
        $max_price = 1000;
    }
    
    // Maps acronyms to full title e.g. TES -> The Elder Scrolls
    $alt = map_acronyms($title);
    $games = array();
    
    if ($alt !== $title){  // Search by acronym first
        $games += get_games_by_title($alt);
    }
    
    $games += get_games_by_title($title);
    $games_found = sizeof($games) !== 0;
    
    if ($games_found){
        $steam_ids = array();
        $i = 0;  // Current game index
        
        // Links games by their steam_id to their position in $games
        $map = array();
        
        foreach ($games as $g){
            $steam_id = $g["steam_id"];
            $on_steam = !is_null($steam_id);
            
            if ($on_steam){
                array_push($steam_ids, $steam_id);
                $map += [$steam_id => $i];
            }
            
            $i++;
        }
        
        $steam_prices = get_steam_prices($steam_ids);
        
        foreach($steam_ids as $id){
            $g = $steam_prices[$id];
            
            if ($g["success"]){  // If game has a steam price add it to $games
                $games[$map[$id]]["steam_price"] = $g["price"];
            }
        }
    }
    
    for ($i = 0; $i < sizeof($games); $i++){
        if (isset($games[$i]["steam_price"])){
            $price = $games[$i]["steam_price"];
            
            if ($price < $min_price || $price > $max_price){
                unset($games[$i]);
                
                if ($i != sizeof($games) - 1){
                    $i--;
                }
            }
        }
    }
    
    $count = sizeof($games);  // Number of games found
    $plural = $count > 1;     // True if two of more games found
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Search results</title>
        <link rel="stylesheet" type="text/css" href="css/main.css">
        <link rel="stylesheet" type="text/css" href="css/search.css">
    </head>
    
    <body>
        <?php include "includes/header.php"; ?>
        
        <main>
            <?php
            if (!$games_found){
                echo "<p>No games found.</p>";
            }else{?>
                <div id="search_results">
                    <p> <?php echo $count ?> game<?php if ($plural){echo "s";} ?> found.</p>
                    <?php if ($count > 20) : ?>
                        <p>Perhaps try using advanced search?</p>
                    <?php endif; ?>

                    <br>
                
                    <?php foreach ($games as $game) : ?>
                        <div class="search_game">
                            <a href="game.php?game_id=<?php echo $game["id"] ?>">
                                <?php echo $game["title"]; ?><br>
                            </a>
                            <?php
                                if (isset($game["steam_price"])){
                                    echo "<p>€" . $game["steam_price"] . " on Steam</p><br>";
                                } ?>
                            <br>
                        </div>
                    <?php endforeach; }?>
                </div>
        </main>
    </body>
</html>
