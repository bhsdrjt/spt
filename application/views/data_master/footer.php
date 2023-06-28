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
<script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>

<!-- Datatables -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>

<!-- Select 2 -->
<script src="<?= base_url() ?>/assets/js/select2.js"></script>

<script>
    //List petugas
    var counter = <?= count($PLH_kepala_balai); ?>

    for (var x = 0; x < counter; x++) {
        $('#PLH_kepala_balai' + x).select2({
            theme: "bootstrap-5",
            width: '100%',
        });
    }

    $("table.tabelMengetahui").on("click", "#addPLH", function(event) {
        var newRow = $("<tr>");
        var cols = "";
        cols += `<td>
                PLH Kepala Balai
                <button type="button" class="btn btn-sm btn-outline-danger deletePLH" style="float: right;"><i class="fa fa-trash"></i></button>
            </td>`;
        cols += `<td>
                <select class="form-control" name="PLH_kepala_balai[]" id="PLH_kepala_balai` + counter + `">
                    <?php foreach ($pegawai as $row) { ?>
                    <option value="<?= $row->id_pegawai ?>"><?= $row->nama ?>
                    <?php } ?>
                </select>
            </td>`;
        console.log(cols);
        newRow.append(cols);
        $("table.tabelMengetahui").append(newRow);
        $('#PLH_kepala_balai' + counter).select2({
            theme: "bootstrap-5",
            width: '100%',
        });
        counter++;
    });
    $("table.tabelMengetahui").on("click", "#deletePLH", function(event) {
        $(this).closest("tr").remove();
    });
</script>