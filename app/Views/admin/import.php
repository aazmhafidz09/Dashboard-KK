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
            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif ?>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= session()->getFlashdata('error'); ?>
                </div>
            <?php endif ?>
            <div class="container-fluid">

                <div class="row mb-4">
                    <div class="col-xl-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="text-center">
                                    <!-- <div class="dropdown float-end">
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
                                    </div> -->
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
                                        <form action="<?=base_url('/admin/handle_import')?>" method="post" enctype="multipart/form-data">
                                            <?= csrf_field(); ?>

                                            <div class="mb-3">
                                                <label for="formFile" class="form-label">Import Publikasi XLSX</label>
                                                <input class="form-control" type="file" id="formFile" name="filePublikasi">
                                            </div>
                                            <div class="mb-3">
                                                <label for="formFile" class="form-label">Import Abdimas XLSX</label>
                                                <input class="form-control" type="file" id="formFile" name="fileAbdimas">
                                            </div>
                                            <div class="mb-3">
                                                <label for="formFile" class="form-label">Import Penelitian XLSX</label>
                                                <input class="form-control" type="file" id="formFile" name="filePenelitian">
                                            </div>
                                            <div class="mb-3">
                                                <label for="formFile" class="form-label">Import Haki XLSX</label>
                                                <input class="form-control" type="file" id="formFile" name="fileHaki">
                                            </div>
                                            <div class = "d-flex btn-group pt-4 pb-2">
                                                <input type="reset" class="btn btn-outline-primary" value="Reset">
                                            </div>
                                            <div class = "d-flex btn-group pb-2">
                                                <input type="submit" class="btn btn-primary" value="Import Data">
                                            </div>
                                        </form>
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
                                            <strong class="font-weight-bold font-size-16" > Perhatian! Fitur ini tidak dimaksudkan untuk restore data dan mengubah struktur dan data</strong>
                                            <p class="mb-1"> Fitur ini dimaksudkan untuk memasukkan data secara masal. Silakan ikuti langkah berikut untuk menggunakannya: </p>
                                            <ol>
                                                <li> Siapkan data dengan bentuk excel untuk diimpor ke dalam database </li>
                                                <li> Pastikan format data yang akan diimpor sudah sesuai dengan aturan impor data: </li>
                                                <ul>
                                                    <!-- <li>Boleh menggunakan tanda ' (petik satu) dalam penggunaan nama</li> -->
                                                    <li>Impor data untuk Publikasi, Penelitian, Pengabdian dilakukan menggunakan format excel yang terpisah</li>
                                                    <li>
                                                        Pada Bagian Publikasi, kolom yang wajib diisi yaitu <code>tahun</code>, <code>penulis_all</code>,
                                                        <code>jenis</code>, dan <code>judul</code>
                                                    </li>
                                                    <li>
                                                        Pada Bagian Penelitian, kolom yang wajib diisi yaitu : <code>tahun</code>, <code>jenis</code>, 
                                                        <code>judul</code>, dan <code> status </code></li>
                                                    <li>
                                                        Pada Bagian Abdimas, kolom yang wajib diisi yaitu : <code>tahun</code>, <code>jenis</code>,
                                                        <code>status</code>, dan <code>judul</code>
                                                    </li>
                                                    <li>
                                                        Pada Bagian Haki, kolom yang wajib diisi yaitu : <code>tahun</code>, <code>jenis</code>, dan <code>judul</code> 
                                                    </li>
                                                </ul>
                                            </ol>
                                        </div>

                                        <div class = "p-3 pt-0">
                                            <!--<h5 class="font-size-16 mb-4">Publikasi</h5>-->
                                            <strong class="font-weight-bold font-size-16" >Penting! Berikut catatan yang perlu diperhatikan</strong>
                                            <ul>
                                                <li> Mohon pastikan file yang diunggah diletakkan pada formulir sesuai dengan apa yang ingin diimpor </li>
                                                <li> Apabila penulis/anggota tidak ada atau berasal dari luar fakultas informatika, silakan kosongkan field tersebut </li>
                                                <li> Gunakan format <code>MM/DD/YYYY</code> pada field yang meminta data tanggal </li>
                                                <li> Untuk setiap baris data, setidaknya sertakan satu ketua / anggota yang terlibat</li>
                                                <li> Jangan ada judul yang sama di antara data yang anda ingin masukkan </li>
                                                <li> Jangan ada baris yang terlewat di antara data yang ingin anda masukkan </li>
                                                <li> Jangan tambahkan kolom di luar template </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!--<p class="mb-1 p-3 " >Template format dapat diunduh di link berikut </p>-->
                                    <strong class="font-size-16 p-4 pb-0" >Template format dapat dengan menekan tombol berikut: </strong>
                                    <div class="d-flex btn-group p-4 pt-2" role="group" aria-label="Basic outlined example">
                                        <button 
                                            type="button" 
                                            class="btn btn-outline-primary"
                                            onclick="window.location=`<?= base_url('/admin/download/template/publikasi')?>`"
                                        > 
                                            Publikasi
                                        </button>
                                        <button 
                                            type="button" 
                                            class="btn btn-outline-primary" 
                                            onclick="window.location=`<?= base_url('/admin/download/template/penelitian')?>`"
                                        > 
                                            Penelitian 
                                        </a>
                                        </button>
                                        <button 
                                            type="button" 
                                            class="btn btn-outline-primary"
                                            onclick="window.location=`<?= base_url('/admin/download/template/abdimas')?>`"
                                        > 
                                            Abdimas
                                        </button>
                                        <button 
                                            type="button" 
                                            class="btn btn-outline-primary"
                                            onclick="window.location=`<?= base_url('/admin/download/template/haki')?>`"
                                        > 
                                            Haki
                                        </button>
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