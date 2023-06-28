<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('M_auth');
        $this->CI = &get_instance();
    }

    function index()
    {
        $tahun = $this->input->post('tahun');
        $data['tahunSelected'] = isset($tahun) ? $tahun : date('Y');
        $data['tahun'] = $this->db->query('SELECT tahun FROM surat GROUP BY tahun')->result();
        $data['totSPT'] = $this->db->get_where('surat', ['tahun' => $data['tahunSelected']])->num_rows();
        $data['PK'] = $this->db->query('SELECT nama_kegiatan,COUNT(surat.kegiatan) AS jmlPK FROM surat JOIN kegiatan ON kegiatan.id_kegiatan=surat.kegiatan WHERE surat.tahun="' . $data['tahunSelected'] . '" GROUP BY surat.kegiatan')->result();
        $data['background'] = $this->db->get('background')->result();
        //var_dump($tahun);
        $this->load->view('auth/login', $data);
    }

    function login_authentication()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $cekUser = $this->db->get_where('user', ['username' => $username])->row();

        if ($cekUser) {
            $pass = $cekUser->password;
            $verify_pass = password_verify($password, $pass);
            if ($verify_pass) {
                $data_session = array(
                    'id_user' => $cekUser->id,
                    'username' => $username,
                    'level' => $cekUser->level,
                    'status' => "is_login",
                );
                $this->M_auth->update_last_login($cekUser->id);
                $this->session->set_userdata($data_session);
                redirect('Surat_tugas');
            } else {
                $this->CI->session->set_flashdata('msg', 'Password salah !');
                redirect('Auth', 'refresh');
            }
        } else {
            $this->CI->session->set_flashdata('msg', 'Username tidak ditemukan !');
            redirect('Auth', 'refresh');
        }
    }

    function logout()
    {
        $this->session->sess_destroy();
        redirect('Auth', 'refresh');
    }
}
