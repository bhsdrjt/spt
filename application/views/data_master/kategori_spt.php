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
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-addKategori"><i class="fa-solid fa-plus"></i> Kategori SPT</button>
                  </div>
                </div>
              </div>

              <div class="table-responsive py-4">
                <table class="text-center row-border" id="tabelKategoriSPT" style="width: 100%;">
                  <thead class="bg-gray-300">
                    <tr>
                      <th>No</th>
                      <th>Nama Kategori</th>
                      <th>Opsi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (isset($kategori)) {
                      $no = 1;
                      foreach ($kategori as $data) { ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $data->nama_kategori ?></td>
                          <td>
                            <a href="#" class="btn btn-sm btn-warning editKategoriSPT" data-id="<?= $data->id_kategori_spt ?>" data-kategori="<?= $data->nama_kategori ?>"><i class="fa fa-edit"></i></a>
                            <a href="#" class="btn btn-sm btn-danger deleteKategoriSPT" data-id="<?= $data->id_kategori_spt ?>" data-kategori="<?= $data->nama_kategori ?>"><i class="fa fa-trash"></i></a>
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

    <!-- Modal add kategori SPT -->
    <div class="modal fade" id="modal-addKategori" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Tambah kategori SPT baru</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open('Data_master/proses_addKategoriSPT') ?>
          <div class="modal-body">
            <div class="mb-3">
              <label for="kategori" class="form-label">Nama Kategori</label>
              <input type="text" name="nama_kategori" class="form-control" placeholder="Nama Kategori">
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
    <!-- Modal add kategori SPT end -->

    <!-- Modal edit kategori spt -->
    <div class="modal fade" id="modal-editKategoriSPT" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Edit kategori SPT</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open('Data_master/proses_editKategoriSPT') ?>
          <input type="hidden" class="form-control" id="edit_id" name="id_kategori_spt">
          <div class="modal-body">
            <div class="mb-3">
              <label for="kategori" class="form-label">Nama Kategori</label>
              <input type="text" name="nama_kategori" id="edit_namaKategori" class="form-control" placeholder="Nama Kategori">
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
    <!-- Modal edit kategori spt end -->

    <!-- Modal delete kategori spt -->
    <div class="modal fade" id="modal-deleteKategoriSPT" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Hapus Kategori SPT</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open('Data_master/proses_deleteKategoriSPT') ?>
          <div class="modal-body">
            <input type="hidden" class="form-control" id="hapus_id" name="id_kategori_spt">
            <span>Ingin menghapus kategori <b id="hapus_namaKategori"></b> ?</span>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Hapus</button>
            <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">Close</button>
          </div>
          <?= form_close() ?>

        </div>
      </div>
    </div>
    <!-- Modal delete kategori spt end -->


    <?php $this->load->view('data_master/footer'); ?>

    <script>
      $(document).ready(function() {
        $('#tabelKategoriSPT').DataTable({
          'scrollX': true,
        });

        //Modal edit sumber dana
        $("body").on("click", ".editKategoriSPT", function(event) {
          const id = $(this).data('id');
          const kategori = $(this).data('kategori');

          $('#edit_id').val(id);
          $('#edit_namaKategori').val(kategori);
          // Call Modal
          $('#modal-editKategoriSPT').modal('show');
        });

        //Modal delete sumber dana
        $("body").on("click", ".deleteKategoriSPT", function(event) {
          const id = $(this).data('id');
          const kategori = $(this).data('kategori');

          $('#hapus_id').val(id);
          $('#hapus_namaKategori').html(kategori);
          // Call Modal
          $('#modal-deleteKategoriSPT').modal('show');
        });
      });
    </script>

</body>

</html>