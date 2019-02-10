
<div class = "container ho">
<div class="row">
    <div class="col-sm-8">
    <h4 class = "hometitle " style = "border-radius: 5px;
    padding: 10px;
    margin:10px;
    ">Tweets from your Tweeps</h4>
    <?php

     displayTweets('isFollowing');
     
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