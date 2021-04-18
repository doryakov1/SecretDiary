<?php
     
	 //session function to log user
    session_start();
     
	 //if ajax function is on (typeing) then
	 //connect to database and update info
    if (array_key_exists("content", $_POST)) {
        //connnect to database
        include("connection.php");
        
		//set the info
        $query = "UPDATE `users` SET `diary` = '".mysqli_real_escape_string($link, $_POST['content'])."' WHERE id = ".mysqli_real_escape_string($link, $_SESSION['id'])." LIMIT 1";
        
		//update it
        mysqli_query($link, $query);
        
    }

?>
