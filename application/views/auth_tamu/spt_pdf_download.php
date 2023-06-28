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
        <h3>SPT <?= isset($pegawai) ? $pegawai->nama : '' ?></h3>
    </div>
    <table id="table" style="text-align: center;">
        <thead>
            <tr>
                <th style="text-align: center;">No</th>
                <th style="text-align: center;">Tanggal</th>
                <th style="text-align: center;">Nama Kegiatan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($detail)) {
                $no = 1;
                foreach ($detail as $data) { ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $data->dari_tanggal == $data->sampai_tanggal ? tgl_indo($data->dari_tanggal) : tgl_indo($data->dari_tanggal) . " - " . tgl_indo($data->sampai_tanggal) ?></td>
                        <td><?= $data->nama_kegiatan_surat ?></td>
                    </tr>
            <?php }
            } ?>
        </tbody>
    </table>
</body>

</html>