<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template_shift extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Template_shift_model');
        $this->load->model('Admin_cuti_model', 'acm');
    }

    // =========================
    // LIST TEMPLATE
    // =========================
    public function index()
    {
        $data['template'] = $this->Template_shift_model->get_all();
        $this->load->view('admin/template_shift/index', $data);
    }

    // =========================
    // FORM TAMBAH TEMPLATE
    // =========================
    public function create()
    {
        $this->load->view('admin/template_shift/create');
    }

    // =========================
    // SIMPAN HEADER TEMPLATE
    // =========================
    public function store()
    {
        $data = [
            'nama_template' => $this->input->post('nama_template'),
            'bulan'         => $this->input->post('bulan'),
            'tahun'         => $this->input->post('tahun')
        ];

        $template_id = $this->Template_shift_model->insert_template($data);

        redirect('admin/template_shift/detail/'.$template_id);
    }

    // =========================
    // DETAIL TEMPLATE (ISI TANGGAL & SHIFT)
    // =========================
    public function detail($id)
    {
        $data['template'] = $this->Template_shift_model->get_by_id($id);
        $data['detail']   = $this->Template_shift_model->get_detail($id);
        $data['shift']    = $this->Template_shift_model->get_shift();

        $this->load->view('admin/template_shift/detail', $data);
    }

    // =========================
    // SIMPAN DETAIL SHIFT
    // =========================
    public function save_detail()
    {
        $data = [
            'template_id' => $this->input->post('template_id'),
            'tanggal'     => $this->input->post('tanggal'),
            'shift_id'    => $this->input->post('shift_id'),
        ];

        $this->Template_shift_model->insert_detail($data);

        redirect('admin/template_shift/detail/'.$data['template_id']);
    }


    public function generate($id_template)
    {
        $template = $this->db->get_where('tbl_shift_template', [
            'id' => $id_template
        ])->row();

        if(!$template){
            show_404();
        }

        $bulan = $template->bulan;
        $tahun = $template->tahun;

        // Hapus dulu detail lama (biar tidak double)
        $this->db->where('template_id', $id_template);
        $this->db->delete('tbl_shift_template_detail');

        // Hitung jumlah hari dalam bulan
        $jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
            for ($i = 1; $i <= $jumlah_hari; $i++) {

                $tanggal = $tahun . '-' . 
                        str_pad($bulan, 2, '0', STR_PAD_LEFT) . '-' . 
                        str_pad($i, 2, '0', STR_PAD_LEFT);

                // Ambil angka hari (1=Senin ... 7=Minggu)
                $hari = date('N', strtotime($tanggal));

                // Jika Sabtu (6) atau Minggu (7)
                if ($hari == 6 || $hari == 7) {
                    $shift_id = 1; // Libur
                } else {
                    $shift_id = 8; // Reguler
                }

                $data = [
                    'template_id' => $id_template,
                    'tanggal'     => $tanggal,
                    'shift_id'    => $shift_id
                ];

                $this->db->insert('tbl_shift_template_detail', $data);
            }

        redirect('admin/template_shift/detail/'.$id_template);
    }


    public function update_shift()
    {
        $detail_id = $this->input->post('detail_id');
        $shift_id = $this->input->post('shift_id');


        for ($i=0; $i < count($detail_id) ; $i++) { 
            $id_shift = $shift_id[$i];
            $this->db->where('id', $detail_id[$i]);
            $this->db->set('shift_id', $id_shift);
            $this->db->update('tbl_shift_template_detail');
        }

        redirect($_SERVER['HTTP_REFERER']);
    }

}