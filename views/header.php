<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" media="screen" href="http://localhost/twitter/styles.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">


    <title>Tweexies</title>
  </head>
  <body class="d-flex flex-column h-100">
     <div id = "body">
        <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-custom " 
         id = "nav">
        <a class="navbar-brand " href="http://localhost/twitter/index.php">
        <img  id = "logo" src="http://localhost/twitter/views/logo.png" width="30" height="30"  alt="" >
        Tweeter</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto  ">
            <li class="nav-item ">
                <a class="nav-link " href="?page=home">Home </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?page=yourtweets">Your Tweets</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="?page=publicprofile">Public Profiles</a>
            </li>
            </ul>
            <div class="form-inline my-2 my-lg-0"><?php 
            if(isset($_SESSION['ID']))
            { ?>
                <a class="btn btn-outline-info my-2 my-sm-0" href="?function=logout"> Logout </a>
            <?php
            }
            else{ 
             ?>
            <button class="btn btn-outline-info my-2 my-sm-0" data-toggle="modal" data-target="#exampleModalCenter">Login/signUp</button>
            <?php
            }
            ?>
</div>
        </div>
        </nav>
     