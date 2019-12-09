<?php
    if ( isset($_GET["errors"])){
        foreach($_GET["errors"] as $error){
            echo "<p class='alert alert-danger'> ". $error ."</p>";
        }
    }
?>