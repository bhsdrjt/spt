<!--

=========================================================
* Volt Pro - Premium Bootstrap 5 Dashboard
=========================================================

* Product Page: https://themesberg.com/product/admin-dashboard/volt-bootstrap-5-dashboard
* Copyright 2021 Themesberg (https://www.themesberg.com)
* License (https://themes.getbootstrap.com/licenses/)

* Designed and coded by https://themesberg.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. Please contact us to request a removal.

-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Primary Meta Tags -->
    <title>BKSDA | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="title" content="Website SPT BKSDA Kalsel - Login">
    <meta name="author" content="BKSDA">
    <meta name="description" content="Website pembuatan surat perintah tugas untuk pegawai di lingkungan BKSDA Kalsel">
    <meta name="keywords" content="SPT, PK, Surat" />
    <!-- <link rel="canonical" href="https://themesberg.com/product/admin-dashboard/volt-premium-bootstrap-5-dashboard"> -->

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="120x120" href="<?= base_url() ?>assets/img/favicon/logo.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url() ?>/assets/img/favicon/logo.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>/assets/img/favicon/logo.png">
    <link rel="manifest" href="<?= base_url() ?>/assets/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="<?= base_url() ?>/assets/img/favicon/safari-pinned-tab.svg" color="#ffffff">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <!-- Sweet Alert -->
    <link type="text/css" href="<?= base_url() ?>/vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Notyf -->
    <link type="text/css" href="<?= base_url() ?>/vendor/notyf/notyf.min.css" rel="stylesheet">

    <!-- Volt CSS -->
    <link type="text/css" href="<?= base_url() ?>/assets/css/volt.css" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

</head>
<style>
    /* Make the image fully responsive */
    /* .carousel-inner img {
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
    } */

    #demo {
        position: absolute;
        z-index: -1;
    }

    /* #frontpage {
        color: red;
        font-size: larger;
        background-color: yellow;
        opacity: 0.5;
        padding: 50px;
    } */
</style>


<div id="demo" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <?php if (!empty($background)) {
            $index = 0;
            $no = 1;
            foreach ($background as $bg) { ?>
                <div class="carousel-item gambar<?= $no ?> <?= $index == 0 ? 'active' : '' ?>">
                    <img src="<?= base_url('assets/uploads/background/' . $bg->bg) ?>" alt="Slide <?= $no ?>" style="width: 100%;object-fit: cover;">
                </div>
            <?php $no++;
                $index++;
            }
        } else { ?>
            <div class="carousel-item gambar active">
                <img src="<?= base_url('assets/img/illustrations/bg2.jpeg') ?>" alt="Slide 1" style="width: 100%;object-fit: cover;">
            </div>
        <?php } ?>
    </div>
</div>

<body class="">
    <div class="row">
        <!-- <div class="row"> -->
        <!-- <?php if (isset($PK)) {
                    $persen = 0;
                    foreach ($PK as $data) { ?>
                <div class="col-3 mt-1">
                    <div class="card border-0 shadow" style="max-height: 80px;">
                        <div class="card-body" style="padding: 8px">
                            <label class="text-black-400" style="font-size:x-small;"> <?= $data->nama_kegiatan ?> <b style="font-size: x-small;"> <?php $persen = ($data->jmlPK / $totSPT) * 100;
                                                                                                                                                    echo number_format($persen, 2, ".", ",") . '%';
                                                                                                                                                    ?></b></label>

                        </div>
                    </div>
                </div>
        <?php }
                } ?> -->
        <!-- </div> -->

        <div class="col-3 vh-lg-100" style="padding-left: 15px;overflow-y:auto;">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow">
                        <div class="card-body rounded py-2 px-2">
                            <form action="<?= base_url('Auth') ?>" method="post">
                                <div class="row">
                                    <div class="col-9">
                                        <select class="form-select form" name="tahun" id="tahun">
                                            <?php foreach ($tahun as $thn) {
                                                echo "<option value='" . $thn->tahun . "'";
                                                echo isset($tahunSelected) && $tahunSelected == $thn->tahun ? 'selected' : '';
                                                echo ">" . $thn->tahun . "</option>";
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <button type="submit" class="btn btn-info"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                            <!-- <div class="py-1">
                                <i class="fa fa-server"></i> &nbsp;<b> Total SPT &nbsp;&nbsp;&nbsp; <? //= isset($totSPT) ? $totSPT : 0 
                                                                                                    ?></b>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>


            <?php if (isset($PK)) {
                $persen = 0;
                foreach ($PK as $data) { ?>
                    <div class="row pt-1">
                        <div class="col-12">
                            <div class="card border-0 shadow">
                                <div class="card-body py-2 px-0">
                                    <div class="row d-block d-xl-flex align-items-center">
                                        <div class="col-12 col-xl-12 mb-3 mb-xl-0 d-flex align-items-center px-xl-4">
                                            <div class="icon-shape icon-shape-info rounded me-4 me-sm-0" style="height: 40px;width:40px">
                                                <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                                                </svg>
                                            </div>
                                            &nbsp;&nbsp;&nbsp;
                                            <h5 class="fw-extrabold pt-2">
                                                <?php $persen = ($data->jmlPK / $totSPT) * 100;
                                                echo number_format($persen, 2, ".", ",") . '%';
                                                ?>
                                            </h5>
                                        </div>
                                        <div class="col-12 col-xl-12 px-xl-4 mt-1" style="font-size: x-small;line-height: normal">
                                            <div class="d-none d-sm-block">
                                                <b><?= $data->nama_kegiatan ?></b>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-9">
                                            <? //= $data->nama_kegiatan . " (" . $data->jmlPK . ")" 
                                            ?>
                                        </div> -->

                        </div>
                    </div>
            <?php }
            } ?>




        </div>

        <div class="col-9">
            <main>
                <!-- Section -->
                <img src="<?= base_url('assets/img/favicon/siratu.png') ?>" height="80px" style=" position: fixed;top: 20px;right: 20px;z-index: 9999;">

                <section class="vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
                    <div class="container">
                        <div class="row justify-content-center form-bg-image">
                            <div class="col-12 d-flex align-items-center justify-content-center">
                                <div class="bg-white bg-opacity-75 shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                                    <div class="text-center text-md-center mb-4 mt-md-0">
                                        <img src="<?= base_url('assets/img/favicon/logo.png') ?>" height="80px">
                                        <h6>APLIKASI SURAT TUGAS (SIRATU) </h6>
                                        <h6>BKSDA KALIMANTAN SELATAN</h6>
                                    </div>
                                    <form action="<?= base_url('Auth/login_authentication') ?>" class="mt-4" method="post">
                                        <!-- Form -->
                                        <div class="form-group mb-4">
                                            <label for="username">Username</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <span class="fa fa-user"></span>
                                                </span>
                                                <input type="username" class="form-control" placeholder="Masukkan Username" id="username" name="username" autofocus required>

                                            </div>
                                        </div>
                                        <!-- End of Form -->
                                        <div class="form-group">
                                            <!-- Form -->
                                            <div class="form-group mb-4">
                                                <label for="password">Password</label>
                                                <div class="input-group">
                                                    <span class="input-group-text" id="basic-addon2">
                                                        <i class="fa fa-lock"></i>
                                                    </span>
                                                    <input type="password" placeholder="Masukkan Password" class="form-control" id="password" name="password" required>
                                                </div>
                                            </div>
                                            <!-- End of Form -->
                                        </div>
                                        <?php if ($this->session->flashdata('msg')) {
                                            echo '<p style="font-size:12pt;color:red;text-align:center">' . $this->session->flashdata('msg') . '</p>';
                                        } ?>
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-gray-800">Login</button>
                                        </div>
                                    </form>

                                    <div class="d-flex justify-content-center align-items-center mt-4">
                                        <span class="fw-normal text-center">
                                            -atau- <br>
                                            <a href="<?= base_url('Auth_tamu') ?>" class="fw-bold btn btn-outline-info"><i class="fa fa-user"></i> Login sebagai tamu</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </div>



    </div>


    <!-- Core -->
    <script src="<?= base_url() ?>/vendor/@popperjs/core/dist/umd/popper.min.js"></script>
    <script src="<?= base_url() ?>/vendor/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Vendor JS -->
    <script src="<?= base_url() ?>/vendor/onscreen/dist/on-screen.umd.min.js"></script>

    <!-- Slider -->
    <script src="<?= base_url() ?>/vendor/nouislider/distribute/nouislider.min.js"></script>

    <!-- Smooth scroll -->
    <script src="<?= base_url() ?>/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>

    <!-- Charts -->
    <script src="<?= base_url() ?>/vendor/chartist/dist/chartist.min.js"></script>
    <script src="<?= base_url() ?>/vendor/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>

    <!-- Datepicker -->
    <script src="<?= base_url() ?>/vendor/vanillajs-datepicker/dist/js/datepicker.min.js"></script>

    <!-- Sweet Alerts 2 -->
    <script src="<?= base_url() ?>/vendor/sweetalert2/dist/sweetalert2.all.min.js"></script>

    <!-- Moment JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>

    <!-- Vanilla JS Datepicker -->
    <script src="<?= base_url() ?>/vendor/vanillajs-datepicker/dist/js/datepicker.min.js"></script>

    <!-- Notyf -->
    <script src="<?= base_url() ?>/vendor/notyf/notyf.min.js"></script>

    <!-- Simplebar -->
    <script src="<?= base_url() ?>/vendor/simplebar/dist/simplebar.min.js"></script>

    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <!-- Volt JS -->
    <script src="<?= base_url() ?>/assets/js/volt.js"></script>


</body>

</html>