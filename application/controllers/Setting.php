<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != "is_login") {
            redirect(base_url("Auth"));
        }

        // $this->load->model('M_setting');
    }

    public function background_login()
    {
        $data = [
            'title' => 'Background Login',
            'background' => $this->db->get('background')->result()
        ];
        // var_dump($data['background']->bg1);
        $this->load->view('setting/background_login', $data);
    }


    public function proses_updateBackground()
    {
        $data = [];

        $no = 1;
        $count = count($_FILES['files']['name']);
        // print_r($_FILES['files']['name']);
        for ($i = 0; $i < $count; $i++) {

            if (!empty($_FILES['files']['name'][$i])) {

                $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                $_FILES['file']['size'] = $_FILES['files']['size'][$i];

                $config['upload_path'] = './assets/uploads/background/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size'] = '2046';
                // $config['file_name'] = $_FILES['files']['name'][$i];
                $config['file_name'] = uniqid();

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file')) {
                    $uploadData = $this->upload->data();
                    $filename = $uploadData['file_name'];

                    $data['totalFiles'][] = $filename;
                }

                $dataBg = array(
                    'bg' => $data['totalFiles'][$i]
                );
                $this->db->insert('background', $dataBg);
            }
        }
        redirect('Setting/background_login');
    }

    function hapusBg($id)
    {
        //Get nama filenya
        $dataBg = $this->db->get_where('background', ['id' => $id])->row();
        // print_r($dataBg);
        if (isset($dataBg)) {
            unlink('assets/uploads/background/' . $dataBg->bg);
        }
        $this->db->delete('background', ['id' => $id]);
        redirect('Setting/background_login');
    }

    // private function _do_upload()
    // {
    //     $config['upload_path']      = './assets/uploads/background/';
    //     $config['allowed_types']    = 'jpeg|jpg|png';
    //     $config['max_size']             = 5048;
    //     $config['overwrite']            = true;
    //     $config['file_name']            = uniqid();

    //     $this->load->library('upload', $config);
    //     if (!$this->upload->do_upload('bg1')) {
    //         // $this->session->set_flashdata('msg', '<span class="badge bg-danger text-dark">Harap periksa eksistensi file/ukuran file</span>');
    //         $this->session->set_flashdata('msg', $this->upload->display_errors('', ''));
    //         redirect('Setting/background_login');
    //     }
    //     return $this->upload->data();
    // }
}
