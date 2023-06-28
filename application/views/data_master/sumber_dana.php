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
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-addDana"><i class="fa-solid fa-plus"></i> Sumber Dana</button>
                  </div>
                </div>
              </div>

              <div class="table-responsive py-4">
                <table class="text-center row-border" id="tabelSumberDana" style="width: 100%;">
                  <thead class="bg-gray-300">
                    <tr>
                      <th>No</th>
                      <th>Sumber dana</th>
                      <th>Kategori</th>
                      <th>Opsi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (isset($dana)) {
                      $no = 1;
                      foreach ($dana as $data) { ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td style="text-align: left;"><?= $data->sumber ?></td>
                          <td><?= $data->kategori ?></td>
                          <td>
                            <a href="#" class="btn btn-sm btn-warning editDana" data-id="<?= $data->id ?>" data-sumber="<?= $data->sumber ?>" data-kategori="<?= $data->kategori ?>"><i class="fa fa-edit"></i></a>
                            <a href="#" class="btn btn-sm btn-danger deleteDana" data-id="<?= $data->id ?>" data-sumber="<?= $data->sumber ?>"><i class="fa fa-trash"></i></a>
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

    <!-- Modal add sumber dana -->
    <div class="modal fade" id="modal-addDana" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Tambah sumber dana baru</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open('Data_master/proses_addDana') ?>
          <div class="modal-body">
            <div class="mb-3">
              <label for="sumber" class="form-label">Sumber dana</label>
              <textarea class="form-control" name="sumber" id="sumber" rows="5" placeholder="Isikan sumber dana" required></textarea>
            </div>
            <div class="mb-3">
              <label for="kategori" class="form-label">Kategori</label>
              <select class="form-select" name="kategori" id="kategori" required>
                <option value="DIPA" selected>DIPA</option>
                <option value="Non DIPA">Non DIPA</option>
              </select>
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
    <!-- Modal add sumber dana end -->

    <!-- Modal edit sumber dana -->
    <div class="modal fade" id="modal-editDana" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Edit sumber dana</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open('Data_master/proses_editDana') ?>
          <input type="hidden" class="form-control id_dana" id="id_dana" name="id_dana">
          <div class="modal-body">
            <div class="mb-3">
              <label for="sumber" class="form-label">Sumber dana</label>
              <textarea class="form-control sumber" name="sumber" id="sumber" rows="5" placeholder="Isikan sumber dana" required></textarea>
            </div>
            <div class="mb-3">
              <label for="kategori" class="form-label">Kategori</label>
              <select class="form-select kategori" name="kategori" id="kategori" required>
                <option value="DIPA">DIPA</option>
                <option value="Non DIPA">Non DIPA</option>
              </select>
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
    <!-- Modal edit sumber dana end -->

    <!-- Modal delete sumber dana -->
    <div class="modal fade" id="modal-deleteDana" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Hapus sumber dana</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open('Data_master/proses_deleteDana') ?>
          <div class="modal-body">
            <input type="hidden" class="form-control ID_dana" id="id_dana" name="id_dana">
            <span>Ingin menghapus sumber dana <b class="sumber"></b> ?</span>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Hapus</button>
            <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">Close</button>
          </div>
          <?= form_close() ?>

        </div>
      </div>
    </div>
    <!-- Modal delete sumber dana end -->


    <?php $this->load->view('data_master/footer'); ?>

    <script>
      $(document).ready(function() {
        $('#tabelSumberDana').DataTable({
          'scrollX': true,
        });

        //Modal edit sumber dana
        $("body").on("click", ".editDana", function(event) {
          const id = $(this).data('id');
          const sumber = $(this).data('sumber');
          const kategori = $(this).data('kategori');

          $('.id_dana').val(id);
          $('.sumber').val(sumber);
          $('.kategori').val(kategori).trigger('change');
          // Call Modal
          $('#modal-editDana').modal('show');
        });

        //Modal delete sumber dana
        $("body").on("click", ".deleteDana", function(event) {
          const id = $(this).data('id');
          const sumber = $(this).data('sumber');

          $('.ID_dana').val(id);
          $('.sumber').html(sumber);
          // Call Modal
          $('#modal-deleteDana').modal('show');
        });
      });
    </script>

</body>

</html>