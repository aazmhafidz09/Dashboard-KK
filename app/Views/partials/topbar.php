<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/logo-dark.png" alt="" height="20">
                    </span>
                </a>

                <a href="index" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/logo-light.png" alt="" height="20">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>

        <div class="d-flex">
            <?php if (logged_in()) : ?>
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle header-profile-user" src="/assets/images/users/user-avatar.jpg" alt="Header Avatar">
                        <span class="d-none d-xl-inline-block ms-1 fw-medium font-size-15">
                            <?php
                                $currentRole = "Unknown";
                                if(in_groups("admin", user_id())) { 
                                    $currentRole = "Admin"; 
                                } else if(in_groups("kk_seal", user_id())) { 
                                    $currentRole = "Admin SEAL"; 
                                } else if(in_groups("kk_citi", user_id())) { 
                                    $currentRole = "Admin CITI"; 
                                } else if(in_groups("kk_dsis", user_id())) { 
                                    $currentRole = "Admin DSIS"; 
                                } else if(in_groups("dosen", user_id())) { 
                                    $currentRole = "Dosen"; 
                                }

                                $kodeDosen = user()->kode_dosen;
                                if(!is_null($kodeDosen) && strlen($kodeDosen) > 0) {
                                    $currentRole = $kodeDosen . " (" . $currentRole . ")";
                                }

                                echo $currentRole;
                            ?>
                        </span>
                        <i class="uil-angle-down d-none d-xl-inline-block font-size-15"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="/admin/index">
                            <span class="align-middle">Kelola Data</span>
                        </a>
                        <a class="dropdown-item" href="/dosen">
                            <i class="uil uil-user-circle font-size-18 align-middle text-muted me-1"> </i> 
                            <span class="align-middle">Dosen</span>
                        </a>
                        <a class="dropdown-item" href="/admin/publikasi">
                            <i class="uil-copy-alt"></i> 
                            <span class="align-middle">Publikasi</span>
                        </a>
                        <a class="dropdown-item" href="/admin/penelitian">
                            <i class="uil-align-center-alt"></i> 
                            <span class="align-middle">Penelitian</span>
                        </a>
                        <a class="dropdown-item" href="/admin/abdimas">
                            <i class="uil-trees"></i> 
                            <span class="align-middle">Abdimas</span>
                        </a>
                        <a class="dropdown-item" href="/admin/haki">
                            <i class="uil-file-bookmark-alt"></i> 
                            <span class="align-middle">Haki</span>
                        </a>
                        <a class="dropdown-item" href="/logout">
                            <i class="uil uil-sign-out-alt font-size-18 align-middle me-1 text-muted"></i> 
                            <span class="align-middle">Sign out</span>
                        </a>
                    </div>
                </div>
            <?php else : ?>
                <div class="dropdown d-inline-block">
                    <!-- <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> -->
                    <!-- <img class="rounded-circle header-profile-user" src="/assets/images/users/user-avatar.jpg" alt="Header Avatar"> -->
                    <!-- <span class="d-none d-xl-inline-block ms-1 fw-medium font-size-15">Login</span> -->
                    <a class="dropdown-item" href="/login"> <span class="align-middle">LOGIN</span></a>
                    <!-- <i class="uil-angle-down d-none d-xl-inline-block font-size-15"></i> -->
                    <!-- </button> -->

                </div>
            <?php endif; ?>

        </div>
    </div>
</header>