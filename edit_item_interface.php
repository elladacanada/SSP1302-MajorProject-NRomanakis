<?php

require_once("header.php");

$errors = [];
$success = [];

$watch_id = $_GET["watch_id"];

$watch_query = " SELECT watch.*, images.url AS watch_pic
                FROM watch
                LEFT JOIN images
                ON watch.watch_pic_id = images.id
                WHERE watch.id = " . $watch_id;
if($watch_request = mysqli_query($conn, $watch_query)) :
    while ($watch_row = mysqli_fetch_array($watch_request)) :
        // print_r($watch_row);    
?>

<div class="container mt-5 mb-5">
    <form action="/actions/edit_item.php" method="post" enctype="multipart/form-data">

        <?php
        include_once($_SERVER["DOCUMENT_ROOT"] . "/includes/error_check.php");
        ?>

        <!-- this hidden input needed to padd user id -->
        <input type="hidden" name="watch_id" value="<?php echo $watch_row["id"];?>">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <img class="w-100" src="<?php echo $watch_row['watch_pic']; ?>">
                    <label for="watch_pic">watch pic</label>
                    <!-- make sure to add enctype="multipart/form-data"  to form in order to send file data-->
                    <input type="file" name="watch_pic" id="watch_pic" class="form-control">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-row form-group">
                    <div class="col">
                        <label for="brand">Brand</label>
                        <select tabindex="4" id="brand" class="form-control" name="brand">
                            <?php
                            $brand_query = "SELECT * FROM watch_brand";
                            if($brand_results = mysqli_query($conn, $brand_query)) :
                                echo "<option disabled ";
                                if( !$watch_row["brand_id"]) echo "selected";
                                echo ">Brand</option>";
                                while($brand = mysqli_fetch_array($brand_results)):
                            ?>

                            <option value="<?=$brand["id"];?>" 
                            <?php if($brand["id"] == $watch_row["brand_id"]) echo " selected";?>><?php echo $brand["brand_name"]; ?></option>

                            <?php
                                endwhile;
                            else:
                                echo mysqli_error($conn);
                            endif;
                        
                            ?>
                        </select>
                            
                    </div>
                </div>
                <div class=" form-row form-group">
                    <label for="model_name">Model Name</label>
                    <input type="text" tabindex="1" id="model_name" name="model_name" placeholder="Model Name" class="form-control" value="<?php echo $watch_row["model_name"];?>">
                </div>
                
                <div class="form-row form-group">
                    <label for="price">Price</label>
                    <input type="text" tabindex="2" id="price" name="price" placeholder="Price" class="form-control" value="<?php echo $watch_row["price"];?>">
                </div>
            </div>
        </div>

        <hr>

        <div class="row my-5">
            <div class="col-md-6">
                <label for="description">Description</label>
                <textarea id="description" name="description" tabindex="3" type="text" class="form-control"  placeholder="Description" value="<?php echo $watch_row["description"];?>"><?php echo $watch_row["description"];?></textarea>
            </div>
        
            <div class="col-md-6">
                <div class="form-row form-group mt-5">
                    <div class="col text-right">
                        <button type="submit" name="action" class="btn btn-text text-danger" value="delete">Delete Item</button>
                        <button type="submit" tabindex="3" name="action" class="btn btn-success" value="update_item">Update Item</button>
                        
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


<?php
    endwhile;
else :
   echo mysqli_error($conn);
endif;

require_once("footer.php");

?>