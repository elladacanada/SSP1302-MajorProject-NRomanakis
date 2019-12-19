<?php

/* step 2 */

require_once($_SERVER["DOCUMENT_ROOT"] . "/conn.php");

$errors = [];
$success = [];


if( isset($_POST["action"]) && $_POST["action"] == "login") : //login button on index page has action name of login.
    //get the users email and password
    //connect to users table
    //check if user exists and password matches
    //if not, send error
    //if correct, login and go to index/profile page

    if(
        ( isset($_POST["email"]) && $_POST["email"] != "") &&
        ( isset($_POST["password"]) && $_POST["password"] != "")
       ){
        $email = $_POST["email"];
        $password = md5($_POST["password"]); //wrap in md5 to hash the password

        $query_users = "SELECT * 
                        FROM users 
                        WHERE email = '" . $email . "'
                        AND password = '" . $password . "' 
                        LIMIT 1"; //select all from users table in database. Limit 1 ensures only 1 person with a specific email and password. 

        $user_result = mysqli_query($conn, $query_users);

        //check if user is in database
        // print_r($query_users);
        
        if(mysqli_num_rows($user_result) > 0 ){
        //User Found!!!

            // STEP 4
            // STEP 4
            // STEP 4 START
            //get all of the users rows from the database
            while($user = mysqli_fetch_array($user_result)){
                // print_r($users);
                session_destroy(); // destroy any current session that may be running.
                session_start(); // start fresh session.

                $_SESSION["email"] = $user["email"];
                $_SESSION["role"] = $user["role"]; 
                $_SESSION["user_id"] = $user["id"]; 
                //this tracks certain things during the logged in session. can add other sessions like first name, last name etc

                header("Location: http://" . $_SERVER["SERVER_NAME"] . "/store.php");

            }
            // STEP 4 END
        } else {
            $errors[] = "Email or Password incorrect.";
        }



    } else {
        $errors[] = "Please Fill Out Username & Password";
    }


    //Step 7?
    //If action is sign up
elseif( isset($_POST["action"]) && $_POST["action"] == "signup") :

    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $password = md5($_POST["password"]);
    $password2 = md5($_POST["password2"]);
    $agree_terms = $_POST["agree_terms"];
    $newsletter = (isset($_POST["newsletter"]) ) ? 1 : 0;
    $date_created = date("Y-m-d H:i:s");

    echo "<pre>";
    print_r($_POST);
    // exit;

    if($password == $password2 && strlen($password) > 7){
        //continue
        if( isset($_POST["agree_terms"])){
            //continue
            if($email !== "" && $first_name !== "" && $last_name !== "" ){
                //I made it!!!
                
                    //STEP 8 ADDING TO DB
                    $new_user_query = "INSERT INTO users 
                                        (first_name, 
                                        last_name, 
                                        email, 
                                        password,
                                        newsletter, 
                                        date_created,
                                        role) 
                                VALUES ('$first_name',
                                        '$last_name', '
                                        $email', 
                                        '$password',
                                        $newsletter, 
                                        '$date_created', 2)"; //integers are not put into quotes

                        //mysqli_query($conn, $new_user_query) changed to if statement below to check for errors
                        if( !mysqli_query($conn, $new_user_query)) { //this if statement is not necessary but it will echo any errors in the query, but you need the echo and print_r that we have at the top of the page
                            echo mysqli_error($conn);
                        } else {
                            //log user in and go to homepage
                            $user_id = mysqli_insert_id($conn);

                            session_destroy();
                            session_start(); //set session data

                            $_SESSION["user_id"] = $user_id;
                            $_SESSION["role"] = 2;
                            $_SESSION["email"] = $email;

                            header("Location: http://". $_SERVER["SERVER_NAME"]);


                        }

                //END I made it!!!
            } else{
                $errors[] = "Please fill out required fields";
            }
        }else {
            $errors[] = "You must agree to our terms";
        }
    }else {
        $errors[] = "Passwords do not match";
    }


    //step 6 start
    //if log out button clicked
elseif( isset($_REQUEST["action"]) && $_REQUEST["action"] == "logout") :
    session_destroy();
    header("Location: http://" . $_SERVER["SERVER_NAME"] );
//step 6 end

endif;


// step 3 show error message.  this links to the step 3 on index page

if( !empty($errors) ) {
    $query = http_build_query( array("errors" => $errors) );
    header("Location: " . strtok($_SERVER["HTTP_REFERER"], "?") . "?" . $query); //referer brings you to referring page.  this reloads your page entirely. strtok and the question mark will strip away everything in url after question mark.??  not sure?



}
mysqli_close($conn);
?>