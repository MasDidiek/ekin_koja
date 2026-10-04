<?php


class Master_api_model extends CI_Model
{



    public function getCapaianPegawai($periode)
    {
        $this->db->order_by('total_capaian', 'ASC');
        $this->db->select('a.id_pegawai, a.nama, b.*');
        $this->db->from('mst_pegawai a');

        $this->db->join(
            'tbl_capaian b',
            "a.nip = b.nip AND b.periode = " . $this->db->escape($periode),
            'left'
        );

        $this->db->where('a.jns_pegawai', 'non_pns');
        $this->db->where('a.status_kerja !=', 0);

        return $this->db->get()->result();
    }

    function getTotalInputanKinerja($id_pegawai, $periode)
    {

        $periodeDate = new DateTime($periode . '-01');

        $start_date = $periodeDate->format('Y-m-01');
        $end_date   = $periodeDate->format('Y-m-t');

        $nextMonthDate = clone $periodeDate;
        $nextMonthDate->modify('+1 month');
        $date_in = $nextMonthDate->format('Y-m-05');

        // $qry = $this->db->get_where('ts_kinerja', array(
        //     'id_pegawai' => $id_pegawai,
        //     'date_in <=' => $date_in,
        //     'tgl >='     => $start_date,
        //     'tgl <='     => $end_date
        // ));

        // $inputan = $qry->result();

        $this->db->select("
                    COUNT(id) AS total_input,
                    SUM(total) AS total_kinerja,
                    SUM(CASE WHEN status = 1 THEN total ELSE 0 END) AS total_approve,
                    COUNT(CASE WHEN status = 1 THEN 1 END) AS jumlah_approve
                ", false);

        $this->db->from('ts_kinerja');

        $this->db->where('id_pegawai', $id_pegawai);
        $this->db->where('date_in <=', $date_in);
        $this->db->where('tgl >=', $start_date);
        $this->db->where('tgl <=', $end_date);

        $result = $this->db->get()->row();

        return $result;
    }

    function getWaktuEfektif($periode)
    {
        $sql = "SELECT id FROM tbl_shift_template_detail WHERE tanggal like '$periode%' AND shift_id > 1";
        $qry = $this->db->query($sql);
        $row = $qry->num_rows();

        $waktu_efektif  = $row * 300;
        return $waktu_efektif;
    }



    function getDataGajiPegawai()
    {
        $sql = "SELECT 
                        p.id_pegawai,
                        p.nip,
                        p.nama,
                        g.tmt,
                        g.gaji_pokok,
                        g.pengali,
                        g.periode_ke,
                        (g.gaji_pokok * g.pengali) AS total_gaji
                    FROM mst_pegawai p
                    JOIN tbl_riwayat_gaji_baru g 
                        ON g.id_pegawai = p.id_pegawai
                    JOIN (
                        SELECT 
                            id_pegawai,
                            MAX(tmt) AS tmt_terakhir
                        FROM tbl_riwayat_gaji_baru
                        GROUP BY id_pegawai
                    ) last_gaji
                        ON last_gaji.id_pegawai = g.id_pegawai
                        AND last_gaji.tmt_terakhir = g.tmt
                    WHERE p.status_kerja > 0
                    AND p.jns_pegawai = 'non_pns'";

        $qry = $this->db->query($sql);
        $result = $qry->result();

        return $result;
    }

    function getDataListingTKD($periode)
    {

        $qry = $this->db->get_where('ts_rekap_tkd', ['periode' => $periode]);
        return $qry->result();
    }
    function insertListingTKD($periode, $nama, $jabatan, $nip, $npwp, $no_rekening, $masa_kerja, $urutan, $tkd_pokok)
    {

        $explodeMasaKerja  = explode(" ", $masa_kerja);
        //hitung untuk mendapatkan masa kerja baru

        $masa_tahun = (int)$explodeMasaKerja[0];
        $masa_bulan = (int)$explodeMasaKerja[2];
        // tambah 1 bulan
        $masa_bulan++;

        // jika bulan sudah 12
        if ($masa_bulan >= 12) {
            $masa_tahun++;
            $masa_bulan = 0;
        }

        $masa_kerja_baru = $masa_tahun . " Tahun " . $masa_bulan . " Bulan";

        $newData = [
            "periode" => $periode,
            "nama" => ucwords($nama),
            "jabatan" => $jabatan,
            "nip" => $nip,
            "npwp" => clear_tags($npwp),
            "tkd_pokok" => $tkd_pokok,
            "capaian" => 0,
            "bruto" => 0,
            "pph21" => 0,
            "bpjs" => 0,
            "bpjs_tk" => 0,
            "thp" => 0,
            "no_rekening" => $no_rekening,
            "masa_kerja" => $masa_kerja_baru,
            "urutan" => $urutan,
            "update_on" => date("Y-m-d H:i:s"),
        ];


        //print_array($newData);
        $cekExist = $this->cekExistData($nip, $periode);
        if ($cekExist == false) {
            $this->db->insert('ts_rekap_tkd', $newData);
        }



        return true;
    }

    function cekExistData($nip, $periode)
    {
        $this->db->select('id');
        $qry = $this->db->get_where('ts_rekap_tkd', ['nip' => $nip, 'periode' => $periode]);
        $row = $qry->num_rows();

        if ($row > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getLastRekapTKD($nip)
    {
        $this->db->order_by('id', 'DESC');
        $this->db->where('nip', $nip);
        $qry = $this->db->get('ts_rekap_tkd', 1);
        $row = $qry->row();

        return $row;
    }
}
