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
                <?php if (session()->getFlashdata('pesan')) : ?>
                    <div class="alert alert-success" role="alert">
                        <?= session()->getFlashdata('pesan'); ?>
                    </div>
                <?php endif ?>

                <?php if (session()->getFlashdata('warning')) : ?>
                    <div class="alert alert-warning" role="alert">
                        <?= session()->getFlashdata('warning'); ?>
                    </div>
                <?php endif ?>

                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?= session()->getFlashdata('error'); ?>
                    </div>
                <?php endif ?>
                <div class="row mb-4">
                    <div class="col-xl-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="clearfix"></div>
                                    <div>
                                        <img src="#" alt="" class="avatar-lg rounded-circle img-thumbnail">
                                    </div>
                                    <h2 class="mt-3 mb-1 fs-4"><?= $dosen['nama_dosen']; ?></h2>
                                    <p class="text-muted"><?= $dosen['kode_dosen']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="card p-2 h-100">
                            <div class="card-body">
                                <div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h3 class="fs-4 m-0 p-0"> Roadmap Saya</h2>
                                        <a 
                                            href="#roadmap__toolSection" 
                                            class="btn btn-primary waves-effect waves-light font-size-14" 
                                            role="button"
                                            onclick="toggleAdd()"
                                        >
                                            <i class="mdi mdi-plus me-1"></i>Tambah
                                        </a>
                                    </div>
                                    <hr>
                                    <div class="table-responsive mb-4">
                                        <table id="example" class="table table-striped" style="width:100%">
                                            <thead>
                                                <th style="width: 10%">Tahun</th>
                                                <th style="width: 80%">Topik</th>
                                                <th style="width: 10%" class="text-center">Aksi</th>
                                            </thead>
                                            <?php foreach($roadmap as $r): ?>
                                                <tr> 
                                                    <td> <?= $r["tahun"] ?> </td> 
                                                    <td> <?= $r["topik"] ?> </td> 
                                                    <td>  
                                                        <ul class='d-flex list-inline mb-0'  style='gap: 12px;'>
                                                            <li class='list-inline-item'>
                                                                <a
                                                                    href="#roadmap__edit"
                                                                    class='p-0 border-0 bg-transparent text-primary'
                                                                    onclick="toggleEdit(<?= $r['id'] ?>)"
                                                                >
                                                                    <i class='uil uil-pen font-size-18'></i>
                                                                </a>
                                                            </li>
                                                            <li class='list-inline-item'>
                                                                <button 
                                                                    class='p-0 border-0 bg-transparent text-danger'
                                                                    onclick="window.location = '/profile/roadmap/delete/<?=$r['id']?>'"
                                                                >
                                                                    <i class='uil uil-trash-alt font-size-18'></i>
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </td> 
                                                </tr>
                                            <?php endforeach ?>
                                        </table>
                                    </div>
                                    <div id="roadmap__toolSection" style="display: none;">
                                        <form 
                                            action="<?= base_url('/profile/roadmap/add')?>"
                                            method="post"
                                            id="roadmap__add"
                                            style="display: none;"
                                        >
                                            <?= csrf_field(); ?>
                                            <h3 class="card-title-desc m-0 p-0 fs-4"> Tambah roadmap</h3>
                                            <hr>
                                        <div class="row">
                                            <div class="col-8">
                                                <label for="roadmapAdd__topik"> Topik </label>
                                                <input 
                                                    class="form-control" 
                                                    type="text" 
                                                    placeholder="Topik roadmap" 
                                                    name="topik"
                                                    id="roadmapAdd__topik"
                                                >
                                            </div>
                                            <div class="col-4">
                                                <div class="mb-2">
                                                    <label for="roadmapAdd__tahun">Tahun</label>
                                                    <input 
                                                        class="form-control" 
                                                        type="number" 
                                                        placeholder="Tahun Periode" 
                                                        name="tahun"
                                                        id="roadmapAdd__tahun"
                                                    >
                                                </div>
                                                <button 
                                                    type="submit" 
                                                    class="float-end btn btn-primary waves-effect waves-light w-md"
                                                > Tambah </button>
                                            </div>
                                        </div>
                                    </form>
                                    <form 
                                        action="#" 
                                        method="post"
                                        id="roadmap__edit"
                                        style="display: none;"
                                    >
                                        <?= csrf_field(); ?>
                                        <h3 class="card-title-desc m-0 p-0 fs-4"> Edit roadmap</h3>
                                        <hr>
                                        <div class="row">
                                            <div class="col-8">
                                                <label for="roadmapEdit__topik"> Topik </label>
                                                <input 
                                                    class="form-control" 
                                                    type="text" 
                                                    placeholder="Topik roadmap" 
                                                    name="topik"
                                                    id="roadmapEdit__topik"
                                                >
                                            </div>
                                            <div class="col-4">
                                                <div class="mb-2">
                                                    <label for="roadmapEdit__tahun">Tahun</label>
                                                    <input 
                                                        class="form-control" 
                                                        type="number" 
                                                        placeholder="Tahun Periode" 
                                                        name="tahun"
                                                        id="roadmapEdit__tahun"
                                                    >
                                                </div>
                                                <button 
                                                    type="submit" 
                                                    class="float-end btn btn-primary waves-effect waves-light w-md"
                                                > Perbarui </button>
                                            </div>
                                        </div>
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

<script>
    const allRoadmap = {<?php
        foreach($roadmap as $r) {
            echo "'" . $r["id"] . "': {";
            foreach($r as $key => $value) {
                echo "'$key': '$value',";
            }
            echo "},";
        }
    ?>}

    const [toggleEdit, toggleAdd] = (function() {
        const roadmapToolSection = document.getElementById("roadmap__toolSection")
        const addSection = document.getElementById("roadmap__add");
        const editSection = document.getElementById("roadmap__edit");
        let state = "";

        const toggleEdit = function(id) {
            const newState = `E${id}`;
            if(state == newState) return;
            state = newState;

            addSection.style.display = "none" ;
            roadmapToolSection.style.display = "block";
            editSection.style.display = "block" ;
            editSection.action = `<?= base_url('/profile/roadmap/edit/')?>${id}`;
            document.getElementById("roadmapEdit__topik").value = allRoadmap[id]["topik"]
            document.getElementById("roadmapEdit__tahun").value = allRoadmap[id]["tahun"]
        }

        const toggleAdd = function() {
            const newState = `A`;
            if(state == newState) return;
            state = newState;

            roadmapToolSection.style.display = "block";
            addSection.style.display = "block" ;
            editSection.style.display = "none" ;
        }

        return [toggleEdit, toggleAdd];
    })()
</script>

</body>
</html>