<?= $this->include('partials/main') ?>

    <head>

        <?= $title_meta ?>

        <?= $this->include('partials/head-css') ?>

    </head>

    <body data-keep-enlarged="true" class="vertical-collpsed" data-layout-size="boxed">

        <!-- Begin page -->
        <div id="layout-wrapper">

            <?= $this->include('partials/topbar') ?>
            <?= $this->include('partials/sidebar') ?>
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <?= $page_title?>


                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->


                <?= $this->include('partials/footer') ?>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <?= $this->include('partials/right-sidebar') ?>

        <?= $this->include('partials/vendor-scripts') ?>
        <!-- apexcharts -->
        <script src="assets/libs/apexcharts/apexcharts.min.js"></script>

        <script src="assets/js/pages/dashboard.init.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>

    </body>

</html>