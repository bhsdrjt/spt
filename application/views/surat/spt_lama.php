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
                                    <div class="col text-end">
                                        <a href="<?= base_url('Surat_tugas/add_spt') ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Surat Tugas</a>
                                    </div>
                                </div>
                            </div>

                            <?php echo $this->session->flashdata('message'); ?>
                            <div class="table-responsive py-4">
                                <table class="table table-bordered table-striped" id="tabelSurat" style="width: 100%;">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>No. Surat</th>
                                            <th>Kegiatan</th>
                                            <th>File Surat Fix</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($surat)) {
                                            $no = 1;
                                            foreach ($surat as $data) { ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= $data->no_surat ?></td>
                                                    <td><?= $data->nama_kegiatan ?></td>
                                                    <td class="text-center"><?php
                                                                            if (!empty($data->file_surat)) {
                                                                                echo '<a href="' . base_url('assets/uploads/surat_tugas/') . $data->file_surat . '" class="text-info" download>Download</a>';
                                                                            }
                                                                            ?> <br>
                                                        <a href="#" class="btn btn-sm btn-outline-tertiary uploadSurat" data-id="<?= $data->id_surat ?>" data-kegiatan="<?= $data->nama_kegiatan ?>" style="font-size:10pt"><i class="fa fa-upload"></i> Upload</a>
                                                    </td>
                                                    <td>
                                                        <a href="<?= base_url('Surat_tugas/edit_spt/' . $data->id_surat) ?>" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                                                        <a href="#" class="btn btn-sm btn-danger deleteSPT" data-id="<?= $data->id_surat ?>" data-kegiatan="<?= $data->nama_kegiatan ?>"><i class="fa fa-trash"></i></a>
                                                        <br>
                                                        <a href="<?= base_url('Surat_tugas/cetak_surat/' . $data->id_surat) ?>" class="btn btn-sm btn-tertiary mt-1" target="_blank"><i class="fa fa-print"></i></a>
                                                    </td>
                                                </tr>
                                        <?php }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Modal upload surat -->
        <div class="modal fade" id="modal-uploadSurat" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
            <div class="modal-dialog modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="h6 modal-title">Upload surat fix</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <?= form_open_multipart('Surat_tugas/proses_uploadSurat') ?>
                    <input class="form-control id_surat" type="hidden" name="id_surat">
                    <div class="modal-body">
                        <p>Kegiatan : <b class="kegiatan"></b></p>
                        <div class="mb-3">
                            <label for="file_surat" class="form-label">Surat fix <sup style="color: blue;">(file max 3 MB)</sup></label>
                            <input class="form-control" type="file" name="file_surat" id="file_surat">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">Upload</button>
                        <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">Close</button>
                    </div>
                    <?= form_close() ?>

                </div>
            </div>
        </div>
        <!-- Modal upload surat end -->

        <!-- Modal delete surat -->
        <div class="modal fade" id="modal-deleteSurat" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
            <div class="modal-dialog modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="h6 modal-title">Hapus Surat Tugas</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <?= form_open_multipart('Surat_tugas/proses_deleteSurat') ?>
                    <input class="form-control id_surat" type="hidden" name="id_surat">
                    <div class="modal-body">
                        <p> Hapus surat tugas pada kegiatan : <b class="kegiatan"></b></p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Hapus</button>
                        <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">Close</button>
                    </div>
                    <?= form_close() ?>

                </div>
            </div>
        </div>
        <!-- Modal delete surat end -->

        <?php $this->load->view('surat/footer'); ?>

</body>

</html>