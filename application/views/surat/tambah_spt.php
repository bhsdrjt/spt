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

    <?php $this->load->view('sidebar'); ?>

    <!-- Main content -->
    <main class="content">

        <?php $this->load->view('navbar'); ?>

        <div class="row mt-5">
            <div class="col-12 col-xl-12">
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="card border-0 shadow">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h2 class="fs-5 fw-bold mb-0"><?= isset($title) ? $title : 'Data' ?></h2>
                                        <?php if ($this->session->flashdata('msg')) {
                                            echo $this->session->flashdata('msg');
                                        } ?>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <?= form_open('Surat_tugas/proses_addSPT', 'name="form_SPT" onsubmit="return validateForm()"') ?>
                                <div class="row">
                                    <div class="col-6 mb-3 text-center" style="margin-left: auto;margin-right:auto">
                                        <label for="no_surat" class="form-label">1. Nomor</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1">
                                                ST.
                                            </span>
                                            <input type="text" class="form-control" name="no_surat" id="no_surat" placeholder="Nomor">
                                            <span class="input-group-text" id="basic-addon1">
                                                /K.16/TU/Peg/
                                            </span>
                                            <select class="form-select" name="bulan" id="bulan" style="width: 2px;">
                                                <option value="1" selected>1</option>
                                                <?php for ($i = 2; $i < 13; $i++) { ?>
                                                    <option value="<?= $i ?>"><?= $i ?></option>
                                                <?php } ?>
                                            </select>
                                            <span class="input-group-text" id="basic-addon1">
                                                /
                                            </span>
                                            <select class="form-select" name="tahun" id="tahun">
                                                <?php
                                                $thn_awal = date('Y') - 10;
                                                $thn_akhir = date('Y') + 10;
                                                for ($i = $thn_akhir; $i >= $thn_awal; $i--) {
                                                    echo "<option value='$i'";
                                                    if (date('Y') == $i) {
                                                        echo "selected";
                                                    }
                                                    echo ">$i</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="dasarDIPA" class="form-label">2. Dasar surat poin 4</label>
                                        <br><span class="badge bg-success mb-1">DIPA</span>
                                        <select class="form-select" name="dasarDIPA" id="dasarDIPA">
                                            <option value="">-Pilih-</option>
                                            <?php foreach ($dasarDIPA as $dd) { ?>
                                                <option value="<?= $dd->id ?>"><?= $dd->dasar ?></option>
                                            <?php } ?>
                                        </select>

                                        <br><span class="badge bg-info mb-1">Kerja sama</span>
                                        <select class="form-select" name="dasarKS" id="dasarKS">
                                            <option value="">-Pilih-</option>
                                            <?php foreach ($dasarKS as $dk) { ?>
                                                <option value="<?= $dk->id ?>"><?= $dk->dasar ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label for="waktu" class="form-label">3. Waktu pelaksanaan</label>
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="startDate" style="font-size:small">Dari Tanggal</label>
                                                <input type="date" class="form-control" name="startDate" id="startDate">
                                            </div>
                                            <div class="col-6">
                                                <label for="endDate" style="font-size:small">Sampai Tanggal</label>
                                                <input type="date" class="form-control" name="endDate" id="endDate">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-7 mb-3">
                                        <label for="petugas" class="form-label">4. Petugas</label>

                                        <table class="table table-bordered listPetugas" style="width: 100%;">
                                            <tr>
                                                <td style="vertical-align:middle;width:5%">1</td>
                                                <td style="width:90%;">
                                                    <select class="form-select" name="petugas[]" id="petugas0" onchange="cekPetugas(0)" required>
                                                        <option disabled selected>-Pilih-</option>
                                                        <?php foreach ($pegawai as $row) {
                                                            echo "<option value='" . $row->id_pegawai . "'>" . $row->nama . "</option>";
                                                        } ?>
                                                    </select>
                                                    <div id="alert_petugas0"></div>
                                                </td>
                                                <td style="width: 5%;">
                                                    <a class="deleteRow"></a>
                                                    <button type="button" class="btn btn-sm rounded-circle btn-outline-info" id="addPetugas"><i class="fa fa-plus"></i></button>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-5 mb-3">
                                        <label for="kategoriSPT" class="form-label">Kategori SPT</label>
                                        <select class="form-select" name="kategori_spt">
                                            <option value="">-Pilih-</option>
                                            <?php foreach ($kategoriSPT as $row) { ?>
                                                <option value="<?= $row->id_kategori_spt ?>"><?= $row->nama_kategori ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="nama_kegiatan_surat" class="form-label">5. Nama Kegiatan</label>
                                        <input type="text" class="form-control" name="nama_kegiatan_surat" id="nama_kegiatan_surat" placeholder="Nama Kegiatan">
                                    </div>
                                </div>

                                <div class="row">
                                    <h6>6. Pilih Kegiatan</h6>
                                    <div class="col-12 mb-3">
                                        <select class="form-select" name="kegiatan" id="kegiatan" required>
                                            <option value="" disabled selected>-Pilih-</option>
                                            <?php foreach ($kegiatan as $row) { ?>
                                                <option value="<?= $row->id_kegiatan ?>"><?= $row->nama_kegiatan ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4" id="hasil"></div>
                                    <div class="col-4" id="hasil2"></div>
                                    <div class="col-4" id="hasil3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="sumber_dana" class="form-label">7. Sumber dana</label>
                                        <select class="form-select" name="sumber_dana" id="sumber_dana" required>
                                            <option value="" disabled selected>-Pilih-</option>
                                            <?php foreach ($sumberDana as $sd) { ?>
                                                <option value="<?= $sd->id ?>"><?= $sd->sumber ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6 mb-3"></div>
                                    <div class="col-6 mb-3">
                                        <label for="tgl_spt" class="form-label">8. Tanggal SPT</label>
                                        <input type="date" class="form-control" name="tgl_spt" id="tgl_spt">
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-6 mb-3" style="padding-left: 200px;">
                                        <label for="jabatan_mengetahui" class="form-label">Jabatan Mengetahui 1</label><br>
                                        <select class="form-select" name="jabatan_mengetahui" id="jabatan_mengetahui" style="width: 300px;" required>
                                            <?php foreach ($jabatanMengetahui as $row) { ?>
                                                <option value="<?= $row->nama_jabatan ?>"><?= $row->nama_jabatan ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="mengetahui" class="form-label">9. Yang mengetahui 1</label>
                                        <select class="form-select" name="mengetahui" id="mengetahui" required>
                                            <?php foreach ($mengetahui as $row) { ?>
                                                <option value="<?= $row->id_pegawai ?>"><?= $row->nama ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6 mb-3" style="padding-left: 200px;">
                                        <label for="jabatan_mengetahui2" class="form-label">Jabatan Mengetahui 2</label><br>
                                        <select class="form-select" name="jabatan_mengetahui2" id="jabatan_mengetahui2" style="width: 300px;">
                                            <option value="" disabled selected>-Pilih-</option>
                                            <?php foreach ($jabatanMengetahui as $row) { ?>
                                                <option value="<?= $row->nama_jabatan ?>"><?= $row->nama_jabatan ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="mengetahui2" class="form-label">10. Yang mengetahui 2</label>
                                        <select class="form-select" name="mengetahui2" id="mengetahui2">
                                            <option value="" disabled selected>-Pilih-</option>
                                            <?php foreach ($mengetahui as $row) { ?>
                                                <option value="<?= $row->id_pegawai ?>"><?= $row->nama ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="text-center mt-3">
                                    <button type="submit" class="btn btn-info">Simpan</button>
                                </div>

                                <?php form_close() ?>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <?php $this->load->view('surat/footer'); ?>

</body>

</html>