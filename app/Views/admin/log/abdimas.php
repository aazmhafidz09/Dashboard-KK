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

<?php
    $sections = [
        "ID Publikasi" => "id",
        "Judul" => "judul",
        "Tahun" => "tahun",
        "Ketua" => "ketua",
        "Anggota 1" => 'anggota_1',
        "Anggota 2" => 'anggota_2',
        "Anggota 3" => 'anggota_3',
        "Anggota 5" => 'anggota_4',
        "Anggota 6" => 'anggota_5',
        "Anggota 7" => 'anggota_6',
        "Anggota 8" => 'anggota_7',
        "Anggota 9" => 'anggota_8',
        "Nama Kegiatan" => "nama_kegiatan",
        "Status" => "status",
        "Jenis" => "jenis",
        "Laboratorium Riset" => "lab_riset",
        "Tanggal Pengesahan" => "tgl_pengesahan",
        "Mitra" => "mitra",
        "Alamat Mitra" => "alamat_mitra",
        "Permasalahan Masyarakat" => "permasalahan_masy",
        "Solusi" => "solusi",
        "Luaran" => "luaran",
        "Kesesuaian Roadmap" => "kesesuaian_roadmap",
        "Catatan" => "catatan",
    ];
    $logAction = $log["action"];
    $old = null;
    $new = null;
    if(in_array($logAction, ["U", "D"])) {
        $old = json_decode($log["value_before"], true);
    }

    if(in_array($logAction, ["U", "C"])) {
        $new = json_decode($log["value_after"],true);
    }
?>

<!-- Begin page -->
<div id="layout-wrapper">
    <?= $this->include('partials/menu') ?>
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <h2> Log Publikasi</h2>
                                        <p class="m-0 p-0">
                                            <strong>Waktu: </strong> 
                                            <?= $log["date"] ?>
                                        </p>
                                        <p class="m-0 p-0">
                                            <strong>Aksi: </strong>
                                            <?= $logAction == "U"
                                                ? "Ubah"
                                                : ($logAction == "C"
                                                ? "Tambah"
                                                : "Hapus")
                                            ?>
                                        </p>
                                        <p class="m-0 p-0">
                                            <strong>Oleh: </strong> 
                                            <?php
                                                $out = is_null($log["kode_dosen"])? "(Kode dosen tidak terdata)": $log["kode_dosen"];
                                                $out .= " | ";
                                                $out .= is_null($log["username"])? "(Username tidak terdata)": $log["username"];
                                                $out .= " | ";
                                                $out .= is_null($log["email"])? "(Email tidak terdata)": $log["email"];
                                                echo $out;
                                            ?>
                                        </p>
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="table-responsive mb-4">
                                    <table id="example" class="table" style="width:100%">
                                        <tbody>
                                            <?php if($logAction == "U"): ?>
                                                <?php foreach($sections as $sName => $sKey): ?>
                                                    <tr class="align-middle">
                                                        <td><b><?= $sName ?></b></td>
                                                        <?php if($old[$sKey] == $new[$sKey]): ?>
                                                            <td> <?= $old[$sKey]?> </td>
                                                        <?php else: ?>
                                                            <td class="m-0 p-0">
                                                                <table class=" m-0 p-0 table-striped table h-100">
                                                                    <tr>
                                                                        <td style="width: 7ch";><strong>Sebelum</strong></td>
                                                                        <td class="text-left"> <?= $old[$sKey]?> </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 7ch; "><strong>Sesudah</strong></td>
                                                                        <td class="text-left"> <?= $new[$sKey]?> </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        <?php endif?>
                                                    </tr>
                                                <?php endforeach ?>
                                            <?php else: ?>
                                                <?php foreach($sections as $sName => $sKey): ?>
                                                    <tr class="align-middle">
                                                        <td><b><?= $sName ?></b></td>
                                                        <td> 
                                                            <?= (($logAction == "D") ? $old[$sKey] 
                                                                                    : $new[$sKey]) ?> 
                                                        </td>
                                                    </tr>
                                                <?php endforeach ?>
                                            <?php endif?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- container-fluid -->
        </div> <!-- End Page-content -->


        <?= $this->include('partials/footer') ?>
    </div>
    <!-- end main content-->

</div>
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