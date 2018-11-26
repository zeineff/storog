<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Profile</title>
        <link rel="stylesheet" type="text/css" href="css/main.css">
        <link rel="stylesheet" type="text/css" href="css/comments.css">
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

				$comments = get_profile_comments($user_id);
				
	        ?>
        
	        <div id = "user_info">

				<h1><?php echo $user['username']; ?></h1>

				<div class = "vote">

			 	<span class = "like" >Like  
			 		<span> 0 </span> 
			 	</span>

			 	<span class = "dislike" >Dislike  
			 		<span> 0 </span> 
			 	</span>

			 </div>

			</div>

			<div class = "commentWrapper">

				<h3 class = "commentTitle">User feedback...
					<span class = "error"></span>
				</h3>

					<div class = "commentInsert">

						<h3 class = "whoSays"> <?php echo $user['username']; ?> </h3>

						<div class = "commentInsertContainer">
							<textarea id = "commentPostText" class = "commentInsertText"></textarea>
						</div>
						
						<div id = "commentPost" class = "commentPost">
							<input type="button" value="post" id = "commentPostBtnWrapper" class = "commentPostBtnWrapper">	
						</div>

					</div>

					<div class="commentsList">
						<ul class = "commentsHolder-ul">
							
							<?php foreach($comments as $comment): ?>

								<li class = "commentHolder"' . $argument['commentId'] . '>
									<div class = "commentBody">
									
										<h3 class = "usernameField"> <?php echo $comment['profile_id']; ?> </h3>
								
										<div class = "userImage"> 
											<img src=""width="55px"/>
										</div>

										<div class = "commentText">
											<?php echo $comment['content']; ?>
										</div>
									</div>
								</li>

							<?php endforeach; ?>

					</ul>
				</div>
			</div>
				
			</div>
        </main>
    </body>
</html>
