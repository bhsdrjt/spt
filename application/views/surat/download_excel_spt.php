<?php
// Skrip berikut ini adalah skrip yang bertugas untuk meng-export data ke excell
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Kegiatan SPT " . $title . ".xls");
?>

<h4 style="text-align:center"><?= isset($title) ? $title : '' ?></h4>

<table border="1">
    <thead>
        <tr>
            <th style="text-align:center">No</th>
            <th style="text-align:center">No. Surat</th>
            <th style="text-align:center">Tanggal Pelaksanaan</th>
            <th style="text-align:center">Kegiatan SPT</th>
            <th style="text-align:center">Perjanjian Kinerja</th>
            <th style="text-align:center">Status</th>
            <th style="text-align:center">Sumber Dana</th>
            <th style="text-align:center">Pelaksana</th>
        </tr>
    </thead>
    <tbody>
        <?php if (isset($surat)) {
            $no = 1;
            foreach ($surat as $data) { ?>
                <tr>
                    <td style="vertical-align: middle;"><?= $no++ ?></td>
                    <td style="vertical-align: middle;"><?= "ST." . $data->no_surat . " /K.16/TU/Peg/" . $data->bulan . "/" . $data->tahun ?></td>
                    <td style="vertical-align: middle;"><?= $data->dari_tanggal == $data->sampai_tanggal ? tgl_indo($data->dari_tanggal) : tgl_indo($data->dari_tanggal) . " - " . tgl_indo($data->sampai_tanggal) ?></td>
                    <td style="vertical-align: middle;"><?= $data->nama_kegiatan_surat ?></td>
                    <td style="vertical-align: middle;"><?= $data->nama_kegiatan ?></td>
                    <td style="vertical-align: middle;"><?= $data->status_pelaksanaan ?></td>
                    <td style="vertical-align: middle;"><?= $data->sumber ?></td>
                    <td style="width: 27%;vertical-align: middle;">
                        <?php
                        $pegawai = $this->db->query('SELECT pt.id_pegawai,nama FROM pegawai_tugas pt JOIN pegawai ON pegawai.id_pegawai=pt.id_pegawai WHERE pt.id_surat=' . $data->id_surat)->result();
                        if (isset($pegawai)) {
                            foreach ($pegawai as $key) {
                                echo $key->nama . "<br/>";
                            }
                        }
                        ?>
                    </td>
                </tr>
        <?php }
        } ?>
    </tbody>
</table>