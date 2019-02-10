<?php

    session_start();
    
    $link = mysqli_connect("127.0.0.1","root","","twitter");

    if(mysqli_connect_errno())
    {
        print_r(mysqli_connect_error());
        exit();
    }
    
    if (isset($_GET['function']) == "logout")
    {
        session_destroy();
        header("Location:http://localhost/twitter/index.php");


    }
    function time_since($since) {
        $chunks = array(
            array(60 * 60 * 24 * 365 , 'year'),
            array(60 * 60 * 24 * 30 , 'month'),
            array(60 * 60 * 24 * 7, 'week'),
            array(60 * 60 * 24 , 'day'),
            array(60 * 60, 'hr'),
            array(60 , 'min'),
            array(1 , 'sec')
        );
    
        for ($i = 0, $j = count($chunks); $i < $j; $i++) {
            $seconds = $chunks[$i][0];
            $name = $chunks[$i][1];
            if (($count = floor($since / $seconds)) != 0) {
                break;
            }
        }
    
        $print = ($count == 1) ? '1 '.$name : "$count {$name}s";
        return $print;
    }
    
    function displayTweets($type)
        {
          global $link;
      
          if(isset($_SESSION['ID']) == '')
          {
              echo '<div class="jumbotron jumbotron-fluid" id = "jumbo">
              <div class="container">
                <h1 class="display-4"></h1>
                <p class="lead"></p>
              </div>
            </div>';
          }
          else
          {
                    if($type == 'public')
                    {
                        $whereclause = "";
                    }
                
                    else if($type == 'isFollowing')
                    {
                        $query = "SELECT * FROM follows WHERE  follower ='".mysqli_real_escape_string($link, $_SESSION['ID'])."' ";
                        $result = mysqli_query($link, $query); 
                        $whereclause = "";
                        while ($row = mysqli_fetch_assoc($result))
                        {
                                if ($whereclause == "") $whereclause = "WHERE ";
                                else $whereclause.= " OR ";
                                $whereclause.= "userid = '".$row['isFollowing']."'";
                        }
                    }
                    
                    else if( $type == 'yourTweets')
                    {
                        $whereclause = "WHERE userid ='".mysqli_real_escape_string($link,$_SESSION['ID'])."'";
                    }

                    else if($type == 'search')
                    {
                        echo '<p class = "alert alert-info shadow-lg">Showing results for '.'<strong>"'.mysqli_real_escape_string($link,$_GET['q']).'"</strong> </p>';
                        $whereclause = "WHERE tweets LIKE '%".mysqli_real_escape_string($link,$_GET['q'])."'";

                    }

                    else if(is_numeric($type))
                    {
                        $userquery = "SELECT * FROM users WHERE ID = '".mysqli_real_escape_string($link, $type)."' LIMIT 1" ;
                        $userQueryResult = mysqli_query($link, $userquery);
                        $user = mysqli_fetch_assoc($userQueryResult);
                        echo "<h3 style='font-family: calibri;'>".mysqli_real_escape_string($link, $user['email'])."'s Tweets</h3>";
                        $whereclause = "WHERE userid ='".mysqli_real_escape_string($link,$type)."'";
                    }

                $query = "SELECT * FROM tweets ".$whereclause." ORDER BY `datetime` DESC LIMIT 10";
                $result = mysqli_query($link, $query);
            
                if (mysqli_num_rows ($result) == 0)
                {
                    echo "There are no tweets to display";
                }
                
                else
                { 
                while( $row = mysqli_fetch_assoc($result))
                {    
                    $userquery = "SELECT * FROM users WHERE ID = '".mysqli_real_escape_string($link, $row['userid'])."' LIMIT 1" ;
                    $userQueryResult = mysqli_query($link, $userquery);
                    $user = mysqli_fetch_assoc($userQueryResult);
            
                    echo "<div class = 'card  shadow-sm '>
                    <p><a class = 'badge badge-light' href ='?page=publicprofile&userid=".$user['ID']."'><i class='fas fa-users'></i>"." ".$user['email']."</a>".
                    " <span style ='color: lightgray'>". time_since(time() - strtotime($row['datetime']))." ago</span>:</p>";
                    echo "<p class = 'lead'>".$row['tweets']."</p>";    
                    echo "<p><a class='btn btn-info toggleFollow'role='button' data-userId = '".$row['userid']."'>";
                    
                    $followingquery = "SELECT * FROM follows WHERE  follower ='".mysqli_real_escape_string($link, $_SESSION['ID'])."' AND `isFollowing` ='".mysqli_real_escape_string($link, $row['userid'])."' LIMIT 1";
                    $res = mysqli_query($link, $followingquery); 
                    if(mysqli_num_rows($res) > 0)
                    {
                        echo "Unfollow";
                    }
                    else
                    {
                        echo "Follow";
                    }
                    echo "</a></p></div>";
                } 
                }
        
        }
        }
    
        function displaySearch()
        {
            echo '<form class="form-inline my-2 my-lg-0">
            <input type = "hidden" name = "page" value = "search">
            <input class="form-control mr-sm-2" name="q" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-info  my-2 my-sm-1" style = "color: rgba(13,50,68,1)" >Search Tweets</button>
          </form>';
        }

        
        function displayTweetbox()
        {
            if (array_key_exists('ID',$_SESSION) && $_SESSION['ID'] > 0)
            {
                echo '<div id = "tweetSuccess" class="alert alert-success alert-dismissible fade show" role="alert">Your Tweet was successfully Posted!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button></div>
              <div id = "tweetFail"class="alert alert-danger alert-dismissible fade show" role="alert"></div>
              <div><p></p></div><div class="form-group">
                <textarea class="form-control" id="tweetContent" placeholder= "whats on your mind?" rows="3" onfocus = "this.value =\'\'"></textarea>
                <button class="btn btn-info my-2 my-sm-0 col-sm-12" id = "postTweet">Tweet</button>
              </div>';
            }
        }

        //TO SHOW WHO IS LOGGED IN
        function displayUser(){
            global $link;
            if(array_key_exists('ID',$_SESSION))
            {
            $userquery = "SELECT email FROM users WHERE ID = '".mysqli_real_escape_string($link, $_SESSION['ID'])."' LIMIT 1" ;
            $userQueryResult = mysqli_query($link, $userquery);
            $user = mysqli_fetch_assoc($userQueryResult);
            echo '<h3 class = "hometitle shadow-lg " style = "border-radius: 5px;
            padding: 10px;
            margin-top: 50px;
            font-family:calibri;"> Welcome '.$user['email'].' </h3>';
            }
        }


        //FOR PULBIC PROFILE
        function displayUsers(){
            global $link;
            
            $userquery = "SELECT * FROM users  LIMIT 10" ;
            $userQueryResult = mysqli_query($link, $userquery);
            while ($user = mysqli_fetch_assoc($userQueryResult))
            {
               echo "<p><a class='btn btn-light shadow profileresult' role='button' href='?page=publicprofile&userid=".$user['ID']."'><i class='fas fa-users'></i> ". $user['email']."</a></p>"; 
            }
               
        }
    
?>