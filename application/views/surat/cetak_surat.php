<html>

<head>
    <title>Print</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

    <style type="text/css">
        /* @page { size: with x height */
        /*page { size: 20cm 10cm; margin: 0px; }*/
        @page {
            size: A4;
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

<body>
    <div class="row">
        <div class="col-md-12">
            <table style="width: 100%;text-align:center" border="0">
                <tr>
                    <td style="width: 15%;text-align:center" rowspan="4"><img src="<?= base_url('assets/img/favicon/logo_black.png') ?>" height="85px"></td>
                    <td>
                        <b style="font-size:12pt;">KEMENTERIAN LINGKUNGAN HIDUP DAN KEHUTANAN</b>
                    </td>
                    <td style="width: 3%;" rowspan="4"></td>
                </tr>
                <tr>
                    <td>
                        <b style="font-size:12pt;">DIREKTORAT JENDERAL KONSERVASI SUMBER DAYA ALAM DAN EKOSISTEM</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b style="font-size:12pt;">BALAI KONSERVASI SUMBER DAYA ALAM KALIMANTAN SELATAN</b>
                    </td>
                </tr>
                <!-- <tr>
                    <td style="font-size:12pt;">JL. Sungai Ulin Kota k Pos. 1048 Telp. (0511) 4772408 Fax (0511) 4773722 <br> BANJARBARU - 70714</td>
                </tr> -->
                <tr>
                    <td style="font-size:12pt;"><br></td>
                </tr>
            </table>
            <hr style="width: 95%;border: solid 1px #000 !important;margin-top:0px">

            <table style="width: 85%;margin-left:auto;margin-right:auto;text-align:center;font-size:11pt" border="0">
                <tr>
                    <td><b>SURAT TUGAS</b></td>
                </tr>
                <tr>
                    <td>Nomor : ST.<?= !empty($surat->no_surat) ? $surat->no_surat : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ?>/K.16/TU/Peg/<?= $surat->bulan ?>/<?= $surat->tahun ?></td>
                </tr>
                <tr>
                    <td><br><b>KEPALA BALAI</b></td>
                </tr>
            </table>

            <table style="width: 95%;margin-left:auto;margin-right:auto;margin-top:30px;text-align:justify;font-size:11pt" border="0">
                <tr>
                    <?php $menimbang = $this->db->get('menimbang')->row() ?>
                    <td style="vertical-align:top">Menimbang</td>
                    <td style="padding-left: 45px; vertical-align:top;width:80px">: a.</td>
                    <td colspan="2"><?= $menimbang->poin_a ?></td>
                    <!-- <td colspan="2">bahwa berdasarkan pasal 3 Bab I Peraturan Menteri Lingkungan Hidup dan Kehutanan Republik Indonesia No. P. 8/MenLHK/Setjen/OTL.0/1/2016 telah ditetapkan Unit Pelaksana Teknis Konservasi Sumber Daya Alam;</td> -->
                </tr>
                <tr>
                    <td></td>
                    <td style="padding-left: 45px;vertical-align:top">&nbsp; b.</td>
                    <td colspan="2"><?= $menimbang->poin_b ?></td>
                    <!-- <td colspan="2">bahwa untuk mendukung pelaksanaan teknis Konservasi Sumber Daya Alam perlu diterbitkan Surat Tugas oleh Kepala Balai Konservasi Sumber Daya Alam Kalimantan Selatan;</td> -->
                </tr>

                <tr>
                    <?php $dasar = $this->db->get('dasar_surat_poin13')->row() ?>
                    <td style="padding-top: 10px;vertical-align:top">Dasar</td>
                    <td style="padding-left: 45px;padding-top: 10px;vertical-align:top">: 1.</td>
                    <td colspan="2" style="padding-top: 10px;"><?= $dasar->poin_1 ?></td>
                    <!-- <td colspan="2" style="padding-top: 10px;">Undang-undang Nomor 5 Tahun 1990 tentang KSDAE;</td> -->
                </tr>
                <tr>
                    <td></td>
                    <td style="padding-left: 45px;vertical-align:top">&nbsp; 2.</td>
                    <td colspan="2"><?= $dasar->poin_2 ?></td>
                    <!-- <td colspan="2">PERPRES Nomor 16 Tahun 2015 tanggal 23 Januari 2015 tentang KemenLHK;</td> -->
                </tr>
                <tr>
                    <td></td>
                    <td style="padding-left: 45px;vertical-align:top">&nbsp; 3.</td>
                    <td colspan="2"><?= $dasar->poin_3 ?></td>
                    <!-- <td colspan="2">PermenLHK No.P.18/MenLHK-II/2015 Tentang Organisasi dan Tata Kerja KemenLHK;</td> -->
                </tr>
                <?php if (!empty($surat->dasarDIPA) && empty($surat->dasarKS)) { ?>
                    <tr>
                        <td></td>
                        <td style="padding-left: 45px;vertical-align:top">&nbsp; 4.</td>
                        <td colspan="2"><?= $surat->dasar_suratDIPA ?></td>
                    </tr>
                <?php } elseif (empty($surat->dasarDIPA) && !empty($surat->dasarKS)) { ?>
                    <tr>
                        <td></td>
                        <td style="padding-left: 45px;vertical-align:top">&nbsp; 4.</td>
                        <td colspan="2"><?= $surat->dasar_suratKS ?></td>
                    </tr>
                <?php } else { ?>
                    <tr>
                        <td></td>
                        <td style="padding-left: 45px;vertical-align:top">&nbsp; 4.</td>
                        <td colspan="2"><?= $surat->dasar_suratDIPA ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding-left: 45px;vertical-align:top">&nbsp; 5.</td>
                        <td colspan="2"><?= $surat->dasar_suratKS ?></td>
                    </tr>
                <?php } ?>

                <tr style="text-align: center;">
                    <td colspan="4" style="padding-top: 20px;padding-bottom: 10px;"><b>MEMBERI TUGAS</b></td>
                </tr>

                <?php if (isset($pegawaiTugas)) {
                    if (COUNT($pegawaiTugas) < 6) {
                        
                        $index = 0;
                        $no = 1;
                        foreach ($pegawaiTugas as $pt) { 
                            $namaLabel = ($pt->tipe_pegawai == 'PPPK') ? 'NI PPPK' : 'NIP';?>
                        
                            <tr>
                                <td style="vertical-align:top"><?= $index == 0 ? 'Kepada' : '' ?></td>
                                <td style="padding-left: 45px;"><?= $no == 1 ? ':' : '&nbsp;' ?> <?= $no++ . '.' ?></td>
                                <td style="width: 15%;">Nama/<?= $namaLabel; ?></td>
                                <td>: <?= $pt->nama . " /". $namaLabel. ". ". ($pt->nip != ''? $pt->nip : '-'); ?></td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td>Jabatan</td>
                                <td>: <?= $pt->jabatan ?></td>
                            </tr>
                <?php $index++;
                        }
                    } else {
                        echo "<tr>
                                <td style='vertical-align:top'>Kepada</td>
                                <td style='padding-left: 45px;' colspan='2'>: Daftar terlampir</td>
                                <td></td>
                            </tr>";
                    }
                } ?>

                <tr>
                    <?php $untuk = $this->db->get('untuk')->row() ?>
                    <td style="padding-top: 10px;vertical-align:top">Untuk</td>
                    <td style="padding-left: 45px;padding-top: 10px;vertical-align:top">: 1. </td>
                    <td colspan="2" style="padding-top: 10px;">Melaksanakan perjalanan dinas dalam rangka <?= str_replace('div', 'span', $surat->nama_kegiatan_surat) ?>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding-left: 45px;vertical-align:top">&nbsp; 2. </td>
                    <td colspan=" 2">Waktu pelaksanaan selama <?php $tgl1 = new DateTime($surat->dari_tanggal);
                                                                $tgl2 = new DateTime($surat->sampai_tanggal);
                                                                $jarak = $tgl2->diff($tgl1);
                                                                echo $jarak->d + 1 ?>
                        (<?= terbilang($jarak->d + 1) ?>) hari tanggal <?= $surat->dari_tanggal == $surat->sampai_tanggal ? tanggal_indo($surat->dari_tanggal) : tanggal_indo($surat->dari_tanggal) . " - " . tanggal_indo($surat->sampai_tanggal) ?>.</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding-left: 45px;vertical-align:top">&nbsp; 3. </td>
                    <td colspan=" 2"><?= $untuk->poin_3 ?></td>
                    <!-- <td colspan=" 2">Selambat-lambatnya 5 (lima) hari setelah selesai melaksanakan kegiatan, berkewajiban membuat laporan kepada Kepala BKSDA Kalimantan Selatan.</td> -->
                </tr>
                <tr>
                    <td></td>
                    <td style="padding-left: 45px;vertical-align:top">&nbsp; 4. </td>
                    <td colspan=" 2"><?= $surat->sumber ?></td>
                </tr>
            </table>

            <table style="width: 85%;margin-left:auto;margin-right:auto;margin-top:20px;text-align:left;font-size:11pt" border="0">
                <tr>
                    <td style="width: 46%;"></td>
                    <td style="padding-top: 35px;">
                        <?php if (isset($denganTTD) && $denganTTD == 'Ya_denganCap') { ?>
                            <img src="<?= base_url('assets/img/favicon/cap.png') ?>" height="150px" style="position:absolute;padding-left:15px;">
                        <?php } ?>
                        <div style="padding-left: 110px;">Banjarbaru, <?= isset($surat->tgl_spt) && $surat->tgl_spt != '0000-00-00' ? tanggal_indo($surat->tgl_spt) : '<span style="padding-left:90px">' . date('Y') . '</span>' ?> <br> <?= $surat->jabatan_mengetahui ?></div>
                    </td>
                </tr>
                <?php if (isset($denganTTD) && $denganTTD == 'Tidak') { ?>
                    <tr>
                        <td></td>
                        <td style="vertical-align: middle;">
                            <img src="<?= base_url('assets/uploads/tanda_tangan/transparantImage.png') ?>" height="90px" style="padding-left: 100px;position:absolute">
                        </td>
                    </tr>
                <?php } else { ?>
                    <tr>
                        <td></td>
                        <td style="vertical-align: middle;">
                            <img src="<?= base_url('assets/uploads/tanda_tangan/' . $surat->image_ttd) ?>" height="90px" style="padding-left: 100px;position:absolute">
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td></td>
                    <td style="padding-left: 110px;padding-top:70px"><?= $surat->nama ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding-left: 110px;"><?= 'NIP. ' . $surat->nip ?></td>
                </tr>
            </table>

        </div>
    </div>

    <?php if (COUNT($pegawaiTugas) > 5) { ?>
        <p style="page-break-after: always;">&nbsp;</p>
        <p style="page-break-before: always;">&nbsp;</p>

        <div class="row">
            <div class="col-md-12">
                <table style="width: 95%;margin-left:auto;margin-right:auto;font-size:11pt" border="0">
                    <tr>
                        <td colspan="2">Lampiran Surat Perintah Tugas Kepala BKSDA Kalsel</td>
                    </tr>
                    <tr>
                        <td style="width: 5%;">Nomor</td>
                        <td style="width: 95%;">: ST.<?= !empty($surat->no_surat) ? $surat->no_surat : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ?>/K.16/TU/Peg/<?= $surat->bulan ?>/<?= $surat->tahun ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>: <?= isset($surat->tgl_spt) && $surat->tgl_spt != '0000-00-00' ? tanggal_indo($surat->tgl_spt) : '<span style="padding-left:100px">' . date('Y') . '</span>' ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">Daftar Nama Tim Pelaksana kegiatan melaksanakan perjalanan dinas dalam rangka <?= lcfirst(str_replace('div', 'span', $surat->nama_kegiatan_surat)) ?></td>
                    </tr>
                </table>

                <table style="width: 95%;margin-left:auto;margin-right:auto;margin-top:40px;text-align:left;font-size:11pt" border="0">

                    <?php if (isset($pegawaiTugas)) {
                        $no = 1;
                        foreach ($pegawaiTugas as $pt) {
                            $namaLabel = ($pt->tipe_pegawai == 'PPPK') ? 'NI PPPK' : 'NIP';
                    ?>
                            <tr>
                                <td style="width: 5%;"><?= $no++ . '.' ?></td>
                                <td style="width: 18%; padding-left: 20px;">Nama/<?= $namaLabel; ?></td>
                                <td style="width:5%;padding-left: 10px;">:</td>
                                <td style="width: 70%; padding-left: 10px;">
                                    <?= $pt->nama . " / " . $namaLabel . ". " . ($pt->nip != ''? $pt->nip : '-'); ?>
                                </td>

                            </tr>
                            <tr>
                                <td></td>
                                <td style="padding-left: 20px;">Jabatan</td>
                                <td style="padding-left: 10px;">:</td>
                                <td style="padding-left: 10px;"><?= $pt->jabatan ?></td>
                            </tr>
                    <?php
                        }
                    } ?>
                </table>

                <table style="width: 85%;margin-left:auto;margin-right:auto;margin-top:20px;text-align:left;font-size:11pt" border="0">
                    <tr>
                        <td style="width: 46%;"></td>
                        <td style="padding-top: 35px;">
                            <?php if (isset($denganTTD) && $denganTTD == 'Ya_denganCap') { ?>
                                <img src="<?= base_url('assets/img/favicon/cap.png') ?>" height="150px" style="position:absolute;padding-left:15px;">
                            <?php } ?>
                            <div style="padding-left: 110px;">Mengetahui, <br>
                                <?php
                                //Get pegawai yg mengetahui 2
                                $mengetahui2 = $this->db->query('SELECT nama,nip,jabatan,image_ttd FROM pegawai JOIN surat ON surat.mengetahui2=pegawai.id_pegawai WHERE surat.id_surat="' . $surat->id_surat . '"')->row();
                                // if (isset($mengetahui2)) {
                                //     echo $mengetahui2->jabatan;
                                // }

                                echo $surat->jabatan_mengetahui2
                                ?></div>
                        </td>
                    </tr>
                    <?php if (isset($denganTTD) && $denganTTD == 'Tidak') { ?>
                        <tr>
                            <td></td>
                            <td style="vertical-align: middle;">
                                <img src="<?= base_url('assets/uploads/tanda_tangan/transparantImage.png') ?>" height="90px" style="padding-left: 100px;position:absolute">
                            </td>
                        </tr>
                    <?php } else { ?>
                        <tr>
                            <td></td>
                            <td style="vertical-align: middle;">
                                <?php if (isset($mengetahui2->image_ttd)) { ?>
                                    <img src="<?= base_url('assets/uploads/tanda_tangan/' . $mengetahui2->image_ttd) ?>" height="90px" style="padding-left: 100px;position:absolute">
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td></td>
                        <td style="padding-left: 110px;padding-top:70px"><?= isset($mengetahui2->nama) ? $mengetahui2->nama : '' ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding-left: 110px;"><?= isset($mengetahui2->nip) ? 'NIP. ' . $mengetahui2->nip : '' ?></td>
                    </tr>
                </table>
            </div>
        </div>

    <?php } ?>

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