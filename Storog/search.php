<?php
    include_once("functions/functions.php");
    
    $query = filter_input(INPUT_GET, "game_title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $games = get_games_by_title($query);
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Storog</title>
        <link rel="stylesheet" type="text/css" href="css/main.css">
    </head>
    
    <body>
        <?php include "includes/header.php"; ?>
        
        <main>
            <?php foreach ($games as $game) : ?>
                <a href="game.php?game_id=<?php echo $game["id"] ?>">
                    <?php echo $game["title"] ?>
                </a><br>
            <?php endforeach ?>
        </main>
    </body>
</html>
