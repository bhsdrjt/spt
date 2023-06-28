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
                  <!-- <div class="col text-end">
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-addUser"><i class="fa-solid fa-plus"></i> User</button>
                  </div> -->
                </div>
              </div>

              <div class="table-responsive py-4">
                <?= form_open('Data_master/updateMengetahui') ?>
                <table class="table table-bordered table-striped tabelMengetahui" style="width: 100%;">
                  <tbody>
                    <tr>
                      <td>Kepala Balai</td>
                      <td>
                        <select class="form-control" name="kepala_balai" id="kepala_balai" required>
                          <?php foreach ($pegawai as $data) {
                            echo "<option value='$data->id_pegawai'";
                            echo  $data->id_pegawai == $kepala_balai->id_pegawai ? 'selected' : '';
                            echo ">$data->nama</option>";
                          } ?>
                        </select>
                      </td>
                    </tr>

                    <?php if (isset($PLH_kepala_balai)) {
                      $index = 0;
                      foreach ($PLH_kepala_balai as $plh) { ?>
                        <tr>
                          <td>Plh. Kepala Balai
                            <button type="button" class="btn btn-sm btn-outline-danger" id="deletePLH" style="float: right;"><i class="fa fa-trash"></i></button>
                          </td>
                          <td>
                            <select class="form-control" name="PLH_kepala_balai[]" id="PLH_kepala_balai<?= $index ?>">
                              <?php foreach ($pegawai as $data) {
                                echo "<option value='$data->id_pegawai'";
                                echo  $data->id_pegawai == $plh->id_pegawai ? 'selected' : '';
                                echo ">$data->nama</option>";
                              } ?>
                            </select>
                          </td>
                        </tr>
                    <?php $index++;
                      }
                    } ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="2">
                        <button type="button" class="btn btn-sm btn-outline-info" id="addPLH"><i class="fa fa-plus"></i> Tambah Plh.</button>
                      </td>
                    </tr>
                    <tr class="text-center">
                      <td colspan="2">
                        <button type="submit" class="btn btn- btn-primary">Simpan</button>
                      </td>
                    </tr>
                  </tfoot>
                </table>
                <?= form_close() ?>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <?php $this->load->view('data_master/footer'); ?>

    <script>
      $(document).ready(function() {
        $('#kepala_balai').select2({
          theme: "bootstrap-5",
          width: '100%',
        });
      });
    </script>

</body>

</html>