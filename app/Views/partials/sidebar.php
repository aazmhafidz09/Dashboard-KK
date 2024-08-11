<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="index" class="logo logo-dark">
            <span class="logo-sm">
                <img src="/assets/images/logo-sm.png" alt="" height="30">
            </span>
            <span class="logo-lg">
                <img src="/assets/images/Logo-KK.png" alt="" height="50">
            </span>
        </a>

        <!-- <a href="index" class="logo logo-light">
            <span class="logo-sm">
                <img src="/assets/images/logo-sm.png" alt="Logo Telkom University" height="30">
            </span>
            <span class="logo-lg">
                <img src="/assets/images/logo-KK.png" alt="Logo Telkom University" height="50">
            </span>
        </a> -->
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
        <i class="fa fa-fw fa-bars"></i>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">
        <div id="sidebar-menu"> <!--- Sidemenu -->
            <ul class="metismenu list-unstyled" id="side-menu"> <!-- Left Menu Start -->
                <li class="menu-title"><?= lang('Files.Menu') ?></li>
                <li>
                    <a href="/index">
                        <i class="uil-home-alt"></i>
                        <span><?= lang('Files.Dashboard') ?></span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-graph-bar"></i>
                        <span><?= lang('Statistik') ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="/publikasi"><?= lang('Publikasi') ?></a></li>
                        <li><a href="/penelitian"><?= lang('Penelitian') ?></a></li>
                        <li><a href="/abdimas"><?= lang('Abdimas') ?></a></li>
                        <li><a href="/haki"><?= lang('HaKi') ?></a></li>
                    </ul>
                </li>


                <li>
                    <a href="/dosen">
                        <i class="uil-user-circle"></i><span class="badge rounded-pill bg-primary float-end"></span>
                        <span><?= lang('Dosen') ?></span>
                    </a>
                </li>
                <?php if(logged_in()): ?>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="uil-share-alt"></i>
                            <span><?= lang('Manage') ?></span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            <li><a href="/admin"><?= lang('Kelola Data') ?></a></li>
                                <li><a href="javascript: void(0);" class="has-arrow"><?= lang('Input Data') ?></a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="/admin/publikasi">Publikasi</a></li>
                                        <li><a href="/admin/penelitian">Penelitian</a></li>
                                        <li><a href="/admin/abdimas">Abdimas</a></li>
                                        <li><a href="/admin/haki">Haki</a></li>
                                    </ul>
                                </li>
                                <?php if(in_groups(["admin", "kk_dsis", "kk_seal", "kk_citi"], user_id())): ?>
                                    <li><a href="/admin/import"><?= lang('Impor Data') ?></a></li>
                                    <li><a href="/admin/export"><?= lang('Ekspor Data') ?></a></li>
                                    <li><a href="/register"><?= lang('Tambah Akun') ?></a></li>
                                <?php endif ?>
                        </ul>
                    </li>
                    <li>
                        <?php if(in_groups(["admin", "kk_dsis", "kk_seal", "kk_citi"], user_id())): ?>
                            <a href="/admin/log">
                                <i class="uil-history"></i><span class="badge rounded-pill bg-primary float-end"></span>
                                <span><?= lang('Log') ?></span>
                            </a>
                        <?php endif ?>
                    </li>
                <?php endif ?>
            </ul>
        </div> <!-- Sidebar -->
    </div>
</div> <!-- Left Sidebar End -->