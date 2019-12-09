<?php
require_once("header.php");


if( !isset($_SESSION["user_id"]) && ($_SESSION["role"] != 1)){
    header("Location: http://".$_SERVER["SERVER_NAME"] . "/signup.php");
}


?>

<div class="container mt-5 mb-5">
    <form action="/actions/add_item.php" method="post" enctype="multipart/form-data">

        <?php
        include_once($_SERVER["DOCUMENT_ROOT"] . "/includes/error_check.php");
        
        ?>



        <div class="row">
            <div class="col-md-6">
                <div class="form-row form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" tabindex="3" class="form-control"  placeholder="Description" rows="10" ></textarea>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-row form-group">
                    <label for="watch_pic">watch pic</label>
                    <input type="file" name="watch_pic" placeholder="Upload Image" class="form-control">
                </div>
                <div class="form-row form-group">
                    
                        <label for="brand">Brand</label>
                        <select tabindex="4" id="brand" class="form-control" name="brand">
                            <?php
                            $brand_query = "SELECT * FROM watch_brand";
                            if($brand_results = mysqli_query($conn, $brand_query)) :
                                echo "<option disabled selected>Brand</option>";
                                while($brand = mysqli_fetch_array($brand_results)):
                            ?>

                            <option value="<?=$brand["id"];?>"><?php echo $brand["brand_name"]; ?></option>

                            <?php
                                endwhile;
                            else:
                                echo mysqli_error($conn);
                            endif;
                        
                            ?>
                        </select>
                            
                   
                </div>
                <div class=" form-row form-group">
                    <label for="model_name">Model Name</label>
                    <input type="text" tabindex="1" id="model_name" name="model_name" placeholder="Model Name" class="form-control">
                </div>
                
                <div class="form-row form-group">
                    <label for="price">Price</label>
                    <input type="text" tabindex="2" id="price" name="price" placeholder="Price" class="form-control">
                </div>
            </div>
        </div>

        <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-row form-group mt-3">
                        <div class="ml-auto">
                            <button type="submit" tabindex="3" name="action" class="btn btn-primary" value="add_item">Add New Item</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


<?php

require_once("footer.php");

?>