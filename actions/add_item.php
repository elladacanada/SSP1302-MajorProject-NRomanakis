<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/conn.php");

$errors = [];
// echo "<pre>";
// print_r($_POST);
// print_r($_FILES);
// print_r($errors);
// exit;

if( isset($_SESSION["user_id"]) && ($_SESSION["role"] == 1)):
    
        
    if(isset ($_POST["action"]) && $_POST["action"] == "add_item"):
        $price = $_POST["price"];
        $brand_id = $_POST["brand"];
        $description = htmlspecialchars($_POST["description"], ENT_QUOTES);
        $model_name = htmlspecialchars($_POST["model_name"], ENT_QUOTES);

        //if profile pic is set and there are no errors
        if( isset($_FILES["watch_pic"]) && $_FILES["watch_pic"]["error"] == 0){
            if(
                ($_FILES["watch_pic"]["type"] == "image/jpeg" ||
                 $_FILES["watch_pic"]["type"] == "image/jpg"  ||
                 $_FILES["watch_pic"]["type"] == "image/png"  ||
                 $_FILES["watch_pic"]["type"] == "image/gif") &&
                 $_FILES["watch_pic"]["size"] < 2000000 //byte size
            ){
                //File is correct type and size
                //upload to uploads folder

                //check if file already exists
                $file_name = $_SERVER["DOCUMENT_ROOT"] . "/uploads/". $_FILES["watch_pic"]["name"];

                 // THIS WHOLE SECTION MAKES SURE YOU ARE ABLE TO UPLOAD SAME IMAGE MORE THAN ONCE.  IT CHANGES THE NAMES BY ADDING THE CURRENT DATE INTO IT.
                 $file_name = explode(".", $file_name); //explode turns string into array
                 $file_extension = strtolower( end($file_name )); //end, gets last element of the array (file extension variable)
                 array_pop($file_name); // pop removes last elemnt from the array whioch is the file extension we took off above
                 $file_name[] = date("YmdHis"); // adds current datetime into array
                 $file_name[] = $file_extension; //  adds the extension back to the end of the array
                 $file_name = implode(".", $file_name); //glues array together into a string

                //go to document root
                if( !file_exists($file_name)){
                    
                    //upload to uploads folder we created
                    if(move_uploaded_file($_FILES["watch_pic"]["tmp_name"], $file_name)){

                            $insert_image_query = " INSERT INTO images (url) 
                                                    VALUES ('" .str_replace($_SERVER["DOCUMENT_ROOT"], "", $file_name). "')"; 
                            
                            if( mysqli_query($conn, $insert_image_query)){
                                $watch_pic_id = mysqli_insert_id($conn);
                                
                            }

                        }
                } else {
                    $errors[] = "FILE ALready Exists";
                }

            } else { //store error message
                $errors[] = "File error ".$_FILES["watch_pic"]["error"];
            }

        
        }else {
            $watch_pic_id = 'NULL';
        }
        
        if($brand_id != "" && $price != "" && $model_name != ""){

            $insert_query =     "INSERT INTO watch
                                (price, brand_id, description, model_name, watch_pic_id)
                                VALUES ('$price', $brand_id, '$description', '$model_name', $watch_pic_id)";

            if( mysqli_query($conn, $insert_query) ){
                //Get id of last entry in database
                $watch_id = mysqli_insert_id($conn);

                header("Location: http://" . $_SERVER["SERVER_NAME"]."/item.php?watch_id=$watch_id");
            } else{
                $errors[] = "Something went wrong: ".mysqli_error($conn);
            }
        
        } else {
            $error[] = "Please Fill In All Fields.";
        }
    endif;  


else:
    header("Location: http://".$_SERVER["SERVER_NAME"]);
endif;


if( !empty($errors) ) {
    $query = http_build_query( array("errors" => $errors) );
    header("Location: " . strtok($_SERVER["HTTP_REFERER"], "?") . "?watch_id=" . $watch_id . "&". $query); //referer brings you to referring page.  this reloads your page entirely. strtok and the question mark will strip away everything in url after question mark.??  not sure?



}





// mysqli_close($conn);
?>