<footer class="footer mt-auto py-2">
  <div class="container">
    <span class="text-muted">&copy My Website 2019.</span>
  </div>
</footer

<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalTitle">Log in</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body container">
      <div class="alert alert-danger " role="alert" id = "error">
       
    </div>
      <form>
          <input type="hidden" id = "loginActive" name = "loginActive" value = "1">
          <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Email: </label>
                <div class="col-sm-10">
                    <input  type="email" class="form-control" id="email" placeholder="Email">
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                </div>
           <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Password:</label>
                <div class="col-sm-10">
                <input type="password" class="form-control" id="password" placeholder="Password">
                <a class = "forgot" id = "forgotpassword" href = "#">Forgot Password </a>    
                </div>
            </div>        
       
        </form>
      </div>
      <div class="modal-footer ">
        <div class = "container-fluid">
      <div >
        <button id = "login" class="btn btn-outline-info bg-col btn-md btn-block ">Login</button>
       </div>
      
         <p>

         </p>
       
       <div class = "notes" >
        <i id = "note"> Don't have an Account?</i>  <Small style = "color:white">?</small><a class="btn btn-outline-info btn-sm " id = "toggleLogin" >Sign Up </a>
        </div>
        <button id ="close" type="button" class="btn btn-info " data-dismiss="modal">Close</button>
		</div>
     </div>
    </div>
  </div>
</div>
<script>
    $("#toggleLogin").click(function(){
       if($("#loginActive").val() == "1")
       {
           $("#loginActive").val("0");
           $("#loginModalTitle").html("Sign Up");
           $("#login").html("Sign Up");
           $("#toggleLogin").html("Log In");
           $("#note").html("Already have an Account? ");
       }
       else
       {
        $("#loginActive").val("1");
           $("#loginModalTitle").html("Log In");
           $("#login").html("Log In");
           $("#toggleLogin").html("Sign Up");
           $("#note").html("Don't have an Account? ");
       }
       
    })

    $("#login").click(function(){
      $.ajax({
          type:"POST",
          url:"actions.php?action=loginSignup",
          data: "email="+ $("#email").val() + "&password=" +$("#password").val() + "&loginActive=" + $("#loginActive").val(),
          success: function(result)
          {
            if(result == "1")
            {
              window.location.assign("http://localhost/twitter/index.php/");
            }
            else
            {
                $("#error").html(result).show();
            }
          }
      })  

    });

    $(".toggleFollow").click(function()
    {
      var id = $(this).attr("data-userId");
          $.ajax({
          type:"POST",
          url:"actions.php?action=toggleFollow",
          data: "userId=" + id,
          success: function(results)
          {
            if (results == "1")
            {
              $("a[data-userId='" + id + "']").html("Follow");
            }
            else if (results == "2")
            {
              $("a[data-userId='" + id + "']").html("Unfollow");
            }
            
          }
      }) 
    
    });


    $("#postTweet").click(function(){
      
      $.ajax({
          type:"POST",
          url:"actions.php?action=postTweet",
          data: "tweetContent=" + $("#tweetContent").val(),
          success: function(results)
          {
            
            if(results == "1")
            {
              $("#tweetSuccess").show();
              $("#tweetFail").hide();

            }
            else if(results != "")
            {
              $("#tweetFail").html(results + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button>').show();
              $("#tweetSuccess").hide();
            }
            
          }
      }) 

    });


</script>
</body>
</html>