
    <!-- jQuery first -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    
      
      <script type="text/javascript">
	  
      //toggle form one display = "none" and one not
        $(".toggleForms").click(function() {
            
            $("#signUpForm").toggle();
            $("#logInForm").toggle();
            
            
        });
		
          //when typing update info to database to url updatedatabase
		  //useing bind function and useing ajax
          $('#diary').bind('input propertychange', function() {

                $.ajax({
                  method: "POST",
                  url: "updatedatabase.php",
                  data: { content: $("#diary").val() }
                });

        });
      
      
      </script>
      
  </body>
</html>


