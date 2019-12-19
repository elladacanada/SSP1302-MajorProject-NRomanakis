<?php
require_once("header.php");

$user_id = ( isset($_GET["user_id"]) ) ? $_GET["user_id"] : $_SESSION["user_id"];

$user_query = "  SELECT users.*, provinces.names AS province_name
                 FROM users 
                 LEFT JOIN provinces 
                 ON users.province_id = provinces.id
                 WHERE users.id = " . $user_id;

if( $user_request = mysqli_query($conn, $user_query)) :
    while( $user_row = mysqli_fetch_array($user_request)) :
        // print_r($user_row);
        ?>

            <div class="container my-5">
                <div class="row">
                    <div class="col-12">
                    <?php
                        include_once($_SERVER["DOCUMENT_ROOT"] . "/includes/error_check.php");
                    ?>
                    </div>
                    <div class="col-md-12  text-center">
                        
                        <h1><?php echo $user_row["first_name"] . " " . $user_row["last_name"];?></h1>
                        <p>
                            <?=$user_row["address"];?><br>
                            <?=($user_row["address2"] != "") ? $user_row["address2"] . "<br>" : '';?>
                            <?=$user_row["city"] . ", " . $user_row["province_name"];?> <br>
                            <?=$user_row["postal_code"];?>
                        </p>
                        <p>
                            <?=$user_row["email"];?>
                        </p>
                        <hr>
                        <?php
                        if($_SESSION["user_id"] == $user_id || $_SESSION["role"] == 1) :
                        ?>
                        <div class="btn-group">
                            <a class="btn btn-outline-primary" href="/edit_account_interface.php?user_id=<?=$user_row["id"];?>">Edit Account Details</a>
                        </div>
                        <?php
                        endif ;
                        ?>
                    </div>
                </div>
            </div>

        <?php
    endwhile ; 
else :
    echo mysqli_error($conn);
endif ;

require_once("footer.php");
?>
