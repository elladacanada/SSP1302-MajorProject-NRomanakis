<?php
require_once("conn.php");

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="/images/favicon.ico" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/css/styles.css">

    <title>Crowns & Jewels</title>

    

    <script src="https://kit.fontawesome.com/f5b4375698.js" crossorigin="anonymous"></script>

  </head>
  <body>

  <header>
    <nav class="navbar navbar-expand-lg px-5">
    
    <a class="navbar-brand " href="http://<?php echo $_SERVER['SERVER_NAME'];?>">Crowns & Jewels</a>
    
    <button class=" navbar-dark navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class=" navbar-toggler-icon"></span>
    </button>

  
    <div class="collapse navbar-collapse " id="navbarSupportedContent">
    
      <ul class="navbar-nav ml-auto mr-5">
        <li class="nav-item">
          <a class="nav-link" href="http://<?php echo $_SERVER['SERVER_NAME'];?>">Home</a>
        </li>
        <li class="nav-item">
          <a href="/store.php" class="nav-link">Shop</a>
        </li>
      
        <?php
        if( isset($_SESSION["user_id"])): //check if user is logged in (we created user id in login.php)
        ?>


        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" >Account</a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <?php
            if($_SESSION["role"] == 1):
            ?>

            <a href="add_item_interface.php" class="dropdown-item"> Add store Item</a>

            <?php
            endif;
            ?>
            <a class="dropdown-item" href="/user_profile.php">My Profile</a>
            <a class="dropdown-item" href="/edit_account_interface.php">Edit Account</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="/actions/login.php?action=logout">Logout</a>
          </div>
        </li>
        <?php
        else: //if user is not logged in 
          ?>
            <li class="nav-item"> 
              <a class="nav-link" href="http://<?php echo $_SERVER['SERVER_NAME'];?>/signup_in.php">Login/Register</a>
            </li>
            

          <?php

        endif;
        ?>
        <li class="nav-item">
          <a class="nav-link" href="/sorry.php"><i class="fas fa-shopping-cart"></i></a>
        </li>
        

      </ul>
      <form class="form-inline my-2 my-lg-0 ">
        
          <input class="form-control bg-transparent text-white" name="search" type="search" placeholder="Search" value="<?= (isset($_GET["search"]) ? $_GET["search"] : "") ?>">
          <div class="input-group-append">
            <button class=" btn btn-light text-warning my-2 my-sm-0" type="submit">Search</button>
          </div>
        
    </form>
    </div>
    
  </nav>
</header>