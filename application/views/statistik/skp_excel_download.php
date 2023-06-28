<?php
// Skrip berikut ini adalah skrip yang bertugas untuk meng-export data ke excell
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=SKP_" . $pegawai->jabatan . ".xls");
?>

<h4>SASARAN KINERJA PEGAWAI</h4>
<table border="0" style="width:50%">
    <tr>
        <td>Nama</td>
        <td>: <?= isset($pegawai->nama) ? $pegawai->nama : '' ?></td>
    </tr>
    <tr>
        <td>NIP</td>
        <td>: <?= isset($pegawai->nip) ? $pegawai->nip : '' ?></td>
    </tr>
    <tr>
        <td>Pangkat/Gol Ruang</td>
        <td>: <?= isset($pegawai->pangkat) || isset($pegawai->golongan) ? $pegawai->pangkat . " / " . $pegawai->golongan : '' ?></td>
    </tr>
    <tr>
        <td>Jabatan</td>
        <td>: <?= isset($pegawai->jabatan) ? $pegawai->jabatan : '' ?></td>
    </tr>
    <tr>
        <td>Unit Kerja</td>
        <td>: Balai BKSDA Kalimantan Selatan</td>
    </tr>
</table>

<table border="1">
    <thead>
        <tr>
            <th style="text-align:center">No</th>
            <th style="text-align:center">Tanggal</th>
            <th style="text-align:center">PK</th>
            <th style="text-align:center">Sasaran Kegiatan</th>
            <th style="text-align:center">Indikator Kegiatan</th>
            <th style="text-align:center">Rincian Output</th>
            <th style="text-align:center">Nama Kegiatan</th>
        </tr>
    </thead>
    <tbody>
        <?php if (isset($detail)) {
            $no = 1;
            foreach ($detail as $data) { ?>
                <tr>
                    <td style="text-align:center"><?= $no++ ?></td>
                    <td style="text-align:center"><?= $data->dari_tanggal == $data->sampai_tanggal ? tgl_indo($data->dari_tanggal) : tgl_indo($data->dari_tanggal) . " - " . tgl_indo($data->sampai_tanggal) ?></td>
                    <td style="text-align:center"><?= $data->nama_kegiatan ?></td>
                    <td style="text-align:center"><?= $data->nama_sasaran ?></td>
                    <td style="text-align:center"><?= $data->nama_indikator ?></td>
                    <td style="text-align:center"><?= $data->nama_ro ?></td>
                    <td style="text-align:center"><?= $data->nama_kegiatan_surat ?></td>
                </tr>
        <?php  }
        } ?>
    </tbody>
</table>