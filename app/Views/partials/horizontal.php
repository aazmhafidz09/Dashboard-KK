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

            <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <!-- App Search-->
            <form class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="<?= lang('Files.Search') ?>...">
                    <span class="uil-search"></span>
                </div>
            </form>
        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="uil-search"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="<?= lang('Files.Search') ?> ..." aria-label="Recipient's username">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="dropdown d-inline-block language-switch">
                <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php
                    $session = \Config\Services::session();

                    $lang = $session->get('lang');
                    switch ($lang) {
                        case 'en':
                            echo '<img src="assets/images/flags/us.jpg" alt="Header Language" height="16">';
                            break;
                        case 'es':
                            echo '<img src="assets/images/flags/spain.jpg" alt="Header Language" height="16">';
                            break;
                        case 'de':
                            echo '<img src="assets/images/flags/germany.jpg" alt="Header Language" height="16">';
                            break;
                        case 'it':
                            echo '<img src="assets/images/flags/italy.jpg" alt="Header Language" height="16">';
                            break;
                        case 'ru':
                            echo '<img src="assets/images/flags/russia.jpg" alt="Header Language" height="16">';
                            break;
                        default:
                            echo '<img src="assets/images/flags/us.jpg" alt="Header Language" height="16">';
                    }
                    ?>
                </button>
                <div class="dropdown-menu dropdown-menu-end">

                    <!-- item-->
                    <?php if ($lang !== 'en') :  ?>
                        <a href="<?= base_url('lang/en'); ?>" class="dropdown-item notify-item">
                            <img src="assets/images/flags/us.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">English</span>
                        </a>
                    <?php endif ?>

                    <!-- item-->
                    <?php if ($lang !== 'es') :  ?>
                        <a href="<?= base_url('lang/es'); ?>" class="dropdown-item notify-item">
                            <img src="assets/images/flags/spain.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Spanish</span>
                        </a>
                    <?php endif ?>

                    <!-- item-->
                    <?php if ($lang !== 'de') :  ?>
                        <a href="<?= base_url('lang/de'); ?>" class="dropdown-item notify-item">
                            <img src="assets/images/flags/germany.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">German</span>
                        </a>
                    <?php endif ?>

                    <!-- item-->
                    <?php if ($lang !== 'it') :  ?>
                        <a href="<?= base_url('lang/it'); ?>" class="dropdown-item notify-item">
                            <img src="assets/images/flags/italy.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Italian</span>
                        </a>
                    <?php endif ?>

                    <!-- item-->
                    <?php if ($lang !== 'ru') :  ?>
                        <a href="<?= base_url('lang/ru'); ?>" class="dropdown-item notify-item">
                            <img src="assets/images/flags/russia.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Russian</span>
                        </a>
                    <?php endif ?>
                </div>
            </div>

            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="uil-apps"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <div class="px-lg-2">
                        <div class="row g-0">
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="assets/images/brands/github.png" alt="Github">
                                    <span>GitHub</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="assets/images/brands/bitbucket.png" alt="bitbucket">
                                    <span>Bitbucket</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="assets/images/brands/dribbble.png" alt="dribbble">
                                    <span>Dribbble</span>
                                </a>
                            </div>
                        </div>

                        <div class="row g-0">
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="assets/images/brands/dropbox.png" alt="dropbox">
                                    <span>Dropbox</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="assets/images/brands/mail_chimp.png" alt="mail_chimp">
                                    <span>Mail Chimp</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="assets/images/brands/slack.png" alt="slack">
                                    <span>Slack</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                    <i class="uil-minus-path"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="uil-bell"></i>
                    <span class="badge bg-danger rounded-pill">3</span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="m-0 font-size-16"> <?= lang('Files.Notifications') ?> </h5>
                            </div>
                            <div class="col-auto">
                                <a href="javascript:void(0);" class="small"> <?= lang('Files.Mark all as read') ?></a>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;">
                        <a href="javascript:void(0);" class="text-dark notification-item">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-xs">
                                        <span class="avatar-title bg-primary rounded-circle font-size-16">
                                            <i class="uil-shopping-basket"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?= lang('Files.Your order is placed') ?></h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1"><?= lang('Files.If several languages coalesce the grammar') ?></p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <?= lang('Files.3 min ago') ?></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="javascript:void(0);" class="text-dark notification-item">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0 me-3">
                                    <img src="assets/images/users/avatar-3.jpg" class="rounded-circle avatar-xs" alt="user-pic">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">James Lemire</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1"><?= lang('Files.It will seem like simplified English') ?>.</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <?= lang('Files.1 hours ago') ?></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="javascript:void(0);" class="text-dark notification-item">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-xs">
                                        <span class="avatar-title bg-success rounded-circle font-size-16">
                                            <i class="uil-truck"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?= lang('Files.Your item is shipped') ?></h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1"><?= lang('Files.If several languages coalesce the grammar') ?></p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <?= lang('Files.3 min ago') ?></p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="javascript:void(0);" class="text-dark notification-item">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0 me-3">
                                    <img src="assets/images/users/avatar-4.jpg" class="rounded-circle avatar-xs" alt="user-pic">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Salena Layfield</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1"><?= lang('Files.As a skeptical Cambridge friend of mine occidental') ?>.</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <?= lang('Files.1 hours ago') ?></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="p-2 border-top">
                        <div class="d-grid">
                            <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                                <i class="uil-arrow-circle-right me-1"></i> <?= lang('Files.View More') ?>..
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-4.jpg" alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1 fw-medium font-size-15">Marcus</span>
                    <i class="uil-angle-down d-none d-xl-inline-block font-size-15"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="javascript:void(0)"><i class="uil uil-user-circle font-size-18 align-middle text-muted me-1"></i> <span class="align-middle"><?= lang('Files.View Profile') ?></span></a>
                    <a class="dropdown-item" href="javascript:void(0)"><i class="uil uil-wallet font-size-18 align-middle me-1 text-muted"></i> <span class="align-middle"><?= lang('Files.My Wallet') ?></span></a>
                    <a class="dropdown-item d-block" href="javascript:void(0)"><i class="uil uil-cog font-size-18 align-middle me-1 text-muted"></i> <span class="align-middle"><?= lang('Files.Settings') ?></span> <span class="badge bg-success-subtle text-success rounded-pill mt-1 ms-2">03</span></a>
                    <a class="dropdown-item" href="auth-lock-screen"><i class="uil uil-lock-alt font-size-18 align-middle me-1 text-muted"></i> <span class="align-middle"><?= lang('Files.Lock screen') ?></span></a>
                    <a class="dropdown-item" href="auth-login"><i class="uil uil-sign-out-alt font-size-18 align-middle me-1 text-muted"></i> <span class="align-middle"><?= lang('Files.Sign out') ?></span></a>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                    <i class="uil-cog"></i>
                </button>
            </div>

        </div>
    </div>
    <div class="container-fluid">
        <div class="topnav">

            <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                <div class="collapse navbar-collapse" id="topnav-menu-content">
                    <ul class="navbar-nav">

                        <li class="nav-item">
                            <a class="nav-link" href="index">
                                <i class="uil-home-alt me-2"></i> <?= lang('Files.Dashboard') ?>
                            </a>
                        </li>







                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-more" role="button">
                                <i class="uil-copy me-2"></i><?= lang('Files.Extra Pages') ?> <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-more">

                                <div class="dropdown">
                                    <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-auth" role="button">
                                        <?= lang('Files.Authentication') ?> <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="topnav-auth">
                                        <a href="auth-login" class="dropdown-item"><?= lang('Files.Login') ?></a>
                                        <a href="auth-register" class="dropdown-item"><?= lang('Files.Register') ?></a>
                                        <a href="auth-recoverpw" class="dropdown-item"><?= lang('Files.Recover Password') ?></a>
                                        <a href="auth-lock-screen" class="dropdown-item"><?= lang('Files.Lock Screen') ?></a>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-utility" role="button">
                                        <?= lang('Files.Utility') ?> <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="topnav-utility">
                                        <a href="pages-starter" class="dropdown-item"><?= lang('Files.Starter Page') ?></a>
                                        <a href="pages-maintenance" class="dropdown-item"><?= lang('Files.Maintenance') ?></a>
                                        <a href="pages-comingsoon" class="dropdown-item"><?= lang('Files.Coming Soon') ?></a>
                                        <a href="pages-404" class="dropdown-item"><?= lang('Files.Error') ?> 404</a>
                                        <a href="pages-500" class="dropdown-item"><?= lang('Files.Error') ?> 500</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button">
                                <i class="uil-window-section me-2"></i><?= lang('Files.Layouts') ?> <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-layout">
                                <div class="dropdown">
                                    <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-verti" role="button">
                                        <?= lang('Files.Vertical') ?> <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="topnav-layout-verti">
                                        <a href="layouts-dark-sidebar" class="dropdown-item"><?= lang('Files.Dark Sidebar') ?></a>
                                        <a href="layouts-compact-sidebar" class="dropdown-item"><?= lang('Files.Compact Sidebar') ?></a>
                                        <a href="layouts-icon-sidebar" class="dropdown-item"><?= lang('Files.Icon Sidebar') ?></a>
                                        <a href="layouts-boxed" class="dropdown-item"><?= lang('Files.Boxed Width') ?></a>
                                        <a href="layouts-preloader" class="dropdown-item"><?= lang('Files.Preloader') ?></a>
                                        <a href="layouts-colored-sidebar" class="dropdown-item"><?= lang('Files.Colored Sidebar') ?></a>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-hori" role="button">
                                        <?= lang('Files.Horizontal') ?> <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="topnav-layout-hori">
                                        <a href="layouts-horizontal" class="dropdown-item"><?= lang('Files.Horizontal') ?></a>
                                        <a href="layouts-hori-topbar-dark" class="dropdown-item"><?= lang('Files.Dark Topbar') ?></a>
                                        <a href="layouts-hori-boxed-width" class="dropdown-item"><?= lang('Files.Boxed Width') ?></a>
                                        <a href="layouts-hori-preloader" class="dropdown-item"><?= lang('Files.Preloader') ?></a>
                                    </div>
                                </div>
                            </div>
                        </li>

                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>