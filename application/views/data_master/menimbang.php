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
                <table class="table table-bordered table-striped" id="tabelMenimbang" style="width: 100%;">
                  <?= form_open('Data_master/updateMenimbang', '', ['id' => $menimbang->id]) ?>
                  <tr>
                    <td>Poin A</td>
                    <td><textarea class="form-control" name="poin_a" rows="7"><?= isset($menimbang->poin_a) ? $menimbang->poin_a : '' ?></textarea></td>
                  </tr>
                  <tr>
                    <td>Poin B</td>
                    <td><textarea class="form-control" name="poin_b" rows="7"><?= isset($menimbang->poin_b) ? $menimbang->poin_b : '' ?></textarea></td>
                  </tr>
                  <tr class="text-center">
                    <td colspan="2">
                      <button type="submit" class="btn btn- btn-primary">Simpan</button>
                    </td>
                  </tr>
                  <?= form_close() ?>
                </table>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <?php $this->load->view('data_master/footer'); ?>

</body>

</html>