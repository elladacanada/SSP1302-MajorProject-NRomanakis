<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
/*-- step 2 make session on conn page-->*/

session_start(); //starts a session to pass your session variables (for sites with logins)

if( $_SERVER["SERVER_NAME"] == "dev.morphemedia.ca") {
    // PRODUCTION - Connects to PLESK DataBase
    $conn = mysqli_connect("localhost", "majorproj_dbuser", "L3q42!*@ZkGe", "ssp1302majorproject-nromanakis");
} else {
    // PRODUCTION - Connects to MAMP DataBase
    $conn = mysqli_connect("localhost", "root", "root", "ssp1302majorproject-nromanakis");
}

if(mysqli_connect_errno( $conn )){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();

}





?>
