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
                </div>
              </div>


              <?= form_open('Data_master/perjanjian_kinerja') ?>
              <div class="row mt-3">
                <div class="col-8" style="padding-left: 35px;">
                  <a class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-addKegiatan"><i class="fa-solid fa-plus"></i> Kegiatan</a>
                </div>

                <div class="col-2">
                  <select name="tahun" id="tahun" class="form-select">
                    <?php if (isset($tahunTersedia)) {
                      foreach ($tahunTersedia as $thn) {
                        echo "<option value='$thn->tahun'";
                        echo $tahunActive == $thn->tahun ? 'selected' : '';
                        echo ">$thn->tahun</option>";
                      }
                    } ?>
                  </select>
                </div>

                <div class="col-2">
                  <button type="submit" class="btn btn btn-outline-info" name="cari">Cari</button>
                </div>
              </div>
              <?= form_close() ?>


              <div class="table-responsive py-4">
                <table class="text-center row-border" id="tabelPK" style="width: 100%;">
                  <thead class="bg-gray-300">
                    <tr>
                      <th>No</th>
                      <th>Nama Kegiatan</th>
                      <th>Opsi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (isset($pk)) {
                      $no = 1;
                      foreach ($pk as $data) { ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><b><?= $data->nama_kegiatan ?></b></td>
                          <td>
                            <a href="<?= base_url('Data_master/detail_kegiatan/' . $data->id_kegiatan) ?>" class="btn btn-sm btn-outline-info">Detail</a>
                            <a href="#" class="btn btn-sm btn-secondary editKegiatan" data-id_kegiatan="<?= $data->id_kegiatan ?>" data-tahun_kegiatan="<?= $data->tahun ?>" data-nama_kegiatan="<?= $data->nama_kegiatan ?>"><i class="fa fa-edit"></i></a>
                            <a href="#" class="btn btn-sm btn-danger deleteKegiatan" data-id_kegiatan="<?= $data->id_kegiatan ?>" data-nama_kegiatan="<?= $data->nama_kegiatan ?>"><i class="fa fa-trash"></i></a>
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

    <!-- Modal add kegiatan -->
    <div class="modal fade" id="modal-addKegiatan" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Tambah kegiatan baru</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <?= form_open('Data_master/proses_addKegiatan') ?>
          <div class="modal-body">
            <div class="mb-3">
              <label for="tahunKegiatan" class="form-label">Tahun</label>
              <select class="form-select" name="tahunKegiatan" id="tahunKegiatan" required>
                <?php
                $thn_awal = date('Y') - 10;
                $thn_akhir = date('Y') + 10;
                for ($i = $thn_akhir; $i >= $thn_awal; $i--) {
                  echo "<option value='$i'";
                  if (date('Y') == $i) {
                    echo "selected";
                  }
                  echo ">$i</option>";
                }
                ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="kegiatan" class="form-label">Nama Kegiatan</label>
              <textarea class="form-control" name="kegiatan" id="kegiatan" placeholder="Masukkan nama kegiatan" rows="5" required></textarea>
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
    <!-- Modal add kegiatan end -->

    <!-- Modal edit kegiatan -->
    <div class="modal fade" id="modal-editKegiatan" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Edit kegiatan</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <?= form_open('Data_master/proses_editKegiatan') ?>
          <input type="hidden" class="id_kegiatan" name="id_kegiatan">
          <div class="modal-body">
            <div class="mb-3">
              <label for="tahunKegiatan" class="form-label">Tahun</label>
              <select class="form-select tahunKegiatan" name="tahunKegiatan" id="tahunKegiatan" required>
                <?php
                $thn_awal = date('Y') - 10;
                $thn_akhir = date('Y') + 10;
                for ($i = $thn_akhir; $i >= $thn_awal; $i--) {
                  echo "<option value='$i'";
                  if (date('Y') == $i) {
                    echo "selected";
                  }
                  echo ">$i</option>";
                }
                ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="kegiatan" class="form-label">Nama Kegiatan</label>
              <textarea class="form-control kegiatan" name="kegiatan" id="kegiatan" placeholder="Masukkan nama kegiatan" rows="5" required></textarea>
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
    <!-- Modal edit kegiatan end -->

    <!-- Modal delete kegiatan -->
    <div class="modal fade" id="modal-deleteKegiatan" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Hapus Kegiatan</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <?= form_open('Data_master/proses_deleteKegiatan') ?>
          <input type="hidden" class="id_kegiatan" name="id_kegiatan">
          <div class="modal-body">
            <div class="mb-3">
              <h5>Kegiatan</h5>
              <h6 class="nama_kegiatan"></h6>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Hapus</button>
            <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">Close</button>
          </div>
          <?= form_close() ?>
        </div>
      </div>
    </div>
    <!-- Modal delete kegiatan end -->


    <?php $this->load->view('data_master/footer'); ?>

    <script>
      $(document).ready(function() {
        $('#tabelPK').DataTable({
          'scrollX': true,
        });

        //Modal edit kegiatan
        $("body").on("click", ".editKegiatan", function(event) {
          const id = $(this).data('id_kegiatan');
          const tahun = $(this).data('tahun_kegiatan');
          const nama = $(this).data('nama_kegiatan');

          $('.id_kegiatan').val(id);
          $('.tahunKegiatan').val(tahun);
          $('.kegiatan').val(nama);
          // Call Modal
          $('#modal-editKegiatan').modal('show');
        });

        //Modal delete kegiatan
        $("body").on("click", ".deleteKegiatan", function(event) {
          const id = $(this).data('id_kegiatan');
          var nama = $(this).data('nama_kegiatan');

          $('.id_kegiatan').val(id);
          $('.nama_kegiatan').html(nama);
          // Call Modal
          $('#modal-deleteKegiatan').modal('show');
        });
      });
    </script>


</body>

</html>