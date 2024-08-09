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
                <div class="row mb-4">
                    <div class="col-xl-12">
                        <div class="card mb-3 p-4">
                            <h2> Ekspor data </h2>
                            <p> 
                                Halaman ini digunakan untuk mengekspor data pada database untuk
                                <code> penelitian</code>, <code>abdimas</code>, dan <code>haki</code>. 
                                Anda dapat memilih tahun berapa yang akan diunduh datanya dengan mengisi
                                <i>field</i> pada <i>form</i>.  <strong> Jika ingin mengunduh keseluruhan 
                                data, cukup kosongkan field tersebut </strong>. Silakan akses tombol 
                                berikut untuk mulai mengunduh:
                            </p>
                            <div class="d-flex" style="gap: 10px;">
                                <form action="<?= base_url('/admin/download/data/publikasi') ?>">
                                    <label for="publikasi__tahun"> Tahun </label>
                                    <input  id="publikasi__tahun"type="number" name="tahun" placeholder="Semua tahun publikasi">
                                    <button 
                                        type="submit"
                                        class="btn btn-outline-primary" 
                                    >Publikasi</button>
                                </form>
                                <form action="<?= base_url('/admin/download/data/penelitian') ?>">
                                    <label for="penelitian__tahun"> Tahun </label>
                                    <input  id="penelitian__tahun"type="number" name="tahun" placeholder="Semua tahun penelitian">
                                    <button 
                                        type="submit"
                                        class="btn btn-outline-primary" 
                                    >Penelitian</button>
                                </form>
                                <form action="<?= base_url('/admin/download/data/abdimas') ?>">
                                    <label for="haki__tahun"> Tahun </label>
                                    <input id="hai__tahun" type="number" name="tahun" placeholder="Semua tahun abdimas">
                                    <button 
                                        type="submit"
                                        class="btn btn-outline-primary" 
                                    >Abdimas</button>
                                </form>
                                <form action="<?= base_url('/admin/download/data/haki') ?>">
                                    <label for="haki__tahun"> Tahun </label>
                                    <input id="haki__tahun" type="number" name="tahun" placeholder="Semua tahun haki">
                                    <button 
                                        type="submit"
                                        class="btn btn-outline-primary" 
                                    >Haki</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?= $this->include('partials/footer') ?>
    </div>
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