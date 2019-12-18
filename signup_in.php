<?php
require_once("header.php");
?>






<div class="container py-5">
    <?php
        include($_SERVER["DOCUMENT_ROOT"] . "/includes/error_check.php");
    ?>
    <div class="row">
        <div id="loginForm" class="col-md-6 mb-3">
            <form action="/actions/login.php" class="col-md-12 p-5" method="post">
                <div  class="pb-5">
                    <div class="text-center pb-5">
                        <h2>Sign in <br>to your account</h2>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                    
                    <div class="form-group">
                        <button name="action" value="login" class="btn btn-warning w-100 text-white">Sign In</button>
                    </div>
                    <div class="text-right">
                        <a href="#">forgot your password?</a>
                    </div>
                </div>
            </form>
        </div>

        <div id="signUpForm" class="col-md-6 mb-3">
            <form action="/actions/login.php" class="col-md-12 p-5" method="post">
                <div class="text-center text-white pb-5">
                    <h2>Not a member? <br>Join now!</h2>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="fname" name="first_name" placeholder="First Name">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="lname" name="last_name" placeholder="Last Name">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email Address">
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck" name="agree_terms" >
                        <label class="form-check-label text-white" for="gridCheck">
                            I agree to the terms of service
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck" name="newsletter" checked value="true">
                        <label class="form-check-label text-white" for="gridCheck">
                            Sign me up for news and exclusive promotions!
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div>
                <div class="form-group">
                        <input type="password" class="form-control" id="password2" name="password2" placeholder="Confirm Password">
                </div>
                <div class="form-group">
                    <button name="action" value="signup" class="btn btn-warning w-100 text-white">Join Now</button>
                </div>
            </form>
        </div>
    </div>
</div>



<?php
require_once("footer.php");
?>