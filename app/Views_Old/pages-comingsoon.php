<?= $this->include('partials/main') ?>

    <head>
        
        <?= $title_meta ?>

        <?= $this->include('partials/head-css') ?>

    </head>

    <body class="authentication-bg">
        <div class="my-5 pt-sm-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <a href="index" class="d-block auth-logo">
                                <img src="assets/images/logo-dark.png" alt="" height="22" class="logo logo-dark">
                                <img src="assets/images/logo-light.png" alt="" height="22" class="logo logo-light">
                            </a>

                            <div class="row justify-content-center mt-5">
                                <div class="col-lg-4 col-sm-5">
                                    <div class="maintenance-img">
                                        <img src="assets/images/coming-soon-img.png" alt="" class="img-fluid mx-auto d-block">
                                    </div>
                                </div>
                            </div>
                            
                            <h4 class="mt-5">Let's get started with Minible</h4>
                            <p class="text-muted">It will be as simple as Occidental in fact it will be Occidental.</p>
                            
                            <div class="row justify-content-center mt-5">
                                <div class="col-lg-10">
                                    <div data-countdown="2024/12/31" class="counter-number"></div>
                                    
                                </div> <!-- end col-->
                            </div> <!-- end row-->

                            <div class="row justify-content-center mt-5">
                                <div class="col-lg-6">
                                    <div class="input-section pt-4">
                                        <div class="row">
                                            <div class="col">
                                                <div class="position-relative">
                                                    <input type="email" class="form-control" placeholder="Enter email address...">
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <button type="submit" class="btn btn-primary w-md waves-effect waves-light">Subscribe</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?= $this->include('partials/vendor-scripts') ?>

        <!-- Plugins js-->
        <script src="assets/libs/jquery-countdown/jquery.countdown.min.js"></script>

        <!-- Countdown js -->
        <script src="assets/js/pages/coming-soon.init.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>

    </body>
</html>
