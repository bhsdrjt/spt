<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_statistik extends CI_Model
{
    public function statistik_tugas($bulan, $tahun)
    {
        $this->db->select('*,ds1.dasar AS dasar_suratDIPA,ds2.dasar AS dasar_suratKS');
        $this->db->from('surat');
        $this->db->join('dasar_surat ds1', 'ds1.id=surat.dasarDIPA', 'left');
        $this->db->join('dasar_surat ds2', 'ds2.id=surat.dasarKS', 'left');
        $this->db->join('sumber_dana', 'sumber_dana.id=surat.sumber_dana');
        $this->db->join('pegawai', 'pegawai.id_pegawai=surat.mengetahui');
        $this->db->join('kegiatan', 'kegiatan.id_kegiatan=surat.kegiatan');
        $this->db->join('sasaran', 'sasaran.id_sasaran=surat.sasaran', 'left');
        $this->db->join('indikator', 'indikator.id_indikator=surat.indikator', 'left');
        $this->db->join('ro', 'ro.id_ro=surat.rincian_output', 'left');
        $query =  $this->db->get();
        return $query->result();
    }

    public function detail_statistikPegawai($id, $pk = 'Semua')
    {
        $this->db->select('*');
        $this->db->from('surat');
        $this->db->join('pegawai_tugas pt', 'pt.id_surat=surat.id_surat');
        $this->db->join('tgl_pelaksanaan tp', 'tp.id_surat=surat.id_surat');
        $this->db->join('kegiatan', 'kegiatan.id_kegiatan=surat.kegiatan');
        $this->db->where('id_pegawai', $id);
        if ($pk != 'Semua') {
            $this->db->where('surat.kegiatan', $pk);
        }
        $this->db->order_by('dari_tanggal', 'ASC');
        $this->db->group_by('surat.id_surat');
        $query =  $this->db->get();
        return $query->result();
    }

    public function detail_skpPegawai($id, $pk = 'Semua',$bulan=null,$tahun= null)
    {
        // var_dump($id, $pk,$bulan,$tahun);
        // var_dump('asek');
        $this->db->select('*');
        $this->db->from('surat');
        $this->db->join('pegawai_tugas pt', 'pt.id_surat=surat.id_surat');
        $this->db->join('tgl_pelaksanaan tp', 'tp.id_surat=surat.id_surat');
        $this->db->join('kegiatan', 'kegiatan.id_kegiatan=surat.kegiatan');
        $this->db->join('sasaran', 'sasaran.id_sasaran=surat.sasaran', 'left');
        $this->db->join('indikator', 'indikator.id_indikator=surat.indikator', 'left');
        $this->db->join('ro', 'ro.id_ro=surat.rincian_output', 'left');
        $this->db->where('id_pegawai', $id);
        if ($pk != 'Semua') {
            $this->db->where('surat.kegiatan', $pk);
        }
        if ($bulan) {
            $this->db->group_start();
            $this->db->where("MONTH(surat.dari_tanggal)", $bulan);
            $this->db->or_where("MONTH(surat.sampai_tanggal)", $bulan);
            $this->db->group_end();
        }
        if ($tahun) {
            $this->db->group_start();
            $this->db->where("YEAR(surat.dari_tanggal)", $tahun);
            $this->db->or_where("YEAR(surat.sampai_tanggal)", $tahun);
            $this->db->group_end();
        }
        $this->db->order_by('dari_tanggal', 'ASC');
        $this->db->group_by('surat.id_surat');
        $query =  $this->db->get();
        return $query->result();
    }
}
