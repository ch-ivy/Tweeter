<?php
date_default_timezone_set('Europe/Athens');
include("functions.php");
include("views/header.php");
if(array_key_exists('page',$_GET) && $_GET['page'] == 'home')
{
    include("views/timeline.php");
}
else if(array_key_exists('page',$_GET) && $_GET['page'] == 'yourtweets')
{
    include("views/yourtweets.php");
}
else if(array_key_exists('page',$_GET) && $_GET['page'] == 'search')
{
    include("views/search.php");
}
else if(array_key_exists('page',$_GET) && $_GET['page'] == 'publicprofile')
{
    include("views/publicprofile.php");
}
else
{
    include("views/home.php");
}

include("views/footer.php");


?>