Hi there!
<div class = "container ho">
<div class="row">
    <div class="col-sm-8">
    <?php
        if (array_key_exists('userid',$_GET) && $_GET['userid'])
        {
            displayTweets($_GET['userid']);
        } 
       else { 
    ?>
       
    <h4 class = "hometitle " style = "border-radius: 5px;
    padding: 10px;
    margin:10px;
    ">Active Users</h4>
    <?php
       
     displayUsers();
       }
    ?>
    </div>
    <div class="col-sm-4">
        <?php displaySearch();
        ?>
        <hr>
        <?php displayTweetbox();
        ?>
    </div>
  </div>
</div>