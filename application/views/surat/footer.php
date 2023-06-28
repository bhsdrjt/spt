<footer class="bg-white rounded shadow p-5 mb-4 mt-4">
    <div class="row">
        <div class="col-12 col-md-4 col-xl-6 mb-4 mb-md-0">
            <p class="mb-0 text-center text-lg-start">© <span class="current-year"></span> <a class="text-primary fw-normal" href="#">BKSDA Kalsel</a></p>
        </div>
    </div>
</footer>
</main>

<!-- Core -->
<script src="<?= base_url() ?>/vendor/@popperjs/core/dist/umd/popper.min.js"></script>
<script src="<?= base_url() ?>/vendor/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Vendor JS -->
<script src="<?= base_url() ?>/vendor/onscreen/dist/on-screen.umd.min.js"></script>

<!-- Slider -->
<script src="<?= base_url() ?>/vendor/nouislider/distribute/nouislider.min.js"></script>

<!-- Smooth scroll -->
<script src="<?= base_url() ?>/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>

<!-- Charts -->
<script src="<?= base_url() ?>/vendor/chartist/dist/chartist.min.js"></script>
<script src="<?= base_url() ?>/vendor/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>

<!-- Datepicker -->
<script src="<?= base_url() ?>/vendor/vanillajs-datepicker/dist/js/datepicker.min.js"></script>

<!-- Sweet Alerts 2 -->
<script src="<?= base_url() ?>/vendor/sweetalert2/dist/sweetalert2.all.min.js"></script>

<!-- Moment JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>

<!-- Vanilla JS Datepicker -->
<script src="<?= base_url() ?>/vendor/vanillajs-datepicker/dist/js/datepicker.min.js"></script>

<!-- Notyf -->
<script src="<?= base_url() ?>/vendor/notyf/notyf.min.js"></script>

<!-- Simplebar -->
<script src="<?= base_url() ?>/vendor/simplebar/dist/simplebar.min.js"></script>

<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

<!-- Volt JS -->
<script src="<?= base_url() ?>/assets/js/volt.js"></script>

<!-- Font Awesome CDN -->
<script src="https://kit.fontawesome.com/d3ea3131f4.js" crossorigin="anonymous"></script>

<!-- Jquery -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<!-- Datatables -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>

<!-- Select 2 -->
<script src="<?= base_url() ?>/assets/js/select2.js"></script>

<!-- <script src="<?= base_url() ?>/assets/js/editor.js"></script>
<script src="<?= base_url() ?>/assets/js/jquery.richtext.min.js"></script> -->
<script>
    tinymce.init({
        selector: '#nama_kegiatan_surat'
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#kegiatan,#petugas0,#sumber_dana,#mengetahui,#mengetahui2').select2({
            theme: "bootstrap-5",
            width: '100%',
            //placeholder: '-Pilih-'
        });

        $('#dasarDIPA,#dasarKS').select2({
            theme: "bootstrap-5",
            width: '100%',
            //placeholder: '-Pilih-',
        });

        $('#kegiatan').change(function() {
            var kegiatan = $("#kegiatan").val()
            $.ajax({
                url: "<?= base_url('Surat_tugas/show_opsiKegiatan') ?>",
                method: "POST",
                data: {
                    kegiatan: kegiatan
                },
                success: function(data) {
                    console.log(data);
                    $("#hasil").html(data)
                    show_opsiSasaran()
                    show_opsiIndikator()
                    $("#rincianKegiatan").hide()
                }
            })
        })

        //List petugas
        <?php if (isset($pegawaiTugas)) { ?>
            var index = <?= count($pegawaiTugas); ?>;
            var no = <?= count($pegawaiTugas) + 1; ?>
        <?php } else { ?>
            var index = 1;
            var no = 2;
        <?php } ?>

        for (var x = 0; x < index; x++) {
            $('#petugas' + x).select2({
                theme: "bootstrap-5",
                width: '100%',
                placeholder: '-Pilih-'
            });
        }

        $("table.listPetugas").on("click", "#addPetugas", function(event) {
            var newRow = $("<tr>");
            var cols = "";
            cols += `<td style="vertical-align:middle">` + no + `</td>`;
            cols += `<td>
                        <select class="form-select" name="petugas[]" id="petugas` + index + `" onchange="cekPetugas(` + index + `)">
                            <option disabled selected>-Pilih-</option>
                            <?php foreach ($pegawai as $row) { ?>
                            <option value="<?= $row->id_pegawai ?>"><?= $row->nama ?>
                            <?php } ?>
                        </select>
                        <div id="alert_petugas` + index + `"></div>
                    </td>`;
            cols += `<td>
                        <button type="button" class="btn btn-sm rounded-circle btn-outline-danger" id="delPetugas"><i class="fa fa-trash"></i></button>
                        <button type="button" class="btn btn-sm rounded-circle btn-outline-info" id="addPetugas"><i class="fa fa-plus"></i></button>
                    </td>`;
            console.log(cols);
            newRow.append(cols);
            $("table.listPetugas").append(newRow);
            $('#petugas' + index).select2({
                theme: "bootstrap-5",
                width: '100%',
                placeholder: '-Pilih-'
            });
            no++;
            index++;
        });
        $("table.listPetugas").on("click", "#delPetugas", function(event) {
            $(this).closest("tr").remove();
        });


    });
</script>

<script>
    //Cek petugas jika bentrok
    function cekPetugas(index) {
        var startDate = $("#startDate").val();
        var endDate = $("#endDate").val()
        var petugas = $("#petugas" + index).val();
        console.log([startDate, endDate, petugas]);

        $.ajax({
            url: "<?= base_url('Surat_tugas/cek_petugas') ?>",
            method: "POST",
            data: {
                startDate: startDate,
                endDate: endDate,
                petugas: petugas
            },
            success: function(data) {
                console.log(data);
                $('#alert_petugas' + index).html(data);
            }
        })
    }

    //Function menampilkan indikator
    function show_opsiSasaran(index) {
        var sasaran = $("#sasaran" + index).val();
        console.log(index);
        console.log(sasaran);
        $.ajax({
            url: "<?= base_url('Surat_tugas/show_indikator') ?>",
            method: "POST",
            data: {
                sasaran: sasaran
            },
            success: function(data) {
                $("#hasil2").html(data)
                show_opsiIndikator()
                $("#rincianKegiatan").hide()
            }
        })
    }

    //Function menampilkan RO
    function show_opsiIndikator(index) {
        var indikator = $("#indikator" + index).val();
        $.ajax({
            url: "<?= base_url('Surat_tugas/show_RO') ?>",
            method: "POST",
            data: {
                indikator: indikator
            },
            success: function(data) {
                $("#hasil3").html(data)
                $("#rincianKegiatan").hide()
            }
        })
    }

    function validateForm() {
        let startDate = document.forms["form_SPT"]["startDate"].value;
        let endDate = document.forms["form_SPT"]["endDate"].value;
        if (startDate == "") {
            alert("Waktu pelaksanaan tidak boleh kosong");
            return false;
        }

        if (endDate == "") {
            alert("Waktu pelaksanaan tidak boleh kosong");
            return false;
        }
    }
</script>