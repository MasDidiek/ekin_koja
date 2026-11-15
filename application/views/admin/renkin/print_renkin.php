<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sasaran Kinerja Pegawai - MUH. SAEFUDDIN</title>
    <style>
        /* Pengaturan Kertas & Print */
        @page {
            size: F4 landscape; /* atau A4 landscape, mediabox PDF 1008x612 pt (14 x 8.5 inch / F4 Landscape) */
            margin: 10mm 10mm 10mm 10mm;
        }

        * {
            box-sizing: border-box;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9pt;
            color: #000;
            margin: 0;
            padding: 15px;
            background-color: #f3f4f6;
        }

        .page-container {
            width: 100%;
            max-width: 1300px;
            margin: 0 auto;
            background: #fff;
            padding: 15px 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Toolbar Print (Hanya tampil di layar, hilang saat di-print) */
        .no-print-bar {
            max-width: 1300px;
            margin: 0 auto 12px auto;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-print {
            background-color: #0284c7;
            color: #fff;
            border: none;
            padding: 8px 18px;
            font-size: 13px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }

        .btn-print:hover {
            background-color: #0369a1;
        }

        /* Judul Dokumen */
        .doc-title {
            text-align: center;
            font-weight: bold;
            font-size: 10pt;
            line-height: 1.4;
            margin-bottom: 14px;
            text-transform: uppercase;
        }

        .sub-header {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            font-size: 9pt;
            margin-bottom: 5px;
        }

        .sub-header .periode span {
            margin-left: 25px;
        }

        /* Styling Tabel Utama */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
            table-layout: fixed;
        }

        th, td {
            border: 1px solid #000;
            padding: 4px 6px;
            vertical-align: top;
            word-wrap: break-word;
            line-height: 1.3;
        }

        /* Warna Header Tosca/Cyan Muda sesuai PDF */
        .bg-header {
            background-color: #88f7f7 !important;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .font-bold {
            font-weight: bold;
        }

        .v-middle {
            vertical-align: middle;
        }

        /* List tanpa bullet berlebih di perilaku kerja */
        .perilaku-list {
            margin: 2px 0 0 0;
            padding-left: 12px;
            list-style-type: none;
        }

        .perilaku-list li {
            text-indent: -10px;
            margin-bottom: 2px;
        }

        /* Area Tanda Tangan */
        .ttd-wrapper {
            width: 100%;
            display: flex;
            justify-content: space-between;
            margin-top: 22px;
            padding: 0 40px;
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .ttd-box {
            width: 300px;
            text-align: center;
            font-size: 9pt;
            line-height: 1.4;
        }

        .ttd-space {
            height: 65px;
        }

        /* Pemisah Halaman Lampiran */
        .lampiran-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px dashed #ccc;
        }

        /* Pengaturan Khusus Saat Dicetak (Print) */
        @media print {
            body {
                background: #fff;
                padding: 0;
                margin: 0;
            }

            .no-print-bar {
                display: none !important;
            }

            .page-container {
                box-shadow: none;
                padding: 0;
                max-width: 100%;
                width: 100%;
            }

            /* Mencegah baris tabel terpotong di tengah saat ganti halaman */
            tr {
                page-break-inside: avoid;
                break-inside: avoid;
            }

            thead {
                display: table-header-group;
            }

            .lampiran-section {
                border-top: none;
                margin-top: 0;
                padding-top: 0;
                page-break-before: always;
                break-before: page;
            }
        }
    </style>
</head>
<body>

    <div class="no-print-bar">
        <button class="btn-print" onclick="window.print()">🖨️ Cetak / Print SKP</button>
    </div>

    <div class="page-container">
        <!-- BAGIAN 1: FORMULIR SKP UTAMA -->
        <div class="doc-title">
            SASARAN KINERJA PEGAWAI<br>
            PENDEKATAN HASIL KERJA KUANTITATIF<br>
            BAGI PEJABAT ADMINISTRASI DAN PEJABAT FUNGSIONAL
        </div>

        <div class="sub-header">
            <div>PUSKESMAS KOJA</div>
            <div class="periode">PERIODE PENILAIAN <span>1 Januari S.D. 31 Desember <?= $tahun_renkin ?></span></div>
        </div>

        <!-- TABEL IDENTITAS PEGAWAI & PEJABAT PENILAI -->
        <table>
            <colgroup>
                <col style="width: 3.5%;">
                <col style="width: 16.5%;">
                <col style="width: 30%;">
                <col style="width: 3.5%;">
                <col style="width: 16.5%;">
                <col style="width: 30%;">
            </colgroup>
            <thead>
                <tr class="bg-header text-center">
                    <th>NO</th>
                    <th colspan="2">PEGAWAI YANG DINILAI</th>
                    <th>NO</th>
                    <th colspan="2">PEJABAT PENILAI KINERJA</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center font-bold">1</td>
                    <td class="font-bold">NAMA</td>
                    <td class="font-bold"><?= $detail_pegawai[0]->nama ?></td>
                    <td class="text-center font-bold">1</td>
                    <td class="font-bold">NAMA</td>
                    <td class="font-bold"><?= $validator[0]->nama ?></td>
                </tr>
                <tr>
                    <td class="text-center font-bold">2</td>
                    <td class="font-bold">NIP</td>
                    <td class="font-bold"><?= $detail_pegawai[0]->nip ?></td>
                    <td class="text-center font-bold">2</td>
                    <td class="font-bold">NIP</td>
                    <td class="font-bold"><?= $validator[0]->nip ?></td>
                </tr>
                <tr>
                    <td class="text-center font-bold">3</td>
                    <td class="font-bold">PANGKAT/GOL. RUANG</td>
                    <td class="font-bold">-</td>
                    <td class="text-center font-bold">3</td>
                    <td class="font-bold">PANGKAT/GOL. RUANG</td>
                    <td class="font-bold"><?= $validator[0]->golongan ?></td>
                </tr>
                <tr>
                    <td class="text-center font-bold">4</td>
                    <td class="font-bold">JABATAN</td>
                    <td class="font-bold"><?= $detail_pegawai[0]->jabatan ?></td>
                    <td class="text-center font-bold">4</td>
                    <td class="font-bold">JABATAN</td>
                    <td class="font-bold"><?= $validator[0]->jabatan ?></td>
                </tr>
                <tr>
                    <td class="text-center font-bold">5</td>
                    <td class="font-bold">UNIT KERJA</td>
                    <td class="font-bold"><?= $detail_pegawai[0]->puskesmas ?></td>
                    <td class="text-center font-bold">5</td>
                    <td class="font-bold">UNIT KERJA</td>
                    <td class="font-bold"><?= $validator[0]->puskesmas ?></td>
                </tr>
            </tbody>
        </table>

        <!-- TABEL HASIL KERJA -->
        <table style="border-top: none;">
            <colgroup>
                <col style="width: 3.5%;">
                <col style="width: 21.5%;">
                <col style="width: 25%;">
                <col style="width: 8%;">
                <col style="width: 29%;">
                <col style="width: 13%;">
            </colgroup>
            <thead>
                <tr class="bg-header">
                    <th colspan="6" class="text-left" style="border-top: none;">HASIL KERJA</th>
                </tr>
                <tr class="bg-header text-center v-middle">
                    <th>NO</th>
                    <th>RENCANA HASIL KERJA ATASAN<br>YANG DIINTERVENSI</th>
                    <th>RENCANA HASIL KINERJA</th>
                    <th>ASPEK</th>
                    <th>INDIKATOR KINERJA INDIVIDU</th>
                    <th>TARGET</th>
                </tr>
                <tr class="bg-header text-center">
                    <th>(1)</th>
                    <th>(2)</th>
                    <th>(3)</th>
                    <th>(4)</th>
                    <th>(5)</th>
                    <th>(6)</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-header">
                    <td colspan="6" class="text-left">A. KINERJA UTAMA</td>
                </tr>

                <?php

//print_array($list_renkin);
?>


<?php
                foreach ($list_renkin as $index => $renkin) {
                ?>
                <tr>
                    <td class="text-center v-middle"><?php echo $index + 1; ?></td>
                    <td></td>
                    <td></td>
                    <td>Kuantitas</td>
                    <td><?php echo $renkin->indikator; ?></td>
                    <td><?php echo $renkin->target_tahunan; ?> <?=$renkin->satuan; ?></td>
                </tr>
                
                <?php
                }
                ?>
              

                <!-- B. KINERJA TAMBAHAN -->
                <tr class="bg-header">
                    <td colspan="6" class="text-left">B. KINERJA TAMBAHAN</td>
                </tr>
                <tr>
                    <td class="text-center v-middle" style="height: 26px;">1</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <!-- TABEL PERILAKU KERJA -->
        <table style="margin-top: 10px;">
            <colgroup>
                <col style="width: 3.5%;">
                <col style="width: 49.5%;">
                <col style="width: 47%;">
            </colgroup>
            <thead>
                <tr class="bg-header">
                    <th colspan="3" class="text-left">PERILAKU KERJA</th>
                </tr>
            </thead>
            <tbody>
                <!-- 1. Berorientasi Pelayanan -->
                <tr>
                    <td rowspan="2" class="text-center v-middle">1</td>
                    <td class="font-bold">Berorientasi Pelayanan</td>
                    <td class="bg-header font-bold">Ekspektasi Khusus Pimpinan :</td>
                </tr>
                <tr>
                    <td>
                        <ul class="perilaku-list">
                            <li>- Melakukan perbaikan tiada henti</li>
                            <li>- Memahami dan memenuhi kebutuhan masyarakat</li>
                            <li>- Ramah, cekatan, solutif, dan dapat diandalkan</li>
                        </ul>
                    </td>
                    <td>
                        <ul class="perilaku-list">
                            <li>- Terbuka dalam menerima masukan dari pegawai dalam kewenangannya</li>
                        </ul>
                    </td>
                </tr>

                <!-- 2. Akuntabel -->
                <tr>
                    <td rowspan="2" class="text-center v-middle">2</td>
                    <td class="font-bold">Akuntabel</td>
                    <td class="bg-header font-bold">Ekspektasi Khusus Pimpinan :</td>
                </tr>
                <tr>
                    <td>
                        <ul class="perilaku-list">
                            <li>- Melaksanakan tugas dengan jujur, bertanggungjawab, cermat, disiplin, dan berintegritas tinggi</li>
                            <li>- Menggunakan kekayaan dan barang milik negara secara bertanggungjawab, efektif, dan efisien</li>
                            <li>- Tidak menyalahgunakan kewenangan jabatan</li>
                        </ul>
                    </td>
                    <td>
                        <ul class="perilaku-list">
                            <li>- Menjadi role model/ panutan dalam menjunjung komitmen dan integritas pegawai di lingkungan kerjanya</li>
                        </ul>
                    </td>
                </tr>

                <!-- 3. Kompeten -->
                <tr>
                    <td rowspan="2" class="text-center v-middle">3</td>
                    <td class="font-bold">Kompeten</td>
                    <td class="bg-header font-bold">Ekspektasi Khusus Pimpinan :</td>
                </tr>
                <tr>
                    <td>
                        <ul class="perilaku-list">
                            <li>- Melaksanakan tugas dengan kualitas terbaik</li>
                            <li>- Membantu orang lain belajar</li>
                            <li>- Meningkatkan kompetensi diri untuk menjawab tantangan yang selalu berubah</li>
                        </ul>
                    </td>
                    <td>
                        <ul class="perilaku-list">
                            <li>- Menyelesaikan setiap pekerjaan sesuai dengan target dan standar kualitas yang ditetapkan</li>
                            <li>- Bersedia untuk mengajarkan pengetahuan atau keterampilan yang dimiliki kepada orang lain</li>
                        </ul>
                    </td>
                </tr>

                <!-- 4. Harmonis -->
                <tr>
                    <td rowspan="2" class="text-center v-middle">4</td>
                    <td class="font-bold">Harmonis</td>
                    <td class="bg-header font-bold">Ekspektasi Khusus Pimpinan :</td>
                </tr>
                <tr>
                    <td>
                        <ul class="perilaku-list">
                            <li>- Membangun lingkungan kerja yang kondusif</li>
                            <li>- Menghargai setiap orang apapun latar belakangnya</li>
                            <li>- Suka menolong orang lain</li>
                        </ul>
                    </td>
                    <td>
                        <ul class="perilaku-list">
                            <li>- Memberikan kesempatan yang sama dan bersikap adil kepada setiap pegawai</li>
                        </ul>
                    </td>
                </tr>

                <!-- 5. Loyal -->
                <tr>
                    <td rowspan="2" class="text-center v-middle">5</td>
                    <td class="font-bold">Loyal</td>
                    <td class="bg-header font-bold">Ekspektasi Khusus Pimpinan :</td>
                </tr>
                <tr>
                    <td>
                        <ul class="perilaku-list">
                            <li>- Memegang teguh ideologi Pancasila, Undang-Undang Dasar Negara Republik Indonesia Tahun 1945, NKRI serta pemerintahan yang sah</li>
                            <li>- Menjaga nama baik sesama ASN, Pimpinan, Instansi, dan Negara</li>
                            <li>- Menjaga rahasia jabatan dan negara</li>
                        </ul>
                    </td>
                    <td>
                        <ul class="perilaku-list">
                            <li>- Berani menyampaikan adanya indikasi/ hal-hal yang dapat merugikan dan membahayakan negara</li>
                        </ul>
                    </td>
                </tr>

                <!-- 6. Adaptif -->
                <tr>
                    <td rowspan="2" class="text-center v-middle">6</td>
                    <td class="font-bold">Adaptif</td>
                    <td class="bg-header font-bold">Ekspektasi Khusus Pimpinan :</td>
                </tr>
                <tr>
                    <td>
                        <ul class="perilaku-list">
                            <li>- Bertindak Proaktif</li>
                            <li>- Cepat menyesuaikan diri menghadapi perubahan</li>
                            <li>- Terus berinovasi dan mengembangkan kreatifitas</li>
                        </ul>
                    </td>
                    <td>
                        <ul class="perilaku-list">
                            <li>- Mempercepat monitoring dan analisa data guna mendukung peningkatan kualitas dan unit kerja</li>
                        </ul>
                    </td>
                </tr>

                <!-- 7. Kolaboratif -->
                <tr>
                    <td rowspan="2" class="text-center v-middle">7</td>
                    <td class="font-bold">Kolaboratif</td>
                    <td class="bg-header font-bold">Ekspektasi Khusus Pimpinan :</td>
                </tr>
                <tr>
                    <td>
                        <ul class="perilaku-list">
                            <li>- Memberi kesempatan kepada berbagai pihak untuk berkontribusi</li>
                            <li>- Terbuka dalam bekerja sama untuk menghasilkan nilai tambah</li>
                            <li>- menggerakkan pemanfaatan berbagai sumber daya untuk tujuan bersama</li>
                        </ul>
                    </td>
                    <td>
                        <ul class="perilaku-list">
                            <li>- Mampu mengelola dan melibatkan seluruh pihak sesuai dengan peran dan fungsinya untuk mencapai tujuan bersama</li>
                            <li>- Memberikan kesempatan kepada setiap anggota untuk menyampaikan ide atau gagasan yang produktif</li>
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- TANDA TANGAN HALAMAN UTAMA -->
        <div class="ttd-wrapper">
            <div class="ttd-box">
                <div>&nbsp;</div>
                <div>Pegawai yang dinilai</div>
                <div class="ttd-space"></div>
                <div><?= $detail_pegawai[0]->nama; ?></div>
                <div>NIP <?= $detail_pegawai[0]->nip; ?></div>
            </div>
            <div class="ttd-box">
                <div>Jakarta, <?= date('d F Y'); ?></div>
                <div>Pejabat Penilai Kerja</div>
                <div class="ttd-space"></div>
                <div><?= $validator[0]->nama ?></div>
                <div>NIP <?= $validator[0]->nip ?></div>
            </div>
        </div>

        <!-- BAGIAN 2: LAMPIRAN SASARAN KINERJA PEGAWAI -->
        <div class="lampiran-section">
            <div class="doc-title">
                LAMPIRAN SASARAN KINERJA PEGAWAI
            </div>

            <div class="sub-header">
                <div>PUSKESMAS KOJA</div>
                <div class="periode">PERIODE PENILAIAN : <span>1 Januari S.D. 31 Desember <?= date('Y'); ?></span></div>
            </div>

            <table>
                <colgroup>
                    <col style="width: 3.5%;">
                    <col style="width: 96.5%;">
                </colgroup>
                <tbody>
                    <!-- Dukungan Sumber Daya -->
                    <tr class="bg-header">
                        <td colspan="2" class="font-bold">Dukungan Sumber Daya</td>
                    </tr>
                    <tr>
                        <td class="text-center font-bold">1</td>
                        <td>Dukungan sarana dan prasarana penunjang pekerjaan pelayanan ke pasien yaitu dental unit dan dental kit</td>
                    </tr>
                    <tr>
                        <td class="text-center font-bold">2</td>
                        <td>Dukungan ruang untuk pelaksanaan pemeriksaan pasien</td>
                    </tr>
                    <tr>
                        <td class="text-center font-bold">3</td>
                        <td>Petunjuk teknis dan petunjuk pelaksanaan dalam proses pelayanan keperawatan gigi pasien</td>
                    </tr>
                    <tr>
                        <td class="text-center font-bold">4</td>
                        <td>Pelatihan terkait penunjang keperawatan gigi</td>
                    </tr>

                    <!-- Skema Pertanggung Jawaban -->
                    <tr class="bg-header">
                        <td colspan="2" class="font-bold">Skema Pertanggung Jawaban</td>
                    </tr>
                    <tr>
                        <td class="text-center font-bold">1</td>
                        <td>Kinerja pegawai akan direviu sebulan sekali sebagai pertanggungjawaban target-target yang telah ditetapkan</td>
                    </tr>
                    <tr>
                        <td class="text-center font-bold">2</td>
                        <td>Membuat Laporan hasil kerja yang dilaporkan setiap 3 bulan sekali dengan menunjukkan bukti fisik hasil kerja</td>
                    </tr>

                    <!-- Konsekuensi -->
                    <tr class="bg-header">
                        <td colspan="2" class="font-bold">Konsekuensi</td>
                    </tr>
                    <tr>
                        <td class="text-center font-bold">1</td>
                        <td>Jika memberikan kinerja yang terbaik akan diprioritaskan dalam pelatihan pengembangan diri</td>
                    </tr>
                    <tr>
                        <td class="text-center font-bold">2</td>
                        <td>Jika tidak melaporkan aktivitas dan hasil kerja maka akan mempengaruhi penilaian kinerja pada sistem informasi TPP</td>
                    </tr>
                </tbody>
            </table>

            <!-- TANDA TANGAN LAMPIRAN -->
            <div class="ttd-wrapper">
                <div class="ttd-box">
                    <div>&nbsp;</div>
                    <div>Pegawai yang dinilai</div>
                    <div class="ttd-space"></div>
                    <div><?= $detail_pegawai[0]->nama ?></div>
                    <div>NIP <?= $detail_pegawai[0]->nip ?></div>
                </div>
                <div class="ttd-box">
                    <div>Jakarta, 02 Januari 2026</div>
                    <div>Pejabat Penilai Kerja</div>
                    <div class="ttd-space"></div>
                    <div><?= $validator[0]->nama ?></div>
                    <div>NIP <?= $validator[0]->nip ?></div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
