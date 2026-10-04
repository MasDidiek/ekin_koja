<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penilaian_kinerja extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Profile_model');
        $this->load->model('Admin_cuti_model', 'acm');
        $this->load->model('Penilaian_model');
        $this->load->model('Kinerja_model');
        $this->load->model('Pegawai_model');
        $this->load->model('Presensi_model');

        $this->Auth_model->cekAuthLogin();
    }

    public function index()
    {
        $id_validator = $this->session->userdata('id_pegawai');
        $id_pj_sess   = $this->session->userdata('id_pj');
        $usergroup    = $this->session->userdata('usergroup');

        $thn_anggaran = 2024;

        if ($usergroup < 3) {
            if ($id_pj_sess == '') {
                $id_validator = 29519; // id pegawai KTU
            } else {
                $id_validator = $id_pj_sess;
            }
        }

        // Ambil parameter dari GET URL, jika tidak ada berikan nilai default (Kompatibel PHP 5.6+)
        $get_bulan           = $this->input->get('bulan');
        $get_tahun           = $this->input->get('tahun');
        $id_validator_select = $this->input->get('id_validator');


        if ($get_bulan != '') {
            $this->session->set_userdata('bulan', $get_bulan);
            $this->session->set_userdata('tahun', $get_tahun);
            $this->session->set_userdata('id_validator', $id_validator_select);

            $bulan = $get_bulan;
            $tahun = $get_tahun;
        } else {
            $get_bulan           = $this->session->userdata('bulan');
            $get_tahun           = $this->session->userdata('tahun');
            $id_validator_select = $this->session->userdata('id_validator');

            $bulan = (isset($get_bulan) && $get_bulan != '') ? $get_bulan : date('n');
            $tahun = (isset($get_tahun) && $get_tahun != '') ? $get_tahun : date('Y');
        }



        if (isset($id_validator_select) && $id_validator_select != '') {
            $id_validator = $id_validator_select;
        }

        // Format ringkas YYYY-MM
        $periode = sprintf('%04d-%02d', $tahun, $bulan);

        // Panggil model berdasarkan parameter GET
        $data['bulan']        = $bulan;
        $data['tahun']        = $tahun;
        $data['id_validator'] = $id_validator;
        $data['data_pegawai'] = $this->Kinerja_model->getListPegawaiWithRekapAktivitas($id_validator, $periode, $thn_anggaran);

        $data['validator']    = $this->Pegawai_model->getValidator();
        $this->load->view('admin/penilaian_kinerja/validasi_aktifitas', $data);
    }

    public function validasi_aktifitas($id_pegawai)
    {
        $get_bulan = $this->input->get('bulan');
        $get_tahun = $this->input->get('tahun');

        $bulan = (isset($get_bulan) && $get_bulan != '') ? $get_bulan : date('m');
        $tahun = (isset($get_tahun) && $get_tahun != '') ? $get_tahun : date('Y');

        // timestamp awal bulan
        $firstDay = strtotime($tahun . '-' . $bulan . '-01');

        $data['bulan']        = $bulan;
        $data['tahun']        = $tahun;
        $data['jumlah_hari']  = date('t', $firstDay);
        $data['hari_pertama'] = date('N', $firstDay); // 1 (Senin) - 7 (Minggu)

        // prev & next
        $data['prev_bulan'] = date('m', strtotime('-1 month', $firstDay));
        $data['prev_tahun'] = date('Y', strtotime('-1 month', $firstDay));
        $data['next_bulan'] = date('m', strtotime('+1 month', $firstDay));
        $data['next_tahun'] = date('Y', strtotime('+1 month', $firstDay));

        // ambil data kinerja
        $awal  = sprintf('%04d-%02d-01', $tahun, $bulan);
        $akhir = date('Y-m-t', strtotime($awal));

        $this->db->select('
            tgl,
            SUM(total) AS total_menit,
            MAX(status) AS status_max,
            MIN(status) AS status_min
        ');
        $this->db->from('ts_kinerja');
        $this->db->where('id_pegawai', $id_pegawai);
        $this->db->where('tgl >=', $awal);
        $this->db->where('tgl <=', $akhir);
        $this->db->group_by('tgl');

        $query = $this->db->get()->result();

        // Ubah jadi array [tanggal => total]
        $kinerja = array();

        foreach ($query as $row) {
            $max = $row->status_max;
            $min = $row->status_min;

            // 1. Jika masih ada minimal 1 aktivitas yang BELUM DIPERIKSA (status = 0)
            if ($min == 0) {
                $bg           = 'bg-warning';      // KUNING (Pending)
                $status_label = 'Pending';
            }
            // 2. Jika ADA YANG DITOLAK (status = 2) DAN ADA YANG DISETUJUI (status = 1)
            elseif ($max == 2 && $min == 1) {
                $bg           = 'bg-orange';       // ORANYE / Cokelat Muda (Sebagian Ditolak)
                $status_label = 'Sebagian Ditolak';
            }
            // 3. Jika SEMUA AKTIVITAS DITOLAK (status_max = 2 dan status_min = 2)
            elseif ($max == 2 && $min == 2) {
                $bg           = 'bg-danger';       // MERAH (Semua Ditolak)
                $status_label = 'Ditolak';
            }
            // 4. Jika SEMUA AKTIVITAS DISETUJUI (status_max = 1 dan status_min = 1)
            else {
                $bg           = 'bg-success';      // HIJAU (Semua Disetujui)
                $status_label = 'Disetujui';
            }

            $kinerja[$row->tgl] = array(
                'total'  => $row->total_menit,
                'bg'     => $bg,
                'status' => $status_label
            );
        }

        $periode    = date('Y-m', strtotime($akhir));
        $summaryRow = $this->Kinerja_model->getSummaryKinerjaLengkap($id_pegawai, $periode);

        $data['summary'] = array(
            'total_input' => array(
                'jumlah' => (isset($summaryRow->total_input_jumlah) ? (int)$summaryRow->total_input_jumlah : 0),
                'menit'  => (isset($summaryRow->total_input_menit) ? (int)$summaryRow->total_input_menit : 0)
            ),
            'disetujui' => array(
                'jumlah' => (isset($summaryRow->disetujui_jumlah) ? (int)$summaryRow->disetujui_jumlah : 0),
                'menit'  => (isset($summaryRow->disetujui_menit) ? (int)$summaryRow->disetujui_menit : 0)
            ),
            'pending' => array(
                'jumlah' => (isset($summaryRow->pending_jumlah) ? (int)$summaryRow->pending_jumlah : 0),
                'menit'  => (isset($summaryRow->pending_menit) ? (int)$summaryRow->pending_menit : 0)
            ),
            'ditolak' => array(
                'jumlah' => (isset($summaryRow->ditolak_jumlah) ? (int)$summaryRow->ditolak_jumlah : 0),
                'menit'  => (isset($summaryRow->ditolak_menit) ? (int)$summaryRow->ditolak_menit : 0)
            )
        );

        $data['kinerja']        = $kinerja;
        $data['detail_pegawai'] = $this->Pegawai_model->getDetailPegawai($id_pegawai);

        $this->load->view('penilaian_kinerja/validasi_aktifitas', $data);
    }

    public function penilaian_perilaku()
    {
        $id_validator = $this->session->userdata('id_pegawai');
        $id_pj_sess   = $this->session->userdata('id_pj');
        $usergroup    = $this->session->userdata('usergroup');
        $thn_anggaran = 2024;

        if ($usergroup < 3) {
            if ($id_pj_sess == '') {
                $id_validator = 29519; // id pegawai KTU
            } else {
                $id_validator = $id_pj_sess;
            }
        }

        $input_bulan = $this->input->get('bulan');
        $bulan       = (isset($input_bulan) && $input_bulan != '') ? $input_bulan : (date('m') - 1);
        $input_tahun = $this->input->get('tahun');
        $tahun       = (isset($input_tahun) && $input_tahun != '') ? $input_tahun : date('Y');

        $input_validator = $this->input->get('id_validator');
        if (isset($input_validator) && $input_validator != '') {
            $id_validator = $input_validator;
        }

        $data['data_pegawai'] = $this->Kinerja_model->getListPegawaiByValidatorWithPerilaku($id_validator, $thn_anggaran, $bulan, $tahun);
        $data['bulan']        = $bulan;
        $data['tahun']        = $tahun;
        $data['id_validator'] = $id_validator;
        $data['validator']    = $this->Pegawai_model->getValidator();

        $this->load->view('admin/penilaian_kinerja/penilaian_perilaku', $data);
    }

    public function penilaian_perilaku_pegawai($id_pegawai, $bulan, $tahun)
    {
        $data['pegawai']    = $this->Pegawai_model->getDetailPegawai($id_pegawai);
        $data['pertanyaan'] = $this->Penilaian_model->getPertanyaanPerilaku($id_pegawai, $bulan, $tahun);

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        $total_poin = 0;
        if (!empty($data['pertanyaan'])) {
            foreach ($data['pertanyaan'] as $row) {
                $total_poin += hitung_poin_perilaku($row->jawaban, $row->jns_item);
            }
        }

        $nilai_perilaku         = round(($total_poin / 250) * 100, 2);
        $data['nilai_perilaku'] = $nilai_perilaku;

        $this->load->view('admin/penilaian_kinerja/penilaian_perilaku_pegawai', $data);
    }

    public function simpan_penilaian_perilaku()
    {
        $id_pegawai = $this->input->post('id_pegawai');
        $bulan      = $this->input->post('bulan');
        $tahun      = $this->input->post('tahun');
        $jawaban    = $this->input->post('jawaban');
        $jns_item   = $this->input->post('jns_item');

        if (!$id_pegawai || !$bulan || !$tahun || empty($jawaban)) {
            $this->session->set_flashdata('error', 'Data penilaian tidak lengkap.');
            redirect('admin/penilaian_kinerja');
            return;
        }

        $tgl_input = date('Y-m-d');

        // Hapus data lama
        $this->db->where('id_pegawai', $id_pegawai);
        $this->db->where('periode_bulan', $bulan);
        $this->db->where('periode_tahun', $tahun);
        $this->db->delete('tbl_penilaian_perilaku');

        $data_insert = array();

        foreach ($jawaban as $id_pertanyaan => $nilai_jawaban) {
            $jenis = isset($jns_item[$id_pertanyaan]) ? $jns_item[$id_pertanyaan] : 1;

            if ($jenis == 1) {
                $poin = (int)$nilai_jawaban;
            } else {
                $poin = 11 - (int)$nilai_jawaban;
            }

            $data_insert[] = array(
                'id_pegawai'    => $id_pegawai,
                'periode_bulan' => $bulan,
                'periode_tahun' => $tahun,
                'tgl_input'     => $tgl_input,
                'id_pertanyaan' => $id_pertanyaan,
                'jns_item'      => $jenis,
                'jawaban'       => $nilai_jawaban,
                'poin'          => $poin
            );
        }

        if (!empty($data_insert)) {
            $this->db->insert_batch('tbl_penilaian_perilaku', $data_insert);
        }

        $this->session->set_flashdata('success', 'Penilaian perilaku berhasil disimpan.');
        redirect('admin/penilaian_kinerja/penilaian_perilaku_pegawai/' . $id_pegawai . '/' . $bulan . '/' . $tahun);
    }

    public function capaian_kinerja()
    {
        $id_pegawai  = $this->session->userdata('id_pegawai');
        $input_bulan = $this->input->get('bulan');
        $bulan       = (isset($input_bulan) && $input_bulan != '') ? $input_bulan : (date('m') - 1);
        $input_tahun = $this->input->get('tahun');
        $tahun       = (isset($input_tahun) && $input_tahun != '') ? $input_tahun : date('Y');

        $input_validator = $this->input->get('id_validator');
        $id_validator    = (isset($input_validator) && $input_validator != '') ? $input_validator : $id_pegawai;

        $periode = sprintf('%04d-%02d', $tahun, $bulan);

        $data['bulan']        = $bulan;
        $data['tahun']        = $tahun;
        $data['id_validator'] = $id_validator;

        $this->db->where('periode', $periode);
        $this->db->where('b.id_validator', $id_validator);
        $this->db->select('a.*, b.nama, b.id_pegawai, b.id_validator');
        $this->db->from('ts_rekap_capaian a');
        $this->db->join('mst_pegawai b', 'a.nip = b.nip');

        $data['capaian_kinerja'] = $this->db->get()->result();
        $data['validator']       = $this->Pegawai_model->getValidator();

        $this->load->view('admin/penilaian_kinerja/capaian_kinerja', $data);
    }

    public function rekap_pegawai()
    {
        $id_validator = $this->session->userdata('id_pegawai');
        $periode      = $this->input->get('periode');
        $id_pj_sess   = $this->session->userdata('id_pj');

        if (isset($id_pj_sess) && $id_pj_sess != '') {
            $id_validator = $id_pj_sess;
        }

        if (!$periode) {
            $periode = date('Y-m');
        }

        $data['periode'] = $periode;
        $data['list']    = $this->Kinerja_model->getRekapPegawaiByValidator($id_validator, $periode);

        $this->load->view('penilaian_kinerja/rekap_pegawai', $data);
    }

    public function update_capaian_perpustu($id_validator, $bulan, $tahun)
    {
        $thn_anggrn = '2024';
        $pegawai    = $this->Pegawai_model->getListPegawaiByValidator($id_validator, $thn_anggrn);

        if (!empty($pegawai)) {
            for ($i = 0; $i < count($pegawai); $i++) {
                $id_pegawai = $pegawai[$i]->id_pegawai;
                $this->Kinerja_model->updateCapaianKinerja($id_pegawai, $bulan, $tahun);
            }
        }
        redirect('admin/penilaian_kinerja/capaian_kinerja?bulan=' . $bulan . '&tahun=' . $tahun . '&id_validator=' . $id_validator);
    }

    public function updateRekapInput()
    {
        $id_validator = $this->session->userdata('id_pegawai');
        $id_pj_sess   = $this->session->userdata('id_pj');
        $usergroup    = $this->session->userdata('usergroup');

        if ($usergroup < 3) {
            if ($id_pj_sess == '') {
                $id_validator = 29519;
            } else {
                $id_validator = $id_pj_sess;
            }
        }

        $input_bulan        = $this->input->get('bulan');
        $bulan              = (isset($input_bulan) && $input_bulan != '') ? $input_bulan : (date('m') - 1);
        $input_tahun        = $this->input->get('tahun');
        $tahun              = (isset($input_tahun) && $input_tahun != '') ? $input_tahun : date('Y');
        $selected_validator = $this->input->get('id_validator');

        if (isset($selected_validator) && $selected_validator != '') {
            $id_validator = $selected_validator;
        }

        $periode = sprintf('%04d-%02d', $tahun, $bulan);

        $data['bulan']   = $bulan;
        $data['tahun']   = $tahun;
        $data['periode'] = $periode;

        $rekap = $this->Kinerja_model->getRekapKinerjaPerPeriode($id_validator, $periode);

        if (!empty($rekap)) {
            foreach ($rekap as $row) {
                $arr_data = array(
                    'id_pegawai'  => $row->id_pegawai,
                    'periode'     => $periode,
                    'total_input' => isset($row->total_input) ? $row->total_input : 0,
                    'disetujui'   => isset($row->disetujui) ? $row->disetujui : 0,
                    'ditolak'     => isset($row->ditolak) ? $row->ditolak : 0
                );

                $cek = $this->db->get_where('rekap_input_kinerja', array(
                    'id_pegawai' => $row->id_pegawai,
                    'periode'    => $periode
                ))->row();

                if ($cek) {
                    $this->db->where('id', $cek->id)->update('rekap_input_kinerja', $arr_data);
                } else {
                    $this->db->insert('rekap_input_kinerja', $arr_data);
                }
            }
        }

        $pesan = createMessageInfo('Data kinerja berhasil diupdate');
        $this->session->set_flashdata('message', $pesan);
        redirect('admin/penilaian_kinerja/index?bulan=' . $bulan . '&tahun=' . $tahun . '&id_validator=' . $id_validator);
    }

    public function detail_capaian($nip)
    {
        $segment5 = $this->uri->segment(5);
        $segment6 = $this->uri->segment(6);

        $bulan   = (isset($segment5) && $segment5 != '') ? $segment5 : date('m');
        $tahun   = (isset($segment6) && $segment6 != '') ? $segment6 : date('Y');
        $periode = sprintf('%04d-%02d', $tahun, $bulan);

        $capaian    = $this->Kinerja_model->getCapaianPegawai($nip, $periode);
        $id_pegawai = isset($capaian->id_pegawai) ? $capaian->id_pegawai : 0;

        $data['rekap']         = $capaian;
        $data['absensi']       = $this->Presensi_model->getRekapAbsensiPegawai($id_pegawai, $periode);
        $data['dataCuti']      = $this->acm->getCutiPegawai($id_pegawai, $bulan, $tahun);

        $total        = $this->Kinerja_model->getTotalKinerja($id_pegawai, $periode);
        $totalStatus0 = $this->Kinerja_model->getTotalKinerja($id_pegawai, $periode, 0);
        $totalStatus1 = $this->Kinerja_model->getTotalKinerja($id_pegawai, $periode, 1);

        $data['dataAktifitas'] = array($total, $totalStatus0, $totalStatus1);
        $data['hariKerja']     = $this->Kinerja_model->getHariKerjaByPeriode($periode);
        $data['periode']       = $periode;

        $this->load->view('admin/penilaian_kinerja/detail_capaian', $data);
    }

    public function update_capaian_kinerja()
    {
        $periode        = $this->input->post('periode');
        $nip            = $this->input->post('nip');
        $bobotAktifitas = $this->input->post('bobot_aktifitas');
        $nilaiPerilaku  = $this->input->post('perilaku');
        $serapan        = 20;

        $total_capaian = $bobotAktifitas + $nilaiPerilaku + $serapan;

        $rekapCapaian = array(
            'periode'         => $periode,
            'nip'             => $nip,
            'bobot_aktifitas' => $bobotAktifitas,
            'perilaku'        => $nilaiPerilaku,
            'serapan'         => $serapan,
            'total_capaian'   => $total_capaian,
            'created_at'      => date('Y-m-d H:i:s')
        );

        $explode = explode('-', $periode);
        $tahun   = isset($explode[0]) ? $explode[0] : date('Y');
        $bulan   = isset($explode[1]) ? $explode[1] : date('m');

        $this->db->where(array('periode' => $periode, 'nip' => $nip))
            ->update('ts_rekap_capaian', $rekapCapaian);

        $this->session->set_flashdata('message', 'Data capaian berhasil diupdate');
        redirect('admin/penilaian_kinerja/detail_capaian/' . $nip . '/' . $bulan . '/' . $tahun);
    }

    public function update_capaian_pegawai($id_pegawai, $nip)
    {
        $segment6 = $this->uri->segment(6);
        $periode  = (isset($segment6) && $segment6 != '') ? $segment6 : date('Y-m');

        $explode = explode('-', $periode);
        $tahun   = isset($explode[0]) ? $explode[0] : date('Y');
        $bulan   = isset($explode[1]) ? $explode[1] : date('m');

        $this->Kinerja_model->updateCapaianKinerja($id_pegawai, $bulan, $tahun);
        $this->session->set_flashdata('message', 'Data capaian berhasil diupdate');

        redirect('admin/penilaian_kinerja/detail_capaian/' . $nip . '/' . $bulan . '/' . $tahun);
    }

    public function view_list_input_aktifitas()
    {
        $tgl        = $this->input->post('tgl');
        $id_pegawai = $this->input->post('id_pegawai');

        $this->db->select('a.*, b.nama_kegiatan as indikator');
        $this->db->where('tgl', $tgl);
        $this->db->where('id_pegawai', $id_pegawai);
        $this->db->from('ts_kinerja a');
        $this->db->join('mst_indikator_kegiatan b', 'a.id_indikator = b.id', 'left');

        $data['list'] = $this->db->get()->result();
        $data['tgl']  = $tgl;

        $this->load->view('penilaian_kinerja/list', $data);
    }

    public function setujui_aktifitas()
    {
        $check_id = $this->input->post('check_id');

        if (!empty($check_id) && is_array($check_id)) {
            for ($i = 0; $i < count($check_id); $i++) {
                $this->db->where('id', $check_id[$i]);
                $this->db->set('status', 1);
                $this->db->update('ts_kinerja');
            }
        }

        echo json_encode(array('status' => true));
    }

    public function view_all_aktifitas()
    {
        $id_pegawai = $this->input->post('id_pegawai');
        $periode    = $this->input->post('periode');

        $awal  = $periode . '-01';
        $akhir = date('Y-m-t', strtotime($awal));

        $this->db->select('a.*, b.nama_kegiatan as indikator');
        $this->db->where('id_pegawai', $id_pegawai);
        $this->db->where('tgl >=', $awal);
        $this->db->where('tgl <=', $akhir);
        $this->db->from('ts_kinerja a');
        $this->db->join('mst_indikator_kegiatan b', 'a.id_indikator = b.id', 'left');

        $dataList = $this->db->get()->result();
        $grouped  = array();

        if (!empty($dataList)) {
            foreach ($dataList as $row) {
                $tgl = $row->tgl;
                if (!isset($grouped[$tgl])) {
                    $grouped[$tgl] = array();
                }
                $grouped[$tgl][] = $row;
            }
        }

        $data['list'] = $grouped;
        $data['tgl']  = '';

        $this->load->view('penilaian_kinerja/list_all_aktifitas', $data);
    }

    public function proses_aktifitas()
    {
        $check_aktifitas = $this->input->post('check_aktifitas');
        $action_status   = $this->input->post('action_status');

        if (empty($check_aktifitas) || !is_array($check_aktifitas)) {
            echo json_encode(array(
                'status'  => 'error',
                'message' => 'Tidak ada aktivitas yang dipilih!'
            ));
            return;
        }

        $status_db = ($action_status === 'setujui') ? 1 : 2;
        $update    = $this->Penilaian_model->updateStatusAktifitasBulk($check_aktifitas, $status_db);

        if ($update) {
            $pesan = ($action_status === 'setujui')
                ? 'Aktivitas terpilih berhasil disetujui.'
                : 'Aktivitas terpilih berhasil ditolak.';

            echo json_encode(array('status' => 'success', 'message' => $pesan));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal memperbarui data aktivitas.'));
        }
    }

    public function approve_aktifitas()
    {
        $id_validator = $this->session->userdata('id_pegawai');
        $id           = $this->input->post('id');
        $status       = $this->input->post('status');
        $tgl_validasi = date('Y-m-d H:i:s');

        $this->db->where('id', $id);
        $this->db->set('status', $status);
        $this->db->set('tgl_validasi', $tgl_validasi);
        $this->db->set('id_validator', $id_validator);
        $this->db->update('ts_kinerja');

        if ($status == 1) {
            echo 'Aktifitas telah disetujui';
        } else {
            echo 'Aktifitas telah ditolak';
        }
    }

    public function aktivitas($id_pegawai, $bulan, $tahun)
    {
        $data['pegawai']               = $this->Pegawai_model->getDetailPegawai($id_pegawai);
        $data['dataAktifitasPegawai'] = $this->Kinerja_model->getAktifitasPegawai($id_pegawai);
        $this->load->view('penilaian_kinerja/penilaian_aktivitas', $data);
    }

    public function getInputanAktifitasPegawai()
    {
        $id_pegawai = $this->input->post('id_pegawai');
        $tgl        = $this->input->post('tanggal');

        $tanggal            = format_db($tgl);
        $data['dataAktifitas'] = $this->Kinerja_model->getDataInputAktifitas($id_pegawai, $tanggal);
        $data['tanggal']    = $tanggal;
        $data['id_pegawai'] = $id_pegawai;

        $cekData = $this->Kinerja_model->cekDataAktifitasPending($id_pegawai, $tanggal);
        if (count($cekData) == 0) {
            $data['approved_all'] = true;
        } else {
            $data['approved_all'] = false;
        }

        $this->load->view('penilaian_kinerja/view_inputan_aktifitas', $data);
    }

    public function cancel_acc_aktifitas()
    {
        $id           = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db->set('status', 0);
        $this->db->update('ts_kinerja');

        echo 'Aktifitas batal disetujui';
    }

    public function approve_all_aktifitas()
    {
        $id_validator = $this->session->userdata('id_pegawai');
        $data_value   = $this->input->post('data_value');
        $xpl          = explode("/", $data_value);
        $id_pegawai   = isset($xpl[0]) ? $xpl[0] : '';
        $tanggal      = isset($xpl[1]) ? $xpl[1] : '';

        $tgl_validasi = date('Y-m-d H:i:s');

        $this->db->where('id_pegawai', $id_pegawai);
        $this->db->where('tgl', $tanggal);
        $this->db->set('status', 1);
        $this->db->set('tgl_validasi', $tgl_validasi);
        $this->db->set('id_validator', $id_validator);
        $this->db->update('ts_kinerja');

        echo 'Aktifitas tanggal ' . format_semi($tanggal) . ' telah disetujui';
    }

    public function set_session_validator()
    {
        $id_pj = $this->input->post('id_pj');
        $this->session->set_userdata('id_pj', $id_pj);
        return true;
    }

    public function ajaxGetPoinPerilaku()
    {
        $data_value = $this->input->post('value');
        $id_pegawai = $this->input->post('id_pegawai');
        $bulan      = $this->session->userdata('periode_bulan');
        $tahun      = $this->session->userdata('periode_tahun');

        $xpl        = explode("_", $data_value);
        $jawaban    = isset($xpl[0]) ? $xpl[0] : 0;
        $id_jawaban = isset($xpl[1]) ? $xpl[1] : 0;
        $jns_item   = isset($xpl[2]) ? $xpl[2] : 1;

        if ($jns_item == 2) {
            $poin = getPoinPerilaku($jawaban);
        } else {
            $poin = $jawaban;
        }

        $this->db->where('id', $id_jawaban);
        $this->db->set('jawaban', $jawaban);
        $this->db->set('poin', $poin);
        $this->db->update('tbl_penilaian_perilaku');

        $totalPoin = $this->Kinerja_model->getPoinPerilaku($id_pegawai, $bulan, $tahun);
        echo $totalPoin;
    }

    public function tarik_data($nip, $id_pegawai_baru)
    {
        $data_ekin = $this->Kinerja_model->getIDPegawaiekin($nip);

        if (!empty($data_ekin) && isset($data_ekin[0]->id_pegawai)) {
            $id_pegawai_ekin = $data_ekin[0]->id_pegawai;
            redirect('admin/penilaian_kinerja/proses_tarik_data/' . $id_pegawai_ekin . '/' . $id_pegawai_baru);
        } else {
            $pesan = createMessageInfo('Data pegawai tidak ditemukan');
            $this->session->set_flashdata('message', $pesan);
            redirect('admin/penilaian_kinerja/index');
        }
    }

    public function proses_tarik_data($id_pegawai, $id_ekin_v2)
    {
        $getInputan = $this->Kinerja_model->getInputan($id_pegawai);
        $this->Kinerja_model->delete_inputan($id_ekin_v2);

        $dataPerilaku = $this->Kinerja_model->getDataPerilkuEkin1($id_pegawai);

        if (!empty($getInputan)) {
            foreach ($getInputan as $akt) {
                $total    = $akt->waktu * $akt->volume;
                $new_data = array(
                    'id_pegawai'    => $id_ekin_v2,
                    'tgl'           => $akt->tgl,
                    'jns_kegiatan'  => $akt->jns_kegiatan,
                    'id_indikator'  => 0,
                    'nama_kegiatan' => $akt->nama_kegiatan,
                    'jam_mulai'     => $akt->jam_mulai,
                    'jam_selesai'   => $akt->jam_selesai,
                    'volume'        => $akt->volume,
                    'waktu_efektif' => $akt->waktu,
                    'total'         => $total,
                    'status'        => $akt->status,
                    'ket'           => $akt->ket
                );
                $this->db->insert('ts_kinerja', $new_data);
            }
        }

        // Hapus data penilaian perilaku lama (Query Binding aman)
        $this->db->where('id_pegawai', $id_ekin_v2);
        $this->db->where('periode_bulan', '01');
        $this->db->where('periode_tahun', '2024');
        $this->db->delete('tbl_penilaian_perilaku');

        if (!empty($dataPerilaku)) {
            for ($i = 0; $i < count($dataPerilaku); $i++) {
                $this->Kinerja_model->insertPenilaianPerilaku(
                    $id_ekin_v2,
                    1,
                    '2024',
                    $dataPerilaku[$i]->tgl_input,
                    $dataPerilaku[$i]->id_pertanyaan,
                    $dataPerilaku[$i]->jns_item,
                    $dataPerilaku[$i]->jawaban,
                    $dataPerilaku[$i]->poin
                );
            }
        }

        $pesan = createMessageInfo('Data kinerja berhasil ditransfer');
        $this->session->set_flashdata('message', $pesan);
        redirect('admin/penilaian_kinerja/index');
    }
}
