<?php
require_once("header.php");
?>

<div id ="storePage" class="container mt-5">
    <div class="row my-3">
        <div class="col-md-6 offset-md-3">
            <h1>
            <?php 
                if( isset($_GET["search"])){
                    echo "Search Results For: ".$_GET["search"];
                } else {
                    echo "Browsing All Watches";
                }
            ?>
            </h1>
        </div>
        <div class="col-md-3">
            <div class="dropdown text-right bg-none">
                <a class="btn btn-secondary dropdown-toggle bg-transparent text-dark" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Sort
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="#">Lowest Price</a>
                    <a class="dropdown-item" href="#">Highest Price</a>
                    <a class="dropdown-item" href="#">Newest</a>
                </div>
            </div>
        </div>
        
    </div>
    <div class="row">
        <div class="col-md-3">
            <h2 class="font-weight-bold mb-3">Categories</h2>
                <div class="form-group">
                    <a  href="/store.php">View All Items</a>
                </div>
            <div class="form-group">
                <h3>Price</h3>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck" name="automatic">
                        <label class="form-check-label" for="gridCheck">
                            $1000-$2000
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck" name="manual">
                        <label class="form-check-label" for="gridCheck">
                        $2000-$3000
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck" name="Quartz">
                        <label class="form-check-label" for="gridCheck">
                        $3000-$4000
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck" name="Quartz">
                        <label class="form-check-label" for="gridCheck">
                        $4000-$5000
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck" name="Quartz">
                        <label class="form-check-label" for="gridCheck">
                        $5000-$10000
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck" name="Quartz">
                        <label class="form-check-label" for="gridCheck">
                        $10000-$15000
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck" name="Quartz">
                        <label class="form-check-label" for="gridCheck">
                        $15000-$20000
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck" name="Quartz">
                        <label class="form-check-label" for="gridCheck">
                        $20000+
                        </label>
                    </div>
            </div>
            
            <div class="form-group">
                <h3>Brand</h3>
                <?php
                $brand_query = " SELECT * FROM watch_brand";
                if ($brand_result = mysqli_query($conn, $brand_query)){
                    while ($brand_row = mysqli_fetch_array($brand_result)){
                ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck" name="<?=$brand_row["id"]?>">
                        <label class="form-check-label" for="gridCheck"><?=$brand_row["brand_name"]?></label>
                    </div>
                <?php
                    }
                }
                ?>
            </div>

        </div>


        <div id="storeCards" class="col-md-9 p-0">
                    <div class="row">
                        <?php
                            

                            if(isset($_GET["pageno"])){
                                $pageno = $_GET["pageno"];
                            }else{
                                $pageno = 1;
                            }
                            $no_of_records_per_page = 9;
                            $offset = ($pageno-1) * $no_of_records_per_page;

                            $total_pages_sql = "SELECT COUNT(*) FROM watch";
                            $result = mysqli_query($conn,$total_pages_sql);
                            $total_rows = mysqli_fetch_array($result)[0];
                            $total_pages = ceil($total_rows / $no_of_records_per_page);

                            $watch_query = "    SELECT watch.id, watch.price, watch_brand.brand_name, watch.model_name, images.url AS watch_pic 
                                                FROM watch
                                                LEFT JOIN images
                                                ON watch.watch_pic_id = images.id
                                                LEFT JOIN watch_brand
                                                ON watch.brand_id = watch_brand.id";
                                                

                            $search = (isset($_GET["search"])) ? $_GET["search"] : false;

                            if($search){
                                $search_words = explode(" ", $search);
                                for($i = 0; $i < count($search_words); $i++){
                                    //only append where if $i is 0
                                    $watch_query .= ($i > 0) ? " OR " : " WHERE ";
                                    $watch_query .= "watch_brand.brand_name LIKE '%".$search_words[$i]."%'";
                                    $watch_query .= " OR watch.model_name LIKE '%".$search_words[$i]."%'"; 
                                    $watch_query .= " LIMIT $offset, $no_of_records_per_page";
                                }
                    
                            } else {
                                $watch_query .= " LIMIT $offset, $no_of_records_per_page";
                            }
                                            
                            if($watch_result = mysqli_query($conn, $watch_query)) {
                                while($watch_row = mysqli_fetch_array($watch_result)) {
                        ?>

                                <div class="col-4 mb-3">
                                    
                                        <a href="/item.php?watch_id=<?=$watch_row["id"]?>">
                                            <div class="store-card">
                                                <div class="store-card-image">
                                                    <img src="<?php echo $watch_row['watch_pic']; ?>"  alt="...">
                                                </div>
                                                <div class="store-card-body text-center" >
                                                    
                                                        <h4 class="p-2"><?=$watch_row["brand_name"]?></h4>
                                                    
                                                    </div>
                                                    <div class="store-card-bottom text-center ">
                                                    <p><?=$watch_row["model_name"]?> <br>
                                                <span class="price"><?="$" . $watch_row["price"]?></span></p>
                                                </div>
                                            </div>
                                        </a>
                                    
                                </div>
                            <?php
                                }
                            } else {
                                echo mysqli_error($conn);
                            }
                        
                            ?>

                    </div>

                    <div class="row">
                        <div class="col-md-9">
                            <nav aria-label="...">
                                <ul class="pagination">
                                    <li><a href="?pageno=1">First</a></li>
                                    <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                                        <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
                                    </li>
                                    <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                                        <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
                                    </li>
                                    <li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
        </div>


    </div>


</div>

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
                        <button class=" btn btn-warning text-white" type="submit">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


<?php
require_once("footer.php");
?>