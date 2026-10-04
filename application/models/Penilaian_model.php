<?php ob_start();
defined('BASEPATH') or exit('No direct script access allowed');
class Penilaian_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		#$this->db2 = $this->load->database('ekin1', true);

	}


        public function getPertanyaanPerilaku($id_pegawai, $bulan, $tahun)
        {
            $sql = "
                SELECT
                    k.id AS id_kategori,
                    k.nama AS nama_kategori,
                    k.sort,
                    p.id AS id_pertanyaan,
                    p.pertanyaan,
                    p.jns_item,
                    jp.jawaban
                FROM mst_kategori_penilaian k
                JOIN daftar_pertanyaan p
                    ON p.id_kategori = k.id
                LEFT JOIN tbl_penilaian_perilaku jp
                    ON jp.id_pertanyaan = p.id
                AND jp.id_pegawai = ?
                AND jp.periode_bulan = ?
                AND jp.periode_tahun = ?
                ORDER BY k.sort ASC, p.id ASC
            ";

            return $this->db->query($sql, [
                $id_pegawai,
                $bulan,
                $tahun
            ])->result();
        }

        public function updateStatusAktifitasBulk($array_id_kinerja, $status)
        {
            // Pastikan parameter id tidak kosong dan berupa array
            if (empty($array_id_kinerja) || !is_array($array_id_kinerja)) {
                return FALSE;
            }

            // Ambil ID user validator dari Session login yang aktif saat ini
            $id_user_sess = $this->session->userdata('id_user');
            $id_peg_sess  = $this->session->userdata('id_pegawai');

            $id_validator = (isset($id_user_sess) && $id_user_sess != '') ? $id_user_sess : $id_peg_sess;
            $tgl_validasi = date('Y-m-d H:i:s');
            // Set kolom yang di-update
            $this->db->set('status', $status);
            $this->db->set('tgl_validasi', $tgl_validasi);
            $this->db->set('id_validator', $id_validator);

            // Filter record berdasarkan array ID yang dicentang
            $this->db->where_in('id', $array_id_kinerja);

            // Eksekusi update pada tabel ts_kinerja
            return $this->db->update('ts_kinerja');
        }

}
