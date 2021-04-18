<?php

//connect to database useing servername/user or database name/password/ and again user or database name
    $link = mysqli_connect("servername", "user or database name", "password", "and again user or database name");
        
		//if there is an error break and echo it
        if (mysqli_connect_error()) {
            
            die ("Database Connection Error");
            
        }

?>