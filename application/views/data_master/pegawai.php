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
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-addPegawai"><i class="fa-solid fa-plus"></i> Pegawai</button>
                  </div>
                </div>
              </div>

              <div class="table-responsive py-4">
                <table class="text-center row-border" id="tabelPegawai" style="width: 100%;">
                  <thead class="bg-gray-300">
                    <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>NIP/NI PPPK</th>
                      <th>Tipe</th>
                      <th>Golongan</th>
                      <th>Pangkat</th>
                      <th>Jabatan</th>
                      <th>Status Pegawai</th>
                      <th>Penempatan</th>
                      <th>Opsi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (isset($pegawai)) {
                      $no = 1;
                      foreach ($pegawai as $data) { ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $data->nama ?></td>
                          <td><?= $data->nip ?></td>
                          <td><?= $data->tipe_pegawai ?></td>
                          <td><?= $data->golongan ?></td>
                          <td><?= $data->pangkat ?></td>
                          <td><?= $data->jabatan ?></td>
                          <td><?= $data->status_pegawai ?></td>
                          <td><?= $data->penempatan ?></td>
                          <td>
                            <a href="#" class="btn btn-sm btn-warning editPegawai" data-tipe_pegawai="<?= $data->tipe_pegawai ?>" data-id="<?= $data->id_pegawai ?>" data-nama="<?= $data->nama ?>" data-nip="<?= $data->nip ?>" data-golongan="<?= $data->golongan ?>" data-pangkat="<?= $data->pangkat ?>" data-jabatan="<?= $data->jabatan ?>" data-status="<?= $data->status_pegawai ?>" data-tandatangan="<?= $data->image_ttd ?>" data-penempatan="<?= $data->penempatan ?>" data-aktif="<?= $data->status_aktif ?>"><i class="fa fa-edit"></i></a>
                            <a href="#" class="btn btn-sm btn-danger deletePegawai" data-id="<?= $data->id_pegawai ?>" data-nama="<?= $data->nama ?>"><i class="fa fa-trash"></i></a>
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

    <!-- Modal add pegawai -->
    <div class="modal fade" id="modal-addPegawai" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Tambah pegawai baru</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open_multipart('Data_master/proses_addPegawai') ?>
          <div class="modal-body">
            <div class="mb-3">
              <label for="nama" class="form-label">Nama</label>
              <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama" autofocus required>
            </div>
            <div class="mb-3">
              <label for="tipe_pegawai" class="form-label">Tipe</label>
              <select class="form-select" name="tipe_pegawai" id="tipe_pegawai" onchange="updateTipePegawaiFields()">
                <option value="" disabled selected>Pilih Tipe</option>
                <option value="NIP">NIP</option>
                <option value="PPPK">PPPK</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="nip" class="form-label " id="nipLabel"> NIP</label>
              <input type="text" class="form-control" id="nip" name="nip" placeholder="Masukkan NIP" disabled required>
            </div>
            <div class="mb-3">
              <label for="golongan" class="form-label">Golongan</label>
              <input type="text" class="form-control" id="golongan" name="golongan" placeholder="Masukkan Golongan">
            </div>
            <div class="mb-3">
              <label for="pangkat" class="form-label">Pangkat</label>
              <input type="text" class="form-control" id="pangkat" name="pangkat" placeholder="Masukkan Pangkat">
            </div>
            <div class="mb-3">
              <label for="jabatan" class="form-label">Jabatan</label>
              <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Masukkan Jabatan">
            </div>
            <div class="mb-3">
              <label for="statusPegawai" class="form-label">Status Pegawai</label>
              <select class="form-select" name="statusPegawai" id="statusPegawai">
              <option value="Pegawai BKSDA">Pegawai BKSDA</option>
                <option value="Non Pegawai BKSDA">Non Pegawai BKSDA</option>
                <option value="Non Pegawai BKSDA">Non Pegawai BKSDA</option>
                <option value="Pensiun">Pensiun</option>
                <option value="Keluar">Keluar</option>
                <option value="Meninggal Dunia">Meninggal Dunia</option>
                <option value="Pegawai Kerjasama">Pegawai Kerjasama</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="penempatan" class="form-label">Penempatan</label>
              <select class="form-select" name="penempatan" id="penempatan">
                <option value="Balai" selected>Balai</option>
                <option value="SKW 1">SKW 1</option>
                <option value="SKW 2">SKW 2</option>
                <option value="SKW 3">SKW 3</option>
                <option value="Non BKSDA">Non BKSDA</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="image_ttd" class="form-label">Gambar Tanda Tangan</label>
              <input type="file" class="form-control" id="image_ttd" name="image_ttd">
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
    <!-- Modal add pegawai end -->

    <!-- Modal edit pegawai -->
    <div class="modal fade" id="modal-editPegawai" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Edit pegawai</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open_multipart('Data_master/proses_editPegawai') ?>
          <input type="hidden" class="form-control id_pegawai" id="id_pegawai"name="id_pegawai">
          <div class="modal-body">
            <div class="mb-3">
              <label for="nama"class="form-label">Nama</label>
              <input type="text" class="form-control nama" id="nama"name="nama"placeholder="Masukkan nama" autofocus required>
            </div>
            <div class="mb-3">
              <label for="tipe_pegawai"class="form-label">Tipe</label>
              <select class="form-select tipe_pegawai" name="tipe_pegawai"id="tipe_pegawai2"onchange="updateTipePegawaiFields('edit')">
                <option value="NIP">NIP</option>
                <option value="PPPK">PPPK</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="nip"id="nipLabel2"class="form-label">NIP</label>
              <input type="text" class="form-control nip" id="nip2"name="nip"placeholder="Masukkan NIP" required>
            </div>
            <div class="mb-3">
              <label for="golongan"class="form-label">Golongan</label>
              <input type="text" class="form-control golongan" id="golongan"name="golongan"placeholder="Masukkan Golongan">
            </div>
            <div class="mb-3">
              <label for="pangkat"class="form-label">Pangkat</label>
              <input type="text" class="form-control pangkat" id="pangkat"name="pangkat"placeholder="Masukkan Pangkat">
            </div>
            <div class="mb-3">
              <label for="jabatan"class="form-label">Jabatan</label>
              <input type="text" class="form-control jabatan" id="jabatan"name="jabatan"placeholder="Masukkan Jabatan">
            </div>
            <div class="mb-3">
              <label for="statusPegawai"class="form-label">Status Pegawai</label>
              <select class="form-select statusPegawai" name="statusPegawai"id="statusPegawai2">
                <option value="Pegawai BKSDA">Pegawai BKSDA</option>
                <option value="Non Pegawai BKSDA">Non Pegawai BKSDA</option>
                <option value="Non Pegawai BKSDA">Non Pegawai BKSDA</option>
                <option value="Pensiun">Pensiun</option>
                <option value="Keluar">Keluar</option>
                <option value="Meninggal Dunia">Meninggal Dunia</option>
                <option value="Pegawai Kerjasama">Pegawai Kerjasama</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="penempatan"class="form-label">Penempatan</label>
              <select class="form-select penempatan" name="penempatan"id="penempatan2">
                <option value="Balai">Balai</option>
                <option value="SKW 1">SKW 1</option>
                <option value="SKW 2">SKW 2</option>
                <option value="SKW 3">SKW 3</option>
                <option value="Non BKSDA">Non BKSDA</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="image_ttd"class="form-label">Gambar Tanda Tangan</label>
              <input type="hidden" class="form-control ttd_lama" id="ttd_lama"name="ttd_lama2">
              <input type="file" class="form-control" id="image_ttd"name="image_ttd2">
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

    <!-- Modal edit pegawai end -->

    <!-- Modal delete pegawai -->
    <div class="modal fade" id="modal-deletePegawai" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Hapus pegawai</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open('Data_master/proses_deletePegawai') ?>
          <div class="modal-body">
            <input type="hidden" class="form-control ID_pegawai" id="id_pegawai" name="id_pegawai">
            <span>Ingin menghapus data pegawai <b class="nama"></b> ?</span>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Hapus</button>
            <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">Close</button>
          </div>
          <?= form_close() ?>

        </div>
      </div>
    </div>
    <!-- Modal delete pegawai end -->


    <?php $this->load->view('data_master/footer'); ?>

    <script>
      $(document).ready(function() {
        $('#tabelPegawai').DataTable({
          'scrollX': true,
        });

        //Modal edit pegawai
        function updateEditModalFields(id, nama, nip, golongan, pangkat, jabatan, status, tandatangan, penempatan, tipe_pegawai) {
          $('.id_pegawai').val(id);
          $('.nama').val(nama);
          $('.nip').val(nip);
          $('.golongan').val(golongan);
          $('.pangkat').val(pangkat);
          $('.jabatan').val(jabatan);
          $('.statusPegawai').val(status).trigger('change');
          $('.penempatan').val(penempatan).trigger('change');
          $('.ttd_lama').val(tandatangan);

          // Update tipe_pegawai field
          if (tipe_pegawai === 'NIP') {
            $('#nipLabel2').text('NIP');
            $('#nip2').attr('placeholder', 'Masukkan NIP');
          } else if (tipe_pegawai === 'PPPK') {
            $('#nipLabel2').text('NI PPPK');
            $('#nip2').attr('placeholder', 'Masukkan NI PPPK');
          }
          $('#tipe_pegawai2').val(tipe_pegawai);
        }

        // Edit button click event
        $("body").on("click", ".editPegawai", function(event) {
          const id = $(this).data('id');
          const nama = $(this).data('nama');
          const nip = $(this).data('nip');
          const golongan = $(this).data('golongan');
          const pangkat = $(this).data('pangkat');
          const jabatan = $(this).data('jabatan');
          const status = $(this).data('status');
          const tandatangan = $(this).data('tandatangan');
          const penempatan = $(this).data('penempatan');
          const tipe_pegawai = $(this).data('tipe_pegawai');

          // console.log(id, nama, nip, golongan, pangkat, jabatan, status, tandatangan, penempatan, tipe_pegawai);
          updateEditModalFields(id, nama, nip, golongan, pangkat, jabatan, status, tandatangan, penempatan, tipe_pegawai);

          // Show the modal
          $('#modal-editPegawai').modal('show');
        });

        //Modal delete pegawai
        $("body").on("click", ".deletePegawai", function(event) {
          const id = $(this).data('id');
          const nama = $(this).data('nama');

          $('.ID_pegawai').val(id);
          $('.nama').html(nama);
          $('#modal-deletePegawai').modal('show');
        });
      });


      function updateTipePegawaiFields(act = null) {
        const tipepegawaiSelect = document.getElementById("tipe_pegawai");
        const tipepegawaiSelect2 = document.getElementById("tipe_pegawai2");
        const nipLabel = document.getElementById("nipLabel");
        const nipLabel2 = document.getElementById("nipLabel2");
        const nipInput = document.getElementById("nip");
        const nipInput2 = document.getElementById("nip2");

        if (act == 'edit') {
          if (tipepegawaiSelect2.value === "NIP") {
            nipLabel2.textContent = "NIP";
            nipInput2.placeholder = "Masukkan NIP";
            nipInput.removeAttribute("disabled");
          } else if (tipepegawaiSelect2.value === "PPPK") {
            nipLabel2.textContent = "NI PPPK";
            nipInput2.placeholder = "Masukkan NI PPPK";
            nipInput.removeAttribute("disabled");
          } else {
            nipLabel.textContent = "";
            nipInput.placeholder = "Pilih Tipe terlebih dahulu";
            nipInput.setAttribute("disabled", "disabled");
          }
        } else {
          if (tipepegawaiSelect.value === "NIP") {
            nipLabel.textContent = "NIP";
            nipInput.placeholder = "Masukkan NIP";
            nipInput.removeAttribute("disabled");
          } else if (tipepegawaiSelect.value === "PPPK") {
            nipLabel.textContent = "NI PPPK";
            nipInput.placeholder = "Masukkan NI PPPK";
            nipInput.removeAttribute("disabled");
          } else {
            nipLabel.textContent = "";
            nipInput.placeholder = "Pilih Tipe terlebih dahulu";
            nipInput.setAttribute("disabled", "disabled");
          }
        }
      }

      // Call the function when the dropdown value changes
      // document.getElementById("tipe_pegawai").addEventListener("change", updateTipePegawaiFields);
    </script>

</body>

</html>