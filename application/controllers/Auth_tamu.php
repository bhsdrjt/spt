<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_tamu extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('M_statistik');
        $this->CI = &get_instance();
    }

    public function index()
    {
        $data['pegawai'] = $this->db->get('pegawai')->result();
        $this->load->view('auth_tamu/data_statistik', $data);
    }

    public function form_download()
    {
        $id = $this->input->post('pegawai');
        $opsi = $this->input->post('opsi');
        if ($opsi == 'download_spt') {
            $this->spt_pdf_download($id);
        } elseif ($opsi == 'download_skp') {
            $this->skp_excel_download($id);
        } else {
            redirect('Auth_tamu');
        }
    }

    public function spt_pdf_download($id)
    {
        $this->load->helper('MY_tanggal');
        $this->load->library('pdfgenerator');
        $bulan = intval($this->input->post('bulan'));
        $tahun = intval($this->input->post('tahun'));
        $data = [
            'pegawai' => $this->db->get_where('pegawai', ['id_pegawai' => $id])->row(),
            'detail' => $this->M_statistik->detail_skpPegawai($id,'Semua',$bulan,$tahun)
        ];

        // title dari pdf
        // $this->data['title_pdf'] = 'SPT';
        $data['title_pdf'] = 'SPT ' . $data['pegawai']->jabatan;

        // filename dari pdf ketika didownload
        $file_pdf = 'SPT_' . $data['pegawai']->jabatan;
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "portrait";

        $html = $this->load->view('auth_tamu/spt_pdf_download', $data, true);
        // run dompdf
        $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }

    public function skp_excel_download($id)
    {
        $this->load->helper('MY_tanggal');
        $bulan = intval($this->input->post('bulan'));
        $tahun = intval($this->input->post('tahun'));
        $data = [
            'pegawai' => $this->db->get_where('pegawai', ['id_pegawai' => $id])->row(),
            'detail' => $this->M_statistik->detail_skpPegawai($id,'Semua',$bulan,$tahun)
        ];
        $this->load->view('auth_tamu/skp_excel_download', $data);
    }

    public function preview_skp()
    {
        $this->load->helper('my_tanggal');
        $id_pegawai = $this->input->post('pegawai');
        $bulan = intval($this->input->post('bulan'));
        $tahun = intval($this->input->post('tahun'));
        // var_dump($this->input->post());
        $pegawai = $this->db->get_where('pegawai', ['id_pegawai' => $id_pegawai])->row();
        $skp = $this->M_statistik->detail_skpPegawai($id_pegawai,'Semua',$bulan,$tahun);

        $pre = "";
        if (isset($skp)) {
            $pre = "<h5>SKP " . $pegawai->nama . "</h5><table border='1' style='width:100%'";
            $pre .= "<thead>
                        <tr>
                            <th style='text-align:center;border:1px solid'>No</th>
                            <th style='text-align:center;border:1px solid'>Tanggal</th>
                            <th style='text-align:center;border:1px solid'>PK</th>
                            <th style='text-align:center;border:1px solid'>Sasaran Kegiatan</th>
                            <th style='text-align:center;border:1px solid'>Indikator Kegiatan</th>
                            <th style='text-align:center;border:1px solid'>Rincian Output</th>
                            <th style='text-align:center;border:1px solid'>Nama Kegiatan</th>
                        </tr>
                    </thead>";
            $pre .= "<tbody>";
            $no = 1;
            foreach ($skp as $data) {
                $tanggal = $data->dari_tanggal == $data->sampai_tanggal ? tgl_indo($data->dari_tanggal) : tgl_indo($data->dari_tanggal) . " - " . tgl_indo($data->sampai_tanggal);
                $pre .= "<tr>
                            <td style='text-align:center;border:1px solid'>" . $no++ . "</td>
                            <td style='text-align:center;border:1px solid'>" . $tanggal . "</td>
                            <td style='text-align:center;border:1px solid'>" . $data->nama_kegiatan . "</td>
                            <td style='text-align:center;border:1px solid'>" . $data->nama_sasaran . "</td>
                            <td style='text-align:center;border:1px solid'>" . $data->nama_indikator . "</td>
                            <td style='text-align:center;border:1px solid'>" . $data->nama_ro . "</td>
                            <td style='text-align:center;border:1px solid'>" . $data->nama_kegiatan_surat . "</td>
                        </tr>";
            }
            $pre .= "</tbody>
                    </table>";
        }

        echo $pre;
    }
}
