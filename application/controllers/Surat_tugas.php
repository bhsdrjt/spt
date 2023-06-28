<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Surat_tugas extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != "is_login") {
            redirect(base_url("Auth"));
        }
        $this->load->model('M_surat_tugas');
    }

    public function index()
    {
        $this->load->helper('MY_tanggal');
        $data['title'] = 'Surat Perintah Tugas';

        $filter = $this->input->post('filter');
        $data['filter'] = $filter;

        $data['tahunSelected'] = date('Y');
        $data['tahun'] = $this->db->query('SELECT tahun FROM surat GROUP BY tahun')->result();

        $opsi = $this->input->post('opsi');
        if ($filter == 'tahun') {
            $tahun = $this->input->post('tahun');
            $data['tahunSelected'] = isset($tahun) ? $tahun : date('Y');
            $data['tahun'] = $this->db->query('SELECT tahun FROM surat GROUP BY tahun')->result();
            $data['surat'] = $this->M_surat_tugas->surat_tugas('', $data['tahunSelected']);

            if ($opsi == 'pdf') {
                $fileName = 'Kegiatan SPT ' . $data['tahunSelected'];
                $this->generatePdf_spt($data, $fileName);
            } elseif ($opsi == 'excel') {
                $data['title'] = 'Kegiatan SPT ' . $data['tahunSelected'];
                $this->load->view('surat/download_excel_spt', $data);
            } else {
                $this->load->view('surat/spt', $data);
            }
        } elseif ($filter == 'bulan-tahun') {
            $bulanTahun = $this->input->post('bulanTahun');
            $bulanSelected = date('m', strtotime($bulanTahun));
            $tahunSelected = date('Y', strtotime($bulanTahun));

            $data['bulanTahunSelected'] = isset($bulanTahun) ? date($tahunSelected . '-' . $bulanSelected) : date('Y-m');
            $data['surat'] = $this->M_surat_tugas->surat_tugas_bulanTahun($tahunSelected, intval($bulanSelected));

            if ($opsi == 'pdf') {
                $fileName = 'Kegiatan SPT ' . $this->ubahBulan($bulanSelected) . ' ' . $tahunSelected;
                $this->generatePdf_spt($data, $fileName);
            } elseif ($opsi == 'excel') {
                $data['title'] = 'Kegiatan SPT ' . $this->ubahBulan($bulanSelected) . ' ' . $tahunSelected;
                $this->load->view('surat/download_excel_spt', $data);
            } else {

                $this->load->view('surat/spt', $data);
            }
        } elseif ($filter == 'penempatan') {
            $penempatan = $this->input->post('penempatan');
            $data['penempatanSelected'] = isset($penempatan) ? $penempatan : 'Balai';

            // Get semua id surat dari tabel pegawai tugas lebih dulu dimana id_pegawainya penempatan di $penempatan
            $idSurat = $this->db->query('SELECT pt.id_surat,pt.id_pegawai,penempatan FROM pegawai_tugas pt JOIN pegawai ON pegawai.id_pegawai=pt.id_pegawai GROUP BY pt.id_surat ORDER BY pt.id ASC')->result();
            if (isset($idSurat)) {
                foreach ($idSurat as $is) {
                    //Kumpulkan semua id surat yg penempatannya sesuai $penempatan
                    if ($is->penempatan == $penempatan) {
                        $data['surat'][] = $this->M_surat_tugas->surat_tugas($is->id_surat);
                    }
                }
            }

            if ($opsi == 'pdf') {
                $fileName = 'Kegiatan SPT ' .   $data['penempatanSelected'];
                $this->generatePdf_spt($data, $fileName);
            } elseif ($opsi == 'excel') {
                $data['title'] = 'Kegiatan SPT ' .   $data['penempatanSelected'];
                $this->load->view('surat/download_excel_spt', $data);
            } else {
                $this->load->view('surat/spt', $data);
            }
        } else {
            $data['surat'] = $this->M_surat_tugas->surat_tugas('', $data['tahunSelected']);

            if ($opsi == 'pdf') {
                $fileName = 'Kegiatan SPT';
                $this->generatePdf_spt($data, $fileName);
            } elseif ($opsi == 'excel') {
                $data['title'] = 'Kegiatan SPT';
                $this->load->view('surat/download_excel_spt', $data);
            } else {
                $this->load->view('surat/spt', $data);
            }
        }
    }

    public function add_spt()
    {
        $data['title'] = 'Surat Perintah Tugas';
        $data['kegiatan'] = $this->db->get_where('kegiatan', ['tahun' => date('Y')])->result();
        $data['pegawai'] = $this->db->get('pegawai')->result();
        $data['mengetahui'] = $this->db->query('SELECT * FROM mengetahui JOIN pegawai ON mengetahui.id_pegawai=pegawai.id_pegawai')->result();
        $data['dasarDIPA'] = $this->db->get_where('dasar_surat', ['kategori' => 'DIPA', 'tahun' => date('Y')])->result();
        $data['dasarKS'] = $this->db->get_where('dasar_surat', ['kategori' => 'Kerja sama', 'tahun' => date('Y')])->result();
        $data['sumberDana'] = $this->db->get('sumber_dana')->result();
        $data['kategoriSPT'] = $this->db->get('kategori_spt')->result();
        $data['jabatanMengetahui'] = $this->db->get('jabatan_mengetahui')->result();
        $this->load->view('surat/tambah_spt', $data);
    }

    function show_opsiKegiatan()
    {
        $kegiatan = $this->input->post('kegiatan');
        //Get Sasaran kegiatan
        $sasaran = $this->db->get_where('sasaran', ['id_kegiatan' => $kegiatan])->result();
        // //Get Indikator kegiatan
        // $indikator = $this->db->get_where('indikator', ['id_kegiatan' => $kegiatan])->result();
        //Get RO kegiatan
        // $ro = $this->db->get_where('ro', ['id_kegiatan' => $kegiatan])->result();

        $output = "";
        $index = 0;
        // Sasaran kegiatan
        if (!empty($sasaran)) {
            $output .= '<div class="alert alert-info" role="alert"><b>Sasaran Kegiatan</b></div>';
            foreach ($sasaran as $sas) {
                $output .= '<div class="form-check">
            <input class="form-check-input" type="radio" value="' . $sas->id_sasaran . '" name="sasaran" id="sasaran' . $index . '" onchange="show_opsiSasaran(' . $index . ')">
            <label class="form-check-label" for="sasaran' . $index . '">
                ' . $sas->nama_sasaran . '/sasaranIndex' . $index . '
            </label>
        </div>';
                $index++;
            }
        }

        // // Indikator kegiatan
        // if (!empty($indikator)) {
        //     $output .= '<div class="col-4"><div class="alert alert-secondary" role="alert"><b>Indikator Kegiatan</b></div>';
        //     foreach ($indikator as $ind) {
        //         $output .= '<div class="form-check">
        //     <input class="form-check-input" type="radio" value="' . $ind->id_indikator . '" name="indikator" id="indikator' . $index++ . '">
        //     <label class="form-check-label" for="indikator' . $index++ . '">
        //         ' . $ind->nama_indikator . '
        //     </label>
        // </div>';
        //     }
        //     $output .= '</div>';
        // }

        // // Rincian output kegiatan
        // if (!empty($ro)) {
        //     $output .= '<div class="col-4"><div class="alert alert-warning" role="alert"><b>Rincian Output</b></div>';
        //     foreach ($ro as $r) {
        //         $output .= '<div class="form-check">
        //     <input class="form-check-input" type="radio" value="' . $r->id_ro . '" name="rincian_output" id="rincian_output' . $index++ . '">
        //     <label class="form-check-label" for="rincian_output' . $index++ . '">
        //         ' . $r->nama_ro . '
        //     </label>
        // </div>';
        //     }
        //     $output .= '</div>';
        // }
        echo $output;
    }

    function show_indikator()
    {
        $sasaran = $this->input->post('sasaran');
        //Get Indikator kegiatan
        $indikator = $this->db->get_where('indikator', ['id_sasaran' => $sasaran])->result();
        // Indikator kegiatan
        $output = "";
        $index = 0;
        if (!empty($indikator)) {
            $output .= '<div class="alert alert-secondary" role="alert"><b>Indikator Kegiatan</b></div>';
            foreach ($indikator as $ind) {
                $output .= '<div class="form-check">
            <input class="form-check-input" type="radio" value="' . $ind->id_indikator . '" name="indikator" id="indikator' . $index . '" onchange="show_opsiIndikator(' . $index . ')">
            <label class="form-check-label" for="indikator' . $index . '">
                ' . $ind->nama_indikator . '
            </label>
        </div>';
                $index++;
            }
        }
        echo $output;
    }

    function show_RO()
    {
        $indikator = $this->input->post('indikator');
        //Get Indikator kegiatan
        $ro = $this->db->get_where('ro', ['id_indikator' => $indikator])->result();
        // Indikator kegiatan
        $output = "";
        $index = 0;
        // Rincian output kegiatan
        if (!empty($ro)) {
            $output .= '<div class="alert alert-warning" role="alert"><b>Rincian Output</b></div>';
            foreach ($ro as $r) {
                $output .= '<div class="form-check">
            <input class="form-check-input" type="radio" value="' . $r->id_ro . '" name="rincian_output" id="rincian_output' . $index . '">
            <label class="form-check-label" for="rincian_output' . $index . '">
                ' . $r->nama_ro . '
            </label>
        </div>';
                $index++;
            }
        }
        echo $output;
    }

    public function proses_addSPT()
    {
        //Cek petugas jika ada id yang sama dalam satu surat
        $petugas = $this->input->post('petugas');
        $count_array = array_count_values($petugas);
        foreach ($count_array as $data) {
            if ($data > 1) {
                $this->session->set_flashdata('msg', '<span class="badge bg-danger text-dark">Ada duplikasi data petugas</span>');
                redirect('Surat_tugas/add_spt');
            }
        }

        $no_surat = $this->input->post('no_surat');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $tgl_spt = $this->input->post('tgl_spt');
        $dasarDIPA = $this->input->post('dasarDIPA');
        $dasarKS = $this->input->post('dasarKS');
        $sumber_dana = $this->input->post('sumber_dana');
        $startDate = $this->input->post('startDate');
        $endDate = $this->input->post('endDate');
        $mengetahui = $this->input->post('mengetahui');
        $jabatan_mengetahui = $this->input->post('jabatan_mengetahui');
        $mengetahui2 = $this->input->post('mengetahui2');
        $jabatan_mengetahui2 = $this->input->post('jabatan_mengetahui2');

        $nama_kegiatan_surat = $this->input->post('nama_kegiatan_surat');
        $kegiatan = $this->input->post('kegiatan');
        $sasaran = $this->input->post('sasaran');
        $indikator = $this->input->post('indikator');
        $rincian_output = $this->input->post('rincian_output');
        $kategori_spt = $this->input->post('kategori_spt');

        if (empty($kegiatan)) {
            $this->session->set_flashdata('msg', '<span class="badge bg-danger text-dark">Kegiatan tidak boleh kosong</span>');
            redirect('Surat_tugas/add_spt');
        }

        // Cek  masing-masing petugas jika terdapat jadwal yang betrok
        for ($i = 0; $i < COUNT($petugas); $i++) {
            $cek = $this->db->query('SELECT * FROM tgl_pelaksanaan tp JOIN surat ON surat.id_surat=tp.id_surat JOIN pegawai_tugas pt ON pt.id_surat=surat.id_surat JOIN pegawai ON pegawai.id_pegawai=pt.id_pegawai JOIN kegiatan ON kegiatan.id_kegiatan=surat.kegiatan WHERE tp.tanggal BETWEEN "' . $startDate . '" AND "' . $endDate . '" AND pt.id_pegawai=' . $petugas[$i] . '')->result();
            if (!empty($cek)) {
                $this->session->set_flashdata('msg', '<span class="badge bg-danger text-dark">Jadwal petugas tidak boleh bentrok</span>');
                redirect('Surat_tugas/add_spt');
            }
        }

        $data = [
            'no_surat' => $no_surat,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'tgl_spt' => $tgl_spt,
            'dasarDIPA' => $dasarDIPA,
            'dasarKS' => $dasarKS,
            'sumber_dana' => $sumber_dana,
            'dari_tanggal' => $startDate,
            'sampai_tanggal' => $endDate,
            'mengetahui' => $mengetahui,
            'jabatan_mengetahui' => $jabatan_mengetahui,
            'mengetahui2' => $mengetahui2,
            'jabatan_mengetahui2' => $jabatan_mengetahui2,
            'nama_kegiatan_surat' => $nama_kegiatan_surat,
            'kegiatan' => $kegiatan,
            'sasaran' => $sasaran,
            'indikator' => $indikator,
            'rincian_output' => $rincian_output,
            'kategori_spt' => $kategori_spt,
            'created_at' => date('Y-m-d H:i:s'),
            'user_input' => $_SESSION['username']
        ];

        $this->db->insert('surat', $data);
        $id_surat = $this->db->insert_id();

        //Rincian tgl pelaksanaan
        $rincian_tgl = $this->createDateRangeArray($startDate, $endDate);
        for ($i = 0; $i < COUNT($rincian_tgl); $i++) {
            $dataTanggal = [
                'id_surat' => $id_surat,
                'tanggal' => $rincian_tgl[$i],
            ];
            $this->db->insert('tgl_pelaksanaan', $dataTanggal);
        }

        //Rincian petugas
        for ($i = 0; $i < COUNT($petugas); $i++) {

            $dataPegawai = [
                'id_surat' => $id_surat,
                'id_pegawai' => $petugas[$i],
            ];
            $this->db->insert('pegawai_tugas', $dataPegawai);
        }
        redirect('Surat_tugas/edit_spt/' . $id_surat);
    }

    public function cek_petugas()
    {
        $this->load->helper('MY_tanggal');
        $startDate = $this->input->post('startDate');
        $endDate = $this->input->post('endDate');
        $petugas = $this->input->post('petugas');
        // $startDate = '2022-03-27';
        // $endDate = '2022-03-31';
        // $allDates = implode(",", $this->createDateRangeArray($startDate, $endDate));
        // $petugas = 2;

        $cek = $this->db->query('SELECT * FROM tgl_pelaksanaan tp JOIN surat ON surat.id_surat=tp.id_surat JOIN pegawai_tugas pt ON pt.id_surat=surat.id_surat JOIN pegawai ON pegawai.id_pegawai=pt.id_pegawai JOIN kegiatan ON kegiatan.id_kegiatan=surat.kegiatan WHERE tp.tanggal BETWEEN "' . $startDate . '" AND "' . $endDate . '" AND pt.id_pegawai=' . $petugas . '')->result();

        if ($cek) {
            foreach ($cek as $data) {
                $tgl[] = $data->tanggal;
                $kegiatan[] = $data->nama_kegiatan_surat;
            }
            echo '<span class="badge bg-danger mt-1" style="text-align:left">' . $cek[0]->nama . ' ada kegiatan ' . implode(", ", $kegiatan) . '<br> pada tanggal ' . implode(", ", $tgl) . '</span>';
        } else {
            echo '';
        }
        // echo "<pre>";
        // print_r($tgl);
        // echo "</pre>";
    }

    public function cetak_surat($id_surat = null, $denganTTD = null)
    {
        $data['title'] = 'Surat Perintah Tugas';
        if ($id_surat != null) {
            $id = $id_surat;
        } else {
            $id = $this->input->post('id_surat');
        }

        if ($denganTTD != null) {
            $data['denganTTD'] = $denganTTD;
        } else {
            $data['denganTTD'] = $this->input->post('denganTTD');
        }
        $data['surat'] = $this->M_surat_tugas->surat_tugas($id);
        $data['pegawaiTugas'] = $this->M_surat_tugas->pegawai_tugas($id);
        //var_dump(($data['pegawaiTugas']));
        $this->load->view('surat/cetak_surat', $data);
    }

    public function proses_uploadSurat()
    {
        $id_surat = $this->input->post('id_surat');
        $get_fileSurat = $this->db->query('SELECT file_surat FROM surat WHERE id_surat=' . $id_surat)->row();
        if (!empty($get_fileSurat->file_surat)) {
            unlink("./assets/uploads/surat_tugas/$get_fileSurat->file_surat");
        }

        if (!empty($_FILES['file_surat']['name'])) {
            //Pengecekan ukuran file
            if ($_FILES['file_surat']['size'] > 1485760) { // 1MB 
                $this->session->set_flashdata('message', '<span class="badge bg-danger text-dark">Ukuran file max 1MB</span>');
                var_dump($_FILES['file_surat']['size']);
                redirect('Surat_tugas');
            }

            //Pengecekan extensi file jika benar maka lolos untuk diproses
            $ext = substr(strrchr($_FILES['file_surat']['name'], '.'), 1);
            if ($ext == 'pdf' || $ext == 'doc' || $ext == 'docx' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') {
                $upload = $this->_do_upload();
                $data['file_surat'] = $upload['file_name'];

                // Simpan datanya ke database
                $data = array('file_surat' => $data['file_surat']);
                $this->db->update('surat', $data, ['id_surat' => $id_surat]);
            } else {
                $this->session->set_flashdata('message', '<span class="badge bg-danger text-dark">Ekstensi file harus berupa pdf/doc/docx/jpg/jpeg/png</span>');
                redirect('Surat_tugas');
            }
        } else {
            $data['file_surat'] = "";
        }
        redirect('Surat_tugas');
    }

    private function _do_upload()
    {
        $config['upload_path']      = './assets/uploads/surat_tugas/';
        $config['allowed_types']    = 'jpeg|jpg|png|pdf|doc|docx';
        $config['max_size']             = 3048;
        $config['overwrite']            = true;
        $config['file_name']            = uniqid();

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('file_surat')) {
            $this->session->set_flashdata('message', '<span class="badge bg-danger text-dark">Harap periksa eksistensi file/ukuran file</span>');
            redirect('Surat_tugas');
        }
        return $this->upload->data();
    }

    public function proses_deleteSurat()
    {
        $id_surat = $this->input->post('id_surat');

        //Hapus file lebih dulu
        $get_fileSurat = $this->db->query('SELECT file_surat FROM surat WHERE id_surat=' . $id_surat)->row();
        if (!empty($get_fileSurat->file_surat)) {
            unlink("./assets/uploads/surat_tugas/$get_fileSurat->file_surat");
        }

        //Hapus data di tabel
        $hapus = $this->db->delete('surat', ['id_surat' => $id_surat]);
        $this->db->delete('pegawai_tugas', ['id_surat' => $id_surat]);
        $this->db->delete('tgl_pelaksanaan', ['id_surat' => $id_surat]);
        if ($hapus) {
            $this->session->set_flashdata('message', '<span class="badge bg-success">Surat berhasil dihapus</span>');
        } else {
            $this->session->set_flashdata('message', '<span class="badge bg-danger">Surat gagal dihapus</span>');
        }
        redirect('Surat_tugas');
    }

    public function proses_deleteUpload_surat()
    {
        $id_surat = $this->input->post('id_surat');

        //Hapus file lebih dulu
        $get_fileSurat = $this->db->query('SELECT file_surat FROM surat WHERE id_surat=' . $id_surat)->row();
        if (!empty($get_fileSurat->file_surat)) {
            unlink("./assets/uploads/surat_tugas/$get_fileSurat->file_surat");
        }

        //Update file surat menjadi kosong
        $data = ['file_surat' => ''];
        $update = $this->db->update('surat', $data, ['id_surat' => $id_surat]);
        if ($update) {
            $this->session->set_flashdata('message', '<span class="badge bg-success">Upload surat berhasil dihapus</span>');
        } else {
            $this->session->set_flashdata('message', '<span class="badge bg-danger">Upload surat gagal dihapus</span>');
        }
        redirect('Surat_tugas');
    }

    public function edit_spt($id_surat)
    {
        $data['title'] = 'Surat Perintah Tugas';
        $data['kegiatan'] = $this->db->get_where('kegiatan', ['tahun' => date('Y')])->result();
        $data['pegawai'] = $this->db->get_where('pegawai')->result();
        $data['mengetahui'] = $this->db->query('SELECT * FROM mengetahui JOIN pegawai ON mengetahui.id_pegawai=pegawai.id_pegawai')->result();
        $data['dasarDIPA'] = $this->db->get_where('dasar_surat', ['kategori' => 'DIPA'])->result();
        $data['dasarKS'] = $this->db->get_where('dasar_surat', ['kategori' => 'Kerja sama'])->result();
        $data['sumberDana'] = $this->db->get('sumber_dana')->result();
        $data['kategoriSPT'] = $this->db->get('kategori_spt')->result();
        $data['jabatanMengetahui'] = $this->db->get('jabatan_mengetahui')->result();

        $data['surat'] = $this->M_surat_tugas->surat_tugas($id_surat);
        $data['pegawaiTugas'] = $this->M_surat_tugas->pegawai_tugas($id_surat);
        $data['tglPelaksanaan'] = $this->db->get_where('tgl_pelaksanaan', ['id_surat' => $id_surat])->result();
        $this->load->view('surat/edit_spt', $data);
    }

    public function proses_editSPT()
    {
        $id_surat = $this->input->post('id_surat');

        //Cek petugas jika ada id yang sama dalam satu surat
        $petugas = $this->input->post('petugas');
        $count_array = array_count_values($petugas);
        foreach ($count_array as $data) {
            if ($data > 1) {
                $this->session->set_flashdata('msg', '<span class="badge bg-danger text-dark">Ada duplikasi data petugas</span>');
                redirect('Surat_tugas/edit_spt/' . $id_surat);
            }
        }

        $no_surat = $this->input->post('no_surat');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $tgl_spt = $this->input->post('tgl_spt');
        $dasarDIPA = $this->input->post('dasarDIPA');
        $dasarKS = $this->input->post('dasarKS');
        $sumber_dana = $this->input->post('sumber_dana');
        $startDate = $this->input->post('startDate');
        $endDate = $this->input->post('endDate');
        $mengetahui = $this->input->post('mengetahui');
        $jabatan_mengetahui = $this->input->post('jabatan_mengetahui');
        $mengetahui2 = $this->input->post('mengetahui2');
        $jabatan_mengetahui2 = $this->input->post('jabatan_mengetahui2');

        $nama_kegiatan_surat = $this->input->post('nama_kegiatan_surat');
        $kegiatan = $this->input->post('kegiatan');

        $sasaranBaru = $this->input->post('sasaran');
        $sasaranEdit = $this->input->post('sasaranEdit');
        if (!empty($sasaranBaru)) {
            $sasaran = $sasaranBaru;
        } else {
            $sasaran = $sasaranEdit;
        }

        $indikatorBaru = $this->input->post('indikator');
        $indikatorEdit = $this->input->post('indikatorEdit');
        if (!empty($indikatorBaru)) {
            $indikator = $indikatorBaru;
        } else {
            $indikator = $indikatorEdit;
        }

        $rincian_outputBaru = $this->input->post('rincian_output');
        $rincian_outputEdit = $this->input->post('rincian_outputEdit');
        if (!empty($rincian_outputBaru)) {
            $rincian_output = $rincian_outputBaru;
        } else {
            $rincian_output = $rincian_outputEdit;
        }
        $kategori_spt = $this->input->post('kategori_spt');

        if (empty($kegiatan)) {
            $this->session->set_flashdata('msg', '<span class="badge bg-danger text-dark">Kegiatan tidak boleh kosong</span>');
            redirect('Surat_tugas/edit_spt/' . $id_surat);
        }

        // Cek petugas
        //$petugas = $this->input->post('petugas');
        // for ($i = 0; $i < COUNT($petugas); $i++) {
        //     $cek = $this->db->query('SELECT * FROM tgl_pelaksanaan tp JOIN surat ON surat.id_surat=tp.id_surat JOIN pegawai_tugas pt ON pt.id_surat=surat.id_surat JOIN pegawai ON pegawai.id_pegawai=pt.id_pegawai JOIN kegiatan ON kegiatan.id_kegiatan=surat.kegiatan WHERE tp.tanggal BETWEEN "' . $startDate . '" AND "' . $endDate . '" AND pt.id_pegawai=' . $petugas[$i] . '')->result();
        //     if (!empty($cek)) {
        //         $this->session->set_flashdata('msg', '<span class="badge bg-danger text-dark">Jadwal petugas tidak boleh bentrok</span>');
        //         redirect('Surat_tugas/edit_spt/' . $id_surat);
        //     }
        // }

        $data = [
            'no_surat' => $no_surat,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'tgl_spt' => $tgl_spt,
            'dasarDIPA' => $dasarDIPA,
            'dasarKS' => $dasarKS,
            'sumber_dana' => $sumber_dana,
            'dari_tanggal' => $startDate,
            'sampai_tanggal' => $endDate,
            'mengetahui' => $mengetahui,
            'jabatan_mengetahui' => $jabatan_mengetahui,
            'mengetahui2' => $mengetahui2,
            'jabatan_mengetahui2' => $jabatan_mengetahui2,
            'nama_kegiatan_surat' => $nama_kegiatan_surat,
            'kegiatan' => $kegiatan,
            'sasaran' => $sasaran,
            'indikator' => $indikator,
            'rincian_output' => $rincian_output,
            'kategori_spt' => $kategori_spt,
            'modified_at' => date('Y-m-d H:i:s'),
            'user_input' => $_SESSION['username']
        ];
        $this->db->update('surat', $data, ['id_surat' => $id_surat]);

        //Rincian tgl pelaksanaan
        $rincian_tgl = $this->createDateRangeArray($startDate, $endDate);
        //Delete tgl pelaksanaan lebih dulu
        $this->db->delete('tgl_pelaksanaan', ['id_surat' => $id_surat]);
        for ($i = 0; $i < COUNT($rincian_tgl); $i++) {
            $dataTanggal = [
                'id_surat' => $id_surat,
                'tanggal' => $rincian_tgl[$i],
            ];
            $this->db->insert('tgl_pelaksanaan', $dataTanggal);
        }

        //Delete pegawai tugas lebih dulu
        $this->db->delete('pegawai_tugas', ['id_surat' => $id_surat]);
        for ($i = 0; $i < COUNT($petugas); $i++) {

            $dataPegawai = [
                'id_surat' => $id_surat,
                'id_pegawai' => $petugas[$i],
            ];
            $this->db->insert('pegawai_tugas', $dataPegawai);
        }
        redirect('Surat_tugas/edit_spt/' . $id_surat);
    }

    function createDateRangeArray($strDateFrom, $strDateTo)
    {
        // takes two dates formatted as YYYY-MM-DD and creates an
        // inclusive array of the dates between the from and to dates.

        // could test validity of dates here but I'm already doing
        // that in the main script

        $aryRange = [];

        $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
        $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));

        if ($iDateTo >= $iDateFrom) {
            array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
            while ($iDateFrom < $iDateTo) {
                $iDateFrom += 86400; // add 24 hours
                array_push($aryRange, date('Y-m-d', $iDateFrom));
            }
        }
        return $aryRange;
    }

    public function proses_ubah_status()
    {
        $id_surat = $this->input->post('id_surat');
        $data = [
            'status_pelaksanaan' => 'Selesai'
        ];
        $update = $this->db->update('surat', $data, ['id_surat' => $id_surat]);
        if ($update) {
            $this->session->set_flashdata('message', '<span class="badge bg-success">Status surat berhasil diubah</span>');
        } else {
            $this->session->set_flashdata('message', '<span class="badge bg-danger">Status surat gagal diubah</span>');
        }
        redirect('Surat_tugas');
    }

    public function tambah_linkDokumentasi()
    {
        $id_surat = $this->input->post('id_surat');
        $link_dokumentasi = $this->input->post('link_dokumentasi');

        $data = [
            'link_dokumentasi' => $link_dokumentasi
        ];
        $update = $this->db->update('surat', $data, ['id_surat' => $id_surat]);
        if ($update) {
            $this->session->set_flashdata('message', '<span class="badge bg-success">Link Dokumentasi berhasil diupdate</span>');
        } else {
            $this->session->set_flashdata('message', '<span class="badge bg-danger">Link Dokumentasi gagal diupdate</span>');
        }
        redirect('Surat_tugas');
    }

    public function tambah_linkLaporan()
    {
        $id_surat = $this->input->post('id_surat');
        $link_laporan = $this->input->post('link_laporan');

        $data = [
            'link_laporan' => $link_laporan
        ];
        $update = $this->db->update('surat', $data, ['id_surat' => $id_surat]);
        if ($update) {
            $this->session->set_flashdata('message', '<span class="badge bg-success">Link Laporan berhasil diupdate</span>');
        } else {
            $this->session->set_flashdata('message', '<span class="badge bg-danger">Link Laporan gagal diupdate</span>');
        }
        redirect('Surat_tugas');
    }

    public function showPegawaiTugas()
    {
        $this->load->helper('MY_tanggal');
        $id_surat = $this->input->post('id');
        $pegawai = $this->db->query('SELECT pt.id_pegawai,nama FROM pegawai_tugas pt JOIN pegawai ON pegawai.id_pegawai=pt.id_pegawai WHERE pt.id_surat=' . $id_surat)->result();

        if (isset($pegawai)) {
            foreach ($pegawai as $key) {
                echo $key->nama . "<br/>";
            }
        }
    }

    public function generatePdf_spt($data, $fileName)
    {
        $this->load->helper('MY_tanggal');
        $this->load->library('pdfgenerator');

        // title dari pdf
        // $this->data['title_pdf'] = 'SPT';
        $data['title_pdf'] = $fileName;

        // filename dari pdf ketika didownload
        $file_pdf = $fileName;
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "landscape";

        $html = $this->load->view('surat/download_pdf_spt', $data, true);
        // run dompdf
        $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }

    function ubahBulan($bulan)
    {
        $bulanIndonesia = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];

        return $bulanIndonesia[$bulan];
    }
}
