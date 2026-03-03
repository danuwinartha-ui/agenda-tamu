<!DOCTYPE html>
<html>
<head>
    <title>ON-TIME - Cetak Laporan</title>
    <style>
        @page { margin: 1cm; }
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            font-size: 11px; 
            color: #000; 
            margin: 0; 
            padding: 0; 
        }

        /* Header Kop Surat */
        .header-table { 
            width: 100%; 
            border-bottom: 3px solid #000; 
            padding-bottom: 8px;
        }
        
        /* Garis ganda kop surat */
        .line-thin { 
            border-bottom: 1px solid #000; 
            margin-bottom: 15px; 
            margin-top: 2px;
        }

        /* Menggunakan sistem kolom untuk menjaga teks tetap center */
        .logo-col { width: 80px; vertical-align: middle; }
        .text-center-col { text-align: center; vertical-align: middle; }
        .spacer-col { width: 80px; } /* Penyeimbang agar teks tengah tidak bergeser */

        .kop-h1 { font-size: 16px; margin: 0; font-weight: bold; text-transform: uppercase; }
        .kop-h2 { font-size: 20px; margin: 2px 0; font-weight: bold; text-transform: uppercase; }
        .kop-p { font-size: 10px; margin: 0; line-height: 1.3; font-weight: normal; }

        /* Styling Tabel Data */
        .data { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .data th { background: #eee; border: 1px solid #000; padding: 8px; font-weight: bold; text-transform: uppercase; }
        .data td { border: 1px solid #000; padding: 8px; vertical-align: top; }

        .footer-container { margin-top: 30px; width: 100%; }
        .ttd-wrapper { float: right; width: 300px; text-align: center; }
    </style>
</head>
<body>

    <table class="header-table" border="0">
        <tr>
            <td class="logo-col">
                <img src="{{ public_path('img/logo.png') }}" style="height: 85px;">
            </td>
            
            <td class="text-center-col">
                <div class="kop-h1">PEMERINTAH KABUPATEN KARANGASEM</div>
                <div class="kop-h2">DINAS KOMUNIKASI DAN INFORMATIKA</div>
                <div class="kop-p">
                    Jalan Ngurah Rai No. 29 Telp/Fax (0363) 21037 | Amlapura<br>
                    e-mail: diskominfo@karangasemkab.go.id | laman: http://diskominfo.karangasemkab.go.id
                </div>
            </td>

            <td class="spacer-col"></td>
        </tr>
    </table>
    <div class="line-thin"></div>

    <center>
        <h3 style="text-decoration: underline; margin-bottom: 5px; text-transform: uppercase;">Jadwal Kegiatan Diskominfo</h3>
        <p style="margin: 0 0 15px 0;">Periode: {{ $tanggal_range }}</p>
    </center>

    <table class="data">
        <thead>
            <tr>
                <th width="5%">NO</th>
                <th width="35%">NAMA KEGIATAN</th>
                <th width="15%">PUKUL</th>
                <th width="20%">TEMPAT</th>
                <th width="25%">DISPOSISI / KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            @foreach($agendas as $index => $a)
            <tr>
                <td align="center">{{ $index + 1 }}</td>
                <td><strong>{{ $a->kegiatan }}</strong><br><small>Asal: {{ $a->dari_instansi }}</small></td>
                <td align="center">{{ \Carbon\Carbon::parse($a->waktu)->format('H:i') }} WITA</td>
                <td>{{ $a->tempat }}</td>
                <td>{{ $a->disposisi ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer-container">
        <div class="ttd-wrapper">
            <p>Karangasem, {{ $tanggal_sekarang }}</p>
            <p>Kepala Dinas Komunikasi dan Informatika<br>Kabupaten Karangasem</p>
            <br><br><br><br>
            <p><strong><u>Ida Nyoman Astawa, S.STP., M.A.P</u></strong><br>Pembina Utama Muda / (IV/c)<br>NIP 197709031996121001</p>
        </div>
    </div>

</body>
</html>