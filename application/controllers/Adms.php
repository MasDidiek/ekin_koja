<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adms extends CI_Controller {

    public function index()
    {
        // optional: batasi hanya IP internal
        if (strpos($_SERVER['REMOTE_ADDR'], '10.') !== 0) {
            exit('Access denied');
        }

        $raw = file_get_contents("php://input");

        if (empty($raw)) {
            echo "OK";
            exit;
        }

        $rows = explode("\n", trim($raw));

        foreach ($rows as $row) {

            $col = explode("\t", trim($row));

            if (count($col) >= 2) {

                $data = [
                    'pin' => $col[0],
                    'datetime_log' => $col[1],
                    'status' => isset($col[2]) ? $col[2] : 0,
                    'verify' => isset($col[3]) ? $col[3] : NULL,
                    'workcode' => isset($col[4]) ? $col[4] : NULL
                ];

                $this->db->insert('tbl_log_mesin', $data);
            }
        }

        echo "OK";
    }

    public function rekap_harian($tanggal)
    {
        $this->db->select('pin, MIN(datetime_log) as jam_masuk, MAX(datetime_log) as jam_pulang');
        $this->db->where('DATE(datetime_log)', $tanggal);
        $this->db->group_by('pin');

        $result = $this->db->get('tbl_log_mesin')->result();

        foreach ($result as $row) {

            $this->db->where('pin', $row->pin);
            $this->db->where('tanggal', $tanggal);
            $this->db->update('tbl_kehadiran_harian', [
                'jam_masuk' => date('H:i:s', strtotime($row->jam_masuk)),
                'jam_pulang'=> date('H:i:s', strtotime($row->jam_pulang)),
                'status'    => 'HADIR'
            ]);
        }
    }

}
