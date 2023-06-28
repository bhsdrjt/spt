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


                            <?= form_open('Statistik') ?>
                            <div class="row mt-3">
                                <div class="col-2" style="margin-left: 10px;">
                                    <select class="form-select" name="bulan" id="bulan" required>
                                        <option value="01" <?= $bulan == '01' ? 'selected' : '' ?>>Januari</option>
                                        <option value="02" <?= $bulan == '02' ? 'selected' : '' ?>>Februari</option>
                                        <option value="03" <?= $bulan == '03' ? 'selected' : '' ?>>Maret</option>
                                        <option value="04" <?= $bulan == '04' ? 'selected' : '' ?>>April</option>
                                        <option value="05" <?= $bulan == '05' ? 'selected' : '' ?>>Mei</option>
                                        <option value="06" <?= $bulan == '06' ? 'selected' : '' ?>>Juni</option>
                                        <option value="07" <?= $bulan == '07' ? 'selected' : '' ?>>Juli</option>
                                        <option value="08" <?= $bulan == '08' ? 'selected' : '' ?>>Agustus</option>
                                        <option value="09" <?= $bulan == '09' ? 'selected' : '' ?>>September</option>
                                        <option value="10" <?= $bulan == '10' ? 'selected' : '' ?>>Oktober</option>
                                        <option value="11" <?= $bulan == '11' ? 'selected' : '' ?>>November</option>
                                        <option value="12" <?= $bulan == '12' ? 'selected' : '' ?>>Desember</option>
                                    </select>
                                </div>

                                <div class="col-2">
                                    <select class="form-select" name="tahun" id="tahun" required>
                                        <?php if (isset($tahunTersedia)) {
                                            foreach ($tahunTersedia as $row) {
                                                echo "<option value='$row->tahun'";
                                                echo isset($tahun) && $row->tahun == $tahun ? 'selected' : '';
                                                echo ">$row->tahun</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-2">
                                    <select class="form-select" name="penempatan">
                                        <option value="">Semua</option>
                                        <option value="Balai" <?= isset($penempatanSelected) && $penempatanSelected == 'Balai' ? 'selected' : '' ?>>Balai</option>
                                        <option value="SKW 1" <?= isset($penempatanSelected) && $penempatanSelected == 'SKW 1' ? 'selected' : '' ?>>SKW 1</option>
                                        <option value="SKW 2" <?= isset($penempatanSelected) && $penempatanSelected == 'SKW 2' ? 'selected' : '' ?>>SKW 2</option>
                                        <option value="SKW 3" <?= isset($penempatanSelected) && $penempatanSelected == 'SKW 3' ? 'selected' : '' ?>>SKW 3</option>
                                        <option value="Non BKSDA" <?= isset($penempatanSelected) && $penempatanSelected == 'Non BKSDA' ? 'selected' : '' ?>>Non BKSDA</option>
                                    </select>
                                </div>
                                <div class="col-5">
                                    <button type="submit" name="opsi" value="cari" class="btn btn-info"><i class="fa fa-search"></i>Cari</button>
                                    <button type="submit" name="opsi" value="print" class="btn btn-warning"><i class="fa fa-print"></i>Print</button>
                                    <button type="submit" name="opsi" value="exportExcel" class="btn btn-success"><i class="fa fa-file-excel-o"></i>Excel</button>
                                </div>

                            </div>

                            <div class="table-responsive py-4 mt-3 text-center">
                                <h5>REKAPITULASI SURAT TUGAS TAHUN ANGGARAN <?= $tahun ?></h5>
                                <b>Satker : BKSDA Kalimantan Selatan</b><br>
                                <b>Bulan : <?= bln_indo($bulan) . " " . $tahun ?></b>

                                <style>
                                    .card .table td,
                                    .card .table th {
                                        padding-left: 0.3rem;
                                        padding-right: 0.3rem;
                                        padding-top: 0.2rem;
                                        padding-bottom: 0.2rem;
                                    }
                                </style>
                                <table class="table table-bordered mt-2" id="tabelStatistik_tugas" style="width: 100%;">
                                    <thead class="bg-success">
                                        <?php
                                        $start_date = "01-" . $bulan . "-" . $tahun;
                                        $start_time = strtotime($start_date);

                                        $end_time = strtotime("+1 month", $start_time);

                                        for ($i = $start_time; $i < $end_time; $i += 86400) {
                                            $list[] = date('d', $i);
                                        }
                                        $jmlHari = COUNT($list) ?>
                                        <tr>
                                            <th rowspan="2" style="vertical-align:middle">No</th>
                                            <th rowspan="2" style="vertical-align:middle">Nama</th>
                                            <th colspan="<?= $jmlHari ?>">Tgl/Bulan/Tahun</th>
                                            <th rowspan="2">Total SPT Bulan Ini</th>
                                            <th rowspan="2">Total SPT s/d Bulan Lalu</th>
                                            <th rowspan="2">Total SPT Kumulatif</th>
                                            <th rowspan="2" style="vertical-align:middle">Keterangan</th>
                                        </tr>
                                        <tr>
                                            <?php for ($i = 0; $i < $jmlHari; $i++) {
                                                echo "<th>" . $list[$i] . "</th>";
                                            } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($pegawai)) {
                                            //$blnSebelumnya = date('m') - 1;
                                            $blnSebelumnya = $bulan - 1;
                                            $no = 1;
                                            foreach ($pegawai as $data) {
                                                $totSPT = 0;
                                                //Get tanggal tugas tiap pegawai
                                                $totSPT_bulan_ini = $this->db->query('SELECT tp.id_surat,id_pegawai,tanggal FROM tgl_pelaksanaan tp JOIN pegawai_tugas pt ON pt.id_surat=tp.id_surat WHERE id_pegawai=' . $data->id_pegawai . ' AND MONTH(tanggal)=' . $bulan . ' AND YEAR(tanggal)=' . $tahun . '')->result();
                                                //Get total SPT sampai bulan sebelum yg dipilih
                                                $totSPT_sampai_bulan_sebelumnya = $this->db->query('SELECT COUNT(tp.id) AS SPT_sampai_bulan_sebelumnya FROM tgl_pelaksanaan tp JOIN pegawai_tugas pt ON pt.id_surat=tp.id_surat WHERE id_pegawai=' . $data->id_pegawai . ' AND MONTH(tanggal)>=01 AND MONTH(tanggal)<=' . $blnSebelumnya . ' AND YEAR(tanggal)=' . $tahun . '')->row();
                                                //Get total SPT sampai bulan yg dipilih
                                                $totSPT_kumulatif = $this->db->query('SELECT COUNT(tp.id) AS SPT_kumulatif FROM tgl_pelaksanaan tp JOIN pegawai_tugas pt ON pt.id_surat=tp.id_surat WHERE id_pegawai=' . $data->id_pegawai . ' AND MONTH(tanggal)>=01 AND MONTH(tanggal)<=' . $bulan . ' AND YEAR(tanggal)=' . $tahun . '')->row(); ?>
                                                <tr style="vertical-align:middle">
                                                    <td style="vertical-align:middle"><?= $no++ ?></td>
                                                    <td><?= "<a href='" . base_url('Statistik/detail_statistikPegawai/' . $data->id_pegawai) . "' class='text-info'>" . $data->nama . "</a>"; ?> <br> NIP. <?= $data->nip ?></td>
                                                    <?php for ($i = 0; $i < $jmlHari; $i++) {
                                                        echo "<td ";
                                                        foreach ($totSPT_bulan_ini as $tp) {
                                                            $timestamp = strtotime($tp->tanggal);
                                                            if ($list[$i] == date('d', $timestamp)) {
                                                                echo "style='background-color:#FFD36E'";
                                                                // echo "style='background-color:" . randColor() . "'";
                                                                echo "onclick='tampilKegiatan(" . $tp->id_surat . "," . strtotime($tp->tanggal) . ")'";
                                                                $totSPT++;
                                                            }
                                                        }
                                                        echo "><span id='#targetPesan'></span></td>";
                                                    } ?>
                                                    <td><?= $totSPT ?></td>
                                                    <td><?= $totSPT_sampai_bulan_sebelumnya->SPT_sampai_bulan_sebelumnya ?></td>
                                                    <td><?= $totSPT_kumulatif->SPT_kumulatif ?></td>
                                                    <td>
                                                        <textarea class="form-control" name="keterangan[]" style="width: 200px;height:30px"></textarea>
                                                    </td>
                                                </tr>
                                        <?php }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?= form_close() ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Modal cetak SPT -->
        <div class="modal fade" id="modal-cetakSPT" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
            <div class="modal-dialog modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="h6 modal-title">Keterangan Statistik</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <strong id="namaKegiatan" class="mb-4"></strong>
                        <br>
                        <hr style="width: 100%;">
                        <?= form_open('Surat_tugas/cetak_surat', 'target="_blank"') ?>
                        <input class="form-control id_surat" type="hidden" name="id_surat">
                        <label>
                            Cetak SPT disertai tanda tangan ?
                        </label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="Ya_denganCap" name="denganTTD" id="Ya_denganCap">
                            <label class="form-check-label" for="Ya_denganCap">
                                Ya + Cap
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="Ya_tanpaCap" name="denganTTD" id="Ya_tanpaCap">
                            <label class="form-check-label" for="Ya_tanpaCap">
                                Ya tanpa Cap
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="Tidak" name="denganTTD" id="Tidak" checked>
                            <label class="form-check-label" for="Tidak">
                                Tidak
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-tertiary">Cetak</button>
                        <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">Close</button>
                    </div>
                    <?= form_close() ?>

                </div>
            </div>
        </div>
        <!-- Modal cetak SPT end -->

        <?php $this->load->view('statistik/footer'); ?>

        <?php function randColor()
        {
            $rand = str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);
            return ('#' . $rand);
        } ?>

        <script type="text/javascript">
            // function tampilKegiatan(id, tanggal) {
            window.tampilKegiatan = function(id, tanggal) {
                $.ajax({
                    url: "<?= base_url('Statistik/data_surat') ?>",
                    method: "POST",
                    data: {
                        id: id,
                        tanggal: tanggal,
                    },
                    success: function(data) {
                        console.log(data);
                        // $('#target_pesan' + id).html(data);
                        // alert(data);
                        $('#namaKegiatan').html(data);

                        $('.id_surat').val(id);
                        $('#modal-cetakSPT').modal('show');
                    }
                })
            }
        </script>
</body>

</html>