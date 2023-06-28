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
                    <h2 class="fs-5 fw-bold mb-0">Detail Kegiatan <u><?= isset($pegawai) ? $pegawai->nama : '' ?></u></h2>
                    <?php if ($this->session->flashdata('msg')) {
                      echo $this->session->flashdata('msg');
                    } ?>
                  </div>
                </div>
              </div>


              <?= form_open('Statistik/detail_statistikPegawai/' . $pegawai->id_pegawai) ?>
              <div class="row mt-2" style="margin-left: 5px;margin-bottom: 15px;">
                <div class="col-md-11">
                  <h6>Filter PK</h6>
                  <select class="form-select" name="pk" id="pk">
                    <option value="Semua" selected>Semua</option>
                    <?php foreach ($pk as $row) {
                      echo "<option value='$row->id_kegiatan'";
                      echo $row->id_kegiatan == $pkSelected ? 'selected' : '';
                      echo ">$row->nama_kegiatan</option>";
                    } ?>
                  </select>
                </div>
                <div class="col-md-12 mt-3">
                  <button type="submit" class="btn btn-sm btn-primary" name="mode" value="cari"><i class="fa fa-search"></i> Cari</button>
                  <button type="submit" class="btn btn-sm btn-info" name="mode" value="spt_pdf_download"><i class="fa fa-download"></i> Download SPT</button>
                  <button type="submit" class="btn btn-sm btn-danger" name="mode" value="skp_excel_download"><i class="fa fa-download" download></i> Download SKP</button>
                </div>
              </div>
              <?= form_close() ?>

              <div class="table-responsive py-4">
                <table class="text-center row-border" id="tabelDetail_statistik" style="width: 100%;">
                  <thead class="bg-warning">
                    <tr>
                      <th>No</th>
                      <th>Tanggal</th>
                      <th>Nama Kegiatan</th>
                      <th>Opsi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (isset($detail)) {
                      $no = 1;
                      foreach ($detail as $data) { ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $data->dari_tanggal == $data->sampai_tanggal ? tgl_indo($data->dari_tanggal) : tgl_indo($data->dari_tanggal) . " - " . tgl_indo($data->sampai_tanggal) ?></td>
                          <td><?= $data->nama_kegiatan_surat ?></td>
                          <td>
                            <?php
                            if (!empty($data->file_surat)) {
                              echo '<a href="' . base_url('assets/uploads/surat_tugas/') . $data->file_surat . '" class="text-info" download>Download</a>';
                            } else {
                              echo "Tidak ada surat";
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

    <?php $this->load->view('statistik/footer'); ?>
    <script type="text/javascript">
      $(document).ready(function() {
        $('#tabelDetail_statistik').DataTable({
          'scrollX': true,
        });

        $('#pk').select2({
          'placeholder': '-Pilih-',
          'width': '100%',
          'allowClear': true
        });
      });
    </script>
</body>

</html>