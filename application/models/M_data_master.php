<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_data_master extends CI_Model
{
    public function perjanjian_kinerja($tahun = null)
    {
        $this->db->select('*');
        $this->db->from('kegiatan');
        $this->db->where('tahun', $tahun);
        $query =  $this->db->get();
        return $query->result();
    }
}
