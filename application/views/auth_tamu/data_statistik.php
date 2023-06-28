<!--

=========================================================
* Volt Free - Bootstrap 5 Dashboard
=========================================================

* Product Page: https://themesberg.com/product/admin-dashboard/volt-bootstrap-5-dashboard
* Copyright 2021 Themesberg (https://www.themesberg.com)
* License (https://themesberg.com/licensing)

* Designed and coded by https://themesberg.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. Please contact us to request a removal.

-->
<!DOCTYPE html>
<html lang="en">

<?php $this->load->view('header'); ?>

<body>

    <?php $this->load->view('auth_tamu/sidebar'); ?>

    <!-- Main content -->
    <main class="content">

        <?php $this->load->view('auth_tamu/navbar'); ?>

        <div class="row mt-5">
            <div class="col-12 col-xl-12">
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="card border-0 shadow">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h2 class="fs-5 fw-bold mb-0">Statisik Pegawai</h2>
                                        <?php if ($this->session->flashdata('msg')) {
                                            echo $this->session->flashdata('msg');
                                        } ?>
                                    </div>
                                </div>
                            </div>

                            <?= form_open('Auth_tamu/form_download') ?>
                            <div class="row mt-3 mb-3">
                                <div class="col-md-3" style="margin-left: auto; margin-right: auto;">
                                    <select class="form-select" name="bulan" id="bulan" required>
                                        <option value="" disabled selected>- Pilih Bulan -</option>
                                        <option value="1">Januari</option>
                                        <option value="2">Februari</option>
                                        <option value="3">Maret</option>
                                        <option value="4">April</option>
                                        <option value="5">Mei</option>
                                        <option value="6">Juni</option>
                                        <option value="7">Juli</option>
                                        <option value="8">Agustus</option>
                                        <option value="9">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                </div>

                                <div class="col-md-2" style="margin-left: auto; margin-right: auto;">
                                    <select class="form-select" name="tahun" id="tahun" required>
                                        <option value="" disabled selected>- Pilih Tahun -</option>
                                        <?php
                                        $startYear = 2022; // Mendapatkan tahun awal (10 tahun yang lalu)
                                        $endYear = date('Y'); // Mendapatkan tahun sekarang
                                        for ($year = $startYear; $year <= $endYear; $year++) {
                                            echo "<option value='$year'>$year</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4" style="margin-left: auto; margin-right: auto;">
                                    <select class="form-select" name="pegawai" id="pegawai" required>
                                        <option value="" disabled selected>- Pilih Pegawai -</option>
                                        <?php foreach ($pegawai as $data) {
                                            echo "<option value='$data->id_pegawai'";
                                            echo isset($pegawaiSelected) && $data->id_pegawai == $pegawaiSelected ? 'selected' : '';
                                            echo ">$data->nama</option>";
                                        } ?>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <button type="submit" name="opsi" value="download_spt" class="btn btn-warning"><i class="fa fa-file-pdf-o"></i> Download SPT</button>
                                    <button type="submit" name="opsi" value="download_skp" class="btn btn-success" download=""><i class="fa fa-file-excel-o"></i> Download SKP</button>
                                </div>
                            </div>
                            <?= form_close() ?>

                            <div id="preview_skp" class="mt-3 mb-3"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php $this->load->view('auth_tamu/footer'); ?>

</body>

</html>