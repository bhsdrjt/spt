<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_master extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != "is_login") {
            redirect(base_url("Auth"));
        }
        $this->load->model('M_data_master');
    }

    public function user()
    {
        $data = [
            'title' => 'Data User',
            'user' => $this->db->get('user')->result()
        ];
        $this->load->view('data_master/user', $data);
    }

    public function proses_addUser()
    {
        $username = $this->input->post('username');
        $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        $level = $this->input->post('level');

        $data = ['username' => $username, 'password' => $password, 'level' => $level, 'created_at' => date('Y-m-d H:i:s')];
        $simpan = $this->db->insert('user', $data);
        if ($simpan) {
            $this->session->set_flashdata('msg', '<div class="badge bg-success">Data user ditambahkan</div>');
        } else {
            $this->session->set_flashdata('msg', '<div class="badge bg-warning">Data user gagal ditambahkan</div>');
        }
        redirect('Data_master/user');
    }

    public function proses_editUser()
    {
        $id_user = $this->input->post('id_user');
        $username = $this->input->post('username');
        $level = $this->input->post('level');
        $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

        $data = ['username' => $username, 'password' => $password, 'level' => $level, 'modified_at' => date('Y-m-d H:i:s')];
        $edit = $this->db->update('user', $data, ['id' => $id_user]);
        if ($edit) {
            $this->session->set_flashdata('msg', '<div class="badge bg-success">Data user diupdate</div>');
        } else {
            $this->session->set_flashdata('msg', '<div class="badge bg-warning">Data user gagal diupdate</div>');
        }
        redirect('Data_master/user');
    }

    public function proses_deleteUser()
    {
        $id_user = $this->input->post('id_user');
        $hapus = $this->db->delete('user', ['id' => $id_user]);
        if ($hapus) {
            $this->session->set_flashdata('msg', '<div class="badge bg-success">Data user dihapus</div>');
        } else {
            $this->session->set_flashdata('msg', '<div class="badge bg-warning">Data user gagal dihapus</div>');
        }
        redirect('Data_master/user');
    }

    public function pegawai()
    {
        $data = [
            'title' => 'Data Pegawai',
            'pegawai' => $this->db->get('pegawai')->result()
        ];
        $this->load->view('data_master/pegawai', $data);
    }

    public function proses_addPegawai()
    {
        $nama = $this->input->post('nama');
        $nip = $this->input->post('nip');
        $golongan = $this->input->post('golongan');
        $pangkat = $this->input->post('pangkat');
        $jabatan = $this->input->post('jabatan');
        $statusPegawai = $this->input->post('statusPegawai');
        $penempatan = $this->input->post('penempatan');
        $tipe_pegawai = $this->input->post('tipe_pegawai');

        $data = [
            'nama' => $nama,
            'nip' => $nip,
            'golongan' => $golongan,
            'pangkat' => $pangkat,
            'jabatan' => $jabatan,
            'status_pegawai' => $statusPegawai,
            'penempatan' => $penempatan,
            'tipe_pegawai' => $tipe_pegawai,
            'created_at' => date('Y-m-d H:i:s'),
            'user_input' => $_SESSION['username'],
            // 'status_aktif' => 1
        ];
        // var_dump($data);exit;
        $simpan = $this->db->insert('pegawai', $data);
        $id_pegawai = $this->db->insert_id();

        if (!empty($_FILES['image_ttd']['name'])) {
            //Pengecekan ukuran file
            if ($_FILES['image_ttd']['size'] > 1048576) { // 1MB 
                $this->session->set_flashdata('msg', '<span class="badge bg-danger text-dark">Ukuran file max 1MB</span>');
                redirect('Data_master/pegawai');
            }

            //Pengecekan extensi file jika benar maka lolos untuk diproses
            $ext = substr(strrchr($_FILES['image_ttd']['name'], '.'), 1);
            if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') {
                $upload = $this->_do_uploadPegawai();
                $data['image_ttd'] = $upload['file_name'];

                // Simpan datanya ke database
                $data = array('image_ttd' => $data['image_ttd']);
                $this->db->update('pegawai', $data, ['id_pegawai' => $id_pegawai]);
            } else {
                $this->session->set_flashdata('msg', '<span class="badge bg-danger text-dark">Ekstensi file harus berupa jpg/jpeg/png</span>');
                redirect('Data_master/pegawai');
            }
        }

        if ($simpan) {
            $this->session->set_flashdata('msg', '<div class="badge bg-success">Data pegawai ditambahkan</div>');
        } else {
            $this->session->set_flashdata('msg', '<div class="badge bg-warning">Data pegawai gagal ditambahkan</div>');
        }
        redirect('Data_master/pegawai');
    }

    public function proses_editPegawai()
    {
        $id_pegawai = $this->input->post('id_pegawai');
        $nama = $this->input->post('nama');
        $nip = $this->input->post('nip');
        $golongan = $this->input->post('golongan');
        $pangkat = $this->input->post('pangkat');
        $jabatan = $this->input->post('jabatan');
        $statusPegawai = $this->input->post('statusPegawai');
        $penempatan = $this->input->post('penempatan');
        $ttd_lama = $this->input->post('ttd_lama');
        $tipe_pegawai = $this->input->post('tipe_pegawai');

        if (!empty($_FILES['image_ttd']['name'])) {
            //Pengecekan ukuran file
            if ($_FILES['image_ttd']['size'] > 1048576) { // 1MB 
                $this->session->set_flashdata('msg', '<span class="badge bg-danger text-dark">Ukuran file max 1MB</span>');
                redirect('Data_master/pegawai');
            }

            //Pengecekan extensi file jika benar maka lolos untuk diproses
            $ext = substr(strrchr($_FILES['image_ttd']['name'], '.'), 1);
            if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') {
                $upload = $this->_do_uploadPegawai();
                $data['image_ttd'] = $upload['file_name'];
            } else {
                $this->session->set_flashdata('msg', '<span class="badge bg-danger text-dark">Ekstensi file harus berupa jpg/jpeg/png</span>');
                redirect('Data_master/pegawai');
            }
        } else {
            $data['image_ttd'] = $ttd_lama;
        }

        $data = [
            'nama' => $nama,
            'nip' => $nip,
            'golongan' => $golongan,
            'pangkat' => $pangkat,
            'jabatan' => $jabatan,
            'status_pegawai' => $statusPegawai,
            'penempatan' => $penempatan,
            'tipe_pegawai' => $tipe_pegawai,
            'image_ttd' => $data['image_ttd'],
            'modified_at' => date('Y-m-d H:i:s'),
            'user_input' => $_SESSION['username'],
            // 'status_aktif' => $this->input->post('status_aktif')
            
        ];
        // var_dump($data);exit;
        $edit = $this->db->update('pegawai', $data, ['id_pegawai' => $id_pegawai]);
        if ($edit) {
            $this->session->set_flashdata('msg', '<div class="badge bg-success">Data pegawai diupdate</div>');
        } else {
            $this->session->set_flashdata('msg', '<div class="badge bg-warning">Data pegawai gagal diupdate</div>');
        }
        redirect('Data_master/pegawai');
    }

    public function proses_deletePegawai()
    {
        $id_pegawai = $this->input->post('id_pegawai');
        $get_fileTTD = $this->db->query('SELECT image_ttd FROM pegawai WHERE id_pegawai=' . $id_pegawai)->row();
        if (!empty($get_fileTTD->image_ttd)) {
            unlink("./assets/uploads/tanda_tangan/$get_fileTTD->image_ttd");
        }

        $hapus = $this->db->delete('pegawai', ['id_pegawai' => $id_pegawai]);
        if ($hapus) {
            $this->session->set_flashdata('msg', '<div class="badge bg-success">Data pegawai dihapus</div>');
        } else {
            $this->session->set_flashdata('msg', '<div class="badge bg-warning">Data pegawai gagal dihapus</div>');
        }
        redirect('Data_master/pegawai');
    }

    public function perjanjian_kinerja()
    {
        $data['title'] = 'Data Perjanjian Kinerja';
        $tahun = $this->input->post('tahun');
        if (isset($tahun)) {
            $tahunActive = $tahun;
        } else {
            $tahunActive = date('Y');
        };
        $data['tahunActive'] = $tahunActive;
        $data['tahunTersedia'] = $this->db->query('SELECT tahun FROM kegiatan GROUP BY tahun')->result();
        $data['pk'] = $this->M_data_master->perjanjian_kinerja($tahunActive);
        $this->load->view('data_master/perjanjian_kinerja', $data);
    }

    public function proses_addKegiatan()
    {
        $tahunKegiatan = $this->input->post('tahunKegiatan');
        $kegiatan = $this->input->post('kegiatan');
        $data = [
            'nama_kegiatan' => $kegiatan,
            'tahun' => $tahunKegiatan,
            'created_at' => date('Y-m-d H:i:s'),
            'user_input' => $_SESSION['username']
        ];
        $this->db->insert('kegiatan', $data);
        redirect('Data_master/perjanjian_kinerja');
    }

    public function proses_editKegiatan()
    {
        $id_kegiatan = $this->input->post('id_kegiatan');
        $tahunKegiatan = $this->input->post('tahunKegiatan');
        $kegiatan = $this->input->post('kegiatan');
        $data = [
            'nama_kegiatan' => $kegiatan,
            'tahun' => $tahunKegiatan,
            'modified_at' => date('Y-m-d H:i:s'),
            'user_input' => $_SESSION['username']
        ];
        $this->db->update('kegiatan', $data, ['id_kegiatan' => $id_kegiatan]);
        redirect('Data_master/perjanjian_kinerja');
    }

    public function proses_deleteKegiatan()
    {
        $id_kegiatan = $this->input->post('id_kegiatan');
        //Hapus ditabel kegiatan
        $this->db->delete('kegiatan', ['id_kegiatan' => $id_kegiatan]);

        //Hapus ditabel sasaran
        $this->db->delete('sasaran', ['id_kegiatan' => $id_kegiatan]);

        //Hapus ditabel kegiatan
        $this->db->delete('indikator', ['id_kegiatan' => $id_kegiatan]);

        //Hapus ditabel ro
        $this->db->delete('ro', ['id_kegiatan' => $id_kegiatan]);
        redirect('Data_master/perjanjian_kinerja');
    }

    public function detail_kegiatan($id)
    {
        $data = [
            'title' => 'Data Perjanjian Kinerja',
            'kegiatan' => $this->db->get_where('kegiatan', ['id_kegiatan' => $id])->row(), //Get data kegiatan
            'sasaran' => $this->db->get_where('sasaran', ['id_kegiatan' => $id])->result()
        ];
        $this->load->view('data_master/detail_kegiatan', $data);
    }

    public function proses_addSasaran()
    {
        $id_kegiatan = $this->input->post('id_kegiatan');
        $sasaran = $this->input->post('sasaran');
        $data = [
            'id_kegiatan' => $id_kegiatan,
            'nama_sasaran' => $sasaran,
            'created_at' => date('Y-m-d H:i:s'),
            'user_input' => $_SESSION['username']
        ];
        $this->db->insert('sasaran', $data);
        redirect('Data_master/detail_kegiatan/' . $id_kegiatan);
    }

    public function proses_editSasaran()
    {
        $id_kegiatan = $this->input->post('id_kegiatan');
        $id_sasaran = $this->input->post('id_sasaran');
        $sasaran = $this->input->post('sasaran');
        $data = [
            'nama_sasaran' => $sasaran,
            'modified_at' => date('Y-m-d H:i:s'),
            'user_input' => $_SESSION['username']
        ];
        $this->db->update('sasaran', $data, ['id_sasaran' => $id_sasaran]);
        redirect('Data_master/detail_kegiatan/' . $id_kegiatan);
    }

    public function proses_deleteSasaran()
    {
        $id_kegiatan = $this->input->post('id_kegiatan');
        $id_sasaran = $this->input->post('id_sasaran');

        //Hapus ditabel sasaran
        $this->db->delete('sasaran', ['id_sasaran' => $id_sasaran]);

        //Hapus ditabel indikator
        $this->db->delete('indikator', ['id_sasaran' => $id_sasaran]);

        //Hapus ditabel ro
        $this->db->delete('ro', ['id_sasaran' => $id_sasaran]);
        redirect('Data_master/detail_kegiatan/' . $id_kegiatan);
    }

    public function proses_addIndikator()
    {
        $id_kegiatan = $this->input->post('id_kegiatan');
        $id_sasaran = $this->input->post('id_sasaran');
        $indikator = $this->input->post('indikator');
        $data = [
            'id_kegiatan' => $id_kegiatan,
            'id_sasaran' => $id_sasaran,
            'nama_indikator' => $indikator,
            'created_at' => date('Y-m-d H:i:s'),
            'user_input' => $_SESSION['username']
        ];
        $this->db->insert('indikator', $data);
        redirect('Data_master/detail_kegiatan/' . $id_kegiatan);
    }

    public function proses_editIndikator()
    {
        $id_kegiatan = $this->input->post('id_kegiatan');
        $id_indikator = $this->input->post('id_indikator');
        $indikator = $this->input->post('indikator');
        $data = [
            'nama_indikator' => $indikator,
            'modified_at' => date('Y-m-d H:i:s'),
            'user_input' => $_SESSION['username']
        ];
        $this->db->update('indikator', $data, ['id_indikator' => $id_indikator]);
        redirect('Data_master/detail_kegiatan/' . $id_kegiatan);
    }

    public function proses_deleteIndikator()
    {
        $id_kegiatan = $this->input->post('id_kegiatan');
        $id_indikator = $this->input->post('id_indikator');

        //Hapus ditabel indikator
        $this->db->delete('indikator', ['id_indikator' => $id_indikator]);

        //Hapus ditabel ro
        $this->db->delete('ro', ['id_indikator' => $id_indikator]);
        redirect('Data_master/detail_kegiatan/' . $id_kegiatan);
    }

    public function proses_addRO()
    {
        $id_kegiatan = $this->input->post('id_kegiatan');
        $id_sasaran = $this->input->post('id_sasaran');
        $id_indikator = $this->input->post('id_indikator');
        $rincian_output = $this->input->post('rincian_output');
        $data = [
            'id_kegiatan' => $id_kegiatan,
            'id_sasaran' => $id_sasaran,
            'id_indikator' => $id_indikator,
            'nama_ro' => $rincian_output,
            'created_at' => date('Y-m-d H:i:s'),
            'user_input' => $_SESSION['username']
        ];
        $this->db->insert('ro', $data);
        redirect('Data_master/detail_kegiatan/' . $id_kegiatan);
    }

    public function proses_editRO()
    {
        $id_kegiatan = $this->input->post('id_kegiatan');
        $id_RO = $this->input->post('id_RO');
        $nama_RO = $this->input->post('nama_RO');

        $data = [
            'nama_ro' => $nama_RO,
            'modified_at' => date('Y-m-d H:i:s'),
            'user_input' => $_SESSION['username']
        ];
        $this->db->update('ro', $data, ['id_ro' => $id_RO]);
        redirect('Data_master/detail_kegiatan/' . $id_kegiatan);
    }

    public function proses_deleteRO()
    {
        $id_kegiatan = $this->input->post('id_kegiatan');
        $id_RO = $this->input->post('id_RO');

        //Hapus ditabel ro
        $this->db->delete('ro', ['id_ro' => $id_RO]);
        redirect('Data_master/detail_kegiatan/' . $id_kegiatan);
    }

    private function _do_uploadPegawai()
    {
        $config['upload_path']      = './assets/uploads/tanda_tangan/';
        $config['allowed_types']    = 'jpeg|jpg|png|pdf|doc|docx';
        $config['max_size']             = 1048;
        $config['overwrite']            = true;
        $config['file_name']            = uniqid();

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('image_ttd')) {
            $this->session->set_flashdata('msg', '<span class="badge bg-danger text-dark">Harap periksa eksistensi file/ukuran file</span>');
            redirect('Data_master/pegawai');
        }
        return $this->upload->data();
    }

    public function dasar_surat()
    {
        $data = [
            'title' => 'Data Dasar Surat',
            'dasarSurat' => $this->db->get('dasar_surat')->result()
        ];
        $this->load->view('data_master/dasar_surat', $data);
    }

    public function proses_addDasarSurat()
    {
        $dasar = $this->input->post('dasar');
        $kategori = $this->input->post('kategori');
        $tahun = $this->input->post('tahun');

        $data = [
            'dasar' => $dasar,
            'kategori' => $kategori,
            'tahun' => $tahun,
            'created_at' => date('Y-m-d H:i:s'),
            'user_input' => $_SESSION['username']
        ];
        $this->db->insert('dasar_surat', $data);
        redirect('Data_master/dasar_surat');
    }

    public function proses_editDasarSurat()
    {
        $id_surat = $this->input->post('id_dasar');
        $dasar = $this->input->post('dasar');
        $kategori = $this->input->post('kategori');
        $tahun = $this->input->post('tahun');

        $data = [
            'dasar' => $dasar,
            'kategori' => $kategori,
            'tahun' => $tahun,
            'modified_at' => date('Y-m-d H:i:s'),
            'user_input' => $_SESSION['username']
        ];
        $this->db->update('dasar_surat', $data, ['id' => $id_surat]);
        redirect('Data_master/dasar_surat');
    }

    public function proses_deleteDasarSurat()
    {
        $id_surat = $this->input->post('id_dasar');

        $this->db->delete('dasar_surat', ['id' => $id_surat]);
        redirect('Data_master/dasar_surat');
    }

    public function sumber_dana()
    {
        $data = [
            'title' => 'Data Sumber Dana',
            'dana' => $this->db->get('sumber_dana')->result()
        ];
        $this->load->view('data_master/sumber_dana', $data);
    }

    public function proses_addDana()
    {
        $sumber = $this->input->post('sumber');
        $kategori = $this->input->post('kategori');
        $data = [
            'sumber' => $sumber,
            'kategori' => $kategori,
            'created_at' => date('Y-m-d H:i:s'),
            'user_input' => $_SESSION['username']
        ];
        $this->db->insert('sumber_dana', $data);
        redirect('Data_master/sumber_dana');
    }

    public function proses_editDana()
    {
        $id_dana = $this->input->post('id_dana');
        $sumber = $this->input->post('sumber');
        $kategori = $this->input->post('kategori');
        $data = [
            'sumber' => $sumber,
            'kategori' => $kategori,
            'modified_at' => date('Y-m-d H:i:s'),
            'user_input' => $_SESSION['username']
        ];
        $this->db->update('sumber_dana', $data, ['id' => $id_dana]);
        redirect('Data_master/sumber_dana');
    }

    public function proses_deleteDana()
    {
        $id_dana = $this->input->post('id_dana');

        $this->db->delete('sumber_dana', ['id' => $id_dana]);
        redirect('Data_master/sumber_dana');
    }

    public function menimbang()
    {
        $data['title'] = 'Data Menimbang';
        $data['menimbang'] = $this->db->get('menimbang')->row();
        $this->load->view('data_master/menimbang', $data);
    }

    public function updateMenimbang()
    {
        $id = $this->input->post('id');
        $poin_a = $this->input->post('poin_a');
        $poin_b = $this->input->post('poin_b');

        $data = [
            'poin_a' => $poin_a,
            'poin_b' => $poin_b,
        ];
        $update = $this->db->update('menimbang', $data, ['id' => $id]);
        if ($update) {
            $this->session->set_flashdata('msg', '<span class="badge bg-success">Data berhasil diubah</span>');
        } else {
            $this->session->set_flashdata('msg', '<span class="badge bg-danger">Data gagal diubah</span>');
        }
        redirect('Data_master/menimbang');
    }

    public function dasar_surat_poin13()
    {
        $data = [
            'title' => 'Data Dasar Surat',
            'dasarSurat' => $this->db->get('dasar_surat_poin13')->row()
        ];
        $this->load->view('data_master/dasar_surat_poin13', $data);
    }

    public function updateDasar_suratPoin13()
    {
        $id = $this->input->post('id');
        $poin_1 = $this->input->post('poin_1');
        $poin_2 = $this->input->post('poin_2');
        $poin_3 = $this->input->post('poin_3');

        $data = [
            'poin_1' => $poin_1,
            'poin_2' => $poin_2,
            'poin_3' => $poin_3,
        ];
        $update = $this->db->update('dasar_surat_poin13', $data, ['id' => $id]);
        if ($update) {
            $this->session->set_flashdata('msg', '<span class="badge bg-success">Data berhasil diubah</span>');
        } else {
            $this->session->set_flashdata('msg', '<span class="badge bg-danger">Data gagal diubah</span>');
        }
        redirect('Data_master/dasar_surat_poin13');
    }

    public function untuk_poin3()
    {
        $data = [
            'title' => 'Data Untuk',
            'untuk' => $this->db->get('untuk')->row()
        ];
        $this->load->view('data_master/untuk_poin3', $data);
    }

    public function updateUntuk()
    {
        $id = $this->input->post('id');
        $poin_3 = $this->input->post('poin_3');

        $data = [
            'poin_3' => $poin_3,
        ];
        $update = $this->db->update('untuk', $data, ['id' => $id]);
        if ($update) {
            $this->session->set_flashdata('msg', '<span class="badge bg-success">Data berhasil diubah</span>');
        } else {
            $this->session->set_flashdata('msg', '<span class="badge bg-danger">Data gagal diubah</span>');
        }
        redirect('Data_master/untuk_poin3');
    }

    public function mengetahui()
    {
        $data = [
            'title' => 'Data Mengetahui',
            'pegawai' => $this->db->get('pegawai')->result(),
            'kepala_balai' => $this->db->get_where('mengetahui', ['status' => 'Kepala Balai'])->row(),
            'PLH_kepala_balai' => $this->db->get_where('mengetahui', ['status' => 'Plh. Kepala Balai'])->result()
        ];
        $this->load->view('data_master/mengetahui', $data);
    }

    public function updateMengetahui()
    {
        //Kepala Balai
        $kepala_balai = $this->input->post('kepala_balai');
        //Update mengetahui yg statusnya kepala balai
        $kb = ['id_pegawai' => $kepala_balai];
        $this->db->update('mengetahui', $kb, ['status' => 'Kepala Balai']);


        //PLH Kepala Balai
        $PLH_kepala_balai = $this->input->post('PLH_kepala_balai');
        //Hapus PLH kepala balai lalu isi ulang
        $this->db->delete('mengetahui', ['status' => 'Plh. Kepala Balai']);

        for ($i = 0; $i < COUNT($PLH_kepala_balai); $i++) {
            $pkb = ['id_pegawai' => $PLH_kepala_balai[$i], 'status' => 'Plh. Kepala Balai'];
            $this->db->insert('mengetahui', $pkb);
        }
        $this->session->set_flashdata('msg', '<span class="badge bg-success">Data berhasil diubah</span>');
        redirect('Data_master/mengetahui');
    }

    public function kategori_spt()
    {
        $data = [
            'title' => 'Kategori SPT',
            'kategori' => $this->db->get('kategori_spt')->result()
        ];
        $this->load->view('data_master/kategori_spt', $data);
    }

    public function proses_addKategoriSPT()
    {
        $nama_kategori = $this->input->post('nama_kategori');
        $data = [
            'nama_kategori' => $nama_kategori,
            'created_at' => date('Y-m-d H:i:s'),
            'user_input' => $_SESSION['username']
        ];
        $this->db->insert('kategori_spt', $data);
        redirect('Data_master/kategori_spt');
    }

    public function proses_editKategoriSPT()
    {
        $id_kategori_spt = $this->input->post('id_kategori_spt');
        $nama_kategori = $this->input->post('nama_kategori');
        $data = [
            'nama_kategori' => $nama_kategori,
            'modified_at' => date('Y-m-d H:i:s'),
            'user_input' => $_SESSION['username']
        ];
        $this->db->update('kategori_spt', $data, ['id_kategori_spt' => $id_kategori_spt]);
        redirect('Data_master/kategori_spt');
    }

    public function proses_deleteKategoriSPT()
    {
        $id_kategori_spt = $this->input->post('id_kategori_spt');

        $this->db->delete('kategori_spt', ['id_kategori_spt' => $id_kategori_spt]);
        redirect('Data_master/kategori_spt');
    }

    public function jabatan_mengetahui()
    {
        $data = [
            'title' => 'Jabatan Mengetahui',
            'jabatan' => $this->db->get('jabatan_mengetahui')->result()
        ];
        $this->load->view('data_master/jabatan_mengetahui', $data);
    }

    public function proses_add_jabatanMengetahui()
    {
        $nama_jabatan = $this->input->post('nama_jabatan');
        $data = [
            'nama_jabatan' => $nama_jabatan,
            'created_at' => date('Y-m-d H:i:s'),
            'user_input' => $_SESSION['username']
        ];
        $this->db->insert('jabatan_mengetahui', $data);
        redirect('Data_master/jabatan_mengetahui');
    }

    public function proses_edit_jabatanMengetahui()
    {
        $id = $this->input->post('id');
        $nama_jabatan = $this->input->post('nama_jabatan');
        $data = [
            'nama_jabatan' => $nama_jabatan,
            'modified_at' => date('Y-m-d H:i:s'),
            'user_input' => $_SESSION['username']
        ];
        $this->db->update('jabatan_mengetahui', $data, ['id' => $id]);
        redirect('Data_master/jabatan_mengetahui');
    }

    public function proses_delete_jabatanMengetahui()
    {
        $id = $this->input->post('id');

        $this->db->delete('jabatan_mengetahui', ['id' => $id]);
        redirect('Data_master/jabatan_mengetahui');
    }
}
