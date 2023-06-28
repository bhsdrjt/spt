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
                                    <div class="col-9">
                                        <h2 class="fs-5 fw-bold mb-0"><?= isset($title) ? $title : 'Data' ?> (Edit)</h2>
                                        <?php if ($this->session->flashdata('msg')) {
                                            echo $this->session->flashdata('msg');
                                        } ?>
                                    </div>
                                    <div class="col-3">
                                        <a href="<?= base_url('Surat_tugas') ?>" class="btn btn-sm btn-gray-100" style="float:right"><i class="fa fa-times"></i></a>
                                        <div class="btn-group me-2" style="float:right;">
                                            <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-print"></i> Cetak
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" target="_blank" href="<?= base_url('Surat_tugas/cetak_surat/' . $surat->id_surat . '/Ya_denganCap') ?>">Dengan TTD + Cap</a>
                                                <a class="dropdown-item" target="_blank" href="<?= base_url('Surat_tugas/cetak_surat/' . $surat->id_surat . '/Ya_tanpaCap') ?>">Dengan TTD tanpa Cap </a>
                                                <a class="dropdown-item" target="_blank" href="<?= base_url('Surat_tugas/cetak_surat/' . $surat->id_surat . '/Tidak') ?>">Tanpa TTD</a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <?= form_open('Surat_tugas/proses_editSPT', 'name="form_SPT" onsubmit="return validateForm()"', ['id_surat' => $surat->id_surat]) ?>
                                <div class="row">
                                    <div class="col-6 mb-3 text-center" style="margin-left: auto;margin-right:auto">
                                        <label for="no_surat" class="form-label">1. Nomor</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1">
                                                ST.
                                            </span>
                                            <input type="text" class="form-control" name="no_surat" id="no_surat" placeholder="Nomor" value="<?= isset($surat->no_surat) ? $surat->no_surat : '' ?>">
                                            <span class="input-group-text" id="basic-addon1">
                                                /K.16/TU/Peg/
                                            </span>
                                            <select class="form-select" name="bulan" id="bulan" style="width: 2px;">
                                                <option value="1" selected>1</option>
                                                <?php for ($i = 2; $i < 13; $i++) {
                                                    echo "<option value='$i'";
                                                    echo isset($surat->bulan) && $i == $surat->bulan ? 'selected' : '';
                                                    echo ">$i</option>";
                                                } ?>
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
                                                    echo isset($surat->tahun) && $i == $surat->tahun ? 'selected' : '';
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
                                            <?php foreach ($dasarDIPA as $dd) {
                                                echo "<option value='$dd->id'";
                                                echo isset($surat->dasarDIPA) && $dd->id == $surat->dasarDIPA ? 'selected' : '';
                                                echo ">$dd->dasar</option>";
                                            } ?>
                                        </select>

                                        <br><span class="badge bg-info mb-1">Kerja sama</span>
                                        <select class="form-select" name="dasarKS" id="dasarKS">
                                            <option value="">-Pilih-</option>
                                            <?php foreach ($dasarKS as $dk) {
                                                echo "<option value='$dk->id'";
                                                echo isset($surat->dasarKS) && $dk->id == $surat->dasarKS ? 'selected' : '';
                                                echo ">$dk->dasar</option>";
                                            } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label for="waktu" class="form-label">3. Waktu pelaksanaan</label>
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="startDate" style="font-size:small">Dari Tanggal</label>
                                                <input type="date" class="form-control" name="startDate" id="startDate" value="<?= isset($surat->dari_tanggal) ? $surat->dari_tanggal : '' ?>">
                                            </div>
                                            <div class="col-6">
                                                <label for="endDate" style="font-size:small">Sampai Tanggal</label>
                                                <input type="date" class="form-control" name="endDate" id="endDate" value="<?= isset($surat->sampai_tanggal) ? $surat->sampai_tanggal : '' ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-7 mb-3">
                                        <label for="petugas" class="form-label">4. Petugas</label>

                                        <table class="table table-bordered listPetugas" style="width: 100%;">
                                            <?php if (isset($pegawaiTugas)) {
                                                $nomor = 1;
                                                $index = 0;
                                                foreach ($pegawaiTugas as $pt) { ?>
                                                    <tr>
                                                        <td style="vertical-align:middle;width:5%"><?= $nomor ?></td>
                                                        <td style="width:90%;">
                                                            <select class="form-select" name="petugas[]" id="petugas<?= $index ?>" onchange="cekPetugas(<?= $index ?>)" required>
                                                                <option disabled selected>-Pilih-</option>
                                                                <?php foreach ($pegawai as $row) {
                                                                    echo "<option value='$row->id_pegawai'";
                                                                    echo  $row->id_pegawai == $pt->id_pegawai ? 'selected' : '';
                                                                    echo ">$row->nama</option>";
                                                                } ?>
                                                            </select>
                                                            <div id="alert_petugas<?= $index ?>"></div>
                                                        </td>
                                                        <td style="width: 5%;">
                                                            <?php if ($index != 0) { ?>
                                                                <button type="button" class="btn btn-sm rounded-circle btn-outline-danger" id="delPetugas"><i class="fa fa-trash"></i></button>
                                                            <?php } ?>
                                                            <button type="button" class="btn btn-sm rounded-circle btn-outline-info" id="addPetugas"><i class="fa fa-plus"></i></button>
                                                        </td>
                                                    </tr>
                                            <?php $nomor++;
                                                    $index++;
                                                }
                                            } ?>
                                        </table>
                                    </div>

                                    <div class="col-5 mb-3">
                                        <label for="kategoriSPT" class="form-label">Kategori SPT</label>
                                        <select class="form-select" name="kategori_spt">
                                            <option value="">-Pilih-</option>
                                            <?php foreach ($kategoriSPT as $row) {
                                                echo "<option value='$row->id_kategori_spt'";
                                                echo  $row->id_kategori_spt == $surat->kategori_spt ? 'selected' : '';
                                                echo ">$row->nama_kategori</option>";
                                            } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="nama_kegiatan_surat" class="form-label">5. Nama Kegiatan</label>
                                        <input type="text" class="form-control" name="nama_kegiatan_surat" id="nama_kegiatan_surat" placeholder="Nama Kegiatan" value="<?= isset($surat->nama_kegiatan_surat) ? $surat->nama_kegiatan_surat : '' ?>" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <h6>6. Pilih Kegiatan</h6>
                                    <div class="col-12 mb-3">
                                        <select class="form-select" name="kegiatan" id="kegiatan" required>
                                            <option value="" disabled>-Pilih-</option>
                                            <?php foreach ($kegiatan as $row) {
                                                echo "<option value='$row->id_kegiatan'";
                                                echo  $row->id_kegiatan == $surat->kegiatan ? 'selected' : '';
                                                echo ">$row->nama_kegiatan</option>";
                                            } ?>
                                        </select>
                                    </div>
                                </div>

                                <div id="rincianKegiatan">
                                    <div class="row">
                                        <?php $output = "";
                                        $urutan = 0;
                                        //Sasaran kegiatan
                                        $dataSasaran = $this->db->get_where('sasaran', ['id_kegiatan' => $surat->kegiatan])->result();
                                        $output .= '<div class="col-4">
                                                <div class="alert alert-info" role="alert"><b>Sasaran Kegiatan</b></div>';
                                        foreach ($dataSasaran as $sas) {
                                            if (isset($surat->sasaran) && $surat->sasaran == $sas->id_sasaran) {
                                                $checked = 'checked';
                                            } else {
                                                $checked = '';
                                            }

                                            $output .= '<div class="form-check">
                                                <input class="form-check-input" type="radio" value="' . $sas->id_sasaran . '" name="sasaranEdit" id="sasaranEdit' . $urutan . '" ' . $checked . '>
                                                <label class="form-check-label" for="sasaran' . $urutan . '">
                                                    ' . $sas->nama_sasaran . '
                                                </label>
                                            </div>';
                                            $urutan++;
                                        }
                                        $output .= '</div>';

                                        //Indikator kegiatan
                                        $dataIndikator = $this->db->get_where('indikator', ['id_sasaran' => $surat->sasaran])->result();
                                        $urutan2 = 0;
                                        $output .= '<div class="col-4">
                                                    <div class="alert alert-secondary" role="alert"><b>Indikator Kegiatan</b></div>';
                                        foreach ($dataIndikator as $ind) {
                                            if ($surat->indikator == $ind->id_indikator) {
                                                $checked = 'checked';
                                            } else {
                                                $checked = '';
                                            }

                                            $output .= '<div class="form-check">
                                                <input class="form-check-input" type="radio" value="' . $ind->id_indikator . '" name="indikatorEdit" id="indikatorEdit' . $urutan2 . '" ' . $checked . '>
                                                <label class="form-check-label" for="indikator' . $urutan2 . '">
                                                    ' . $ind->nama_indikator . '
                                                </label>
                                            </div>';
                                            $urutan2++;
                                        }
                                        $output .= '</div>';

                                        //RO kegiatan
                                        $dataRO = $this->db->get_where('ro', ['id_indikator' => $surat->indikator])->result();
                                        $urutan = 0;
                                        $output .= '<div class="col-4">
                                                    <div class="alert alert-warning" role="alert"><b>Rincian Output</b></div>';
                                        foreach ($dataRO as $r) {
                                            if ($surat->rincian_output == $r->id_ro) {
                                                $checked = 'checked';
                                            } else {
                                                $checked = '';
                                            }

                                            $output .= '<div class="form-check">
                                                <input class="form-check-input" type="radio" value="' . $r->id_ro . '" name="rincian_outputEdit" id="rincian_outputEdit' . $urutan . '" ' . $checked . '>
                                                <label class="form-check-label" for="rincian_output' . $urutan . '">
                                                    ' . $r->nama_ro . '
                                                </label>
                                            </div>';
                                            $urutan++;
                                        }
                                        $output .= '</div>';
                                        echo $output;
                                        ?>
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
                                            <option value="" disabled>-Pilih-</option>
                                            <?php foreach ($sumberDana as $sd) {
                                                echo "<option value='$sd->id'";
                                                echo isset($surat->sumber_dana) && $sd->id == $surat->sumber_dana ? 'selected' : '';
                                                echo ">$sd->sumber</option>";
                                            } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6 mb-3"></div>
                                    <div class="col-6 mb-3">
                                        <label for="tgl_spt" class="form-label">8. Tanggal SPT</label>
                                        <input type="date" class="form-control" name="tgl_spt" id="tgl_spt" value="<?= isset($surat->tgl_spt) ? $surat->tgl_spt : '' ?>">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6 mb-3" style="padding-left: 200px;">
                                        <label for="jabatan_mengetahui" class="form-label">Jabatan Mengetahui 1</label><br>
                                        <select class="form-select" name="jabatan_mengetahui" id="jabatan_mengetahui" style="width: 300px;" required>
                                            <?php foreach ($jabatanMengetahui as $row) {
                                                echo "<option value='$row->nama_jabatan'";
                                                echo $row->nama_jabatan == $surat->jabatan_mengetahui ? 'selected' : '';
                                                echo ">$row->nama_jabatan</option>";
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="mengetahui" class="form-label">9. Yang mengetahui 1</label>
                                        <select class="form-select" name="mengetahui" id="mengetahui" required>
                                            <?php foreach ($mengetahui as $row) {
                                                echo "<option value='$row->id_pegawai'";
                                                echo $row->id_pegawai == $surat->mengetahui ? 'selected' : '';
                                                echo ">$row->nama</option>";
                                            } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6 mb-3" style="padding-left: 200px;">
                                        <label for="jabatan_mengetahui2" class="form-label">Jabatan Mengetahui 2</label><br>
                                        <select class="form-select" name="jabatan_mengetahui2" id="jabatan_mengetahui2" style="width: 300px;">
                                            <option value="NULL" <?= $surat->jabatan_mengetahui2 == null ? 'selected' : '' ?>>-Pilih-</option>
                                            <?php foreach ($jabatanMengetahui as $row) {
                                                echo "<option value='$row->nama_jabatan'";
                                                echo $row->nama_jabatan == $surat->jabatan_mengetahui2 ? 'selected' : '';
                                                echo ">$row->nama_jabatan</option>";
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="mengetahui2" class="form-label">10. Yang mengetahui 2</label>
                                        <select class="form-select" name="mengetahui2" id="mengetahui2">
                                            <option value="NULL" <?= $surat->mengetahui2 == null ? 'selected' : '' ?>>-Pilih-</option>
                                            <?php foreach ($mengetahui as $row) {
                                                echo "<option value='$row->id_pegawai'";
                                                echo $row->id_pegawai == $surat->mengetahui2 ? 'selected' : '';
                                                echo ">$row->nama</option>";
                                            } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="text-center mt-3">
                                    <button type="submit" class="btn btn-warning">Update</button>
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