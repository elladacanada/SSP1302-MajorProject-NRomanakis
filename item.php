<?php
require_once("header.php");

if( isset($_GET["watch_id"])){

    $watch_query = " SELECT watch.*, watch_brand.brand_name AS brand_name, images.url AS watch_pic
                     FROM watch 
                     LEFT JOIN watch_brand
                     ON watch.brand_id = watch_brand.id
                     LEFT JOIN images
                     ON watch.watch_pic_id = images.id
                     WHERE watch.id = " . $_GET["watch_id"];

    if($user_request = mysqli_query($conn, $watch_query)){
        while ($watch_row = mysqli_fetch_array($user_request)) {
                            // print_r($user_row);
?>
            <section id="itemPage">
                <div class="container mt-5">
                    <?php
                        include_once($_SERVER["DOCUMENT_ROOT"] . "/includes/error_check.php");
                    ?>
                    <div class="row">
                        <div class="col-md-6 d-flex flex-wrap">
                            
                            <div class="item-image">
                                <img src="<?php echo $watch_row['watch_pic']; ?>"  alt="item picture">
                            </div>
                                    
                        </div>

                        <div class="col-md-6">
                            <h3><?php echo $watch_row["brand_name"];?></h3>
                            <h1><?php echo $watch_row["model_name"];?></h1>
                            <span class="price"><?php echo "$" . $watch_row["price"];?></span> <br>
                            <button disabled class="btn btn-primary text-white mt-2">Add To Cart</button> <br>
                            <a class="mt-2" href="/sorry.php"><i class="far fa-heart"></i> Add To Wishlist</a> <br>
                            <a class="mt-2" href="/sorry.php"><i class="fas fa-share-alt"></i> Share Item</a> 
                        </div>

                    </div>
                </div>
                <hr>

                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <h2>Description</h2>
                            <p><?php echo $watch_row["description"];?></p>
                        </div>
                        <div class="col-md-6">

                            <?php
                            if(isset($_SESSION["user_id"]) && $_SESSION["role"] == 1){
                            ?>

                            <a href="edit_item_interface.php?watch_id=<?=$watch_row["id"];?>" class="btn btn-outline-success mt-2 mb-5"> Edit Item</a>

                            <?php
                            }
        }
    }else{
        echo mysqli_error($conn);
    }
}
                            ?>

                        </div>
                    </div>
                </div>
            </section>

            <section id="signUp">
                <div class="container py-5">
                    <div class="row pt-5">
                        <div class="col-md-12 text-center pt-5">
                            <p>Join our mailing list and be the first to receive news and exclusive promotions.</p>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center pb-5">
                        <form class="form-inline">
                            <div class="input-group outline-dark">
                                <input class="form-control bg-light" type="search" placeholder="Enter Your Email Address Here" aria-label="Search">
                                <div class="input-group-append">
                                    <button class=" btn btn-warning text-white" type="submit" disabled>Sign Up</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>

<?php
require_once("footer.php");
?>
