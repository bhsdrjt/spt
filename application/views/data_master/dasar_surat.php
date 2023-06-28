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

            <div class="nav-wrapper position-relative">
              <ul class="nav nav-pills rounded nav-fill flex-column flex-md-row">
                <li class="nav-item">
                  <a class="nav-link mb-sm-3 mb-md-0" href="<?= base_url('Data_master/dasar_surat_poin13') ?>">Poin 1-3</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link mb-sm-3 mb-md-0 bg-info" style="color:white" href="<?= base_url('Data_master/dasar_surat') ?>">Poin 4</a>
                </li>
              </ul>
            </div>

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
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-addDasarSurat"><i class="fa-solid fa-plus"></i> Dasar Surat</button>
                  </div>
                </div>
              </div>

              <div class="table-responsive py-4">
                <table class="text-center row-border" id="tabelDasarSurat" style="width: 100%;">
                  <thead class="bg-gray-300">
                    <tr>
                      <th>No</th>
                      <th>Dasar</th>
                      <th>Kategori</th>
                      <th>Tahun</th>
                      <th>Opsi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (isset($dasarSurat)) {
                      $no = 1;
                      foreach ($dasarSurat as $data) { ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td style="text-align: left;"><?= $data->dasar ?></td>
                          <td><?= $data->kategori ?></td>
                          <td><?= $data->tahun ?></td>
                          <td>
                            <a href="#" class="btn btn-sm btn-warning editDasarSurat" data-id="<?= $data->id ?>" data-dasar="<?= $data->dasar ?>" data-kategori="<?= $data->kategori ?>" data-tahun="<?= $data->tahun ?>"><i class="fa fa-edit"></i></a>
                            <a href="#" class="btn btn-sm btn-danger deleteDasarSurat" data-id="<?= $data->id ?>" data-dasar="<?= $data->dasar ?>"><i class="fa fa-trash"></i></a>
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

    <!-- Modal add dasar surat -->
    <div class="modal fade" id="modal-addDasarSurat" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Tambah dasar surat baru</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open('Data_master/proses_addDasarSurat') ?>
          <div class="modal-body">
            <div class="mb-3">
              <label for="dasar" class="form-label">Dasar</label>
              <textarea class="form-control" name="dasar" id="dasar" rows="5" placeholder="Isikan dasar surat" required></textarea>
            </div>
            <div class="mb-3">
              <label for="kategori" class="form-label">Kategori</label>
              <select class="form-select" name="kategori" id="kategori" required>
                <option value="DIPA" selected>DIPA</option>
                <option value="Kerja sama">Kerja sama</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="tahun" class="form-label">Tahun</label>
              <input type="number" class="form-control" name="tahun" value="<?= date('Y') ?>" required />
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
    <!-- Modal add dasar surat end -->

    <!-- Modal edit dasar surat -->
    <div class="modal fade" id="modal-editDasarSurat" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Edit dasar surat</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open('Data_master/proses_editDasarSurat') ?>
          <input type="hidden" class="form-control id_dasar" id="id_dasar" name="id_dasar">
          <div class="modal-body">
            <div class="mb-3">
              <label for="dasar" class="form-label">Dasar</label>
              <textarea class="form-control dasar" name="dasar" id="dasar" rows="5" placeholder="Isikan dasar surat" required></textarea>
            </div>
            <div class="mb-3">
              <label for="kategori" class="form-label">Kategori</label>
              <select class="form-select kategori" name="kategori" id="kategori" required>
                <option value="DIPA">DIPA</option>
                <option value="Kerja sama">Kerja sama</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="tahun" class="form-label">Tahun</label>
              <input type="number" class="form-control tahun" name="tahun" value="<?= date('Y') ?>" required />
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
    <!-- Modal edit dasar surat end -->

    <!-- Modal delete dasar surat -->
    <div class="modal fade" id="modal-deleteDasarSurat" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Hapus dasar surat</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open('Data_master/proses_deleteDasarSurat') ?>
          <div class="modal-body">
            <input type="hidden" class="form-control ID_dasar" id="id_dasar" name="id_dasar">
            <span>Ingin menghapus dasar <b class="dasar"></b> ?</span>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Hapus</button>
            <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">Close</button>
          </div>
          <?= form_close() ?>

        </div>
      </div>
    </div>
    <!-- Modal delete dasar surat end -->


    <?php $this->load->view('data_master/footer'); ?>

    <script>
      $(document).ready(function() {
        $('#tabelDasarSurat').DataTable({
          'scrollX': true,
        });

        //Modal edit dasar surat
        $("body").on("click", ".editDasarSurat", function(event) {
          const id = $(this).data('id');
          const dasar = $(this).data('dasar');
          const kategori = $(this).data('kategori');
          const tahun = $(this).data('tahun');

          $('.id_dasar').val(id);
          $('.dasar').val(dasar);
          $('.kategori').val(kategori).trigger('change');
          $('.tahun').val(tahun);
          // Call Modal
          $('#modal-editDasarSurat').modal('show');
        });

        //Modal delete RO
        $("body").on("click", ".deleteDasarSurat", function(event) {
          const id = $(this).data('id');
          const dasar = $(this).data('dasar');

          $('.ID_dasar').val(id);
          $('.dasar').html(dasar);
          // Call Modal
          $('#modal-deleteDasarSurat').modal('show');
        });
      });
    </script>

</body>

</html>