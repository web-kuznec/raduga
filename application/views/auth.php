<body class="sign-in-up" id="to-top">
    <!-- Sign In/Sign Up section -->
    <section class="sign-in-up-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Logo -->
                    <figure class="text-center">
                        <a href="<?= URL::base('http'); ?>">
                            <img class="img-logo" src="<?= URL::base('http'); ?>public/images/logo.png" alt="">
                        </a>
                    </figure> <!-- /.text-center -->
                </div> <!-- /.col-md-12 -->
            </div> <!-- /.row -->
            <section class="sign-in-up-content">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="text-center">Sign In to your account</h4>
                        <form class="sign-in-up-form" action="./sign-in.html" role="form">
                            <!-- Input 1 -->
                            <div class="form-group">
                                <input class="form-control" id="exampleInputEmail2" type="email" placeholder="Enter email address">
                            </div> <!-- /.form-group -->
                            <!-- Input 2 -->
                            <div class="form-group">
                                <input class="form-control" id="exampleInputPassword1" type="password" placeholder="Password">
                            </div> <!-- /.form-group -->
                            <!-- Button -->
                            <button class="btn btn-success btn-block" type="submit">Sign In</button>
                            <!-- Checkbox -->
                            <section class="text-center">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" checked> Keep me logged in
                                    </label>
                                </div> <!-- /.checkbox -->
                            </section> <!-- /.text-center -->
                            <!-- Sign In/Sign Up links -->
                            <section class="sign-in-up-links text-center">
                                <p><a href="./forgot-password.html">Forgot password?</a> <span class="sep">&ndash;</span> <a href="./sign-up.html">Need an account?</a></p>
                            </section> <!-- /.sign-in-up-links -->
                        </form> <!-- /.sign-in-up-form -->
                    </div> <!-- /.col-md-12 -->
                </div> <!-- /.row -->
            </section> <!-- /.sign-in-up-content -->
            <div class="row">
                <div class="col-md-12">
                    <section class="footer-copyright text-center">
                        <p>Made with <i class="fa fa-heart"></i> by Aryandhani.</p>
                    </section> <!-- /.footer-section -->
                </div> <!-- /.col-md-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section> <!-- /.sign-in-up-section -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?= URL::base('http'); ?>public/js/vendor/jquery-2.1.0.min.js"></script>
    <script src="<?= URL::base('http'); ?>public/js/bootstrap.min.js"></script>
    <script src="<?= URL::base('http'); ?>public/js/assets/application.js"></script>
</body>