<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Admin_jadwal_shift extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();
        $this->load->library('cart');
        $this->load->model('Shift_model');
        $this->Auth_model->cekAuthLogin();
    }


    function index()
    {
        $id_pegawai  =  $this->session->userdata('id_pegawai');
        $data['bagian'] = $this->Master_model->getBagianShift();
        $usergroup  = $this->session->userdata('usergroup');

        if ($usergroup == 7) {
            $qry = $this->db->get_where('mst_bagian', array('id_pj' => $id_pegawai));
            $row = $qry->result();
            $id_bagian = $row[0]->id_bagian;
            redirect('admin_jadwal_shift/shift_kerja/' . $id_bagian);
        }

        //print_array($this->session->userdata);
        $this->cart->destroy();
        $this->load->view('admin_jadwal_shift/index', $data);
    }

    function create_bagian()
    {
        $nama_bagian = $this->input->post('nama_bagian');

        $data = array(
            'nama_bagian' => $nama_bagian,
            'nama_pj_bagian' => $this->input->post('nama_pj'),
            'id_pj' => $this->input->post('id_pj')
        );
        $this->session->set_flashdata('success', 'Data bagian telah berhasil ditambahkan');
        $this->db->insert('mst_bagian', $data);
    }


    function change_periode($id_pjlp)
    {
        $this->session->set_userdata($this->input->post());


        redirect('admin_jadwal_shift/shift_pjlp');
    }

    function delete($id_bagian)
    {

        $this->db->where('id_bagian', $id_bagian);
        $this->db->delete('mst_bagian');

        $this->session->set_flashdata('success', 'Data bagian telah berhasil dihapus');
        redirect('admin_jadwal_shift/index');
    }

    public function search_pegawai()
    {
        $keyword = $this->input->post('keyword');

        echo '<script>


                $(".choose_pegawai").click(function() {
                    var data = $(this).attr("id");
                    var pecah = data.split("/");
                    var id_pegawai = pecah[0];
                    var nama_pegawai = pecah[1];

                    $("#search_pegawai").val(nama_pegawai);
                    $("#id_pj_choose").val(id_pegawai);
                    $("#list_pegawai").hide();
                });
                </script>';



        $row = $this->Pegawai_model->search_pegawai($keyword);

        for ($i = 0; $i < count($row); $i++) {
            $id_pegawai = $row[$i]->id_pegawai;
            $nama = $row[$i]->nama;

            echo '<div class="choose_pegawai" id="' . $id_pegawai . '/' . $nama . '">' . $nama . '</div>';
        }
    }

    function edit()
    {
        $id_bagian = $this->input->post('id_bagian');

        $qry = $this->db->get_where('mst_bagian', array('id_bagian' => $id_bagian));
        $data['data_edit']  = $qry->result();

        $this->load->view('admin_jadwal_shift/edit', $data);
        // print_array($row);
    }

    function update($id_bagian)
    {
        $nama_bagian = $this->input->post('nama_bagian');

        $data = array(
            'nama_bagian' => $nama_bagian,
            'nama_pj_bagian' => $this->input->post('nama_pj'),
            'id_pj' => $this->input->post('id_pj')
        );

        $this->db->where('id_bagian', $id_bagian);
        $this->db->update('mst_bagian', $data);

        $this->session->set_flashdata('success', 'Data bagian telah berhasil disimpan');
        redirect('admin_jadwal_shift/index');
    }


    function shift_kerja($id_bagian)
    {

        $data['list_pegawai']  = $this->Pegawai_model->getPegawaiPerbagian($id_bagian);
        $data['shift_kerja']  =  $this->Master_model->getShiftKerja(1);
        $this->load->view('admin_jadwal_shift/list_pegawai', $data);
    }


    function summary($id_bagian)
    {
        $data['list_pegawai']  = $this->Pegawai_model->getPegawaiPerbagian($id_bagian);
        $data['shift_kerja']  =  $this->Master_model->getShiftKerja(1);
        $this->load->view('admin_jadwal_shift/summary', $data);
    }

    function insertShiftKerja()
    {
        $data_post = $this->input->post('data_post');
        $kode_shift = $this->input->post('kode_shift');
        $pin   = $this->input->post('pin');

        if ($pin == '') {
            //pakai pin pegawai yg jam kerjanya regular, karena untuk pegawai yg jam kerjanya regular tidak ada pin di tabel pegawai
              $pin = '5050';
        }


        $expld = explode("_", $data_post);
        $id_pegawai = $expld[0];
        $tanggal    = $expld[1];

        $tgl = format_db($tanggal);

        // $row = $this->db->select('id_mesin')
        //     ->where('id_pegawai', $id_pegawai)
        //     ->get('mst_pegawai')
        //     ->row();

        //$pin = $row ? $row->id_mesin : 0;

        $row = $this->db->select('id')
            ->where([
                'pin' => $pin,
                'tanggal'    => $tgl
            ])
            ->get('ts_shift_kerja')
            ->row();

        if ($row) {
            // Update
            $this->db->where('id', $row->id)
                ->update('ts_shift_kerja', [
                    'shift' => $kode_shift
                ]);
        } else {
            // Insert
            $this->db->insert('ts_shift_kerja', [
                'tanggal'    => $tgl,
                'id_pegawai' => $id_pegawai,
                'pin'        => $pin,
                'shift'      => $kode_shift
            ]);
        }



        $cekAbsenExist = $this->Presensi_model->cekAbsenExist($tgl, $pin);
        $id_absen = $cekAbsenExist;
        if ($id_absen == 0) {
            $this->db->where('id', $id_absen);
            $this->db->set('shift', $kode_shift);
            $this->db->update('tbl_absensi');
        }
        // redirect('admin_jadwal_shift/index');
    }

    function insertShiftKerjaPJLP()
    {
        $data_post = $this->input->post('data_post');
        $kode_shift = $this->input->post('kode_shift');


        $expld = explode("_", $data_post);
        $id_pjlp = $expld[0];
        $tanggal    = $expld[1];

        $tgl = format_db($tanggal);


        $pegawai = $this->Pegawai_model->getDataEditPegawaiPJLP($id_pjlp);
        $nama       = $pegawai[0]->nama;

        $cekIdShift =  $this->Presensi_model->getDatashiftKerjaPJLP($id_pjlp, $tgl, 'id', 'pjlp');


        // echo $cekIdShift;
        // exit;

        if ($cekIdShift != 0) {
            $id = $cekIdShift;
            $this->db->where('id', $id);
            $this->db->set('shift', $kode_shift);
            $this->db->update('ts_shift_kerja');
        } else {
            $data = array(
                'tanggal' => $tgl,
                'id_pegawai' => $pegawai[0]->id,
                'pin' => $id_pjlp,
                'shift' => $kode_shift,
                'jns_pegawai' => 'pjlp'
            );


            $this->db->insert('ts_shift_kerja', $data);
        }

        //redirect('admin_jadwal_shift/index');
    }


    function upload_shift_kerja(){
        //mensinkronkan jadwal shift kerja pegawai ke tble absensi pegawai

        $id_pjlp = $this->input->get('id_pegawai');
        $pin = $this->input->get('pin');
        $periode = $this->input->get('periode');

         $qry = $this->db->get_where('tbl_pegawai_pjlp', ['id_pjlp' => $id_pjlp]);
        $row1 = $qry->row();
        if (!empty($row1)) {
            $pin =  $row1->id_mesin;
        } else {
            $this->session->set_flashdata('error', 'PIN tidak ditemukan');
            redirect('admin/absensi_pjlp/index/' . $id_pjlp);
        }



        $sql = "SELECT a.*, b.jam_masuk, b.jam_pulang
                FROM ts_shift_kerja a
                LEFT JOIN mst_shift_kerja b ON a.shift = b.kode_shift
                WHERE pin = '$pin' AND tanggal like '$periode%'";



        $qry = $this->db->query($sql);
        $row = $qry->result();

        if (empty($row)) {

            $this->session->set_flashdata('error', 'Data shift  tidak ditemukan');
            redirect('admin/absensi_pjlp/index/' . $id_pjlp);
        }

        // print_array($row);
        // exit;

        for ($i = 0; $i < count($row); $i++) {

            $tanggal = $row[$i]->tanggal;
            $shift = $row[$i]->shift;
            $jam_masuk = $row[$i]->jam_masuk;
            $jam_pulang = $row[$i]->jam_pulang;


            $cekID = $this->Presensi_model->cekAbsenExist($tanggal, $id_pjlp, 'tbl_absensi_pjlp');

            if ($cekID == 0) {
                $newArray = array(
                    'tanggal' => $tanggal,
                    'pin' => $id_pjlp,
                    'shift' => $shift,
                    'jam_masuk' => $jam_masuk,
                    'jam_pulang' => $jam_pulang,
                    'masuk' => '',
                    'pulang' => '',
                    'telat' => 0,
                    'p_awal' => 0,
                    'keterangan' => ''
                );

                $this->db->insert('tbl_absensi_pjlp', $newArray);
            } else {
                $newArray = array(
                    'tanggal' => $tanggal,
                    'pin' => $id_pjlp,
                    'shift' => $shift,
                    'jam_masuk' => $jam_masuk,
                    'jam_pulang' => $jam_pulang,
                    'telat' => 0,
                    'p_awal' => 0,
                    'keterangan' => ''
                );

                $this->db->where('id', $cekID);
                $this->db->update('tbl_absensi_pjlp', $newArray);
            }
        }
        $this->session->set_flashdata('success', 'Data shift pegawai berhasil diupdate');

        redirect('admin_jadwal_shift/shift_pjlp');

    }

    function update_absensi_pegawai($id_pegawai, $pin)
    {
        $periode_bulan = $this->session->userdata('periode_bulan');
        $periode_tahun = $this->session->userdata('periode_tahun');

        if ($periode_bulan == '') {
            $bulan = date('m');
            $tahun = date('Y');
        } else {
            $bulan = $periode_bulan;
            $tahun = $periode_tahun;
        }


        $periode = $tahun . '-' . $bulan;
        $periode = date('Y-m', strtotime($periode));

        $lastDate = date('t', strtotime($periode)) + 1;
        for ($t = 1; $t < $lastDate; $t++) {
            $tanggal = $periode . '-' . $t;
            $formatDate = date('Y-m-d', strtotime($tanggal));

            $shift = $this->Presensi_model->getDatashiftKerja($id_pegawai, $formatDate, 'shift');

            if ($shift == '-') {
                //echo 'Jangan Update';

                // $id = $this->Presensi_model->cekAbsenExist($formatDate, $pin);

            } else {
                $id = $this->Presensi_model->cekAbsenExist($formatDate, $pin);

                if ($id == 0) {
                    $this->Presensi_model->insertShiftPegawai($pin, $formatDate, $shift);
                } else {

                    $this->Presensi_model->updateShiftPegawai($pin, $formatDate, $shift, $id);
                }
            }
        }
        redirect('admin_jadwal_shift/shift_kerja/7');
    }



    function shift_regular()
    {
        //
        $data['shift_kerja']  =  $this->Shift_model->getShiftTemplate();
        $this->load->view('admin_jadwal_shift/shift_regular', $data);
    }

    function detail_shift_template($id)
    {
        $data['template']  =  $this->Shift_model->getShiftTemplateByID($id);
        $data['detail_template']  =  $this->Shift_model->getDetailShiftTemplate($id);
        $data['shift_kerja']  =  $this->Master_model->getShiftKerja(1);
        $this->load->view('admin/template_shift/detail', $data);
    }

    function update_shift(){
            
        $id_template = $this->input->post('id_template');
        $detail_id = $this->input->post('detail_id');
        $shift_id = $this->input->post('shift_id');

       // print_array($this->input->post());

        for($i=0; $i<count($detail_id); $i++){
            $data = array(
                'shift_id' => $shift_id[$i]
            );

            $this->db->where('id', $detail_id[$i]);
            $this->db->update('tbl_shift_template_detail', $data);
        }

        redirect('admin_jadwal_shift/detail_shift_template/'.$id_template);
    }



    function getInfo()
    {
        $data_post = $this->input->post('data_post');

        $expld = explode("_", $data_post);
        $id_pegawai = $expld[0];
        $tanggal    = $expld[1];

        $formatDate = format_view($tanggal);


        if ($id_pegawai > 0) {
            $nama = $this->Pegawai_model->getNamaPegawaiByID($id_pegawai);
        } else {
            $nama = '';
        }


        echo  '<h5>' . $nama . '</h5>Tanggal : <strong>' . $formatDate . '</strong>';
    }

    function getInfoPegawaiPJLP()
    {
        $data_post = $this->input->post('data_post');

        $expld = explode("_", $data_post);
        $id_pjlp = $expld[0];
        $tanggal    = $expld[1];

        $formatDate = format_view($tanggal);



        if ($id_pjlp > 0) {
            $pegawai = $this->Pegawai_model->getDataEditPegawaiPJLP($id_pjlp);
            $nama = $pegawai[0]->nama;
        } else {
            $nama = '';
        }


        echo  '<h5>' . $nama . '</h5>Tanggal : <strong>' . $formatDate . '</strong>';
    }


    public function search_pegawai_edit()
    {
        $keyword = $this->input->post('keyword');

        echo '<script>


                $(".choose_pegawai").click(function() {
                    var data = $(this).attr("id");
                    var pecah = data.split("/");
                    var id_pegawai = pecah[0];
                    var nama_pegawai = pecah[1];

                    $("#search_pegawai_edit").val(nama_pegawai);
                    $("#id_pj_choose_edit").val(id_pegawai);
                    $("#list_pegawai_edit").hide();
                });
                </script>';



        $row = $this->Pegawai_model->search_pegawai($keyword);

        for ($i = 0; $i < count($row); $i++) {
            $id_pegawai = $row[$i]->id_pegawai;
            $nama = $row[$i]->nama;

            echo '<div class="choose_pegawai" id="' . $id_pegawai . '/' . $nama . '">' . $nama . '</div>';
        }
    }


    function get_data()
    {
        $keyword = $this->input->post('keyword');
        $bagian = trim($this->input->post('bagian'));

        if ($bagian == 41) {

            $this->db->like('nama', $keyword, 'after');
            $qry = $this->db->get('tbl_pegawai_pjlp');
            $data = $qry->result();


            //$data = $this->Pegawai_model->search_pegawai_pjlp($keyword);
            //  $table = 'tbl_pegawai_pjlp';
        } else {

            $data = $this->Pegawai_model->search_pegawai($keyword);
            // $table = 'mt_pegawai';
        }
        //  echo $table;


        $html = '';
        if (!empty($data)) {
            foreach ($data as $row) {

                if ($bagian == 41) {
                    $html .= '<tr>';
                    $html .= '<td>' . $row->nama . '</td>';
                    $html .= '<td>' . $row->id_pjlp . '</td>';
                    $html .= '<td>' . $row->id_pjlp . '</td>';
                    $html .= '<td>';

                    // Cek status, jika sudah 1 maka tombol dinonaktifkan

                    $html .= '<button class="btn btn-primary btn-sm btn-tambah" data-id="' . $row->id_pjlp . '">Tambahkan</button>';
                } else {
                    $html .= '<tr>';
                    $html .= '<td>' . $row->nama . '</td>';
                    $html .= '<td>' . $row->nip . '</td>';
                    $html .= '<td>' . $row->id_pegawai . '</td>';
                    $html .= '<td>';

                    // Cek status, jika sudah 1 maka tombol dinonaktifkan

                    $html .= '<button class="btn btn-primary btn-sm btn-tambah" data-id="' . $row->id_pegawai . '">Tambahkan</button>';
                }


                $html .= '</td>';
                $html .= '</tr>';
            }
        } else {
            $html .= '<tr><td colspan="4" class="text-center">Data tidak ditemukan</td></tr>';
        }

        echo $html;
    }


    // Mengubah status via AJAX
    public function add_list_pegawai()
    {
        $id = $this->input->post('id_pegawai');
        $id_bagian = trim($this->input->post('bagian'));



        if ($id_bagian == 41) {
            //bagian pjlp
            //$nip = $item['desc'];
            $this->db->where('id_pjlp', $id);
            $this->db->set('bagian_shift', $id_bagian);
            $update =  $this->db->update('tbl_pegawai_pjlp');
        } else {
            //yg lainnya (non pns) pppk pw

            $this->db->where('id_pegawai', $id);
            $this->db->set('bagian_shift', $id_bagian);
            $update =  $this->db->update('mst_pegawai');
        }



        if ($update) {
            echo json_encode(['status' => 'success', 'message' => 'Pegawai berhasil ditambahkan!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan pegawai.']);
        }
    }





    public function search_pegawai_cart()
    {
        $keyword = $this->input->post('keyword');


        echo '<script>


                $(".choose_pegawai").click(function() {
                    var id_pegawai = $(this).attr("id");


                        $.ajax({
                            type: "POST",
                            url: "' . base_url() . 'admin_jadwal_shift/add_cart",
                            data: "id_pegawai=" + id_pegawai,
                            success: function(return_data) {
                                $("#search_pegawai_cart").val("");
                                $("#list_pegawai_cart").hide();
                                $("#cart_pegawai").html(return_data);
                            }
                        });


                });
                </script>';



        $row = $this->Pegawai_model->search_pegawai($keyword);

        for ($i = 0; $i < count($row); $i++) {
            $id_pegawai = $row[$i]->id_pegawai;
            $nama       = $row[$i]->nama;

            echo '<div class="choose_pegawai" id="' . $id_pegawai . '">' . $nama . '</div>';
        }
    }

    public function add_cart()
    {
        $id_pegawai = $this->input->post('id_pegawai');

        $pegawai = $this->Pegawai_model->getDataEditPegawai($id_pegawai);

        $nama = $pegawai[0]->nama;
        $nama_cart = str_replace(",", "-", $nama);

        $data = array(
            'id'      => $id_pegawai,
            'qty'     => 1,
            'price'   => 1000,
            'name'    => $nama_cart,
            'desc'  =>  $pegawai[0]->nip,
        );

        $this->cart->insert($data);
        $cart_contents = $this->cart->contents();
        foreach ($cart_contents as $item) :

            $nama_cart = $item['name'];
            $nama_pegawai = str_replace("-", ",", $nama_cart);
            echo ' <div class="cart-list">' . $nama_pegawai . ' <a class="remove-cart" id="' . $item['rowid'] . '">  <i class="ti ti-trash"></i> </a> </div> ';

        endforeach;
    }

    function simpan($id_bagian)
    {
        $cart_contents = $this->cart->contents();

        print_array($cart_contents);
        exit;

        foreach ($cart_contents as $item) :


            if ($id_bagian == 40) {
                //bagian pjlp
                $nip = $item['desc'];
                $this->db->where('nip', $nip);
                $this->db->set('bagian_shift', $id_bagian);
                $this->db->update('tbl_pegawai_pjlp');
            } else {
                //yg lainnya (non pns) pppk pw
                $nip = $item['desc'];
                $this->db->where('nip', $nip);
                $this->db->set('bagian_shift', $id_bagian);
                $this->db->update('mst_pegawai');
            }



        endforeach;


        $this->session->set_flashdata('success', 'Data bagian telah berhasil disimpan');
        redirect('admin_jadwal_shift/index');
    }
    function delete_from_list($id_pegawai)
    {
        $this->db->where('id_pegawai', $id_pegawai);
        $this->db->set('bagian_shift', 0);
        $this->db->update('mst_pegawai');
        $this->session->set_flashdata('success', 'Data bagian telah berhasil disimpan');
        redirect('admin_jadwal_shift/index');
    }


    function shift_pjlp()
    {

        // $data['list_pegawai'] = $this->Pegawai_model->getPegawaiPJLP();

        // Konfigurasi pagination
        $config['base_url'] = base_url('admin_jadwal_shift/shift_pjlp/');
        $config['total_rows'] = $this->Pegawai_model->countPegawaiPJLP(); // Jumlah total data
        $config['per_page'] = 10; // Jumlah data per halaman

        // Inisialisasi pagination
        $this->pagination->initialize($config);
        $offset =  $this->uri->segment(3);
        if ($offset == '') {
            $offset = 0;
        }
        // Ambil data dari model dengan limit dan offset

        $data['shift_kerja']  =  $this->Master_model->getShiftKerjaPJLP();
        $data['list_pegawai'] = $this->Pegawai_model->getListPJLP($config['per_page'], $offset);
        $data['total_rows']  =      $config['total_rows'];
        $data['offset'] =  $offset;


        

       $this->load->view('admin_jadwal_shift/shift_pjlp', $data);

        // 
        // $this->load->view('admin_jadwal_shift/shift_pjlp', $data);
    }
}
