<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat_gaji extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'Pegawai_model',
            'RiwayatGaji_model'
        ]);
    }

    public function generate()
    {
        $tahun_anggaran = 2024;
        $today = date('Y-m-d');

        $pegawaiList = $this->Pegawai_model
            ->getPegawaiForRiwayatGaji($tahun_anggaran);

        foreach ($pegawaiList as $pegawai) {

            $tglMasuk = new DateTime($pegawai->tgl_masuk);
            $now      = new DateTime($today);

            // loop 2 tahunan
            $periodeKe = 0;
            $currentTmt = clone $tglMasuk;

            while ($currentTmt <= $now) {

                $tmt = $currentTmt->format('Y-m-d');

                // hitung masa kerja
                $masaKerjaTahun = $tglMasuk->diff($currentTmt)->y;
                $masaKerjaBulan = $tglMasuk->diff($currentTmt)->m;

                // ambil master masa kerja
                $masaKerja = $this->RiwayatGaji_model
                    ->getByTahun($masaKerjaTahun);

                if (!$masaKerja) {
                    $currentTmt->modify('+2 years');
                    $periodeKe++;
                    continue;
                }

                // ambil gaji pokok
                $gaji = $this->RiwayatGaji_model
                    ->getGajiPokok($masaKerja->id, $pegawai->id_pendidikan);

                if (!$gaji) {
                    $currentTmt->modify('+2 years');
                    $periodeKe++;
                    continue;
                }

                // cek apakah sudah ada
                if (!$this->RiwayatGaji_model->exists($pegawai->id_pegawai, $tmt)) {

                    $gajiPokok = $gaji->jumlah;
                    $totalGaji = $gajiPokok * $pegawai->pengali;

                    $data = [
                        'id_pegawai'        => $pegawai->id_pegawai,
                        'nip'               => $pegawai->nip,
                        'tmt'               => $tmt,
                        'periode_ke'        => $periodeKe,
                        'masa_kerja_tahun'  => $masaKerjaTahun,
                        'masa_kerja_bulan'  => $masaKerjaBulan,
                        'id_masa_kerja'     => $masaKerja->id,
                        'gaji_pokok'        => $gajiPokok,
                        'pengali'           => $pegawai->pengali,
                        'total_gaji'        => $totalGaji,
                        'jenis_riwayat'     => ($periodeKe == 0) ? 'awal' : 'kenaikan_berkala',
                        'created_at'        => date('Y-m-d H:i:s')
                    ];

                    $this->RiwayatGaji_model->insert($data);
                }

                // next periode
                $currentTmt->modify('+2 years');
                $periodeKe++;
            }
        }

        echo "Generate riwayat gaji selesai";
    }
}
