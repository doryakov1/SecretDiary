<?php
     
	 //session function to log user
    session_start();
    //$diaryContent="";

	
	//if cookie exists longer the time and pass id
    if (array_key_exists("id", $_COOKIE) && $_COOKIE ['id']) {
        
        $_SESSION['id'] = $_COOKIE['id'];
        
    }

    if (array_key_exists("id", $_SESSION)) {
              //if user login
			  //get diary content
			  //from database
			  //and echo it to screen textarea
      include("connection.php");
      
      $query = "SELECT diary FROM `users` WHERE id = ".mysqli_real_escape_string($link, $_SESSION['id'])." LIMIT 1";
      $row = mysqli_fetch_array(mysqli_query($link, $query));
 
      $diaryContent = $row['diary'];
      
    } else {
        //else redirect to index page
        header("Location: index.php");
        
    }

	include("header.php");

?>
<nav class="navbar navbar-light bg-faded navbar-fixed-top">
  

  <a class="navbar-brand" href="#">Secret Diary</a>

    <div class="pull-xs-right">
      <a href ='index.php?logout=1'>
        <button class="btn btn-success-outline" type="submit">Logout</button></a>
    </div>

</nav>



    <div class="container-fluid" id="containerLoggedInPage">

        <textarea id="diary" class="form-control"><?php echo $diaryContent; ?></textarea>
    </div>
<?php
    
    include("footer.php");
?>