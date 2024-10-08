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


<style>
    hr {
        margin-top: 2rem;
        margin-bottom: 2rem;
        border: 0;
        border-top: 1px solid rgba(0, 0, 0, 0.5);
    }
</style>

<!-- Begin page -->



<!-- Begin page -->
<div id="layout-wrapper">

    <?= $this->include('partials/menu') ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <form action="/admin/abdimas_save" method="post">
                    <?= csrf_field(); ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="card-title">Input Data Abdimas</h4>
                                    <p class="card-title-desc">Masukan data <code>abdimas</code> ke dalam <code>form</code> berikut</p>

                                    <div class="mb-3 row">
                                        <label for="Judul-Abdimas" class="col-md-2 col-form-label">Judul Abdimas</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" placeholder="Judul" id="Judul_Abdimas" name="Judul_Abdimas">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="Tahun" class="col-md-2 col-form-label">Tahun</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="number" placeholder="Tahun" id="Tahun" name="Tahun">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="jenis" class="col-md-2 col-form-label">Jenis Abdimas</label>
                                        <div class="col-md-10">
                                            <select id="jenis" class="form-select" name="jenis">
                                                <option>Internal</option>
                                                <option>Eksternal</option>
                                                <option>Internal dan Eksternal</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-2 row">
                                        <label for="status" class="col-md-2 col-form-label">status</label>
                                        <div class="col-mb-1-md-40 row">
                                            <select id="status" class="form-select" name="status">
                                                <option>Didanai</option>
                                                <option>Closed</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <!-- <h4 class="card-title">Data Penulis</h4> -->
                                    <p class="card-title-desc">Masukan data <code>abdimas</code> ke dalam <code>form</code> berikut.</p>
                                    <div class="mb-3 row">
                                        <label for="Ketua" class="col-md-2 col-form-label">Ketua</label>
                                        <div class="col-md-10">
                                            <input class="form-control" list="datalistOptions" id="Ketua" placeholder="kode dosen" name="ketua">
                                            <datalist id="datalistOptions">
                                                <option value="ABW">
                                                <option value="ADF">
                                                <option value="AHY">
                                                <option value="BBD">
                                                <option value="BDP">
                                                <option value="COK">
                                                <option value="DNH">
                                                <option value="EAR">
                                                <option value="EDF">
                                                <option value="FAR">
                                                <option value="FSV">
                                                <option value="GIA">
                                                <option value="GKL">
                                                <option value="HIW">
                                                <option value="HUI">
                                                <option value="IZA">
                                                <option value="JMT">
                                                <option value="KNR">
                                                <option value="MDS">
                                                <option value="MZI">
                                                <option value="PEY">
                                                <option value="RMB">
                                                <option value="RRD">
                                                <option value="RSM">
                                                <option value="SLL">
                                                <option value="SSD">
                                                <option value="SUO">
                                                <option value="UIN">
                                                <option value="UNW">
                                                <option value="WKF">
                                                <option value="NDP">
                                                <option value="ACK">
                                                <option value="ENY">
                                                <option value="HII">
                                                <option value="OGO">
                                                <option value="STZ">
                                                <option value="IAU">
                                                <option value="LDS">
                                                <option value="ZHH">
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="Anggota_1" class="col-md-2 col-form-label">Anggota 1</label>
                                        <div class="col-md-10">
                                            <input class="form-control" list="datalistOptions" id="Anggota_1" placeholder="kode dosen" name="anggota_1">
                                            <datalist id="datalistOptions">
                                                <option value="ABW">
                                                <option value="ADF">
                                                <option value="AHY">
                                                <option value="BBD">
                                                <option value="BDP">
                                                <option value="COK">
                                                <option value="DNH">
                                                <option value="EAR">
                                                <option value="EDF">
                                                <option value="FAR">
                                                <option value="FSV">
                                                <option value="GIA">
                                                <option value="GKL">
                                                <option value="HIW">
                                                <option value="HUI">
                                                <option value="IZA">
                                                <option value="JMT">
                                                <option value="KNR">
                                                <option value="MDS">
                                                <option value="MZI">
                                                <option value="PEY">
                                                <option value="RMB">
                                                <option value="RRD">
                                                <option value="RSM">
                                                <option value="SLL">
                                                <option value="SSD">
                                                <option value="SUO">
                                                <option value="UIN">
                                                <option value="UNW">
                                                <option value="WKF">
                                                <option value="NDP">
                                                <option value="ACK">
                                                <option value="ENY">
                                                <option value="HII">
                                                <option value="OGO">
                                                <option value="STZ">
                                                <option value="IAU">
                                                <option value="LDS">
                                                <option value="ZHH">
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="Anggota_2" class="col-md-2 col-form-label">Anggota 2</label>
                                        <div class="col-md-10">
                                            <input class="form-control" list="datalistOptions" id="Anggota_2" placeholder="kode dosen" name="anggota_2">
                                            <datalist id="datalistOptions">
                                                <option value="ABW">
                                                <option value="ADF">
                                                <option value="AHY">
                                                <option value="BBD">
                                                <option value="BDP">
                                                <option value="COK">
                                                <option value="DNH">
                                                <option value="EAR">
                                                <option value="EDF">
                                                <option value="FAR">
                                                <option value="FSV">
                                                <option value="GIA">
                                                <option value="GKL">
                                                <option value="HIW">
                                                <option value="HUI">
                                                <option value="IZA">
                                                <option value="JMT">
                                                <option value="KNR">
                                                <option value="MDS">
                                                <option value="MZI">
                                                <option value="PEY">
                                                <option value="RMB">
                                                <option value="RRD">
                                                <option value="RSM">
                                                <option value="SLL">
                                                <option value="SSD">
                                                <option value="SUO">
                                                <option value="UIN">
                                                <option value="UNW">
                                                <option value="WKF">
                                                <option value="NDP">
                                                <option value="ACK">
                                                <option value="ENY">
                                                <option value="HII">
                                                <option value="OGO">
                                                <option value="STZ">
                                                <option value="IAU">
                                                <option value="LDS">
                                                <option value="ZHH">
                                            </datalist>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="Anggota_3" class="col-md-2 col-form-label">Anggota 3</label>
                                        <div class="col-md-10">
                                            <input class="form-control" list="datalistOptions" id="Anggota_3" placeholder="kode dosen" name="anggota_3">
                                            <datalist id="datalistOptions">
                                                <option value="ABW">
                                                <option value="ADF">
                                                <option value="AHY">
                                                <option value="BBD">
                                                <option value="BDP">
                                                <option value="COK">
                                                <option value="DNH">
                                                <option value="EAR">
                                                <option value="EDF">
                                                <option value="FAR">
                                                <option value="FSV">
                                                <option value="GIA">
                                                <option value="GKL">
                                                <option value="HIW">
                                                <option value="HUI">
                                                <option value="IZA">
                                                <option value="JMT">
                                                <option value="KNR">
                                                <option value="MDS">
                                                <option value="MZI">
                                                <option value="PEY">
                                                <option value="RMB">
                                                <option value="RRD">
                                                <option value="RSM">
                                                <option value="SLL">
                                                <option value="SSD">
                                                <option value="SUO">
                                                <option value="UIN">
                                                <option value="UNW">
                                                <option value="WKF">
                                                <option value="NDP">
                                                <option value="ACK">
                                                <option value="ENY">
                                                <option value="HII">
                                                <option value="OGO">
                                                <option value="STZ">
                                                <option value="IAU">
                                                <option value="LDS">
                                                <option value="ZHH">
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="Anggota_4" class="col-md-2 col-form-label">Anggota 4</label>
                                        <div class="col-md-10">
                                            <input class="form-control" list="datalistOptions" id="Anggota_4" placeholder="kode dosen" name="anggota_4">
                                            <datalist id="datalistOptions">
                                                <option value="ABW">
                                                <option value="ADF">
                                                <option value="AHY">
                                                <option value="BBD">
                                                <option value="BDP">
                                                <option value="COK">
                                                <option value="DNH">
                                                <option value="EAR">
                                                <option value="EDF">
                                                <option value="FAR">
                                                <option value="FSV">
                                                <option value="GIA">
                                                <option value="GKL">
                                                <option value="HIW">
                                                <option value="HUI">
                                                <option value="IZA">
                                                <option value="JMT">
                                                <option value="KNR">
                                                <option value="MDS">
                                                <option value="MZI">
                                                <option value="PEY">
                                                <option value="RMB">
                                                <option value="RRD">
                                                <option value="RSM">
                                                <option value="SLL">
                                                <option value="SSD">
                                                <option value="SUO">
                                                <option value="UIN">
                                                <option value="UNW">
                                                <option value="WKF">
                                                <option value="NDP">
                                                <option value="ACK">
                                                <option value="ENY">
                                                <option value="HII">
                                                <option value="OGO">
                                                <option value="STZ">
                                                <option value="IAU">
                                                <option value="LDS">
                                                <option value="ZHH">
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="Anggota_5" class="col-md-2 col-form-label">Anggota 5</label>
                                        <div class="col-md-10">
                                            <input class="form-control" list="datalistOptions" id="Anggota_5" placeholder="kode dosen" name="anggota_5">
                                            <datalist id="datalistOptions">
                                                <option value="ABW">
                                                <option value="ADF">
                                                <option value="AHY">
                                                <option value="BBD">
                                                <option value="BDP">
                                                <option value="COK">
                                                <option value="DNH">
                                                <option value="EAR">
                                                <option value="EDF">
                                                <option value="FAR">
                                                <option value="FSV">
                                                <option value="GIA">
                                                <option value="GKL">
                                                <option value="HIW">
                                                <option value="HUI">
                                                <option value="IZA">
                                                <option value="JMT">
                                                <option value="KNR">
                                                <option value="MDS">
                                                <option value="MZI">
                                                <option value="PEY">
                                                <option value="RMB">
                                                <option value="RRD">
                                                <option value="RSM">
                                                <option value="SLL">
                                                <option value="SSD">
                                                <option value="SUO">
                                                <option value="UIN">
                                                <option value="UNW">
                                                <option value="WKF">
                                                <option value="NDP">
                                                <option value="ACK">
                                                <option value="ENY">
                                                <option value="HII">
                                                <option value="OGO">
                                                <option value="STZ">
                                                <option value="IAU">
                                                <option value="LDS">
                                                <option value="ZHH">
                                            </datalist>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Form Layout -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <!-- <h4 class="card-title">Input Data Publikasi</h4> -->
                                    <p class="card-title-desc">Masukan data <code>Abdimas</code> ke dalam <code>form</code> berikut</p>
                                    <div class="mb-3 row">
                                        <label for="Institusi_mitra" class="col-md-2 col-form-label">Institusi Mitra</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" placeholder="institusi mitra" id="Institusi_mitra" name="Institusi_mitra">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="Alamat_mitra" class="col-md-2 col-form-label">Alamat Mitra</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" placeholder="alamat mitra" id="Alamat_mitra" name="alamat_mitra">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="kesesuaian_roadmap" class="col-md-2 col-form-label">Kesesuaian Roadmap</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" placeholder="Kesesuaian Roadmap" id="kesesuaian_roadmap" name="kesesuaian_roadmap">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="permasalahan_masyarakat" class="col-md-2 col-form-label">Permasalahan Masyarakat</label>
                                        <div class="col-md-10">
                                            <!-- <input class="form-control" type="text" placeholder="Permasalahan Masyarakat" id="permasalahan_masyarakat"> -->
                                            <textarea class="form-control" id="permasalahan_masyarakat" rows="3" name="permasalahan_masyarakat"></textarea>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="solusi" class="col-md-2 col-form-label">Solusi</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" placeholder="Solusi" id="solusi" name="solusi">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="catatan" class="col-md-2 col-form-label">Catatan</label>
                                        <div class="col-md-10">
                                            <!-- <input class="form-control" type="text" placeholder="Catatan" id="catatan"> -->
                                            <textarea class="form-control" id="catatan" rows="3" name="catatan"></textarea>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="luaran" class="col-md-2 col-form-label">Luaran</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" placeholder="Luaran" id="luaran" name="luaran">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="tanggal_pengesahan" class="col-md-2 col-form-label">Tanggal Pengesahan</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="date" placeholder="tanggal pengesahan" id="tanggal_pengesahan" name="tgl_pengesahan">
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div> <!-- end col -->

                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">

                                    <p class="card-title-desc">Submit hasil <code>isian</code> data anda dengan klik <code>tombol</code> berikut</p>
                                    <!-- <form> -->
                                    <div class="hstack gap-3">
                                        <!-- <input class="form-control me-auto" type="text" placeholder="Add your item here..." aria-label="Add your item here..."> -->
                                        <button type="submit" class="btn btn-primary waves-effect waves-light w-md">Submit</button>
                                        <div class="vr"></div>
                                        <button type="reset" class="btn btn-outline-danger waves-effect waves-light w-md">Reset</button>
                                    </div>
                                    <!-- </form> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- end row -->

                    <!-- Start Form Sizing -->
                </form>

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

<!-- App js -->
<script src="assets/js/app.js"></script>

</body>
<!-- END layout-wrapper -->

<?= $this->include('partials/right-sidebar') ?>

<?= $this->include('partials/vendor-scripts') ?>

<!-- App js -->
<script src="assets/js/app.js"></script>





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