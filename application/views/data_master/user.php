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
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-addUser"><i class="fa-solid fa-plus"></i> User</button>
                  </div>
                </div>
              </div>

              <div class="table-responsive py-4">
                <table class="text-center row-border" id="tabelUser" style="width: 100%;">
                  <thead class="bg-gray-300">
                    <tr>
                      <th>No</th>
                      <th>Username</th>
                      <th>Level</th>
                      <th>Last login</th>
                      <th>Opsi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (isset($user)) {
                      $no = 1;
                      foreach ($user as $data) { ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $data->username ?></td>
                          <td><?= $data->level ?></td>
                          <td><?= $data->last_login ?></td>
                          <td>
                            <a href="#" class="btn btn-sm btn-warning editUser" data-id="<?= $data->id ?>" data-username="<?= $data->username ?>" data-level="<?= $data->level ?>"><i class="fa fa-edit"></i></a>
                            <a href="#" class="btn btn-sm btn-danger deleteUser" data-id="<?= $data->id ?>" data-username="<?= $data->username ?>"><i class="fa fa-trash"></i></a>
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

    <!-- Modal add user -->
    <div class="modal fade" id="modal-addUser" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Tambah user baru</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open('Data_master/proses_addUser') ?>
          <div class="modal-body">
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" autofocus required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
            </div>
            <div class="mb-3">
              <label for="level" class="form-label">Level</label>
              <select class="form-select" name="level" id="level" required>
                <option value="Admin utama" selected>Admin utama</option>
                <option value="Admin biasa">Admin biasa</option>
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
    <!-- Modal add user end -->

    <!-- Modal edit user -->
    <div class="modal fade" id="modal-editUser" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Edit user</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open('Data_master/proses_editUser') ?>
          <input type="hidden" class="form-control id_user" id="id_user" name="id_user">
          <div class="modal-body">
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control username" id="username" name="username" placeholder="Masukkan username" autofocus required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password baru</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
            </div>
            <div class="mb-3">
              <label for="level" class="form-label">Level</label>
              <select class="form-select level" name="level" id="level" required>
                <option value="Admin utama">Admin utama</option>
                <option value="Admin biasa">Admin biasa</option>
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
    <!-- Modal edit user end -->

    <!-- Modal delete user -->
    <div class="modal fade" id="modal-deleteUser" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Hapus user</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open('Data_master/proses_deleteUser') ?>
          <div class="modal-body">
            <input type="hidden" class="form-control ID_user" id="id_user" name="id_user">
            <span>Ingin menghapus user <b class="username"></b> ?</span>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Hapus</button>
            <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">Close</button>
          </div>
          <?= form_close() ?>

        </div>
      </div>
    </div>
    <!-- Modal delete user end -->


    <?php $this->load->view('data_master/footer'); ?>

    <script>
      $(document).ready(function() {
        $('#tabelUser').DataTable({
          'scrollX': true,
        });

        //Modal edit user
        $("body").on("click", ".editUser", function(event) {
          const id = $(this).data('id');
          const username = $(this).data('username');
          const level = $(this).data('level');

          $('.id_user').val(id);
          $('.username').val(username);
          $('.level').val(level).trigger('change');
          // Call Modal
          $('#modal-editUser').modal('show');
        });

        //Modal delete user
        $("body").on("click", ".deleteUser", function(event) {
          const id = $(this).data('id');
          const username = $(this).data('username');

          $('.ID_user').val(id);
          $('.username').html(username);
          // Call Modal
          $('#modal-deleteUser').modal('show');
        });
      });
    </script>

</body>

</html>