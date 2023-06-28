<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Statistik extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != "is_login") {
            redirect(base_url("Auth"));
        }
        $this->load->model('M_statistik');
    }

    public function index()
    {
        $this->load->helper('MY_tanggal');
        $bulan = !empty($this->input->post('bulan')) ? $this->input->post('bulan') : date('m');
        $tahun = !empty($this->input->post('tahun')) ? $this->input->post('tahun') : date('Y');
        $opsi = $this->input->post('opsi');
        $penempatan =  $this->input->post('penempatan');
        $data = [
            'title' => 'Data Statistik',
            'bulan' => $bulan,
            'tahun' => $tahun,
            'tahunTersedia' => $this->db->query('SELECT tahun FROM surat GROUP BY tahun')->result(),
        ];

        if (!empty($penempatan)) {
            $data['penempatanSelected'] = $penempatan;
            $data['pegawai'] = $this->db->get_where('pegawai', ['status_pegawai' => 'Pegawai BKSDA', 'penempatan' => $penempatan])->result();
        } else {
            $data['pegawai'] = $this->db->get_where('pegawai', ['status_pegawai' => 'Pegawai BKSDA'])->result();
        }

        if ($opsi == 'print') {
            $data['keterangan'] = $this->input->post('keterangan');
            // echo "<pre>";
            // print_r($data['keterangan']);
            // echo "</pre>";
            $this->load->view('statistik/cetak_statistik', $data);
        } elseif ($opsi == 'exportExcel') {
            $data['keterangan'] = $this->input->post('keterangan');
            $this->load->view('statistik/excel_statistik', $data);
        } else {
            $this->load->view('statistik/data_statistik', $data);
        }
    }

    // public function detail_statistikPegawai($id)
    // {
    //     $this->load->helper('MY_tanggal');
    //     $data = [
    //         'title' => 'Data Statistik',
    //         'pegawai' => $this->db->get_where('pegawai', ['id_pegawai' => $id])->row(),
    //         'detail' => $this->M_statistik->detail_statistikPegawai($id),
    //     ];
    //     // print_r($data['pegawai']);
    //     $this->load->view('statistik/detail_statistikPegawai', $data);
    // }

    public function detail_statistikPegawai($id)
    {
        $pk = $this->input->post('pk');
        $mode = $this->input->post('mode');

        $this->load->helper('MY_tanggal');
        $data['title'] = 'Data Statistik';
        $data['pegawai'] = $this->db->get_where('pegawai', ['id_pegawai' => $id])->row();
        $data['pk'] = $this->db->get('kegiatan')->result();
        $data['pkSelected'] = $pk;
        //print_r($data['pegawai']);

        if ($mode == 'cari') {
            if ($pk == 'Semua') {
                $data['detail'] = $this->M_statistik->detail_statistikPegawai($id, 'Semua');
            } else {
                $data['detail'] = $this->M_statistik->detail_statistikPegawai($id, $pk);
            }
            $this->load->view('statistik/detail_statistikPegawai', $data);
        } elseif ($mode == 'spt_pdf_download') {
            $this->spt_pdf_download($id, $pk);
        } elseif ($mode == 'skp_excel_download') {
            $this->skp_excel_download($id, $pk);
        } else {
            $data['detail'] = $this->M_statistik->detail_statistikPegawai($id, 'Semua');
            $this->load->view('statistik/detail_statistikPegawai', $data);
        }
    }

    public function spt_pdf_download($id, $pk)
    {
        $this->load->helper('MY_tanggal');
        $this->load->library('pdfgenerator');
        $data['pegawai'] = $this->db->get_where('pegawai', ['id_pegawai' => $id])->row();
        if ($pk == 'Semua') {
            $data['detail'] = $this->M_statistik->detail_statistikPegawai($id, 'Semua');
        } else {
            $data['detail'] = $this->M_statistik->detail_statistikPegawai($id, $pk);
        }
        // $data = [
        //     'pegawai' => $this->db->get_where('pegawai', ['id_pegawai' => $id])->row(),
        //     'detail' => $this->M_statistik->detail_statistikPegawai($id)
        // ];

        // title dari pdf
        // $this->data['title_pdf'] = 'SPT';
        $data['title_pdf'] = 'SPT ' . $data['pegawai']->jabatan;

        // filename dari pdf ketika didownload
        $file_pdf = 'SPT_' . $data['pegawai']->jabatan;
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "portrait";

        $html = $this->load->view('statistik/spt_pdf_download', $data, true);
        // run dompdf
        $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }

    public function skp_excel_download($id, $pk)
    {
        $this->load->helper('MY_tanggal');
        $data['pegawai'] = $this->db->get_where('pegawai', ['id_pegawai' => $id])->row();
        if ($pk == 'Semua') {
            $data['detail'] = $this->M_statistik->detail_skpPegawai($id, 'Semua');
        } else {
            $data['detail'] = $this->M_statistik->detail_skpPegawai($id, $pk);
        }
        // $data = [
        //     'pegawai' => $this->db->get_where('pegawai', ['id_pegawai' => $id])->row(),
        //     'detail' => $this->M_statistik->detail_skpPegawai($id)
        // ];
        $this->load->view('statistik/skp_excel_download', $data);
    }

    public function data_surat()
    {
        $this->load->helper('MY_tanggal');
        $id_surat = $this->input->post('id');
        $tanggal = $this->input->post('tanggal');
        $surat = $this->db->get_where('surat', ['id_surat' => $id_surat])->row();

        echo "Kegiatan " . $surat->nama_kegiatan_surat;
        // echo " pada tanggal " . tgl_indo(date('Y-m-d', $tanggal));
        if ($surat->dari_tanggal == $surat->sampai_tanggal) {
            echo " pada tanggal " . tgl_indo($surat->dari_tanggal);
        } else {
            echo " pada tanggal " . tgl_indo($surat->dari_tanggal) . " - " . tgl_indo($surat->sampai_tanggal);
        }
    }
}
