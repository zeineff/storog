<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Profile</title>
        <link rel="stylesheet" type="text/css" href="css/main.css">
        <script type="text/javascript" src="js/jquery-3.3.1.js"></script>
        <script type="text/javascript" src="js/votes.js"></script>
    </head>
    
    <body>
    	<main>
	        <?php

	            include "includes/header.php";
	            include "functions/functions.php";
	            
	            $user_id = filter_input(INPUT_GET, 'user_id', FILTER_VALIDATE_INT);
				$user = get_user_by_id($user_id);

				$comments = array(array("content" => "abc"));

	        ?>
        
	        <div id = "user_info">

				<h1><?php echo $username['username']; ?></h1>

				<div class = "vote">

			 	<span class = "like" >Like  
			 		<span> 0 </span> 
			 	</span>

			 	<span class = "dislike" >Dislike  
			 		<span> 0 </span> 
			 	</span>

			 </div>

			</div>

			<div id = "comment_box">

				<div class = "comment">
					<p>sdf</p>
				</div>
				
			</div>
        </main>
    </body>
</html>
