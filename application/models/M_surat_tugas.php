<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_surat_tugas extends CI_Model
{
    public function surat_tugas($id_surat = null, $tahun = null)
    {
        $this->db->select('*,surat.modified_at,ds1.dasar AS dasar_suratDIPA,ds2.dasar AS dasar_suratKS,surat.tahun AS tahun,surat.bulan AS bulan');
        $this->db->from('surat');
        $this->db->join('dasar_surat ds1', 'ds1.id=surat.dasarDIPA', 'left');
        $this->db->join('dasar_surat ds2', 'ds2.id=surat.dasarKS', 'left');
        $this->db->join('sumber_dana', 'sumber_dana.id=surat.sumber_dana');
        $this->db->join('pegawai', 'pegawai.id_pegawai=surat.mengetahui');
        $this->db->join('mengetahui', 'mengetahui.id_pegawai=surat.mengetahui');
        $this->db->join('kegiatan', 'kegiatan.id_kegiatan=surat.kegiatan');
        $this->db->join('sasaran', 'sasaran.id_sasaran=surat.sasaran', 'left');
        $this->db->join('indikator', 'indikator.id_indikator=surat.indikator', 'left');
        $this->db->join('ro', 'ro.id_ro=surat.rincian_output', 'left');
        if ($id_surat != null) {
            $this->db->where('id_surat', $id_surat);
            $query =  $this->db->get();
            return $query->row();
        } else {
            if ($tahun != null) {
                $this->db->where('surat.tahun', $tahun);
            }
            $this->db->order_by('surat.modified_at', 'DESC');
            $this->db->order_by('tgl_spt', 'DESC');
            $query =  $this->db->get();
            return $query->result();
        }
    }

    public function cetak_surat($id)
    {
        $this->db->select('*');
        $this->db->from('surat');
        $this->db->join('kegiatan', 'kegiatan.id_kegiatan=surat.kegiatan');
        $this->db->join('pegawai', 'pegawai.id_pegawai=surat.mengetahui');
        $this->db->where(['id_surat' => $id]);
        $query =  $this->db->get();
        return $query->row();
    }

    public function pegawai_tugas($id)
    {
        $this->db->select('*');
        $this->db->from('pegawai_tugas pt');
        $this->db->join('pegawai', 'pegawai.id_pegawai=pt.id_pegawai');
        $this->db->where(['id_surat' => $id]);
        $query =  $this->db->get();
        return $query->result();
    }

    public function insert_surat($data, $id_surat)
    {
        $this->db->update('surat', $data, ['id_surat' => $id_surat]);
        return ($this->db->affected_rows() > 0) ? true : false;
    }

    public function surat_tugas_bulanTahun($tahun = null, $bulan = null)
    {
        $this->db->select('*,surat.modified_at,ds1.dasar AS dasar_suratDIPA,ds2.dasar AS dasar_suratKS');
        $this->db->from('surat');
        $this->db->join('dasar_surat ds1', 'ds1.id=surat.dasarDIPA', 'left');
        $this->db->join('dasar_surat ds2', 'ds2.id=surat.dasarKS', 'left');
        $this->db->join('sumber_dana', 'sumber_dana.id=surat.sumber_dana');
        $this->db->join('pegawai', 'pegawai.id_pegawai=surat.mengetahui');
        $this->db->join('mengetahui', 'mengetahui.id_pegawai=surat.mengetahui');
        $this->db->join('kegiatan', 'kegiatan.id_kegiatan=surat.kegiatan');
        $this->db->join('sasaran', 'sasaran.id_sasaran=surat.sasaran', 'left');
        $this->db->join('indikator', 'indikator.id_indikator=surat.indikator', 'left');
        $this->db->join('ro', 'ro.id_ro=surat.rincian_output', 'left');

        if ($tahun != null && $bulan != null) {
            $this->db->where('surat.tahun', $tahun);
            $this->db->where('surat.bulan', $bulan);
        }
        $this->db->order_by('surat.modified_at', 'DESC');
        $this->db->order_by('tgl_spt', 'DESC');
        $query =  $this->db->get();
        return $query->result();
    }
}
