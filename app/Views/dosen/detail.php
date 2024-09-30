<?= $this->include('partials/main') ?>

<!-- 
    NOTICE:
    This page is dependent on Kemendikbud's SINTA page because it doesn't
    provide any usable API. THat means, if SINTA page is changed, this file 
    SHOULD sync itself with SINTA latest state. It includes the way this page
    gather its data from SINTA which heavily depends on SINTA page layout or 
    the domain itself -->
<head>
    <?= $this->include('partials/head-css') ?>
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- Data Table CSS -->
    <link rel='stylesheet' href='https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css'>
    <!-- Font Awesome CSS -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css'>

    <!-- NOTE: SINTA icon pack -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">  -->
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
                    <div class="col-xl-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="clearfix"></div>
                                    <div>
                                        <img 
                                            id="dosenImg"
                                            src="/assets/images/users/user-avatar.jpg" 
                                            alt="<?= $dosen['kode_dosen']; ?>" 
                                            class="avatar-lg rounded-circle img-thumbnail"
                                            style="aspect-ratio:1; width: 100px"
                                            onerror="this.src='/assets/images/users/user-avatar.jpg'">
                                    </div>
                                    <h5 class="mt-3 mb-1"><?= $dosen['nama_dosen']; ?></h5>
                                    <p class="text-muted"><?= $dosen['kode_dosen']; ?></p>
                                </div>

                                <hr class="my-4">

                                <div class="text-muted">
                                    <h5 class="font-size-16">Kelompok Keahlian :</h5>
                                    <p> <?= $dosen["KK"] ?></p>
                                    <div class="mt-4">
                                        <div>
                                            <h5 class="mb-1 font-size-16">Nama :</h5>
                                            <p class=""><?= $dosen['nama_dosen']; ?></p>
                                        </div>
                                        <hr class="my-4">
                                        <h4>Statistik</h4>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mt-3">
                                                    <p class="text-muted mb-2"> Publikasi Penulis 1</p>
                                                    <h3 class="font-size-16 mb-0"><?php echo $jumlah_publikasi_1 ?></h3>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mt-3">
                                                    <p class="text-muted mb-2"># Publikasi</p>
                                                    <h3 class="font-size-16 mb-0"><?php echo $jumlah_publikasi ?></h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mt-3">
                                                    <p class="text-muted mb-2"> Ketua Penelitian</p>
                                                    <h3 class="font-size-16 mb-0"><?php echo $jumlah_ketua_peneliti ?></h3>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mt-3">
                                                    <p class="text-muted mb-2"> # Penelitian</p>
                                                    <h3 class="font-size-16 mb-0"><?php echo $jumlah_penelitian ?></h3>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mt-3">
                                                    <p class="text-muted mb-2"> Abdimas</p>
                                                    <h3 class="font-size-16 mb-0"><?php echo $jumlah_abdimas ?></h3>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mt-3">
                                                    <p class="text-muted mb-2"> Haki</p>
                                                    <h3 class="font-size-16 mb-0"><?php echo $jumlah_haki ?></h3>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="my-4">

                                        <h4>SINTA</h4>
                                        <div id="sinta">
                                            <?php if(is_null($dosen["sinta_id"])): ?>
                                                <p> Data SINTA belum ditambahkan untuk dosen ini </p>
                                            <?php else:?>
                                                <p id="sinta_fetchInfo"> Memuat data SINTA...</p>
                                                <!-- <div class="row" id="sinta_profStat"> </div> -->
                                                <div class="mt-3" id="sinta_sideStat"> </div>
                                                <button type="button" 
                                                    class="btn btn-primary p-0 bg-transparent text-primary float-end" 
                                                    style="border: 0px solid black;"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#exampleModal">
                                                    Profil Selengkapnya
                                                    <i class="uil uil-arrow-right font-size-20"></i> 
                                                </button>
                                            <?php endif?>
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
                                        <i class="uil uil-clipboard-notes font-size-20"></i>
                                        <span class="d-none d-sm-block">Publikasi</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#penelitian" role="tab">
                                        <i class="uil uil-microscope font-size-20"></i>
                                        <span class="d-none d-sm-block">Penelitian</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#abdimas" role="tab">
                                        <i class="uil uil-smile font-size-20"></i>
                                        <span class="d-none d-sm-block">Abdimas</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#haki" role="tab">
                                        <i class="uil uil-dropbox font-size-20"></i>
                                        <span class="d-none d-sm-block">HaKi</span>
                                    </a>
                                </li>
                            </ul>
                            <!-- Tab content -->
                            <div class="tab-content p-4">
                                <div class="tab-pane active" id="publikasi" role="tabpanel">
                                    <div>
                                        <div>
                                            <div class="table-responsive">
                                                <table class="table table-nowrap table-hover mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">No</th>
                                                            <th scope="col">Judul</th>
                                                            <th scope="col">Tahun</th>
                                                            <th scope="col" style="width: 6ch; text-align: center;">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1 ?>
                                                        <?php foreach ($publikasi as $pb) : ?>
                                                            <tr>
                                                                <td scope="row"><?= $i++; ?></td>
                                                                <td>
                                                                    <p class="text-reset " > <?= (
                                                                        (strlen($pb['judul_publikasi']) <= 50)
                                                                        ? $pb['judul_publikasi']
                                                                        : substr($pb['judul_publikasi'], 0, 50) . "..."
                                                                    ); ?> </p>
                                                                </td>
                                                                <td> <?= $pb['tahun']; ?> </td>
                                                                <td> 
                                                                    <a 
                                                                        style="width: 20px; display: block; margin: auto;"
                                                                        href="<?=base_url("/publikasi/view/" . $pb['id'])?>"
                                                                        class="uil uil-eye font-size-18" >
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="penelitian" role="tabpanel">
                                    <div>
                                        <div class="table-responsive">
                                            <table class="table table-nowrap table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">No</th>
                                                        <th scope="col">Judul</th>
                                                        <th scope="col">Tahun</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col" style="width: 6ch; text-align: center;">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1 ?>
                                                    <?php foreach ($penelitian as $pn) : ?>
                                                        <tr>
                                                            <th scope="row"><?= $i++; ?></th>
                                                            <td>
                                                                <p class="text-reset "> <?= (
                                                                    (strlen($pn['judul_penelitian']) <= 40)
                                                                    ? $pn['judul_penelitian']
                                                                    : substr($pn['judul_penelitian'], 0, 40) . "..."
                                                                ); ?> </p>
                                                            </td>
                                                            <td> <?= $pn['tahun']; ?> </td>
                                                            <td> <?= $pn['status']; ?> </td>
                                                            <td> 
                                                                <a 
                                                                    style="width: 20px; display: block; margin: auto;"
                                                                    href="<?=base_url("/penelitian/view/" . $pn['id'])?>"
                                                                    class="uil uil-eye font-size-18">
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="abdimas" role="tabpanel">
                                    <div>
                                        <div class="table-responsive">
                                            <table class="table table-nowrap table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">No</th>
                                                        <th scope="col">Judul</th>
                                                        <th scope="col">Tahun</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Mitra</th>
                                                        <th scope="col" style="width: 6ch; text-align: center;">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1 ?>
                                                    <?php foreach ($abdimas as $ab) : ?>
                                                        <tr>
                                                            <td scope="row"><?= $i++; ?></td>
                                                            <td>
                                                                <p class="text-reset "> <?= (
                                                                    (strlen($ab['judul']) <= 40)
                                                                    ? $ab['judul']
                                                                    : substr($ab['judul'], 0, 40) . "..."
                                                                ); ?> </p>
                                                            <td> <?= $ab['tahun']; ?> </td>
                                                            <td> <?= $ab['status']; ?> </td>
                                                            <td> 
                                                                <p class="text-reset "> <?= (
                                                                    (strlen($ab['mitra']) <= 20)
                                                                    ? $ab['mitra']
                                                                    : substr($ab['mitra'], 0, 20) . "..."
                                                                ); ?> </p>
                                                            </td>
                                                            <td> 
                                                                <a 
                                                                    style="width: 20px; display: block; margin: auto;"
                                                                    href="<?=base_url("/abdimas/view/" . $ab['id'])?>"
                                                                    class="uil uil-eye font-size-18">
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="haki" role="tabpanel">
                                    <div>
                                        <div class="table-responsive">
                                            <table class="table table-nowrap table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">No</th>
                                                        <th scope="col">Judul</th>
                                                        <th scope="col">Tahun</th>
                                                        <th scope="col">Jenis</th>
                                                        <th scope="col" style="width: 6ch; text-align: center;">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1 ?>
                                                    <?php foreach ($haki as $hk) : ?>
                                                        <tr>
                                                            <td scope="row"><?= $i++; ?></td>
                                                            <td>
                                                                <p class="text-reset "> <?= (
                                                                    (strlen($hk['judul']) <= 40)
                                                                    ? $hk['judul']
                                                                    : substr($hk['judul'], 0, 40) . "..."
                                                                ); ?> </p>
                                                            </td>
                                                            <td> <?= $hk['tahun']; ?> </td>
                                                            <td> <?= $hk['jenis']; ?> </td>
                                                            <td> 
                                                                <a 
                                                                    style="width: 20px; display: block; margin: auto;"
                                                                    href="<?=base_url("/haki/view/" . $hk['id'])?>"
                                                                    class="uil uil-eye font-size-18">
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade modal-xl" 
                    id="exampleModal" 
                    tabindex="-1" 
                    aria-labelledby="exampleModalLabel" 
                    aria-hidden="true"
                >
                    <div class="modal-dialog overflow-clip">
                        <div class="modal-content" style="height: 90vh">
                            <div class="modal-header pb-3 pt-3">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-0 d-flex" style="overflow: clip">
                                <?php if(is_null($dosen["sinta_id"])): ?>
                                    <p class="align-center h-100"> Data SINTA belum ditambahkan untuk dosen ini </p>
                                <?php else:?>
                                    <iframe 
                                        data-reloaded="0"
                                        allow="fullscreen"
                                        style="flex: 1;"
                                        src="https://sinta.kemdikbud.go.id/authors/profile/<?= $dosen["sinta_id"]?>" frameborder="0"
                                    ><!-- 
                                        Onload forcefully reload, since the graph sometimes doesn't load on initialization and the reason why is unknown 
                                        onload=" () => { console.log('hell'); if ($(this).attr('data-reloaded')) { $(this).attr('src', $(this).attr('src')); $(this).removeAttr('data-reloaded') }}" 
                                    -->
                                    </iframe>
                                <?php endif?>
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

