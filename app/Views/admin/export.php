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
                            <div style="display: grid; grid-template: 1fr / repeat(auto-fit, minmax(300px, 1fr)); grid-gap: 20px;">
                                <div class="p-3 border rounded border-muted">
                                    <form action="<?= base_url('/admin/download/data/publikasi') ?>">
                                        <p class="fs-5"> <strong> Publikasi </strong> </p>
                                        <div class="d-flex" style="gap: 10px;">
                                            <label for="publikasi__tahun"> Tahun </label>
                                            <input  id="publikasi__tahun" style="flex: 1;" type="number" name="tahun" placeholder="(Semua tahun)">
                                        </div>
                                        <button 
                                            type="submit"
                                            class="btn btn-outline-primary float-end mt-2" 
                                        > Ekspor</button>
                                    </form>
                                </div>
                                <div class="p-3 border rounded border-muted">
                                    <form action="<?= base_url('/admin/download/data/penelitian') ?>">
                                        <p class="fs-5"> <strong> Penelitian </strong> </p>
                                        <div class="d-flex" style="gap: 10px;">
                                            <label for="penelitian__tahun"> Tahun </label>
                                            <input id="penelitian__tahun" style="flex: 1;" type="number" name="tahun" placeholder="(Semua tahun)">
                                        </div>
                                        <button 
                                            type="submit"
                                            class="btn btn-outline-primary float-end mt-2" 
                                        >Ekspor</button>
                                    </form>
                                </div>
                                <div class="p-3 border rounded border-muted">
                                    <form action="<?= base_url('/admin/download/data/abdimas') ?>">
                                        <p class="fs-5"> <strong> Abdimas </strong> </p>
                                        <div class="d-flex" style="gap: 10px;">
                                            <label for="abdimas__tahun"> Tahun </label>
                                            <input id="abdimas__tahun" style="flex: 1;" type="number" name="tahun" placeholder="(Semua tahun)">
                                        </div>
                                        <button 
                                            type="submit"
                                            class="btn btn-outline-primary float-end mt-2" 
                                        >Ekspor</button>
                                    </form>
                                </div>
                                <div class="p-3 border rounded border-muted">
                                    <form action="<?= base_url('/admin/download/data/haki') ?>">
                                        <p class="fs-5"> <strong> Haki </strong> </p>
                                        <div class="d-flex" style="gap: 10px;">
                                            <label for="haki__tahun"> Tahun </label>
                                            <input id="haki__tahun" style="flex: 1;" type="number" name="tahun" placeholder="(Semua tahun)">
                                        </div>
                                        <button 
                                            type="submit"
                                            class="btn btn-outline-primary float-end mt-2" 
                                        >Ekspor</button>
                                    </form>
                                </div>
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