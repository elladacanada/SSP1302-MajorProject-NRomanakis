<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/conn.php");

    $errors = [];
    // print_r($_POST);
    //UPDATE USER

if( isset($_POST["action"]) && $_POST["action"] == "update" ) :
    
    
    if( isset($_SESSION["user_id"]) && ($_SESSION["user_id"] == $_POST["user_id"] || $_SESSION["role"] == 1) ) {
        $user_id = $_POST["user_id"];
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $address = $_POST["address"];
        $address2 = $_POST["address2"];
        $city = $_POST["city"];
        $postal_code = $_POST["postal_code"];
        $province_id = (isset($_POST["province_id"])) ? $_POST["province_id"] : 0;
        $email = $_POST["email"];

        if(($first_name == '' || $last_name == '' ) && !empty($errors)){
            $errors[] = "Fields Cannot Be Empty";
        } else {
            $update_query =    "UPDATE  users 
                                SET     first_name = '$first_name',
                                        last_name = '$last_name', 
                                        address = '$address', 
                                        address2 = '$address2', 
                                        city = '$city', 
                                        postal_code = '$postal_code', 
                                        province_id = $province_id,
                                        email = '$email'
                                WHERE   id =  $user_id ";

            if( mysqli_query($conn, $update_query) ){
                header("Location: " . strtok($_SERVER["HTTP_REFERER"], "?") . "?user_id=" . $user_id . "&success=User+Updated");
            } else {
                $errors[] = mysqli_error($conn);
                print_r($errors);
            }
        }
    } else {
        $errors[] = "You don't have permission to do that.";
        print_r($errors);
    }

elseif( isset($_POST["action"]) && $_POST["action"] == "delete") :
    $user_id = $_POST["user_id"];
    $delete_query = "DELETE FROM users WHERE id = $user_id";
    $select_query = "SELECT * FROM users WHERE id = $user_id";

    if($user_result = mysqli_query($conn, $select_query)) {
        while($user_row = mysqli_fetch_array($user_result)){
            if($user_row["role"] != 1) {
                if(mysqli_query($conn, $delete_query)) {
                    if($user_row["id"] == $_SESSION["user_id"]){
                        session_destroy();
                        header("Location: http://" . $_SERVER["SERVER_NAME"]);
                    }
                } else {
                    $errors[] = mysqli_error($conn);
                }
            } else {
                $errors[] = "Cannot Delete Super Admin";
            }
        }
    } else {
        $errors[] = "User does not exist: " . mysqli_error($conn);
    }

elseif( isset($_POST["action"]) && $_POST["action"] == "change_password") :
    $user_id            = $_POST["user_id"];
    $current_password   = md5($_POST["password"]);
    $new_password       = md5($_POST["new_password"]);
    $new_password2      = md5($_POST["new_password2"]);

    $select_query = "   SELECT * FROM users
                        WHERE id = $user_id AND PASSWORD = '$current_password'";

    $select_result = mysqli_query($conn, $select_query);
    if(mysqli_num_rows($select_result) > 0) {
        if($new_password == $new_password2){

            $update_query = "UPDATE users SET password = '$new_password' WHERE id = $user_id";
            if(mysqli_query($conn, $update_query)){
                header("Location: http://" . $_SERVER["SERVER_NAME"] . "/user_profile.php?success=Password+Reset");
            } else {
                $errors[] = "Something Went Wrong: " . mysqli_error($conn);
            }
        } else {
            $errors[] = "New Passwords Do Not Match";
        }
    } else {
        $errors[] = "Current Password Is Incorrect! " . mysqli_error($conn);
    }

endif;
?>