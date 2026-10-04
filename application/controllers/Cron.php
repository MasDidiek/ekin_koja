<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // Hanya boleh jalan via CLI
        if (!$this->input->is_cli_request()) {
            show_error('Direct access not allowed');
        }

        $this->load->model('Absensi_model');
    }

    public function sync_absensi()
    {
        echo "Mulai sinkron...\n";

        // Panggil function SOAP kamu
        $this->Absensi_model->sync_mesin();

        echo "Selesai sinkron.\n";
    }
}
