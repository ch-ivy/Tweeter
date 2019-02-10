<?php

   include("functions.php");
  
    if($_GET['action'] == "loginSignup")
    {
      
      $error = "";
       if (!$_POST['email']) 
       {
         $error .= "An email address is required<br>";
       }

      else if(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) === false)
		{
			$error .= "This is not a valid email address <br>";
		}	 
     
     if (!$_POST['password'])
      {
         
         $error .= "A password is required<br>";  
     } 
   
     else
     {
      if($_POST['loginActive'] == "0")
       {
            $query = "SELECT * FROM users WHERE  email ='".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";
            $result = mysqli_query($link, $query);
            if(mysqli_num_rows($result) > 0)
            {
               $error.="An account exists already with that email address";
            } 
            else
            {
               $query = "INSERT INTO users(email,password) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."','".mysqli_real_escape_string($link, $_POST['password'])."') ";
               if(mysqli_query($link, $query))
               {
                  $_SESSION['ID'] = mysqli_insert_id($link);

                  $query = "UPDATE users SET password = '".md5(md5($_SESSION['ID']).$_POST['password'])."'
                   WHERE ID = ".mysqli_insert_id($link)." LIMIT 1 ";
                   mysqli_query($link, $query);
                  echo 1;
               }
               else{
                  $error.="Couldn't create User, Please Try again Later!";
               }
            }
          
       }
       else
       {
         $query = "SELECT * FROM users WHERE  email ='".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";
         $result = mysqli_query($link, $query);
         $check = mysqli_fetch_assoc($result);
            if ($check['password'] == md5(md5($check['ID']).$_POST['password']))
            {
               echo 1;
               $_SESSION['ID'] = $check['ID'];
            }
            else
            {
               $error.= "You have typed in an incorrect password or Email please Try again!";
            }
       }
     
      }
      if ($error != "") {
         
         echo $error = '<strong>OOPS!</strong><br>' . $error;	
          
       }
    }

    if($_GET['action'] == "toggleFollow")
    {
      $query = "SELECT * FROM follows WHERE  follower ='".mysqli_real_escape_string($link, $_SESSION['ID'])."' AND `isFollowing` ='".mysqli_real_escape_string($link, $_POST['userId'])."' LIMIT 1";
      $result = mysqli_query($link, $query); 
      if(mysqli_num_rows($result) > 0)
      {
         $row = mysqli_fetch_assoc($result);
         mysqli_query($link, "DELETE FROM follows WHERE ID ='".mysqli_real_escape_string($link,$row['ID'])."'LIMIT 1");
         echo "1";
      }
      else
      {
         $row = mysqli_fetch_assoc($result);
         mysqli_query($link, "INSERT INTO follows (follower, `isFollowing`) VALUES('".mysqli_real_escape_string($link,$_SESSION['ID'])."','".mysqli_real_escape_string($link,$_POST['userId'])."') ");
         echo "2";
      }
    
   }
   if($_GET['action'] == "postTweet")
   {
      if(!$_POST['tweetContent'])
      {
         echo 'But there is nothing to Post though! <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
       </button>';
      }
      else if(strlen($_POST['tweetContent']) > 140)
      {
         echo 'Your Tweet is too Long! <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
       </button>';
      }
      else{
         mysqli_query($link, "INSERT INTO tweets (tweets, `userid`, `datetime`) VALUES('".mysqli_real_escape_string($link,$_POST['tweetContent'])."','".mysqli_real_escape_string($link,$_SESSION['ID'])."',  Now()) ");
          echo "1";

      }
   }

?>