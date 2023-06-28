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
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-addJabatan"><i class="fa-solid fa-plus"></i> Jabatan Mengetahui</button>
                  </div>
                </div>
              </div>

              <div class="table-responsive py-4">
                <table class="text-center row-border" id="tabel_jabatanMengetahui" style="width: 100%;">
                  <thead class="bg-gray-300">
                    <tr>
                      <th>No</th>
                      <th>Nama Jabatan</th>
                      <th>Opsi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (isset($jabatan)) {
                      $no = 1;
                      foreach ($jabatan as $data) { ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $data->nama_jabatan ?></td>
                          <td>
                            <a href="#" class="btn btn-sm btn-warning edit_jabatanMengetahui" data-id="<?= $data->id ?>" data-nama="<?= $data->nama_jabatan ?>"><i class="fa fa-edit"></i></a>
                            <a href="#" class="btn btn-sm btn-danger delete_jabatanMengetahui" data-id="<?= $data->id ?>" data-nama="<?= $data->nama_jabatan ?>"><i class="fa fa-trash"></i></a>
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

    <!-- Modal add jabatan mengetahui -->
    <div class="modal fade" id="modal-addJabatan" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Tambah jabatan mengetahui baru</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open('Data_master/proses_add_jabatanMengetahui') ?>
          <div class="modal-body">
            <div class="mb-3">
              <label for="kategori" class="form-label">Nama Jabatan</label>
              <input type="text" name="nama_jabatan" class="form-control" placeholder="Nama Jabatan">
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">Close</button>
          </div>
          <?= form_close() ?>

        </div>
      </div>
    </div>
    <!-- Modal add jabatan mengetahui end -->

    <!-- Modal edit jabatan mengetahui -->
    <div class="modal fade" id="modal-edit_jabatanMengetahui" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Edit jabatan mengetahui</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open('Data_master/proses_edit_jabatanMengetahui') ?>
          <input type="hidden" class="form-control" id="edit_id" name="id">
          <div class="modal-body">
            <div class="mb-3">
              <label for="kategori" class="form-label">Nama Jabatan</label>
              <input type="text" name="nama_jabatan" id="edit_namaJabatan" class="form-control" placeholder="Nama Jabatan">
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-secondary">Update</button>
            <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">Close</button>
          </div>
          <?= form_close() ?>

        </div>
      </div>
    </div>
    <!-- Modal edit jabatan mengetahui end -->

    <!-- Modal delete jabatan mengetahui -->
    <div class="modal fade" id="modal-delete_jabatanMengetahui" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Hapus jabatan mengetahui</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open('Data_master/proses_delete_jabatanMengetahui') ?>
          <div class="modal-body">
            <input type="hidden" class="form-control" id="hapus_id" name="id">
            <span>Ingin menghapus jabatan <b id="hapus_namaJabatan"></b> ?</span>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Hapus</button>
            <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">Close</button>
          </div>
          <?= form_close() ?>

        </div>
      </div>
    </div>
    <!-- Modal delete jabatan mengetahui end -->


    <?php $this->load->view('data_master/footer'); ?>

    <script>
      $(document).ready(function() {
        $('#tabel_jabatanMengetahui').DataTable({
          'scrollX': true,
        });

        //Modal edit sumber dana
        $("body").on("click", ".edit_jabatanMengetahui", function(event) {
          const id = $(this).data('id');
          const nama = $(this).data('nama');

          $('#edit_id').val(id);
          $('#edit_namaJabatan').val(nama);
          // Call Modal
          $('#modal-edit_jabatanMengetahui').modal('show');
        });

        //Modal delete sumber dana
        $("body").on("click", ".delete_jabatanMengetahui", function(event) {
          const id = $(this).data('id');
          const nama = $(this).data('nama');

          $('#hapus_id').val(id);
          $('#hapus_namaJabatan').html(nama);
          // Call Modal
          $('#modal-delete_jabatanMengetahui').modal('show');
        });
      });
    </script>

</body>

</html>