<?php

    //log user
    session_start();

    $error = "";  
	
     //if user press logout end session "logout"
	 //and end cookies
    if (array_key_exists("logout", $_GET)) {
        
        unset($_SESSION);
        setcookie("id", "", time() - 60*60);
        $_COOKIE["id"] = "";  
        
        session_destroy();
        
		//else redirecet to logged page
    } else if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])) {
        
		//the redirect
        header("Location: loggedinpage.php");
        
    }
          //check if user press submit button by name="submit"
		  //if it is connect to database
		  //else dont do nothing
    if (array_key_exists("submit", $_POST)) {
        
        include("connection.php");
        
		//if no user or password typed and press
		//submit at form get errors to error var
        if (!$_POST['email']) {
            
            $error .= "An email address is required<br>";
            
        } 
        
        if (!$_POST['password']) {
            
            $error .= "A password is required<br>";
            
        } 
        
		//if there is error echo it
		//else move along
        if ($error != "") {
            
            $error = "<p>There were error(s) in your form:</p>".$error;
            
        } else {
            
			//if the sign up pressed then
			//move along with sign up form
			//else go login form
            if ($_POST['signUp'] == '1') {
                 
				 //get the from database useing that email
				 //the user increse
                $query = "SELECT id FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";
                   
				   //update and save the requst to database
				   //to reuslt var
                $result = mysqli_query($link, $query);
                      
					  //if there is info echo error with
					  //email exists
					  //else add email and password to database
                if (mysqli_num_rows($result) > 0) {

                    $error = "That email address is taken.";

                } else {
					
                        //add to users table in database
						//the email and password the user entered
						//with mysqli_real..function use to get the true 
						//strings without errors
                    $query = "INSERT INTO `users` (`email`, `password`) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."', '".mysqli_real_escape_string($link, $_POST['password'])."')";
                          
						  //if there is an error 
						  //save and echo it
                    if (!mysqli_query($link, $query)) {

                        $error = "<p>Could not sign you up - please try again later.</p>";

                    } else {
						
                       //else store info to database useing
					   //md5 for stronger password
                        $query = "UPDATE `users` SET password = '".md5(md5(mysqli_insert_id($link)).$_POST['password'])."' WHERE id = ".mysqli_insert_id($link)." LIMIT 1";
                        
						//get the id user database
                        $id = mysqli_insert_id($link);
						
                        //update 
                        mysqli_query($link, $query);
						
                         //start session "login"
                        $_SESSION['id'] = $id;
						
                          //if staylog box is check
						  //start cookie also for stay the user
						  //as long we want
                        if ($_POST['stayLoggedIn'] == '1') {

                            setcookie("id", $id, time() + 60*60*24*365);

                        } 
                            //redirecet to login page
                        header("Location: loggedinpage.php");

                    }

                } 
                
            } else {
                    //if login form is choise
					//find that user useing email
                    $query = "SELECT * FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";
                
                    $result = mysqli_query($link, $query);
                
                    $row = mysqli_fetch_array($result);
					
                       //if email could not find
					   //end and echo error
                    if (isset($row)) {
                        
                        $hashedPassword = md5(md5($row['id']).$_POST['password']);
						
                        //else get user password useing the email
						//and match is to the user form password
						//useing md5 to get the full password
						//cuz it's securely
                        if ($hashedPassword == $row['password']) {
							
                            //if the passwords match
							//save the id for session
							//if stay log box is checked
							//longer the cookies
							//and redirect to loggin page
                            $_SESSION['id'] = $row['id'];
                            
                            if (isset($_POST['stayLoggedIn']) AND $_POST['stayLoggedIn'] == '1') {

                                setcookie("id", $row['id'], time() + 60*60*24*365);

                            } 

                            header("Location: loggedinpage.php");
                                
                        } else {
                            //else end and echo error
                            $error = "That email/password combination could not be found.";
                            
                        }
                        
                    } else {
                        
                        $error = "That email/password combination could not be found.";
                        
                    }
                    
                }
            
        }
        
        
    }
//include data from header page
//for header

?>
         
<?php include("header.php"); ?>
      
      <div class="container" id="homePageContainer">
      
    <h1>Secret Diary</h1>
          
          <p><strong>Store your thoughts permanently and securely.</strong></p>
          
          <div id="error"><?php if ($error!="") {
    echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
    
} ?></div>

<form method="post" id = "signUpForm">
    
    <p>Interested? Sign up now.</p>
    
    <fieldset class="form-group">

        <input class="form-control" type="email" name="email" placeholder="Your Email">
        
    </fieldset>
    
    <fieldset class="form-group">
    
        <input class="form-control" type="password" name="password" placeholder="Password">
        
    </fieldset>
    
    <div class="checkbox">
    
        <label>
    
        <input type="checkbox" name="stayLoggedIn" value=1> Stay logged in
            
        </label>
        
    </div>
    
    <fieldset class="form-group">
    
        <input type="hidden" name="signUp" value="1">
        
        <input class="btn btn-success" type="submit" name="submit" value="Sign Up!">
        
    </fieldset>
    
    <p><a class="toggleForms">Log in</a></p>

</form>

<form method="post" id = "logInForm">
    
    <p>Log in using your username and password.</p>
    
    <fieldset class="form-group">

        <input class="form-control" type="email" name="email" placeholder="Your Email">
        
    </fieldset>
    
    <fieldset class="form-group">
    
        <input class="form-control"type="password" name="password" placeholder="Password">
        
    </fieldset>
    
    <div class="checkbox">
    
        <label>
    
            <input type="checkbox" name="stayLoggedIn" value=1> Stay logged in
            
        </label>
        
    </div>
        
        <input type="hidden" name="signUp" value="0">
    
    <fieldset class="form-group">
        
        <input class="btn btn-success" type="submit" name="submit" value="Log In!">
        
    </fieldset>
    
    <p><a class="toggleForms">Sign up</a></p>

</form>
          
      </div>

<?php include("footer.php"); ?>


