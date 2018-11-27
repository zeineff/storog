<?php
    include_once("functions/functions.php");
    include_once("functions/api_calls.php");
    
    $title = filter_input(INPUT_GET, "query", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $min_price = filter_input(INPUT_GET, "min_price", FILTER_SANITIZE_NUMBER_FLOAT);
    $max_price = filter_input(INPUT_GET, "max_price", FILTER_SANITIZE_NUMBER_FLOAT);
    
    $min_price = (empty($min_price) ? 0 : $min_price);
    $max_price = (empty($max_price) ? 1000 : $max_price);
    
    $games = search($title, $min_price, $max_price);
    //print_r($games);
    $games_found = sizeof($games) > 0;
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
                            <a href="game.php?game_id=<?php echo $game->id ?>">
                                <?php echo $game->title; ?><br>
                            </a>
                            <?php
                                $steam = $game->steam;
                                if (!is_null($steam)){
                                    echo "<p>€" . $steam->price . " on Steam</p>";
                                }
                                
                                $gog = $game->gog;
                                if (!is_null($gog)){
                                    echo "<p>€" . $gog->price . " on GOG</p>";
                                }
                            ?>
                            <br>
                        </div>
                    <?php endforeach; }?>
                </div>
        </main>
    </body>
</html>
