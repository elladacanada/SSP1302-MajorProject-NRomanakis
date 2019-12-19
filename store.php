<?php
require_once("header.php");
?>

<form id ="storePage" class="container mt-5 ">
    <div class="row my-3 align-items-center">
        <div class="col-md-6 offset-md-3 col-sm-12">
            <h1>
            <?php 
                if( isset($_GET["search"])){
                    echo "Search Results For: ".$_GET["search"];
                } else {
                    echo "<h3>Browsing All Watches</h3>";
                }
            ?>
            </h1>
        </div>
        <div class="col-md-3 col-sm-12 ">
            <div class="row ">
                <div class="col-6">
                    <button class="btn btn-primary text-white" id="mobileFilterButton">Filter</button>
                </div>
                <div class="col-6 d-flex justify-content-end ">
                    <select name="sort_by" id="sort_by"> 
                        <option value="low_high" <?=(isset($_GET["sort_by"]) && $_GET["sort_by"] == "low_high")?"selected":"";?>>Low to High</option>    
                        <option value="high_low" <?=(isset($_GET["sort_by"]) && $_GET["sort_by"] == "high_low")?"selected":"";?>>High to Low</option>    
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row ">
        <div class="col-md-3 p-0">
            <div id="filterTitle" class="col-md-12">
                
                    <h2 class="font-weight-bold mb-3">Filter</h2>
                    <a  href="/store.php">View All Items</a>
            </div> 
            
            <div id="filterRow" class=" my-3 mx-0">
                <div class="row p-3">
                    <div  class="col-md-12 col-6">
                        <div class="form-group">
                            <h3>Price</h3>
                            <div class="input-group">
                                <input class="form-check-input" type="checkbox" id="gridCheck" name="pricerange[]" value="range1" <?=(isset($_GET["pricerange"]) && in_array("range1", $_GET["pricerange"]))?"checked":"";?>>
                                <label class="form-check-label" for="gridCheck">$1000-$2000</label>
                            </div>
                            <div class="input-group">
                                <input class="form-check-input" type="checkbox" id="gridCheck" name="pricerange[]" value="range2" <?=(isset($_GET["pricerange"]) && in_array("range2", $_GET["pricerange"]))?"checked":"";?>>
                                <label class="form-check-label" for="gridCheck">$2000-$3000</label>
                            </div>
                            <div class="input-group">
                                <input class="form-check-input" type="checkbox" id="gridCheck" name="pricerange[]" value="range3" <?=(isset($_GET["pricerange"]) && in_array("range3", $_GET["pricerange"]))?"checked":"";?>>
                                <label class="form-check-label" for="gridCheck">$3000-$4000</label>
                            </div>
                            <div class="input-group">
                                <input class="form-check-input" type="checkbox" id="gridCheck" name="pricerange[]" value="range4" <?=(isset($_GET["pricerange"]) && in_array("range4", $_GET["pricerange"]))?"checked":"";?>>
                                <label class="form-check-label" for="gridCheck">$4000-$5000</label>
                            </div>
                            <div class="input-group">
                                <input class="form-check-input" type="checkbox" id="gridCheck" name="pricerange[]" value="range5" <?=(isset($_GET["pricerange"]) && in_array("range5", $_GET["pricerange"]))?"checked":"";?>>
                                <label class="form-check-label" for="gridCheck">$5000-$10000</label>
                            </div>
                            <div class="input-group">
                                <input class="form-check-input" type="checkbox" id="gridCheck" name="pricerange[]" value="range6" <?=(isset($_GET["pricerange"]) && in_array("range6", $_GET["pricerange"]))?"checked":"";?>>
                                <label class="form-check-label" for="gridCheck">$10000-$20000</label>
                            </div>
                            <div class="input-group">
                                <input class="form-check-input" type="checkbox" id="gridCheck" name="pricerange[]" value="range7" <?=(isset($_GET["pricerange"]) && in_array("range7", $_GET["pricerange"]))?"checked":"";?>>
                                <label class="form-check-label" for="gridCheck">$20000+</label>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-12 col-6">
                        <div class="form-group">
                            <h3>Brand</h3>
                            <?php
                            $brand_query = " SELECT * FROM watch_brand";
                            if ($brand_result = mysqli_query($conn, $brand_query)){
                                while ($brand_row = mysqli_fetch_array($brand_result)){
                            ?>
                                <div class="input-group">
                                    <input class="form-check-input" type="checkbox" id="gridCheck" name="brand[]" value="<?=$brand_row["id"]?>"<?=(isset($_GET["brand"]) && in_array($brand_row["id"], $_GET["brand"]))?"checked":"";?>>
                                    <label class="form-check-label" for="gridCheck"><?=$brand_row["brand_name"]?></label>
                                </div>
                            <?php
                                }
                            }
                            ?>
                            
                        </div>
                    </div>
                
                    <div class=" col-sm-12">
                        <hr>
                        <button class="btn btn-primary text-white" type="submit">Apply Filter</button>
                    </div>
                    
                </div>
            </div>
        </div>

        <div id="storeCards" class="col-md-9 p-0">
                    
                        <?php
                            //  echo "<pre>";
                            //  print_r($_GET);
                            //  echo "</pre>";

                            // echo "$".number_format(100100, 2);


                            $watch_query = "    SELECT watch.id, watch.price, watch_brand.brand_name, watch.model_name, images.url AS watch_pic 
                                                FROM watch
                                                LEFT JOIN images
                                                ON watch.watch_pic_id = images.id
                                                LEFT JOIN watch_brand
                                                ON watch.brand_id = watch_brand.id";
                                                

                            $search = (isset($_GET["search"])) ? $_GET["search"] : false;
                            $watch_where_search = "";
                            if($search){
                                $search_words = explode(" ", $search);
                                for($i = 0; $i < count($search_words); $i++){
                                    //only append where if $i is 0
                                    $watch_where_search = ($i > 0) ? " OR " : " WHERE ";
                                    $watch_where_search .= "watch_brand.brand_name LIKE '%".$search_words[$i]."%'";
                                    $watch_where_search .= " OR watch.model_name LIKE '%".$search_words[$i]."%'"; 
                                    
                                    
                                }
                    
                            } else {
                                $watch_where_search .= " WHERE watch.model_name IS NOT NULL ";
                            }

                            if(isset($_GET["brand"])){
                                $brands = $_GET["brand"];
                                $watch_where_search .= " AND (";
                                $i = 0;
                                foreach($brands as $brand_id){
                                    if($i > 0) $watch_where_search .= " OR";
                                    $i++;
                                    $watch_where_search .= " watch.brand_id = $brand_id";
                                }
                                $watch_where_search .=  ")";
                            }
                            //if(isset($_GET[""]))

                            if(isset($_GET["pricerange"])) {
                                $pricerange = $_GET["pricerange"];
                                $watch_where_search .= " AND (";
                                $i = 0;
                                foreach($pricerange as $range){
                                    if($i > 0) $watch_where_search .= " OR";
                                    $i++;

                                    // $watch_where_search .= " (watch.band_id = $range)";




                                    switch($range){
                                        case "range1":
                                            $watch_where_search .= "  (watch.price_int > 1000";
                                            $watch_where_search .= " AND watch.price_int < 2000)";
                                        break;

                                        case "range2":
                                            $watch_where_search .= "  (watch.price_int > 2000";
                                            $watch_where_search .= " AND watch.price_int < 3000)";
                                        break;
                                        
                                        case "range3":
                                            $watch_where_search .= "  (watch.price_int > 3000";
                                            $watch_where_search .= " AND watch.price_int < 4000)";
                                        break;
                                        
                                        case "range4":
                                            $watch_where_search .= "  (watch.price_int > 4000";
                                            $watch_where_search .= " AND watch.price_int < 5000)";
                                        break;
                                        
                                        case "range5":
                                            $watch_where_search .= "  (watch.price_int > 5000";
                                            $watch_where_search .= " AND watch.price_int < 10000)";
                                        break;
                                        
                                        case "range6":
                                            $watch_where_search .= "  (watch.price_int > 10000";
                                            $watch_where_search .= " AND watch.price_int < 20000)";
                                        break;
                                        
                                        case "range7":
                                            $watch_where_search .= "  watch.price_int > 20000";
                                            
                                        break;
                                    }
                                }
                                $watch_where_search .= ")";
                            }

                            $current_page = (isset($_GET["page"])) ? $_GET["page"] : 1;
                            $limit = 9;
                            $offset = $limit * ($current_page-1);

                            $sort_direction = (isset($_GET["sort_by"]) && $_GET["sort_by"] == "low_high")? "ASC" :"DESC";
                            
                            $watch_query .= $watch_where_search;
                            $watch_query .=  "  ORDER BY watch.price_int $sort_direction
                                                LIMIT $limit OFFSET $offset";
                                            
                            if($watch_result = mysqli_query($conn, $watch_query)) {

                                $pagi_query = "SELECT COUNT(*) AS total FROM watch 
                                                LEFT JOIN watch_brand
                                                ON watch.brand_id = watch_brand.id";
                                
                                    $pagi_query .= $watch_where_search;
                                
                                $pagi_result = mysqli_query($conn, $pagi_query);
                                $pagi_row = mysqli_fetch_array($pagi_result);
                                $total_articles = $pagi_row["total"];
                                //floor will round down
                                //ceil will round up
                                //round will round down below 5 or up otherwise.
                                $page_count = ceil($total_articles / $limit);

                                echo "<div class='row'>";// row div start

                                while($watch_row = mysqli_fetch_array($watch_result)) {
                            ?>

                                <div class="col-lg-4 col-sm-6 mb-3">
                                    
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
                                
                                echo "</div>"; // end row div
                                 // PAGINATION START
                                    // PAGINATION START
                                // PAGINATION START
                                
                                echo "<nav aria-label='Page navigation example'><ul class='pagination'>";
        
                                $get_search = ($search) ? "&search=".$search : "";
        
                                if($current_page > 1){
                                    echo "<li class='page-item'><a class='page-link' href='/store.php?page=" . ($current_page - 1) . "$get_search'>Previous</a></li>";    
                                }
        
                                for($i = 1; $i <= $page_count; $i++){
                                    echo "<li class='page-item";
                                    if($current_page == $i) echo " active";
                                    echo "'><a class='page-link' href='/store.php?page=$i".$get_search."'>$i</a></li>";
                                }
                                if($current_page < $page_count){
                                    echo "<li class='page-item'><a class='page-link' href='/store.php?page=" . ($current_page + 1) . "$get_search'>Next</a></li>";
                                }
                                echo "</ul></nav>"; 
                            } else {
                                echo mysqli_error($conn);
                            }
                        
                           
                            
                            ?>
                            

                    
                    
        </div>


    </div>


</form>

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