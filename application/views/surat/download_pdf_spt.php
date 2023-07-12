<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title_pdf; ?></title>
    <style>
        #table {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #table td,
        #table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #table th {
            padding-top: 10px;
            padding-bottom: 10px;
            text-align: left;
            /* background-color: #4CAF50;
            color: white; */
        }
    </style>
</head>

<body style="font-size: 12pt;">
    <div style="text-align:center;font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
        <h3><?= isset($title_pdf) ? $title_pdf : '' ?></h3>
    </div>
    <table id="table" style="text-align: center;">
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
                        <td><?= $no++ ?></td>
                        <td><?= "ST." . $data->no_surat . " /K.16/TU/Peg/" . $data->bulan . "/" . $data->tahun ?></td>
                        <td><?= $data->dari_tanggal == $data->sampai_tanggal ? tgl_indo($data->dari_tanggal) : tgl_indo($data->dari_tanggal) . " - " . tgl_indo($data->sampai_tanggal) ?></td>
                        <td><?= $data->nama_kegiatan_surat ?></td>
                        <td><?= $data->nama_kegiatan ?></td>
                        <td><?= $data->status_pelaksanaan ?></td>
                        <td style="width: 27%;"><?= $data->sumber ?></td>
                        <td style="width: 27%;">
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
</body>

</html>