<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MONITOR AGENDA - DISKOMINFO KARANGASEM</title>
    
    <meta name="last-update" content="{{ $lastUpdate ?? time() }}">
    
    <style>
        :root { 
            --royal-blue: #2a3692; 
            --kuning-emas: #ffcc00; 
            --bg-gelap: #0a1120; 
            --text-white: #ffffff;
            --text-grey: #64748b;
        }

        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background-color: var(--bg-gelap); 
            margin: 0; padding: 0; 
            overflow: hidden; 
            color: var(--text-white); 
        }

        /* =========================================
           HEADER SECTION (FIXED & CENTERED)
           ========================================= */
        .header { 
            background-color: var(--royal-blue); 
            height: 130px; 
            display: flex; 
            align-items: center; 
            padding: 0 40px; 
            position: relative; 
            border-bottom: 5px solid var(--kuning-emas);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            z-index: 100; 
        }

        /* Akses Admin (Sisi Kiri) */
        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
            z-index: 110; 
            cursor: pointer;
        }

        .header-left img { height: 120px; width: auto; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3)); }

        .divider-header {
            width: 2px;
            height: 60px;
            background: rgba(255,255,255,0.2);
        }

        /* Judul Tengah */
        .header-center-title { 
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            width: auto;
            z-index: 50;
            pointer-events: none; 
        }

        .header-center-title h1 { 
            font-size: 2.4rem; 
            margin: 0; 
            line-height: 1.1; 
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
        }

        .header-center-title h2 { 
            font-size: 1.1rem; 
            margin: 5px 0 0 0; 
            letter-spacing: 4px;
            font-weight: bold;
            color: #cbd5e1; 
        }

        /* Container Kanan (ASN + JAM Vertikal) */
        .header-right-container {
            margin-left: auto;
            display: flex;
            flex-direction: column; 
            align-items: flex-end; 
            justify-content: center;
            gap: 10px; /* Jarak antara logo ASN dan Jam */
            z-index: 110;
        }

        .logo-asn-header {
            height: 65px;
            width: auto;
            filter: drop-shadow(0 2px 10px rgba(0,0,0,0.3));
        }

        .header-info { text-align: right; }

        .jam {
            font-size: 1rem; 
            font-weight: 900;
            color: var(--kuning-emas);
            line-height: 1;
            margin: 0;
        }

        .hari-tanggal {
            font-size: 0.9rem;
            font-weight: 600;
            color: #ffffff;
            text-transform: uppercase;
            margin-top: 5px;
        }

        /* Area Konten */
        .content-area { height: calc(100vh - 190px); width: 100%; overflow-y: auto; scrollbar-width: none; }
        .content-area::-webkit-scrollbar { display: none; }
        .table-container { width: 100%; display: flex; flex-direction: column; align-items: center; }
        .agenda-table { width: 96%; border-collapse: separate; border-spacing: 0 15px; }
        .agenda-table td { background: rgba(255, 255, 255, 0.07); padding: 15px 20px; font-size: 22px; vertical-align: middle; }
        .agenda-table tr td:first-child { border-left: 8px solid var(--royal-blue); border-top-left-radius: 10px; border-bottom-left-radius: 10px; font-weight: bold; width: 12%; text-align: center; }
        .col-kegiatan { width: 32%; }
        .kegiatan-text { font-weight: bold; text-transform: uppercase; display: block; font-size: 24px; }
        .instansi-text { font-size: 16px; color: #ccc; font-style: italic; margin-top: 5px; display: block; }
        .col-tempat { width: 25%; color: #00a8ff; font-weight: 500; }
        .col-disposisi { width: 31%; border-top-right-radius: 10px; border-bottom-right-radius: 10px; color: var(--kuning-emas); font-style: italic; font-size: 20px; }

        .footer { position: fixed; bottom: 0; left: 0; width: 100%; background: #000; color: #fff; padding: 12px 0; border-top: 4px solid var(--kuning-emas); font-size: 20px; font-weight: bold; z-index: 30; }
        
        /* Modal Login */
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.85); z-index: 9999; justify-content: center; align-items: center; }
        .modal-box { background: #1e293b; padding: 40px; border-radius: 15px; border: 2px solid var(--royal-blue); width: 350px; text-align: center; }
        .input-field { width: 100%; padding: 12px; margin: 10px 0; border-radius: 5px; border: 1px solid #475569; background: #0f172a; color: white; box-sizing: border-box; }
        .btn-submit { width: 100%; padding: 12px; background: var(--royal-blue); color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; margin-top: 10px; }
    </style>
</head>
<body>

    <div class="header">
        <div class="header-left" onclick="showLogin()">
            <img src="{{ asset('img/logo.png') }}" alt="Logo Karangasem">
            <div class="divider-header"></div>
            <img src="{{ asset('img/logo-bupati.png') }}" alt="Logo Bupati">
        </div>

        <div class="header-center-title">
            <h1>AGENDA KEGIATAN DISKOMINFO</h1>
            <h2>Pemerintah Kabupaten Karangasem</h2>
        </div>

        <div class="header-right-container">
            <img src="{{ asset('img/asn-berakhlak.png') }}" alt="ASN Berakhlak" class="logo-asn-header">
            <div class="header-info">
                <div class="jam" id="jam">00:00:00</div>
                <div class="hari-tanggal" id="tanggal">Memuat...</div>
            </div>
        </div>
    </div>

    <div class="content-area" id="scrollContainer">
        <div class="table-container" id="contentWrapper">
            @if(isset($agendas) && count($agendas) > 0)
                <div id="originalContent" style="width: 100%; display: flex; justify-content: center;">
                    <table class="agenda-table">
                        @foreach($agendas as $item)
                        <tr>
                            <td>{{ substr($item->waktu, 0, 5) }} WITA</td>
                            <td class="col-kegiatan">
                                <span class="kegiatan-text">{{ $item->kegiatan }}</span>
                                <span class="instansi-text">{{ $item->dari_instansi }}</span>
                            </td>
                            <td class="col-tempat">📍 {{ $item->tempat }}</td>
                            <td class="col-disposisi">
                                @if($item->disposisi) 📝 {{ $item->disposisi }} @else - @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div id="clonedContent" style="width: 100%; display: flex; justify-content: center;"></div>
            @else
                <div style="text-align:center; padding-top: 100px; color: var(--text-grey);">
                    <h2 style="font-size: 30px;">TIDAK ADA AGENDA KEGIATAN HARI INI</h2>
                </div>
            @endif
        </div>
    </div>

    <div class="footer">
        <marquee scrollamount="6">Selamat Datang di ON-TIME (Online Tata Informasi & Manajemen Event) Diskominfo Kabupaten Karangasem - Menuju Karangasem yang AGUNG (Aman, Gigih, Unggul, Nyaman, Gemah Ripah Loh Jinawi)</marquee>
    </div>

    <div id="loginModal" class="modal-overlay">
        <div class="modal-box">
            <h2 style="color:white; margin:0 0 20px 0;">Login Admin</h2>
            <form action="{{ route('login.submit') }}" method="POST">
                @csrf
                <input type="email" name="email" class="input-field" placeholder="Email" required>
                <input type="password" name="password" class="input-field" placeholder="Password" required>
                <button type="submit" class="btn-submit">MASUK</button>
            </form>
            <div style="margin-top:15px; color:#94a3b8; cursor:pointer;" onclick="closeLogin()">Batal</div>
        </div>
    </div>
    

    <script>
        
        // 1. Fungsi Jam & Tanggal
        function updateClock() {
            const now = new Date();
            const jam = String(now.getHours()).padStart(2, '0');
            const mnt = String(now.getMinutes()).padStart(2, '0');
            const dtk = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('jam').textContent = `${jam}:${mnt}:${dtk}`;

            const opsi = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('tanggal').textContent = now.toLocaleDateString('id-ID', opsi);
        }
        setInterval(updateClock, 1000); updateClock();

        // 2. Fungsi Modal
        function showLogin() { document.getElementById('loginModal').style.display = 'flex'; }
        function closeLogin() { document.getElementById('loginModal').style.display = 'none'; }

        // 3. Auto Scroll Logic
        const SCROLL_SPEED = 0.5; 
        const scrollContainer = document.getElementById('scrollContainer');
        const originalContent = document.getElementById('originalContent');
        const clonedContent = document.getElementById('clonedContent');
        
        window.onload = function() {
            if (originalContent && scrollContainer && originalContent.clientHeight > scrollContainer.clientHeight) {
                clonedContent.innerHTML = originalContent.innerHTML;
                requestAnimationFrame(smoothScroll);
            }
        };

        function smoothScroll() {
            scrollContainer.scrollTop += SCROLL_SPEED;
            if (scrollContainer.scrollTop >= originalContent.clientHeight) {
                scrollContainer.scrollTop = 0;
            }
            requestAnimationFrame(smoothScroll);
        }
    </script>
    <script>
    // --- 1. Watermark Console (Tempatkan Paling Atas) ---
    console.clear();
    console.log(
        "%c ON-TIME  %c Diskominfo Karangasem ",
        "background: #d61f26; color: #fff; font-size: 20px; font-weight: bold; border-radius: 5px 0 0 5px; padding: 5px;",
        "background: #0a1120; color: #ffcc00; font-size: 20px; font-weight: bold; border-radius: 0 5px 5px 0; padding: 5px; border: 1px solid #d61f26;"
    );
    console.log(
        "Crafted by Danu Winartha ",
    );

    // --- 2. Fungsi-fungsi lainnya (Clock, Scroll, Polling Update) ---
    function updateClock() {
        // ... kode jam Danu ...
    }
    
    // ... dan seterusnya ...
</script>
    
</body>
</html>