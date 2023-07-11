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

    <div class="row mt-3">
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

                  <?php if ($_SESSION['level'] == 'Admin utama') { ?>
                    <div class="col text-end">
                      <a href="<?= base_url('Surat_tugas/add_spt') ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Surat Tugas</a>
                    </div>
                  <?php } ?>
                </div>
              </div>

              <form action="<?= base_url('Surat_tugas') ?>" method="post" target="_blank">
                <div class="row mb-2 mt-2" style="margin-left: 10px;">
                  <div class="col-3 mb-1">
                    <h4>Filter by</h4>
                    <input type="radio" value="tahun" name="filter" id="opsiTahun" checked onchange="opsiFilter()">Tahun &nbsp;&nbsp;&nbsp;
                    <input type="radio" value="bulan-tahun" name="filter" id="opsi_bulanTahun" onchange="opsiFilter()">Bulan-Tahun &nbsp;&nbsp;&nbsp;
                    <input type="radio" value="penempatan" name="filter" id="opsiPenempatan" onchange="opsiFilter()">Pegawai
                  </div>
                  <div class="col-9 mb-1">
                    <br>
                    <h4>Kategori SPT</h4>
                  </div>

                  <div class="col-3" id="tahun">
                    <select class="form-select" name="tahun">
                      <?php foreach ($tahun as $thn) {
                        echo "<option value='" . $thn->tahun . "'";
                        echo isset($tahunSelected) && $tahunSelected == $thn->tahun ? 'selected' : '';
                        echo ">" . $thn->tahun . "</option>";
                      } ?>
                    </select>
                  </div>
                  <div class="col-3" id="bulanTahun" style="display:none">
                    <input type="month" class="form-control" name="bulanTahun" value="<?= isset($bulanTahunSelected) ? $bulanTahunSelected : date('Y-m') ?>">
                  </div>
                  <div class="col-3" id="penempatan" style="display:none">
                    <select class="form-select" name="penempatan">
                      <option value="Balai" <?= isset($penempatanSelected) && $penempatanSelected == 'Balai' ? 'selected' : '' ?>>Balai</option>
                      <option value="SKW 1" <?= isset($penempatanSelected) && $penempatanSelected == 'SKW 1' ? 'selected' : '' ?>>SKW 1</option>
                      <option value="SKW 2" <?= isset($penempatanSelected) && $penempatanSelected == 'SKW 2' ? 'selected' : '' ?>>SKW 2</option>
                      <option value="SKW 3" <?= isset($penempatanSelected) && $penempatanSelected == 'SKW 3' ? 'selected' : '' ?>>SKW 3</option>
                      <option value="Non BKSDA" <?= isset($penempatanSelected) && $penempatanSelected == 'Non BKSDA' ? 'selected' : '' ?>>Non BKSDA</option>
                    </select>
                  </div>
                  <div class="col-1" id="kategori" >
                    <select class="form-select" name="kategori">
                      <option value="">-Pilih-</option>
                      <?php foreach ($kategoriSPT as $row) { ?>
                        <option value="<?= $row->id_kategori_spt ?>" <?= isset($kategori) && $kategori == $row->id_kategori_spt ? 'selected' : '' ?>><?= $row->nama_kategori ?></option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="col-3">
                    <button type="submit" class="btn btn-info" name="opsi" value="search"><i class="fa fa-search"></i></button>
                    <button type="submit" class="btn btn-danger" name="opsi" value="pdf"><i class="fa fa-download"></i> Pdf</button>
                    <button type="submit" class="btn btn-success" name="opsi" value="excel"><i class="fa fa-download"></i> Excel</button>
                  </div>
                </div>
              </form>

              <?php if ($this->session->flashdata('message')) {
                echo $this->session->flashdata('message');
              } ?>
              <div class="table-responsive py-4">
                <table class="text-center row-border font-small" id="tabelSurat" style="width: 100%;">
                  <thead class="bg-gray-300">
                    <tr>
                      <th>No</th>
                      <th>No. Surat</th>
                      <th>Tanggal Pelaksanaan</th>
                      <th>Kegiatan SPT</th>
                      <th>Perjanjian Kinerja</th>
                      <th>Link Dokumentasi</th>
                      <th>Link Laporan</th>
                      <th>Status</th>
                      <th>File Surat Fix</th>
                      <th>Kategori</th>
                      <th>Opsi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (isset($surat)) {
                      $no = 1;
                      foreach ($surat as $data) { ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= "ST." . $data->no_surat . " /K.16/TU/Peg/" . $data->bulan . "/" . $data->tahun ?></td>
                          <td><?= $data->dari_tanggal == $data->sampai_tanggal ? tgl_indo($data->dari_tanggal) : tgl_indo($data->dari_tanggal) . " - " . tgl_indo($data->sampai_tanggal) ?></td>
                          <td onclick="showPegawaiTugas(<?= $data->id_surat ?>)" class="text-info"><?= $data->nama_kegiatan_surat ?></td>
                          <td><?= $data->nama_kegiatan ?></td>
                          <td><?php if (!empty($data->link_dokumentasi)) {
                                echo '<a href="' . $data->link_dokumentasi . '" class="text-info" target="_blank">Preview</a>';
                              }
                              echo "<br>";
                              echo '<a href="#" class="btn btn-xs btn-warning linkDokumentasi" data-id="' . $data->id_surat . '">Update</i></a>';
                              ?>
                          </td>
                          <td><?php if (!empty($data->link_laporan)) {
                                echo '<a href="' . $data->link_laporan . '" class="text-info"  target="_blank">Preview</a>';
                              }
                              echo "<br>";
                              echo '<a href="#" class="btn btn-xs btn-warning linkLaporan" data-id="' . $data->id_surat . '">Update</i></a>';
                              ?>
                          </td>
                          <td><?= $data->status_pelaksanaan ?></td>
                          <td class="text-center"><?php
                                                  if (!empty($data->file_surat)) {
                                                    echo '<a href="' . base_url('assets/uploads/surat_tugas/') . $data->file_surat . '" class="text-info" download>Download</a>';
                                                    echo " | ";
                                                    echo '<a href="#" class="text-danger deleteUpload_surat" data-id="' . $data->id_surat . '">Hapus</i></a>';
                                                  }
                                                  ?> <br>
                            <a href="#" class="btn btn-xs btn-outline-tertiary uploadSurat" data-id="<?= $data->id_surat ?>" data-kegiatan="<?= $data->nama_kegiatan ?>" style="font-size:10pt"> Upload</a>
                          </td>
                          <td> <?= $data->nama_kategori ?></td>
                          <td>
                            <?php if ($_SESSION['level'] == 'Admin utama') { ?>
                              <a href="<?= base_url('Surat_tugas/edit_spt/' . $data->id_surat) ?>" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                              <a href="#" class="btn btn-sm btn-danger deleteSPT" data-id="<?= $data->id_surat ?>" data-kegiatan="<?= $data->nama_kegiatan ?>"><i class="fa fa-trash"></i></a>
                              <a href="#" class="btn btn-sm btn-info ubahStatus" data-id="<?= $data->id_surat ?>" data-nosurat="ST.<?= $data->no_surat ?>/K.16/TU/Peg/<?= $data->bulan ?>/<?= $data->tahun ?>"><i class="fa fa-exchange"></i></a>
                              <br>
                            <?php } ?>

                            <a href="#" class="btn btn-sm btn-tertiary cetakSPT" data-id="<?= $data->id_surat ?>"><i class="fa fa-print"></i></a>
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

    <!-- Modal upload surat -->
    <div class="modal fade" id="modal-uploadSurat" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Upload surat fix</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open_multipart('Surat_tugas/proses_uploadSurat') ?>
          <input class="form-control id_surat" type="hidden" name="id_surat">
          <div class="modal-body">
            <p>Kegiatan : <b class="kegiatan"></b></p>
            <div class="mb-3">
              <label for="file_surat" class="form-label">Surat fix <sup style="color: blue;">(file max 1 MB)</sup></label>
              <input class="form-control" type="file" name="file_surat" id="file_surat">
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-info">Upload</button>
            <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">Close</button>
          </div>
          <?= form_close() ?>

        </div>
      </div>
    </div>
    <!-- Modal upload surat end -->

    <!-- Modal delete surat -->
    <div class="modal fade" id="modal-deleteSurat" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Hapus Surat Tugas</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open_multipart('Surat_tugas/proses_deleteSurat') ?>
          <input class="form-control id_surat" type="hidden" name="id_surat">
          <div class="modal-body">
            <p> Hapus surat tugas pada kegiatan : <b class="kegiatan"></b></p>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Hapus</button>
            <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">Close</button>
          </div>
          <?= form_close() ?>

        </div>
      </div>
    </div>
    <!-- Modal delete surat end -->

    <!-- Modal cetak SPT -->
    <div class="modal fade" id="modal-cetakSPT" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Cetak SPT</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open('Surat_tugas/cetak_surat', 'target="_blank"') ?>
          <input class="form-control id_surat" type="hidden" name="id_surat">
          <div class="modal-body">
            <label>
              Cetak SPT disertai tanda tangan ?
            </label>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Ya_denganCap" name="denganTTD" id="Ya_denganCap">
              <label class="form-check-label" for="Ya_denganCap">
                Ya + Cap
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Ya_tanpaCap" name="denganTTD" id="Ya_tanpaCap">
              <label class="form-check-label" for="Ya_tanpaCap">
                Ya tanpa Cap
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Tidak" name="denganTTD" id="Tidak" checked>
              <label class="form-check-label" for="Tidak">
                Tidak
              </label>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-tertiary">Cetak</button>
            <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">Close</button>
          </div>
          <?= form_close() ?>

        </div>
      </div>
    </div>
    <!-- Modal cetak SPT end -->

    <!-- Modal delete surat yg di upload -->
    <div class="modal fade" id="modal-deleteUpload_surat" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Hapus Upload Surat</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open('Surat_tugas/proses_deleteUpload_surat') ?>
          <input class="form-control id_surat" type="hidden" name="id_surat">
          <div class="modal-body">
            <p> Hapus surat tugas yang diupload ?</p>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Hapus</button>
            <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">Close</button>
          </div>
          <?= form_close() ?>

        </div>
      </div>
    </div>
    <!-- Modal delete surat end -->

    <!-- Modal ubah status surat -->
    <div class="modal fade" id="modal-ubahStatus" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Status Surat Tugas</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open('Surat_tugas/proses_ubah_status') ?>
          <input class="form-control" type="hidden" name="id_surat" id="status_idSurat">
          <div class="modal-body">
            <p> Ubah surat tugas dengan no surat : <strong id="status_nomorSurat"></strong> menjadi <b>selesai</b> ?</p>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-info">Ya</button>
            <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">Close</button>
          </div>
          <?= form_close() ?>

        </div>
      </div>
    </div>
    <!-- Modal ubah status surat end -->

    <!-- Modal tambah link dokumentasi surat -->
    <div class="modal fade" id="modal-linkDokumentasi" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Tambah link dokumentasi</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open('Surat_tugas/tambah_linkDokumentasi') ?>
          <input class="form-control" type="hidden" name="id_surat" id="doc_idSurat">
          <div class="modal-body">
            <div class="mb-3">
              <label for="link_dokumentasi" class="form-label">Link Dokumentasi</label>
              <input class="form-control" type="text" name="link_dokumentasi" id="link_dokumentasi" placeholder="Link Dokumentasi">
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-info">Simpan</button>
            <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">Close</button>
          </div>
          <?= form_close() ?>
        </div>
      </div>
    </div>
    <!-- Modal tambah link dokumentasi surat end -->

    <!-- Modal tambah link laporan surat -->
    <div class="modal fade" id="modal-linkLaporan" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Tambah link laporan</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?= form_open('Surat_tugas/tambah_linkLaporan') ?>
          <input class="form-control" type="hidden" name="id_surat" id="doc_idSurat">
          <div class="modal-body">
            <div class="mb-3">
              <label for="link_laporan" class="form-label">Link Laporan</label>
              <input class="form-control" type="text" name="link_laporan" id="link_laporan" placeholder="Link Laporan">
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-info">Simpan</button>
            <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">Close</button>
          </div>
          <?= form_close() ?>
        </div>
      </div>
    </div>
    <!-- Modal tambah link laporan surat end -->

    <!-- Modal show pegawai tugas -->
    <div class="modal fade" id="modal-pegawaiTugas" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">List Pegawai Tugas</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <strong id="listPetugas" class="mb-4"></strong>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal show pegawai tugas end -->

    <?php $this->load->view('surat/footer'); ?>

    <script type="text/javascript">
      $(document).ready(function() {
        $('#tabelSurat').DataTable({
          'scrollX': true,
        });

        <?php if (isset($filter)) {
          if ($filter == 'tahun') { ?>
            document.getElementById("tahun").style.display = 'block';
            document.getElementById("opsiTahun").checked = true;

            document.getElementById("bulanTahun").style.display = 'none';
            document.getElementById("penempatan").style.display = 'none';
          <?php } elseif ($filter == 'bulan-tahun') { ?>
            document.getElementById("tahun").style.display = 'none';
            document.getElementById("bulanTahun").style.display = 'block';
            document.getElementById("opsi_bulanTahun").checked = true;

            document.getElementById("penempatan").style.display = 'none';
          <?php } elseif ($filter == 'penempatan') { ?>
            document.getElementById("tahun").style.display = 'none';
            document.getElementById("bulanTahun").style.display = 'none';
            document.getElementById("penempatan").style.display = 'block';
            document.getElementById("opsiPenempatan").checked = true;
          <?php } ?>
        <?php } else { ?>
          document.getElementById("tahun").style.display = 'block';
          document.getElementById("bulanTahun").style.display = 'none';
          document.getElementById("penempatan").style.display = 'none';
        <?php } ?>

        //Modal upload surat fix
        $("body").on("click", ".uploadSurat", function(event) {
          const id = $(this).data('id');
          const kegiatan = $(this).data('kegiatan');

          $('.id_surat').val(id);
          $('.kegiatan').html(kegiatan);
          // Call Modal
          $('#modal-uploadSurat').modal('show');
        });

        //Modal delete surat
        $("body").on("click", ".deleteSPT", function(event) {
          const id = $(this).data('id');
          const kegiatan = $(this).data('kegiatan');

          $('.id_surat').val(id);
          $('.kegiatan').html(kegiatan);
          // Call Modal
          $('#modal-deleteSurat').modal('show');
        });

        //Modal delete upload surat
        $("body").on("click", ".deleteUpload_surat", function(event) {
          const id = $(this).data('id');

          $('.id_surat').val(id);
          // Call Modal
          $('#modal-deleteUpload_surat').modal('show');
        });

        //Modal cetak surat
        $("body").on("click", ".cetakSPT", function(event) {
          const id = $(this).data('id');
          $('.id_surat').val(id);
          // Call Modal
          $('#modal-cetakSPT').modal('show');
        });


        //Modal ubah status
        $("body").on("click", ".ubahStatus", function(event) {
          const id = $(this).data('id');
          const nosurat = $(this).data('nosurat');

          $('#status_idSurat').val(id);
          $('#status_nomorSurat').html(nosurat);
          // Call Modal
          $('#modal-ubahStatus').modal('show');
        });


        //Modal tambah link dokumentasi
        $("body").on("click", ".linkDokumentasi", function(event) {
          const id = $(this).data('id');

          $('#doc_idSurat').val(id);
          // Call Modal
          $('#modal-linkDokumentasi').modal('show');
        });

        //Modal tambah link laporan
        $("body").on("click", ".linkLaporan", function(event) {
          const id = $(this).data('id');

          $('#lap_idSurat').val(id);
          // Call Modal
          $('#modal-linkLaporan').modal('show');
        });

        window.opsiFilter = function() {
          if ($('#opsiTahun').is(':checked')) {
            document.getElementById("tahun").style.display = 'block';
            document.getElementById("bulanTahun").style.display = 'none';
            document.getElementById("penempatan").style.display = 'none';
          } else if ($('#opsi_bulanTahun').is(':checked')) {
            document.getElementById("tahun").style.display = 'none';
            document.getElementById("bulanTahun").style.display = 'block';
            document.getElementById("penempatan").style.display = 'none';
          } else if ($('#opsiPenempatan').is(':checked')) {
            document.getElementById("tahun").style.display = 'none';
            document.getElementById("bulanTahun").style.display = 'none';
            document.getElementById("penempatan").style.display = 'block';
          }

        }
      });
    </script>

    <script type="text/javascript">
      // function tampilKegiatan(id, tanggal) {
      window.showPegawaiTugas = function(id) {
        $.ajax({
          url: "<?= base_url('Surat_tugas/showPegawaiTugas') ?>",
          method: "POST",
          data: {
            id: id,
          },
          success: function(data) {
            console.log(data);
            $('#listPetugas').html(data);
            $('#modal-pegawaiTugas').modal('show');
          }
        })
      }
    </script>

</body>

</html>