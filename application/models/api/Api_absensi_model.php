<?php


class Api_absensi_model extends CI_Model
{
    function getRekapAbsensiPerbulan($jns_pegawai, $periode)
    {
        $this->db->order_by('ts_rekap_absensi.telat', 'DESC');
        $this->db->select('mst_pegawai.nama, mst_pegawai.pin, mst_pegawai.id_pegawai, ts_rekap_absensi.*');
        $this->db->from('ts_rekap_absensi');
        $this->db->join('mst_pegawai', 'mst_pegawai.id_pegawai = ts_rekap_absensi.id_pegawai', 'left');
        $this->db->where("periode", $periode);
        $this->db->where("mst_pegawai.jns_pegawai", $jns_pegawai);
        $qry = $this->db->get();
        $rekap = $qry->result();
        return $rekap;
    }

    function getRekapAbsensiPerpegawai($id_pegawai, $periode)
    {
        $this->db->select('mst_pegawai.nama, mst_pegawai.pin, mst_pegawai.id_pegawai, ts_rekap_absensi.*');
        $this->db->from('ts_rekap_absensi');
        $this->db->join('mst_pegawai', 'mst_pegawai.id_pegawai = ts_rekap_absensi.id_pegawai', 'left');
        $this->db->where("periode", $periode);
        $this->db->where("ts_rekap_absensi.id_pegawai", $id_pegawai);
        $qry = $this->db->get();
        $rekap = $qry->row();
        return $rekap;
    }

    function getInfoPegawaiByPin($pin, $jns_pegawai = 'non_pns')
    {
        $this->db->select('
                mst_pegawai.*,
                mst_puskesmas.nama AS puskesmas,
                mst_jabatan.nama AS jabatan
            ');

        $this->db->from('mst_pegawai');
        $this->db->join(
            'mst_puskesmas',
            'mst_puskesmas.id_puskesmas = mst_pegawai.id_puskesmas',
            'left'
        );
        $this->db->join(
            'mst_jabatan',
            'mst_jabatan.id = mst_pegawai.id_jabatan',
            'left'
        );

        $this->db->where('mst_pegawai.pin', $pin);
        $this->db->where('mst_pegawai.jns_pegawai', $jns_pegawai);
        $qry = $this->db->get();

        $row = $qry->row();

        return $row;
    }

    function updateAbsensiKehadiranCuti($id_cuti, $pin, $keterangan = '')
    {

        $list_hari_cuti = $this->Api_cuti_model->getListHariCuti($id_cuti);
        foreach ($list_hari_cuti as $list) {
            $tgl_cuti = $list->tgl_cuti;

            $update_data = [
                'status'         => 'CUTI',
                'status_detail'  => '',
                'keterangan'     => $keterangan,
                'telat_menit'    => 0,
                'p_awal_menit'   => 0,
                'shift'          => 'OFF'

            ];

            $this->db->where('pin', $pin);
            $this->db->where('tanggal', $tgl_cuti);

            $update = $this->db->update('tbl_kehadiran_harian', $update_data);
        }

        return $update;
    }

    function updateDataKehadiran($id, $jam_masuk = null, $jam_pulang = null, $telat = 0, $p_awal = 0)
    {

        $update_data = [
            'jam_masuk'    => $jam_masuk,
            'jam_pulang'   => $jam_pulang,
            'telat_menit'    => $telat,
            'p_awal_menit'   => $p_awal,
        ];

        $this->db->where('id', $id);
        $update = $this->db->update('tbl_kehadiran_harian', $update_data);
        return true;
    }
}
