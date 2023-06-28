<?php
// Skrip berikut ini adalah skrip yang bertugas untuk meng-export data ke excell
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=statistik_" . bln_indo($bulan) . "/" . $tahun . ".xls");
?>

<div class="row">
    <div class="col-md-12">
        <h5 class="text-center">KALENDER SURAT TUGAS TAHUN ANGGARAN <?= $tahun ?></h5>
        <b style="margin-left:100px">Satker : BKSDA Kalimantan Selatan</b><br>
        <b style="margin-left:100px">Bulan : &nbsp;<?= bln_indo($bulan) . " " . $tahun ?></b>
        <table border="1" id="" style="width: 100%;">
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
                    <th rowspan="2" style="vertical-align:middle;text-align:center">No</th>
                    <th rowspan="2" style="vertical-align:middle;text-align:center">Nama</th>
                    <th colspan="<?= $jmlHari ?>" style="text-align:center">Tgl/Bulan/Tahun</th>
                    <th rowspan="2" style="vertical-align:middle;text-align:center">Total SPT Bulan Ini</th>
                    <th rowspan="2" style="vertical-align:middle;text-align:center">Total SPT s/d Bulan Lalu</th>
                    <th rowspan="2" style="vertical-align:middle;text-align:center">Total SPT Kumulatif</th>
                    <th rowspan="2" style="vertical-align:middle;text-align:center">Keterangan</th>
                </tr>
                <tr>
                    <?php for ($i = 0; $i < $jmlHari; $i++) {
                        echo "<td>" . $list[$i] . "</td>";
                    } ?>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($pegawai)) {
                    //$blnSebelumnya = date('m') - 1;
                    $blnSebelumnya = $bulan - 1;
                    $index = 0;
                    $no = 1;
                    foreach ($pegawai as $data) {
                        $totSPT = 0;
                        //Get tanggal tugas tiap pegawai
                        $totSPT_bulan_ini = $this->db->query('SELECT tp.id_surat,id_pegawai,tanggal FROM tgl_pelaksanaan tp JOIN pegawai_tugas pt ON pt.id_surat=tp.id_surat WHERE id_pegawai=' . $data->id_pegawai . ' AND MONTH(tanggal)=' . $bulan . ' AND YEAR(tanggal)=' . $tahun . '')->result();
                        //Get total SPT sampai bulan sebelum yg dipilih
                        $totSPT_sampai_bulan_sebelumnya = $this->db->query('SELECT COUNT(tp.id) AS SPT_sampai_bulan_sebelumnya FROM tgl_pelaksanaan tp JOIN pegawai_tugas pt ON pt.id_surat=tp.id_surat WHERE id_pegawai=' . $data->id_pegawai . ' AND MONTH(tanggal)>=01 AND MONTH(tanggal)<=' . $blnSebelumnya . ' AND YEAR(tanggal)=' . $tahun . '')->row();
                        //Get total SPT sampai bulan yg dipilih
                        $totSPT_kumulatif = $this->db->query('SELECT COUNT(tp.id) AS SPT_kumulatif FROM tgl_pelaksanaan tp JOIN pegawai_tugas pt ON pt.id_surat=tp.id_surat WHERE id_pegawai=' . $data->id_pegawai . ' AND MONTH(tanggal)>=01 AND MONTH(tanggal)<=' . $bulan . ' AND YEAR(tanggal)=' . $tahun . '')->row(); ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data->nama ?> <br> NIP. <?= $data->nip ?> </td>
                            <?php for ($i = 0; $i < $jmlHari; $i++) {
                                echo "<td ";
                                foreach ($totSPT_bulan_ini as $tp) {
                                    $timestamp = strtotime($tp->tanggal);
                                    if ($list[$i] == date('d', $timestamp)) {
                                        // echo "<img src='" . base_url('assets/img/yellow.jpeg') . "' style='height:100px !important;width:20px !important'";
                                        echo "style='vertical-align:middle;text-align:center;background-color:yellow'";
                                        $totSPT++;
                                    }
                                }
                                echo "></td>";
                            } ?>
                            <td><?= $totSPT ?></td>
                            <td><?= $totSPT_sampai_bulan_sebelumnya->SPT_sampai_bulan_sebelumnya ?></td>
                            <td><?= $totSPT_kumulatif->SPT_kumulatif ?></td>
                            <td>
                                <?= $keterangan[$index] ?>
                            </td>
                        </tr>
                <?php $index++;
                    }
                } ?>
            </tbody>
        </table>
    </div>
</div>

<?php
// FUNGSI
function tanggal_indo($tanggal, $cetak_hari = false)
{
    $hari = array(
        1 =>    'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu',
        'Minggu'
    );

    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $split       = explode('-', $tanggal);
    $tgl_indo = $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];

    if ($cetak_hari) {
        $num = date('N', strtotime($tanggal));
        return $hari[$num] . ', ' . $tgl_indo;
    }
    return $tgl_indo;
}
?>