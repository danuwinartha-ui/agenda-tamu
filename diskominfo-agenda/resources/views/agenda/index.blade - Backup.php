<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MONITOR AGENDA - DISKOMINFO KARANGASEM</title>
    
    <meta name="last-update" content="{{ $lastUpdate ?? time() }}">
    
    <style>
        /* =========================================
           1. VARIABEL GLOBAL
           ========================================= */
        :root { 
            --merah-utama: #d61f26; 
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
           2. HEADER SECTION
           ========================================= */
        .header { 
            background-color: var(--merah-utama); 
            height: 130px; 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            padding: 0 40px; 
            border-bottom: 6px solid var(--kuning-emas); 
            box-shadow: 0 4px 15px rgba(0,0,0,0.5); 
            position: relative; 
            z-index: 20; 
        }

        .logo-kiri { cursor: pointer; transition: transform 0.2s; }
        .logo-kiri:active { transform: scale(0.95); }
        .logo-kiri img { height: 100px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3)); }
        
        .center-content { 
            text-align: center; 
            flex-grow: 1; 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            justify-content: center; 
        }
        
        .title-main { 
            font-size: 38px; 
            font-weight: 800; 
            margin: 0; 
            text-shadow: 2px 2px 4px rgba(0,0,0,0.4); 
            line-height: 1.1; 
        }
        
        .title-sub { 
            font-size: 20px; 
            color: var(--kuning-emas); 
            font-weight: bold; 
            margin: 2px 0 2px 0; 
            text-transform: uppercase; 
            letter-spacing: 1px; 
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5); 
        }
        
        .clock-box { 
            background: rgba(80, 0, 0, 0.6); 
            border: 1px solid rgba(255, 255, 255, 0.3); 
            padding: 2px 30px; 
            border-radius: 50px; 
            font-size: 28px; 
            font-weight: bold; 
            font-family: 'Courier New', Courier, monospace; 
            letter-spacing: 2px; 
            box-shadow: inset 0 0 10px rgba(0,0,0,0.5); 
        }
        
        .right-logos { display: flex; align-items: center; gap: 15px; }
        .logo-bupati { height: 115px; }
        .logo-berakhlak { height: 60px; background: #fff; padding: 5px; border-radius: 6px; }

        /* =========================================
           3. AREA KONTEN (SCROLLABLE AREA)
           ========================================= */
        .content-area { 
            height: calc(100vh - 190px); 
            width: 100%;
            overflow-y: auto; 
            position: relative;
            scrollbar-width: none; 
        }
        .content-area::-webkit-scrollbar { display: none; }

        .table-container { width: 100%; display: flex; flex-direction: column; align-items: center; }

        /* =========================================
           4. TABEL AGENDA STYLING (UPDATE LEBAR KOLOM)
           ========================================= */
        .agenda-table { width: 96%; border-collapse: separate; border-spacing: 0 15px; }
        .agenda-table td { background: rgba(255, 255, 255, 0.07); padding: 15px 20px; font-size: 22px; vertical-align: middle; }
        
        /* Kolom 1: Waktu (Tetap 12%) */
        .agenda-table tr td:first-child { 
            border-left: 8px solid var(--merah-utama); 
            border-top-left-radius: 10px; 
            border-bottom-left-radius: 10px; 
            color: #fff; font-weight: bold; 
            width: 12%; text-align: center; 
        }

        /* Kolom 2: Kegiatan (Dikurangi jadi 32% agar Tempat geser kiri) */
        .col-kegiatan { width: 32%; text-align: left; }
        .kegiatan-text { font-weight: bold; text-transform: uppercase; display: block; font-size: 24px; }
        .instansi-text { font-size: 16px; color: #ccc; font-style: italic; margin-top: 5px; display: block; }
        
        /* Kolom 3: Tempat (Ditambah jadi 25%) */
        .col-tempat { width: 25%; color: #00a8ff; font-weight: 500; }
        
        /* Kolom 4: Disposisi (Sisanya 31%) */
        .col-disposisi { 
            width: 31%; 
            border-top-right-radius: 10px; 
            border-bottom-right-radius: 10px; 
            color: var(--kuning-emas); 
            font-style: italic; font-size: 20px; 
        }

        /* =========================================
           5. EMPTY STATE & UTILITIES
           ========================================= */
        .empty-wrapper { height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center; min-height: 500px; }
        .empty-icon { width: 120px; margin-bottom: 20px; filter: invert(1); }
        .empty-text { font-size: 24px; font-weight: bold; color: var(--text-grey); letter-spacing: 1px; }

        .footer { position: fixed; bottom: 0; left: 0; width: 100%; background: #000; color: #fff; padding: 12px 0; border-top: 4px solid var(--kuning-emas); font-size: 20px; font-weight: bold; z-index: 30; }

        .fab-scroll { position: fixed; bottom: 80px; right: 30px; width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border: 2px solid var(--kuning-emas); border-radius: 50%; display: flex; justify-content: center; align-items: center; cursor: pointer; z-index: 99; transition: 0.3s; }
        .fab-scroll:hover { background: var(--merah-utama); }
        .fab-icon { width: 20px; height: 20px; fill: white; }

        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.85); z-index: 9999; justify-content: center; align-items: center; }
        .modal-box { background: #1e293b; padding: 40px; border-radius: 15px; border: 2px solid var(--merah-utama); width: 350px; text-align: center; box-shadow: 0 0 30px rgba(214, 31, 38, 0.3); }
        .input-field { width: 100%; padding: 12px; margin: 10px 0; border-radius: 5px; border: 1px solid #475569; background: #0f172a; color: white; box-sizing: border-box; }
        .btn-submit { width: 100%; padding: 12px; background: var(--merah-utama); color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; margin-top: 10px; font-size: 16px; }
        .btn-submit:hover { background: #b91c22; }
        .close-txt { margin-top: 15px; color: #94a3b8; cursor: pointer; font-size: 14px; }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo-kiri" onclick="showLogin()">
            <img src="{{ asset('img/logo.png') }}" alt="Logo Karangasem">
        </div>
        <div class="center-content">
            <h1 class="title-main">AGENDA KEGIATAN DISKOMINFO</h1>
            <p class="title-sub">PEMERINTAH KABUPATEN KARANGASEM</p>
            <div class="clock-box" id="clock">00.00.00 WITA</div>
        </div>
        <div class="right-logos">
            <img src="{{ asset('img/logo-bupati.png') }}" class="logo-bupati" alt="Pimpinan">
            <img src="{{ asset('img/asn-berakhlak.png') }}" class="logo-berakhlak" alt="Berakhlak">
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
                <div class="empty-wrapper">
                    <div class="empty-icon">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M19 4H5C3.89543 4 3 4.89543 3 6V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V6C21 4.89543 20.1046 4 19 4Z" stroke="white" stroke-width="2"/><path d="M16 2V6" stroke="white" stroke-width="2"/><path d="M8 2V6" stroke="white" stroke-width="2"/><path d="M3 10H21" stroke="white" stroke-width="2"/></svg>
                    </div>
                    <div class="empty-text">TIDAK ADA AGENDA KEGIATAN</div>
                </div>
            @endif
        </div>
    </div>

    @if(isset($agendas) && count($agendas) > 0)
    <div class="fab-scroll" onclick="toggleScroll()" title="Pause/Play Auto Scroll">
        <svg id="icon-pause" class="fab-icon" viewBox="0 0 24 24"><rect x="6" y="4" width="4" height="16"></rect><rect x="14" y="4" width="4" height="16"></rect></svg>
        <svg id="icon-play" class="fab-icon" viewBox="0 0 24 24" style="display: none;"><path d="M8 5v14l11-7z"></path></svg>
    </div>
    @endif

    <div class="footer">
        <marquee scrollamount="6">Selamat Datang di ON-TIME (Online Tata Informasi & Manajemen Agenda) Diskominfo Kabupaten Karangasem - Menuju Karangasem yang AGUNG (Aman, Gigih, Unggul, Nyaman, Gemah Ripah Loh Jinawi) - </marquee>
    </div>

    <div id="loginModal" class="modal-overlay">
        <div class="modal-box">
            <img src="{{ asset('img/logo.png') }}" style="height: 60px; margin-bottom: 20px;">
            <h2 style="color:white; margin:0 0 20px 0;">Login Admin</h2>
            <form action="{{ route('login.submit') }}" method="POST">
                @csrf
                <input type="email" name="email" class="input-field" placeholder="Email" required autocomplete="off">
                <input type="password" name="password" class="input-field" placeholder="Password" required>
                <button type="submit" class="btn-submit">MASUK</button>
            </form>
            <div class="close-txt" onclick="closeLogin()">Batal / Tutup</div>
        </div>
    </div>

    <script>
        // KONFIGURASI KECEPATAN (0.1 = Rekomendasi)
        const SCROLL_SPEED = 0.2; 

        // --- Watermark Console ---
        console.clear();
        console.log(
            "%c ON-TIME  %c Diskominfo Karangasem ",
            "background: #d61f26; color: #fff; font-size: 20px; font-weight: bold; border-radius: 5px 0 0 5px; padding: 5px;",
            "background: #0a1120; color: #ffcc00; font-size: 20px; font-weight: bold; border-radius: 0 5px 5px 0; padding: 5px; border: 1px solid #d61f26;"
        );console.log(
            "Crafted by Danu Winartha ",
        );

        function updateClock() {
            const now = new Date();
            const h = String(now.getHours()).padStart(2, '0');
            const m = String(now.getMinutes()).padStart(2, '0');
            const s = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('clock').textContent = `${h}.${m}.${s} WITA`;
        }
        setInterval(updateClock, 1000); updateClock();

        function showLogin() { document.getElementById('loginModal').style.display = 'flex'; }
        function closeLogin() { document.getElementById('loginModal').style.display = 'none'; }

        let lastUpdateTimestamp = document.querySelector('meta[name="last-update"]').content;
        setInterval(() => {
            fetch('{{ route("check.update") }}')
                .then(r => r.json())
                .then(d => { if (d.last_update > lastUpdateTimestamp) location.reload(); })
                .catch(e => console.error(e));
        }, 5000);

        const scrollContainer = document.getElementById('scrollContainer');
        const originalContent = document.getElementById('originalContent');
        const clonedContent = document.getElementById('clonedContent');
        
        let isPaused = false;
        let scrollAccumulator = 0; 

        window.onload = function() {
            if (originalContent && scrollContainer) {
                if (originalContent.clientHeight > scrollContainer.clientHeight) {
                    clonedContent.innerHTML = originalContent.innerHTML;
                    requestAnimationFrame(smoothScroll);
                } else {
                    document.getElementById('contentWrapper').style.height = "100%";
                    document.getElementById('contentWrapper').style.justifyContent = "center";
                }
            }
        };

        function smoothScroll() {
            if (!isPaused) {
                scrollAccumulator += SCROLL_SPEED;
                if (scrollAccumulator >= 1) {
                    const pixelsToMove = Math.floor(scrollAccumulator);
                    scrollContainer.scrollTop += pixelsToMove;
                    scrollAccumulator -= pixelsToMove;
                }
                if (scrollContainer.scrollTop >= originalContent.clientHeight) {
                    scrollContainer.scrollTop = 0;
                }
            }
            requestAnimationFrame(smoothScroll);
        }

        function toggleScroll() {
            isPaused = !isPaused;
            document.getElementById('icon-pause').style.display = isPaused ? 'none' : 'block';
            document.getElementById('icon-play').style.display = isPaused ? 'block' : 'none';
        }
    </script>
</body>
</html>