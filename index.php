<?php
require_once("header.php");

// print_r($_SESSION);

?>

<section id="homePage">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1>Canada's Online <br>Luxury Watch Source</h1>
                </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <a href="/store.php" class="btn btn-primary text-white">Shop Now</a>
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


