<?php
    $game_id = filter_input(INPUT_GET, "game_id", FILTER_SANITIZE_NUMBER_INT);
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
            <h2>Game Title</h2>
            
            <img src="img/steam_logo.png" id="game_cover" alt="game_cover">
            
            <p id="game_description">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            
            <ul id="stores">
                <li>A</li>
                <li>B</li>
                <li>C</li>
            </ul>
        </main>
    </body>
</html>