<script>
    <?php if(!is_null($dosen["sinta_id"])): ?>
        // NOTE: This approach really depends on https://sinta.kemdikbud.go.id/ layout
        // It it's get updated, the following code should be adapted to that layout to
        // get the desired data
        $(document).ready(async() => {
            const SINTA_ID = "<?= $dosen["sinta_id"]?>"
            const SINTA_URL = `https://sinta.kemdikbud.go.id/authors/profile/${SINTA_ID}`
            const $sintaFetchInfo = $("#sinta_fetchInfo")

            await fetch(`/thirdparty/sinta/${SINTA_ID}`)
                .then(res => {
                    if(!res.ok) throw Error("Something went wrong")
                    return res.text()
                })
                .then(res => {
                    // Always sync these with how the data exist within SINTA page's DOM
                    const $html = $(res);
                    // const $statistics = $html.find(".stat-profile > div")
                    const $summary = $html.find(".side-content")
                                        .find(".table")
                    const $pfp = $html.find(".content-box")
                                    .children()
                                    .first()
                                    .children()
                                    .first()
                                    .find("img")

                    const fetchOK = $summary.length !== 0 //&& $statistics.length !== 0
                    if(!fetchOK) {
                        throw Error(`Failed fething SINTA author page. This might be because of profile id ${SINTA_ID} wasn't found or the SINTA page layout has changed`)
                    }
                    $sintaFetchInfo.remove()

                    // Adjust some breaking changes as this site uses Bootstrap5 
                    // while SINTA uses Bootstrap4
                    const $sintaSideStats = $("#sinta_sideStat")
                    $summary
                        .find("thead > tr")
                        .children()
                        .first()
                        .removeClass("text-left")
                        .addClass("text-start")
                    $summary
                        .find("tbody")
                        .children()
                        .each(function() {
                            $(this).children()
                                    .first()
                                    .removeClass("text-left") 
                                    .addClass("text-start")
                        })
                    $sintaSideStats.empty()
                    $sintaSideStats.append($summary.prop("outerHTML"))

                    // const $sintaProfileStats = $("#sinta_profStat")
                    // $statistics
                    //     .children(":nth-child(even)")
                    //     .each(function() {
                    //         const $child = $(this).clone()
                    //         const $statName = $('<p class="text-muted mb-2"> </p>')
                    //         const $statValue = $('<h3 class="font-size-16 mb-0"> </h3>')
                    //         $statName.text($child.find(".pr-txt").prop("innerHTML"))
                    //         $statValue.text($child.find(".pr-num").prop("innerHTML"))

                    //         const $column = $("<div class='col-6'></div>")
                    //         const $content = $("<div class='mt-3'></div>")

                    //         $content.append($statName)
                    //         $content.append($statValue)
                    //         $column.append($content)
                    //         $sintaProfileStats.append($column)
                    //     })

                    $dosenPfp = $("#dosenImg")
                    $dosenPfp.attr("src", $pfp.attr("src"))

                })
                .catch(err => {
                    $sintaFetchInfo.text("Terjadi kesalahan ketika memuat data SINTA")
                    console.log(`LOG: ${err}`)
                })
        })
    <?php endif?>
</script>
</body>
</html>