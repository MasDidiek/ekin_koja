<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Dashboard extends CI_Controller {

    public function index()
    {
        // 1. Total Driver
        $total_driver = $this->db->count_all('mst_driver');

        // 2. Driver Belum Diperiksa
        $this->db->where('status_pemeriksaan', 0);
        $belum_diperiksa = $this->db->count_all_results('mst_driver');

        // 3. Driver Laik (status_laik = 1)
        $driver_laik = $this->db->select('COUNT(DISTINCT tp.id_driver) as total')
            ->from('ts_pemeriksaan tp')
            ->where('tp.status_laik', 1)
            ->get()
            ->row()->total;

        // 4. Driver Laik dengan Catatan (status_laik = 2)
        $driver_laik_catatan = $this->db->select('COUNT(DISTINCT tp.id_driver) as total')
            ->from('ts_pemeriksaan tp')
            ->where('tp.status_laik', 2)
            ->get()
            ->row()->total;

        // 5. Driver Tidak Laik (status_laik = 3)
        $driver_tidak_laik = $this->db->select('COUNT(DISTINCT tp.id_driver) as total')
            ->from('ts_pemeriksaan tp')
            ->where('tp.status_laik', 3)
            ->get()
            ->row()->total;

        // 6. Driver dengan Hipertensi (status_ht = 3 atau lebih, menunjukkan masalah)
        $driver_hipertensi = $this->db->select('COUNT(DISTINCT tp.id_driver) as total')
            ->from('ts_pemeriksaan tp')
            ->where('tp.status_ht >=', 3)
            ->get()
            ->row()->total;

        // 7. Driver dengan Gula Darah Tinggi (status_gds = 3 atau lebih)
        $driver_gula_tinggi = $this->db->select('COUNT(DISTINCT tp.id_driver) as total')
            ->from('ts_pemeriksaan tp')
            ->where('tp.status_gds >=', 3)
            ->get()
            ->row()->total;

        // 8. Driver Positif Alkohol (alkohol = 1 di tbl_faktor_resiko)
        $driver_positif_alkohol = $this->db->select('COUNT(DISTINCT fr.id_driver) as total')
            ->from('tbl_faktor_resiko fr')
            ->where('fr.alkohol', 1)
            ->get()
            ->row()->total;

        // 9. 10 Pemeriksaan Terakhir
        $pemeriksaan_terbaru = $this->db->select('tp.*, md.nama, mu.nama as petugas')
            ->from('ts_pemeriksaan tp')
            ->join('mst_driver md', 'tp.id_driver = md.id', 'left')
            ->join('mst_user mu', 'tp.id_petugas = mu.id', 'left')
            ->order_by('tp.date_time', 'DESC')
            ->limit(10)
            ->get()
            ->result();

        // Data untuk Chart Bar (Surat Masuk per Bulan - tetap seperti sebelumnya)
        $dataSuratMasuk = [120, 150, 180, 245, 210, 300];

        // Gabung data untuk view
        $data = [
            'total_driver' => $total_driver,
            'belum_diperiksa' => $belum_diperiksa,
            'driver_laik' => $driver_laik,
            'driver_laik_catatan' => $driver_laik_catatan,
            'driver_tidak_laik' => $driver_tidak_laik,
            'driver_hipertensi' => $driver_hipertensi,
            'driver_gula_tinggi' => $driver_gula_tinggi,
            'driver_positif_alkohol' => $driver_positif_alkohol,
            'pemeriksaan_terbaru' => $pemeriksaan_terbaru,
            'surat_masuk_json' => json_encode($dataSuratMasuk),
            'status_laik_json' => json_encode([$driver_laik, $driver_laik_catatan, $driver_tidak_laik])
        ];

        $this->load->view('admin/dashboard_view', $data);
    }

    public function view_driver()
    {
        $filter = $this->input->get('filter');
        $data['filter'] = $filter;
        $drivers = [];

        if ($filter == 'belum_diperiksa') {
            $this->db->where('status_pemeriksaan', 0);
            $drivers = $this->db->get('mst_driver')->result();
        } elseif ($filter == 'laik') {
            $drivers = $this->db->select('md.id, md.nama, md.no_ktp, md.no_hp, md.tgl_lahir, md.nama_po, md.nama_terminal, md.status_pemeriksaan', FALSE)
                ->from('mst_driver md')
                ->join('ts_pemeriksaan tp', 'tp.id_driver = md.id', 'inner')
                ->where('tp.status_laik', 1)
                ->group_by('md.id')
                ->get()
                ->result();
        } elseif ($filter == 'laik_catatan') {
            $drivers = $this->db->select('md.id, md.nama, md.no_ktp, md.no_hp, md.tgl_lahir, md.nama_po, md.nama_terminal, md.status_pemeriksaan', FALSE)
                ->from('mst_driver md')
                ->join('ts_pemeriksaan tp', 'tp.id_driver = md.id', 'inner')
                ->where('tp.status_laik', 2)
                ->group_by('md.id')
                ->get()
                ->result();
        } elseif ($filter == 'tidak_laik') {
            $drivers = $this->db->select('md.id, md.nama, md.no_ktp, md.no_hp, md.tgl_lahir, md.nama_po, md.nama_terminal, md.status_pemeriksaan', FALSE)
                ->from('mst_driver md')
                ->join('ts_pemeriksaan tp', 'tp.id_driver = md.id', 'inner')
                ->where('tp.status_laik', 3)
                ->group_by('md.id')
                ->get()
                ->result();
        } elseif ($filter == 'hipertensi') {
            $drivers = $this->db->select('md.id, md.nama, md.no_ktp, md.no_hp, md.tgl_lahir, md.nama_po, md.nama_terminal, md.status_pemeriksaan', FALSE)
                ->from('mst_driver md')
                ->join('ts_pemeriksaan tp', 'tp.id_driver = md.id', 'inner')
                ->where('tp.status_ht >=', 3)
                ->group_by('md.id')
                ->get()
                ->result();
        } elseif ($filter == 'gula_tinggi') {
            $drivers = $this->db->select('md.id, md.nama, md.no_ktp, md.no_hp, md.tgl_lahir, md.nama_po, md.nama_terminal, md.status_pemeriksaan', FALSE)
                ->from('mst_driver md')
                ->join('ts_pemeriksaan tp', 'tp.id_driver = md.id', 'inner')
                ->where('tp.status_gds >=', 3)
                ->group_by('md.id')
                ->get()
                ->result();
        } elseif ($filter == 'positif_alkohol') {
            $drivers = $this->db->select('md.id, md.nama, md.no_ktp, md.no_hp, md.tgl_lahir, md.nama_po, md.nama_terminal, md.status_pemeriksaan', FALSE)
                ->from('mst_driver md')
                ->join('tbl_faktor_resiko fr', 'fr.id_driver = md.id', 'inner')
                ->where('fr.alkohol', 1)
                ->group_by('md.id')
                ->get()
                ->result();
        }

        $data['drivers'] = $drivers;
        $this->load->view('admin/dashboard_view_driver', $data);
    }
}
