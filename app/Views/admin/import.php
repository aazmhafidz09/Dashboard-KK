<?= $this->include('partials/main') ?>

<head>
    <?= $this->include('partials/head-css') ?>
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- Data Table CSS -->
    <link rel='stylesheet' href='https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css'>
    <!-- Font Awesome CSS -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css'>
</head>

<?= $this->include('partials/body') ?>




<!-- Begin page -->
<div id="layout-wrapper">

    <?= $this->include('partials/menu') ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <div class="row mb-4">
                    <div class="col-xl-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="dropdown float-end">
                                        <a class="text-body dropdown-toggle font-size-18" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                            <i class="uil uil-ellipsis-v"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="#">Edit</a>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Remove</a>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div>
                                        <img src="assets/images/users/avatar-4.jpg" alt="" class="avatar-lg rounded-circle img-thumbnail">
                                    </div>
                                    <!--<h5 class="mt-3 mb-1"> Aaz M hafidz Azis</h5>-->
                                    <!--<p class="text-muted">ZHH</p>-->
                                </div>

                                <hr class="my-4">

                                <div class="text-muted">
                                    <!--<h5 class="font-size-16">Import XLS</h5>-->
                                    <!--<p>IS</p>-->
                                    <div class="table-responsive mt-4">
                                        <!--<div>-->
                                        <!--    <p class="mb-1">Nama :</p>-->
                                        <!--    <h5 class="font-size-16">Aazs</h5>-->
                                        <!--</div>-->
                                        
                                        <div class="mb-3">
                                            <label for="formFile" class="form-label">Import Publikasi XLSX</label>
                                            <input class="form-control" type="file" id="formFile">
                                        </div>
                                        <div class="mb-3">
                                            <label for="formFile" class="form-label">Import Abdimas XLSX</label>
                                            <input class="form-control" type="file" id="formFile">
                                        </div>
                                        <div class="mb-3">
                                            <label for="formFile" class="form-label">Import Penelitian XLSX</label>
                                            <input class="form-control" type="file" id="formFile">
                                        </div>
                                        <div class="mb-3">
                                            <label for="formFile" class="form-label">Import Haki XLSX</label>
                                            <input class="form-control" type="file" id="formFile">
                                        </div>
                                        <div class = "d-flex btn-group p-4">
                                            <input type="submit" class="btn btn-primary" value="Import Data">
                                            
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-8">
                        <div class="card mb-0">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#publikasi" role="tab">
                                        <i class="uil uil-user-circle font-size-20"></i>
                                        <span class="d-none d-sm-block">Import Database</span>
                                    </a>
                                </li>
                                
                            </ul>
                            <!-- Tab content -->
                            
                            <div class="tab-content p-1">
                                <div class="tab-pane active" id="publikasi" role="tabpanel">
                                    <div>
                                        <div class = "p-3">
                                            <!--<h5 class="font-size-16 mb-4">Publikasi</h5>-->
                                            <h5 class="font-size-16 mb-4" >Penting: fitur ini tidak dimaksudkan untuk Restore data penduduk dan Mengubah struktur dan data</h5>
                                            <p class="mb-1">Fitur ini dimaksudkan untuk memasukkan data penduduk awal dan data susulan serta mengubah data penduduk yang sudah ada secara masal </p>
                                            </br>
                                            </br> Mempersiapkan data dengan bentuk excel untuk Impor ke dalam database SID :</p>
                                            </br><p> Pastikan format data yang akan diImpor sudah sesuai dengan aturan Impor data:</p>
                                            <ul>
                                              <li>Boleh menggunakan tanda ' (petik satu) dalam penggunaan nama</li>
                                              <li>Kolom Publikasi, Penelitian, Pengabdian menggunakan format excel yang terpisah</li>
                                              <li>Pada Bagian Publikasi, Field yang wajib diisi yaitu : Tahun dan Judul</li>
                                              <li>Pada Bagian Penelitian, Field yang wajib diisi yaitu : Tahun, Jenis dan  Judul</li>
                                              <li>Pada Bagian Abdimas, Field yang wajib diisi yaitu : Tahun dan Judul</li>
                                              <li>Pada Bagian Haki, Field yang wajib diisi yaitu : Tahun dan Judul </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!--<p class="mb-1 p-3 " >Template format dapat diunduh di link berikut </p>-->
                                    <h5 class="font-size-16 mb-4 p-3 " >Template format dapat diunduh di link berikut</h5>
                                    <div class="d-flex btn-group p-4" role="group" aria-label="Basic outlined example">
                                      <button type="button" class="btn btn-outline-primary">Publikasi</button>
                                      <button type="button" class="btn btn-outline-primary">Penelitian</button>
                                      <button type="button" class="btn btn-outline-primary">Abdimas</button>
                                      <button type="button" class="btn btn-outline-primary">Haki</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

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
<script src="/assets/libs/apexcharts/apexcharts.min.js"></script>

<script src="/assets/js/pages/dashboard.init.js"></script>

<!-- App js -->
<script src="/assets/js/app.js"></script>

</body>

</html>