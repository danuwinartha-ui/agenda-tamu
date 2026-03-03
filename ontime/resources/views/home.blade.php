<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ON-TIME</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&family=Rajdhani:wght@600&family=Inter:wght@400;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        /* === TEMA WARNA DARK MODE === */
        :root { 
            --navy: #0f172a; 
            --merah: #e62129; 
            --kuning: #fecb00; 
        }
        body { 
            background-color: var(--navy); 
            color: white; 
            overflow: hidden; 
            font-family: 'Rajdhani', sans-serif; 
            height: 100vh; 
            margin: 0; 
        }
        
        /* === HEADER === */
        .header { 
            background: linear-gradient(90deg, var(--merah), #8b0000); 
            border-bottom: 4px solid var(--kuning); 
            padding: 0 20px; 
            height: 15vh; 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            position: relative;
            z-index: 20;
        }
        
        .header-left, .header-right { width: 25%; display: flex; align-items: center; justify-content: center; }
        .header-center { width: 50%; text-align: center; }

        /* Styling Logo */
        .img-kab { height: 95px; filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.4)); transition: transform 0.3s; }
        .img-kab:hover { transform: scale(1.05); }

        .img-bupati { height: 115px; margin-right: 15px; filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.4)); }
        .img-berakhlak { height: 60px; background: rgba(255,255,255,0.9); padding: 4px; border-radius: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.3); }

        /* Teks & Jam */
        .title-main { 
            font-family: 'Inter', sans-serif; 
            font-weight: 800; 
            font-size: 1.8rem; 
            line-height: 1.1; 
            margin-bottom: 0; 
            text-transform: uppercase; 
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5); 
            white-space: nowrap; 
        }
        
        .title-sub { 
            font-size: 1.1rem; 
            color: var(--kuning); 
            letter-spacing: 2px; 
            text-transform: uppercase; 
            margin-bottom: 2px; 
        }
        
        .jam-digital { 
            font-family: 'Orbitron', sans-serif; 
            color: #fff; 
            background: rgba(0,0,0,0.3);
            display: inline-block;
            padding: 2px 15px;
            border-radius: 20px;
            font-size: 1.3rem; 
            letter-spacing: 1.5px;
            border: 1px solid rgba(255,255,255,0.2);
            margin-top: 0;
        }

        /* === CONTAINER SCROLL === */
        .main-container { height: 80vh; padding: 25px 40px; position: relative; }
        
        .scroll-container { 
            height: 100%; 
            overflow: hidden; 
            position: relative; 
            scrollbar-width: thin;
            scrollbar-color: var(--kuning) var(--navy);
            mask-image: linear-gradient(to bottom, transparent, black 5%, black 95%, transparent); 
        }
        
        .scroll-content { animation: scrollUp 45s linear infinite; }
        
        .manual-mode .scroll-content { animation: none !important; transform: none !important; }
        .manual-mode { overflow-y: auto !important; }

        @keyframes scrollUp { 
            0% { transform: translateY(0); } 
            100% { transform: translateY(-50%); } 
        }

        /* === KARTU AGENDA === */
        .card-agenda { 
            background: rgba(255,255,255,0.05); 
            border: 1px solid rgba(255,255,255,0.1); 
            border-left: 5px solid var(--kuning);
            border-radius: 12px; 
            padding: 15px 20px; 
            margin-bottom: 25px; 
            display: flex; 
            align-items: center; 
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
        }
        
        .dt-box { 
            background: var(--kuning); 
            color: #000; 
            padding: 10px; 
            border-radius: 10px; 
            min-width: 140px; 
            text-align: center; 
            margin-right: 25px; 
            font-weight: 800; 
            line-height: 1.2; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        .dt-date { font-size: 1.1rem; border-bottom: 2px solid rgba(0,0,0,0.1); margin-bottom: 5px; padding-bottom: 5px; }
        .dt-time { font-size: 1.8rem; font-family: 'Orbitron', sans-serif; }

        .info-box { flex: 1; }
        .kegiatan-text { font-size: 1.8rem; font-weight: 700; text-transform: uppercase; margin-bottom: 5px; line-height: 1.1; color: white; text-shadow: 1px 1px 3px rgba(0,0,0,0.8); }
        .sub-text { font-size: 1.2rem; color: #90caf9; margin-bottom: 8px; display: flex; align-items: center; gap: 10px; }

        .disposisi-box { 
            display: inline-block;
            background: rgba(220, 53, 69, 0.3); 
            border: 1px solid var(--merah);
            padding: 5px 15px; 
            font-size: 1rem; 
            font-weight: bold;
            color: #ffdad9; 
            border-radius: 20px;
            margin-top: 5px;
        }

        /* FOOTER */
        .footer { 
            position: fixed; bottom: 0; width: 100%; height: 5vh; 
            background: #000; display: flex; align-items: center; 
            border-top: 3px solid var(--kuning); 
            font-size: 1.3rem; z-index: 100; letter-spacing: 1px;
        }
        
        /* TOMBOL CONTROL */
        .scroll-control-btn { position: fixed; bottom: 7vh; right: 20px; z-index: 9999; opacity: 0.5; transition: 0.3s; border: 2px solid white; font-weight: bold; text-transform: uppercase; font-size: 0.8rem; }
        .scroll-control-btn:hover { opacity: 1; }
    </style>
</head>
<body>
    @php
        $today = \Carbon\Carbon::today();
        $filtered = $agendas->filter(fn($a) => \Carbon\Carbon::parse($a->tanggal)->between($today, $today->copy()->addDays(7)))->sortBy(['tanggal', 'waktu']);
        $needsScroll = $filtered->count() > 4; 
        $display = $needsScroll ? $filtered->concat($filtered) : $filtered;
    @endphp

    <div class="header">
        <div class="header-left">
            <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
                <img src="{{ asset('img/logo.png') }}" class="img-kab" alt="Logo Karangasem">
            </a>
        </div>

        <div class="header-center">
            <div class="title-main">AGENDA KEGIATAN DISKOMINFO</div>
            <div class="title-sub">Pemerintah Kabupaten Karangasem</div>
            <div id="clock" class="jam-digital">00:00 WITA</div>
        </div>

        <div class="header-right">
            <img src="{{ asset('img/logo-bupati.png') }}" class="img-bupati" alt="Bupati">
            <img src="{{ asset('img/asn-berakhlak.png') }}" class="img-berakhlak" alt="Berakhlak">
        </div>
    </div>

    <div class="main-container">
        <div id="scrollContainer" class="scroll-container">
            <div id="scrollContent" class="scroll-content {{ !$needsScroll ? 'no-scroll' : '' }}">
                @forelse($display as $a)
                <div class="card-agenda">
                    <div class="dt-box">
                        <div class="dt-date">{{ \Carbon\Carbon::parse($a->tanggal)->isoFormat('dddd, D MMM') }}</div>
                        <div class="dt-time">{{ substr($a->waktu, 0, 5) }}</div>
                    </div>
                    <div class="info-box">
                        <div class="kegiatan-text">{{ $a->kegiatan }}</div>
                        <div class="sub-text">
                            <span><i class="bi bi-geo-alt-fill text-warning"></i> {{ $a->tempat }}</span>
                            <span>|</span>
                            <span><i class="bi bi-building-fill text-info"></i> Asal: {{ $a->dari_instansi }}</span>
                        </div>
                        @if($a->disposisi)
                            <div class="disposisi-box"><i class="bi bi-pin-angle-fill"></i> {{ $a->disposisi }}</div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center mt-5" style="opacity: 0.3;">
                    <i class="bi bi-calendar-x" style="font-size: 5rem;"></i>
                    <h2 class="mt-3">TIDAK ADA AGENDA KEGIATAN</h2>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    @if($needsScroll)
    <button id="toggleScrollBtn" class="btn btn-warning rounded-pill scroll-control-btn shadow">
        <i class="bi bi-pause-fill"></i> STOP SCROLL
    </button>
    @endif

    <div class="footer">
        <marquee scrollamount="6">Selamat Datang di ON-TIME (Online Tata Informasi & Manajemen Event). Menuju Karangasem yang AGUNG (Aman, Gigih, Unggul, Nyaman, Gemah Ripah Loh Jinawi). Pastikan data agenda Anda selalu terupdate. Dinas Komunikasi dan Informatika Kabupaten Karangasem</marquee>
    </div>

    <div class="modal fade" id="loginModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4 text-dark" style="border:3px solid var(--kuning); border-radius:15px;">
                <h4 class="fw-bold mb-3 text-center">LOGIN ADMIN</h4>
                
                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show p-2" role="alert" style="font-size: 0.9rem;">
                    <i class="bi bi-exclamation-triangle-fill"></i> Email atau Password Salah!
                    <button type="button" class="btn-close small p-2" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <form action="{{ route('login.submit') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button class="btn btn-primary w-100 fw-bold py-2">MASUK</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // 1. SCRIPT AUTO-OPEN MODAL JIKA ERROR
        @if($errors->any())
            document.addEventListener("DOMContentLoaded", function() {
                var myModal = new bootstrap.Modal(document.getElementById('loginModal'));
                myModal.show();
            });
        @endif

        // 2. JAM DIGITAL
        function updateClock() {
            const now = new Date();
            document.getElementById('clock').innerHTML = now.toLocaleTimeString('id-ID', { hour12: false }) + ' WITA';
        }
        setInterval(updateClock, 1000); updateClock();

        // 3. SCROLL CONTROL
        const container = document.getElementById('scrollContainer');
        const btn = document.getElementById('toggleScrollBtn');
        let isAutoScroll = localStorage.getItem('autoScrollState') !== 'manual';

        function applyScrollState() {
            if (btn) {
                if (isAutoScroll) {
                    container.classList.remove('manual-mode');
                    btn.innerHTML = '<i class="bi bi-pause-fill"></i> STOP SCROLL';
                    btn.classList.replace('btn-success', 'btn-warning');
                } else {
                    container.classList.add('manual-mode');
                    btn.innerHTML = '<i class="bi bi-play-fill"></i> AUTO SCROLL';
                    btn.classList.replace('btn-warning', 'btn-success');
                }
            }
        }
        applyScrollState();
        if(btn) btn.addEventListener('click', () => { isAutoScroll = !isAutoScroll; localStorage.setItem('autoScrollState', isAutoScroll ? 'auto' : 'manual'); if(isAutoScroll) location.reload(); else applyScrollState(); });

        // 4. AUTO REFRESH (Cek Data Baru)
        let lastUpdate = 0;
        async function checkUpdates() {
            try {
                let response = await fetch('/check-update');
                let data = await response.json();
                if (lastUpdate === 0) lastUpdate = data.last_update;
                else if (data.last_update > lastUpdate) location.reload(); 
            } catch (error) { console.error("Gagal cek update", error); }
        }
        setInterval(checkUpdates, 10000);
    </script>
  <script>
    // Identitas Tersembunyi (Easter Egg)
    console.log(
        "%c ON-TIME  %c Online Tata Informasi & Manajemen Event ",
        "color: white; background: #e62129; padding: 5px 10px; border-radius: 5px 0 0 5px; font-weight: bold; font-size: 16px;",
        "color: #e62129; background: #1e293b; padding: 5px 10px; border-radius: 0 5px 5px 0; font-weight: bold; font-size: 16px;"
    );
    console.log(
        "%c Handcrafted with ☕ by Danu Winartha %c",
        "color: #ffffff; font-style: italic; font-size: 12px;",
        ""
    );
    console.log("Release Version: 2.0.0 (January 2026)");
    </script>
</body>
</html>