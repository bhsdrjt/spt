<html>

<head>
    <title>Print</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

    <style type="text/css">
        /* @page { size: with x height */
        /*page { size: 20cm 10cm; margin: 0px; }*/
        @page {
            size: A4 landscape;
            margin: 30px;
        }
    </style>
    <script type="text/javascript">
        var beforePrint = function() {};

        // var afterPrint = function() {
        //     document.location.href = '<?php echo base_url('index.php/cabang/range_biayaExpedisi') ?>';
        // };

        if (window.matchMedia) {
            var mediaQueryList = window.matchMedia('print');
            mediaQueryList.addListener(function(mql) {
                if (mql.matches) {
                    beforePrint();
                } else {
                    // afterPrint();
                }
            });
        }

        window.onbeforeprint = beforePrint;
        window.onafterprint = afterPrint;
    </script>
</head>

<style>
    /* thead {
        background-color: green !important;
        color: white !important;
        -webkit-print-color-adjust: exact !important;
    } */
</style>

<body>
    <div class="row">
        <div class="col-md-12">
            <h5 class="text-center">KALENDER SURAT TUGAS TAHUN ANGGARAN <?= $tahun ?></h5>
            <b style="margin-left:100px">Satker : BKSDA Kalimantan Selatan</b><br>
            <b style="margin-left:100px">Bulan : &nbsp;<?= bln_indo($bulan) . " " . $tahun ?></b>
            <table class="table table-bordered mt-2" id="" style="width: 100%;">
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
                                    echo "<td style='vertical-align:middle;text-align:center'>";
                                    foreach ($totSPT_bulan_ini as $tp) {
                                        $timestamp = strtotime($tp->tanggal);
                                        if ($list[$i] == date('d', $timestamp)) {
                                            echo "<img src='" . base_url('assets/img/yellow.jpeg') . "' style='height:100px !important;width:20px !important'";
                                            $totSPT++;
                                        }
                                    }
                                    echo "</td>";
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

    <script src=" <?php echo base_url() ?>assets/src/js/vendor/jquery-3.3.1.min.js"></script>
    <script type=" text/javascript">
        $(document).ready(function() {
            window.print();
        });
    </script>
</body>
<?php
// FUNGSI
function bulan_indo($tanggal)
{
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
    $bln_indo = $bulan[(int)$split[1]] . ' ' . $split[0];
    return $bln_indo;
}

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

function rupiah($angka)
{

    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    /*$hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');*/
    return $hasil_rupiah;
}

function penyebut($nilai)
{
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " " . $huruf[$nilai];
    } else if ($nilai < 20) {
        $temp = penyebut($nilai - 10) . " belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
    }
    return $temp;
}

function terbilang($nilai)
{
    if ($nilai < 0) {
        $hasil = "minus " . trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }
    return $hasil;
}
?>

</html>