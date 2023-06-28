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
                    <h2 class="fs-5 fw-bold mb-0">Detail Kegiatan : <u><?= $kegiatan->nama_kegiatan ?></u> (<?= $kegiatan->tahun ?>)</h2>
                    <?php if ($this->session->flashdata('msg')) {
                      echo $this->session->flashdata('msg');
                    } ?>
                  </div>
                </div>
              </div>

              <div class="card-body mb-8">
                <a class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-addSasaran"><i class="fa-solid fa-plus"></i> Sasaran</a>
                <div class="table-responsive py-4">

                  <style>
                    table,
                    th,
                    td {
                      border: 1px solid;
                    }
                  </style>
                  <table class="" id="">
                    <thead class="">
                      <tr class="text-center">
                        <th>Sasaran Kegiatan</th>
                        <th>Indikator</th>
                        <th>Rincian Output</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (isset($sasaran)) {
                        $no = 1;
                        foreach ($sasaran as $data) { ?>
                          <tr>
                            <!-- Sasaran Kegiatan -->
                            <td><?= $data->nama_sasaran ?>
                              <div class="btn-group me-2">
                                <a class="text-info dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: x-small;">
                                  [Option]
                                </a>
                                <div class="dropdown-menu">
                                  <a class="dropdown-item editSasaran" href="#" data-id_sasaran="<?= $data->id_sasaran ?>" data-nama_sasaran="<?= $data->nama_sasaran ?>">Edit Sasaran</a>
                                  <a class="dropdown-item deleteSasaran" href="#" data-id_sasaran="<?= $data->id_sasaran ?>" data-nama_sasaran="<?= $data->nama_sasaran ?>">Hapus Sasaran</a>
                                  <div class="dropdown-divider"></div>
                                  <a class="dropdown-item addIndikator" href="#" data-id_sasaran="<?= $data->id_sasaran ?>" data-nama_sasaran="<?= $data->nama_sasaran ?>">Tambah Indikator</a>
                                </div>
                              </div>
                            </td>

                            <!-- Indikator kegiatan -->
                            <td>
                              <?php $indikator = $this->db->query('SELECT * FROM indikator WHERE id_sasaran=' . $data->id_sasaran . ' AND id_kegiatan=' . $kegiatan->id_kegiatan . '')->result();
                              if (isset($indikator)) {
                                foreach ($indikator as $ind) { ?>
                                  &bull; <?= $ind->nama_indikator ?>
                                  <div class="btn-group me-2">
                                    <a class="text-info dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: x-small;">
                                      [Option]
                                    </a>
                                    <div class="dropdown-menu">
                                      <a class="dropdown-item editIndikator" href="#" data-nama_sasaran="<?= $data->nama_sasaran ?>" data-id_indikator="<?= $ind->id_indikator ?>" data-nama_indikator="<?= $ind->nama_indikator ?>">Edit Indikator</a>
                                      <a class="dropdown-item deleteIndikator" href="#" data-id_indikator="<?= $ind->id_indikator ?>" data-nama_indikator="<?= $ind->nama_indikator ?>">Hapus Indikator</a>
                                      <div class="dropdown-divider"></div>
                                      <a class="dropdown-item addRO" href="#" data-id_sasaran="<?= $data->id_sasaran ?>" data-id_indikator="<?= $ind->id_indikator ?>" data-nama_indikator="<?= $ind->nama_indikator ?>">Tambah RO</a>
                                    </div>
                                  </div>
                              <?php }
                              }
                              ?>
                            </td>

                            <!-- Rincian Output kegiatan -->
                            <td>
                              <?php $rincian_output = $this->db->query('SELECT * FROM ro WHERE id_sasaran=' . $data->id_sasaran . ' AND id_kegiatan=' . $kegiatan->id_kegiatan . '')->result();
                              if (isset($rincian_output)) {
                                foreach ($rincian_output as $ro) { ?>
                                  &bull; <?= $ro->nama_ro ?>
                                  <div class="btn-group me-2">
                                    <a class="text-info dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: x-small;">
                                      [Option]
                                    </a>
                                    <div class="dropdown-menu">
                                      <a class="dropdown-item editRO" href="#" data-nama_sasaran="<?= $data->nama_sasaran ?>" data-id="<?= $ro->id_ro ?>" data-nama="<?= $ro->nama_ro ?>">Edit RO</a>
                                      <a class="dropdown-item deleteRO" href="#" data-id="<?= $ro->id_ro ?>" data-nama="<?= $ro->nama_ro ?>">Hapus RO</a>
                                    </div>
                                  </div>
                              <?php }
                              }
                              ?>
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
    </div>

    <!-- Modal add sasaran -->
    <div class="modal fade" id="modal-addSasaran" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Tambah sasaran kegiatan baru</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open('Data_master/proses_addSasaran') ?>
          <input type="hidden" name="id_kegiatan" value="<?= $kegiatan->id_kegiatan ?>">
          <div class="modal-body">
            <h6>Kegiatan : <?= $kegiatan->nama_kegiatan ?></h6>
            <div class="mb-3">
              <label for="sasaran" class="form-label">Sasaran Kegiatan</label>
              <textarea class="form-control" name="sasaran" id="sasaran" rows="5" required></textarea>
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
    <!-- Modal add sasaran end -->

    <!-- Modal edit sasaran -->
    <div class="modal fade" id="modal-editSasaran" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Edit Sasaran Kegiatan</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open('Data_master/proses_editSasaran') ?>
          <input type="hidden" name="id_kegiatan" value="<?= $kegiatan->id_kegiatan ?>">
          <input type="hidden" class="form-control id_sasaran" id="id_sasaran" name="id_sasaran">
          <div class="modal-body">
            <h6>Kegiatan : <?= $kegiatan->nama_kegiatan ?></h6>
            <div class="mb-3">
              <label for="sasaran" class="form-label">Sasaran Kegiatan</label>
              <textarea class="form-control sasaran" name="sasaran" id="sasaran" rows="5" required></textarea>
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
    <!-- Modal edit sasaran end -->

    <!-- Modal delete sasaran -->
    <div class="modal fade" id="modal-deleteSasaran" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Hapus Sasaran Kegiatan</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open('Data_master/proses_deleteSasaran') ?>
          <div class="modal-body">
            <input type="hidden" name="id_kegiatan" value="<?= $kegiatan->id_kegiatan ?>">
            <input type="hidden" class="form-control ID_sasaran" id="id_sasaran" name="id_sasaran">
            <span>Ingin menghapus sasaran kegiatan <b class="sasaran"></b> ?</span>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Hapus</button>
            <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">Close</button>
          </div>
          <?= form_close() ?>

        </div>
      </div>
    </div>
    <!-- Modal delete sasaran end -->

    <!-- Modal add indikator -->
    <div class="modal fade" id="modal-addIndikator" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Tambah Indikator Kegiatan</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open('Data_master/proses_addIndikator') ?>
          <input type="hidden" name="id_kegiatan" value="<?= $kegiatan->id_kegiatan ?>">
          <input type="hidden" class="form-control id_sasaran" id="id_sasaran" name="id_sasaran">
          <div class="modal-body">
            <p>Sasaran Kegiatan : <b class="sasaran"></b></p>
            <div class="mb-3">
              <label for="indikator" class="form-label">Indikator Kegiatan</label>
              <textarea class="form-control" name="indikator" id="indikator" rows="5" required></textarea>
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
    <!-- Modal add indikator end -->

    <!-- Modal edit indikator -->
    <div class="modal fade" id="modal-editIndikator" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Edit Indikator Kegiatan</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open('Data_master/proses_editIndikator') ?>
          <input type="hidden" name="id_kegiatan" value="<?= $kegiatan->id_kegiatan ?>">
          <!-- <input type="hidden" class="form-control id_sasaran" id="id_sasaran" name="id_sasaran"> -->
          <input type="hidden" class="form-control id_indikator" id="id_indikator" name="id_indikator">
          <div class="modal-body">
            <p>Sasaran Kegiatan : <b class="sasaran"></b></p>
            <div class="mb-3">
              <label for="indikator" class="form-label">Indikator Kegiatan</label>
              <textarea class="form-control indikator" name="indikator" id="indikator" rows="5" required></textarea>
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
    <!-- Modal edit indikator end -->

    <!-- Modal delete indikator -->
    <div class="modal fade" id="modal-deleteIndikator" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Hapus Indikator Kegiatan</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open('Data_master/proses_deleteIndikator') ?>
          <div class="modal-body">
            <input type="hidden" name="id_kegiatan" value="<?= $kegiatan->id_kegiatan ?>">
            <input type="hidden" class="form-control ID_indikator" id="id_indikator" name="id_indikator">
            <span>Ingin menghapus indikator kegiatan <b class="indikator"></b> ?</span>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Hapus</button>
            <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">Close</button>
          </div>
          <?= form_close() ?>

        </div>
      </div>
    </div>
    <!-- Modal delete indikator end -->

    <!-- Modal add RO -->
    <div class="modal fade" id="modal-addRO" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Tambah Rincian Output</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open('Data_master/proses_addRO') ?>
          <input type="hidden" name="id_kegiatan" value="<?= $kegiatan->id_kegiatan ?>">
          <input type="hidden" class="form-control id_sasaran" id="id_sasaran" name="id_sasaran">
          <input type="hidden" class="form-control id_indikator" id="id_indikator" name="id_indikator">
          <div class="modal-body">
            <p>Indikator Kegiatan : <b class="indikator"></b></p>
            <div class="mb-3">
              <label for="rincian_output" class="form-label">Rincian Output</label>
              <textarea class="form-control" name="rincian_output" id="rincian_output" rows="5" required></textarea>
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
    <!-- Modal add RO end -->

    <!-- Modal edit RO -->
    <div class="modal fade" id="modal-editRO" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Edit Rincian Output</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open('Data_master/proses_editRO') ?>
          <input type="hidden" name="id_kegiatan" value="<?= $kegiatan->id_kegiatan ?>">
          <input type="hidden" class="form-control id_RO" id="id_RO" name="id_RO">
          <div class="modal-body">
            <p>Sasaran Kegiatan : <b class="sasaran"></b></p>
            <div class="mb-3">
              <label for="ro" class="form-label">Rincian Output</label>
              <textarea class="form-control nama_RO" name="nama_RO" id="nama_RO" rows="5" required></textarea>
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
    <!-- Modal edit RO end -->

    <!-- Modal delete RO -->
    <div class="modal fade" id="modal-deleteRO" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Hapus Rincian Output</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open('Data_master/proses_deleteRO') ?>
          <div class="modal-body">
            <input type="hidden" name="id_kegiatan" value="<?= $kegiatan->id_kegiatan ?>">
            <input type="hidden" class="form-control ID_RO" id="id_RO" name="id_RO">
            <span>Ingin menghapus rincian output <b class="nama_RO"></b> ?</span>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Hapus</button>
            <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">Close</button>
          </div>
          <?= form_close() ?>

        </div>
      </div>
    </div>
    <!-- Modal delete RO end -->

    <?php $this->load->view('data_master/footer'); ?>

    <script>
      $(document).ready(function() {
        //Modal edit sasaran
        $("body").on("click", ".editSasaran", function(event) {
          const id = $(this).data('id_sasaran');
          const nama = $(this).data('nama_sasaran');

          $('.id_sasaran').val(id);
          $('.sasaran').val(nama);
          // Call Modal
          $('#modal-editSasaran').modal('show');
        });

        //Modal delete sasaran
        $("body").on("click", ".deleteSasaran", function(event) {
          const id = $(this).data('id_sasaran');
          const nama = $(this).data('nama_sasaran');

          $('.ID_sasaran').val(id);
          $('.sasaran').html(nama);
          // Call Modal
          $('#modal-deleteSasaran').modal('show');
        });

        //Modal add indikator
        $("body").on("click", ".addIndikator", function(event) {
          const id = $(this).data('id_sasaran');
          const nama = $(this).data('nama_sasaran');

          $('.id_sasaran').val(id);
          $('.sasaran').html(nama);
          // Call Modal
          $('#modal-addIndikator').modal('show');
        });

        //Modal edit indikator
        $("body").on("click", ".editIndikator", function(event) {
          const nama_sas = $(this).data('nama_sasaran');
          const id = $(this).data('id_indikator');
          const nama_ind = $(this).data('nama_indikator');

          $('.sasaran').html(nama_sas);
          $('.id_indikator').val(id);
          $('.indikator').val(nama_ind);
          // Call Modal
          $('#modal-editIndikator').modal('show');
        });

        //Modal delete indikator
        $("body").on("click", ".deleteIndikator", function(event) {
          const id = $(this).data('id_indikator');
          const nama = $(this).data('nama_indikator');

          $('.ID_indikator').val(id);
          $('.indikator').html(nama);
          // Call Modal
          $('#modal-deleteIndikator').modal('show');
        });

        //Modal add RO
        $("body").on("click", ".addRO", function(event) {
          const id_sasaran = $(this).data('id_sasaran');
          const id_indikator = $(this).data('id_indikator');
          const nama = $(this).data('nama_indikator');

          $('.id_sasaran').val(id_sasaran);
          $('.id_indikator').val(id_indikator);
          $('.indikator').html(nama);
          // Call Modal
          $('#modal-addRO').modal('show');
        });

        //Modal edit RO
        $("body").on("click", ".editRO", function(event) {
          const nama_sas = $(this).data('nama_sasaran');
          const id_RO = $(this).data('id');
          const nama_RO = $(this).data('nama');

          $('.sasaran').html(nama_sas);
          $('.id_RO').val(id_RO);
          $('.nama_RO').val(nama_RO);
          // Call Modal
          $('#modal-editRO').modal('show');
        });

        //Modal delete RO
        $("body").on("click", ".deleteRO", function(event) {
          const id_RO = $(this).data('id');
          const nama_RO = $(this).data('nama');

          $('.ID_RO').val(id_RO);
          $('.nama_RO').html(nama_RO);
          // Call Modal
          $('#modal-deleteRO').modal('show');
        });
      });
    </script>

</body>

</html>