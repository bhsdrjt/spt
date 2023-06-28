    <nav class="navbar navbar-dark navbar-theme-primary px-4 col-12 d-lg-none">
        <a class="navbar-brand me-lg-5" href="<?= base_url('Admin') ?>">
            <img class="navbar-brand-dark" src="<?= base_url() ?>assets/img/favicon/logo.png" alt="Logo" /> <img class="navbar-brand-light" src="<?= base_url() ?>assets/img/favicon/logo.png" alt="Logo" />
        </a>
        <div class="d-flex align-items-center">
            <button class="navbar-toggler d-lg-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
        <div class="sidebar-inner px-4 pt-3">
            <div class="user-card d-flex d-md-none align-items-center justify-content-between justify-content-md-center pb-4">
                <div class="d-flex align-items-center">
                    <div class="avatar-lg me-4">
                        <img src="<?= base_url() ?>assets/img/favicon/logo.png" class="card-img-top rounded-circle border-white" alt="Admin">
                    </div>
                    <div class="d-block">
                        <h2 class="h5 mb-3"><?= $this->session->userdata('username'); ?></h2>
                        <a href="<?= base_url('Auth/logout') ?>" class="btn btn-secondary btn-sm d-inline-flex align-items-center">
                            <svg class="icon icon-xxs me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Sign Out
                        </a>
                    </div>
                </div>
                <div class="collapse-close d-md-none">
                    <a href="#sidebarMenu" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="true" aria-label="Toggle navigation">
                        <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </div>
            </div>
            <ul class="nav flex-column pt-3 pt-md-0">
                <li class="nav-item">
                    <a href="#" class="nav-link d-flex align-items-center">
                        <span class="sidebar-icon">
                            <img src="<?= base_url() ?>assets/img/favicon/logo.png" height="30" alt="Logo">
                        </span>
                        <span class="mt-1 ms-1 sidebar-text">BKSDA</span>
                    </a>
                </li>
                <li class="nav-item <?= $title == 'Surat Perintah Tugas' ? 'active' : '' ?>">
                    <a href="<?= base_url('Surat_tugas') ?>" class="nav-link">
                        <span class="sidebar-icon"><i class="fa-solid fa-list-check"></i></span>
                        <span class="sidebar-text">SPT</span>

                    </a>
                </li>

                <?php if ($_SESSION['level'] == 'Admin utama') { ?>
                    <li class="nav-item">
                        <span class="nav-link  collapsed  d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#submenu-app">
                            <span>
                                <span class="sidebar-icon"><i class="fa fa-box"></i></span>
                                <span class="sidebar-text">Data Master</span>
                            </span>
                            <span class="link-arrow">
                                <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </span>
                        </span>
                        <div class="multi-level collapse <?= $title == 'Data Perjanjian Kinerja' || $title == 'Data Pegawai' || $title == 'Data User' || $title == 'Data Dasar Surat' || $title == 'Data Sumber Dana' || $title == 'Data Menimbang' || $title == 'Data Untuk' || $title == 'Data Mengetahui' ? 'show' : '' ?>" role="list" id="submenu-app" aria-expanded="false">
                            <ul class="flex-column nav">
                                <li class="nav-item <?= $title == 'Data Menimbang' ? 'active' : '' ?>">
                                    <a class="nav-link" href="<?= base_url('Data_master/menimbang') ?>">
                                        <span class="sidebar-text">Menimbang</span>
                                    </a>
                                </li>
                                <li class="nav-item <?= $title == 'Data Dasar Surat' ? 'active' : '' ?> ">
                                    <a class="nav-link" href="<?= base_url('Data_master/dasar_surat') ?>">
                                        <span class="sidebar-text">Dasar Surat</span>
                                    </a>
                                </li>
                                <li class="nav-item <?= $title == 'Data Sumber Dana' ? 'active' : '' ?> ">
                                    <a class="nav-link" href="<?= base_url('Data_master/sumber_dana') ?>">
                                        <span class="sidebar-text">Sumber Dana</span>
                                    </a>
                                </li>
                                <li class="nav-item <?= $title == 'Data Untuk' ? 'active' : '' ?> ">
                                    <a class="nav-link" href="<?= base_url('Data_master/untuk_poin3') ?>">
                                        <span class="sidebar-text">Untuk</span>
                                    </a>
                                </li>
                                <li class="nav-item <?= $title == 'Data Perjanjian Kinerja' ? 'active' : '' ?>">
                                    <a class="nav-link" href="<?= base_url('Data_master/perjanjian_kinerja') ?>">
                                        <span class="sidebar-text">PK</span>
                                    </a>
                                </li>
                                <li class="nav-item <?= $title == 'Data Mengetahui' ? 'active' : '' ?>">
                                    <a class="nav-link" href="<?= base_url('Data_master/mengetahui') ?>">
                                        <span class="sidebar-text">Mengetahui</span>
                                    </a>
                                </li>
                                <li class="nav-item <?= $title == 'Data Jabatan Mengetahui' ? 'active' : '' ?>">
                                    <a class="nav-link" href="<?= base_url('Data_master/jabatan_mengetahui') ?>">
                                        <span class="sidebar-text">Jabatan Mengetahui</span>
                                    </a>
                                </li>
                                <li class="nav-item <?= $title == 'Kategori SPT' ? 'active' : '' ?> ">
                                    <a class="nav-link" href="<?= base_url('Data_master/kategori_spt') ?>">
                                        <span class="sidebar-text">Kategori SPT</span>
                                    </a>
                                </li>
                                <li class="nav-item <?= $title == 'Data Pegawai' ? 'active' : '' ?> ">
                                    <a class="nav-link" href="<?= base_url('Data_master/pegawai') ?>">
                                        <span class="sidebar-text">Pegawai</span>
                                    </a>
                                </li>
                                <li class="nav-item <?= $title == 'Data User' ? 'active' : '' ?>">
                                    <a class="nav-link" href="<?= base_url('Data_master/user') ?>">
                                        <span class="sidebar-text">User</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item <?= $title == 'Data Statistik' ? 'active' : '' ?>">
                        <a href="<?= base_url('Statistik') ?>" class="nav-link">
                            <span class="sidebar-icon"><i class="fa fa-line-chart"></i></span>
                            <span class="sidebar-text">Statistik</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link  collapsed  d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#setting-app">
                            <span>
                                <span class="sidebar-icon"><i class="fa fa-gears"></i></span>
                                <span class="sidebar-text">Setting</span>
                            </span>
                            <span class="link-arrow">
                                <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </span>
                        </span>
                        <div class="multi-level collapse <?= $title == 'Background Login' ? 'show' : '' ?> role=" list" id="setting-app" aria-expanded="false">
                            <ul class="flex-column nav">
                                <li class="nav-item <?= $title == 'Background Login' ? 'active' : '' ?>">
                                    <a class="nav-link" href="<?= base_url('Setting/background_login') ?>">
                                        <span class="sidebar-text">Background Login</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>