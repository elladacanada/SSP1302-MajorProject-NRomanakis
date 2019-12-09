<?php
require_once("header.php");

$user_id = ( isset($_GET["user_id"]) ) ? $_GET["user_id"] : $_SESSION["user_id"];

$user_query = " SELECT * FROM users WHERE id = " . $user_id;

if($user_request = mysqli_query($conn, $user_query)) :
    while ( $user_row = mysqli_fetch_array($user_request)):
        // print_r($user_row)
?>


<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Update Your Account</h1>
            
            <form action="/actions/edit_account.php" method="post" enctype="multipart/form-data"> 

            <?php include_once($_SERVER["DOCUMENT_ROOT"] . "/includes/error_check.php")?>
            
            <!-- this hidden input needed to padd user id -->
            <input type="hidden" name="user_id" value="<?php echo $user_row["id"]; ?>">

            <div class="form-row form-group">
                <div class="col">
                    <input type="text" tabindex="1" name="first_name" placeholder="First Name" class="form-control" value="<?php echo $user_row["first_name"];?>">
                </div>
                <div class="col">
                    <input type="text" tabindex="2" name="last_name" placeholder="last Name" class="form-control" value="<?php echo $user_row["last_name"];?>">
                </div>
            </div>
            <div class="form-row form-group">
                <div class="col">
                    <input type="text" tabindex="3" name="address" placeholder="Address" class="form-control" value="<?php echo $user_row["address"];?>">
                </div>
                <div class="col">
                    <input type="text" tabindex="4" name="address2" placeholder="Address2" class="form-control" value="<?php echo $user_row["address2"];?>">
                </div>
            </div>
            <div class="form-row form-group">
                <div class="col">
                    <input type="text" tabindex="5" name="city" placeholder="City" class="form-control" value="<?php echo $user_row["city"];?>">
                </div>
                <div class="col">
                    <input type="text" tabindex="6" name="postal_code" placeholder="Postal Code" class="form-control" value="<?php echo $user_row["postal_code"];?>">
                </div>
            </div>

            <div class="form-row form-group">
                <div class="col">
                    <select class="form-control" name="province_id" tabindex="7" >

                        <?php
                        $province_query = "SELECT * FROM provinces";

                        if($province_results = mysqli_query($conn, $province_query)):
                            echo "<option disabled ";

                            if( !$user_row["province_id"]) echo "selected";
                                echo ">Province</option>";
                                while($province = mysqli_fetch_array($province_results)):
                        ?>

                        <option value="<?=$province["id"];?>" <?php
                        if($province["id"] == $user_row["province_id"]) echo " selected";
                        ?>><?php echo $province["names"]?></option>

                        <?php
                            endwhile;
                        else:
                            echo mysqli_error($conn);
                        endif;
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="col-6">
                    <input type="email" tabindex="8" name="email" placeholder="Email" class="form-control" value="<?php echo $user_row["email"];?>">
                </div>
                
            </div>
            
            <hr>
            <div class="form-row">
                
                <?php 
                if($_SESSION["user_id"] == $user_id || $_SESSION["role"] == 1):
                ?>
                    <div class="col">
                        <a href="/reset_password.php">Change Password</a>
                    </div>
                    <div class="col text-right">
                        <button type="submit" name="action" class="btn btn-text text-danger" value="delete">Delete Account</button>
                        <button type="submit" tabindex="3" name="action" class="btn btn-primary" value="update">Update Account</button>
                    </div>
                <?php
                    endif;
                ?>
            </div>

            </form>
        </div>
    </div>
</div>


<?php
endwhile;
else :
    echo mysqli_error($conn);

endif;

require_once("footer.php");
?>
