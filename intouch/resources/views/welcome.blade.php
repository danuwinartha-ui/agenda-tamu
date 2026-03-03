<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>IN-TOUCH - Buku Tamu Diskominfo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
</head>
<body class="bg-[#0f172a] font-sans text-slate-200">
    <div class="max-w-md mx-auto min-h-screen bg-[#1e293b] shadow-2xl flex flex-col border-x border-slate-700/50">
        
        <div class="bg-[#1e293b] py-6 px-6 flex items-center justify-between border-b border-slate-700/50 sticky top-0 z-50">
            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="active:scale-95 transition-transform">
                    <img src="{{ asset('img/logo.png') }}" class="h-12 w-auto drop-shadow-lg" alt="Logo">
                </a>
                <div>
                    <h1 class="text-2xl font-black italic uppercase leading-none tracking-tighter text-white">IN-TOUCH</h1>
                    <p class="text-[9px] font-bold text-blue-400 uppercase tracking-widest mt-1 leading-tight">
                        Buku Tamu <br> Dinas Komunikasi dan Informatika 
                    </p>
                </div>
            </div>
        </div>

        <div class="p-6">
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-2xl text-sm font-bold text-center">
                    {{ session('success') }}
                </div>
            @endif

            <form id="guest-form" action="{{ route('guest.store') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="swafoto" id="swafoto-input">
                <input type="hidden" name="tanda_tangan" id="signature-input">
                <input type="hidden" name="jam_isi" id="jam-isi-input">

                <div class="space-y-4">
                    <label class="text-[10px] font-black uppercase text-slate-500 tracking-[0.2em] ml-1">Data Diri Pengunjung</label>
                    <input type="text" name="nama" required placeholder="Nama Lengkap" class="w-full p-4 bg-[#0f172a] border border-slate-700 rounded-2xl outline-none text-sm text-white focus:border-blue-500 transition-all placeholder:text-slate-600">
                    <input type="tel" name="whatsapp" required placeholder="Nomor WhatsApp" class="w-full p-4 bg-[#0f172a] border border-slate-700 rounded-2xl outline-none text-sm text-white focus:border-blue-500 transition-all placeholder:text-slate-600">
                    <input type="text" name="instansi" required placeholder="Asal Instansi/Alamat" class="w-full p-4 bg-[#0f172a] border border-slate-700 rounded-2xl outline-none text-sm text-white focus:border-blue-500 transition-all placeholder:text-slate-600">
                    <input type="text" name="pejabat_ditemui" required placeholder="Pejabat yang ditemui" class="w-full p-4 bg-[#0f172a] border border-slate-700 rounded-2xl outline-none text-sm text-white focus:border-blue-500 transition-all placeholder:text-slate-600">
                    <textarea name="tujuan_kunjungan" placeholder="Keperluan/Tujuan" rows="3" class="w-full p-4 bg-[#0f172a] border border-slate-700 rounded-2xl outline-none text-sm text-white focus:border-blue-500 transition-all placeholder:text-slate-600"></textarea>
                </div>

                <div class="space-y-3 bg-[#0f172a] p-5 rounded-3xl border border-slate-700/50">
                    <label class="text-[10px] font-black uppercase text-slate-500 tracking-widest block text-center italic">Swafoto</label>
                    <div class="flex flex-col items-center gap-4">
                        <div class="w-36 h-36 bg-[#1e293b] rounded-2xl border-2 border-dashed border-slate-700 flex items-center justify-center overflow-hidden relative shadow-inner">
                            <img id="photo-preview" class="hidden w-full h-full object-cover">
                            <svg id="placeholder-icon" class="w-12 h-12 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><circle cx="12" cy="13" r="3" stroke="currentColor" stroke-width="1.5"></circle></svg>
                        </div>
                        <label class="cursor-pointer bg-blue-600 text-white px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest active:scale-95 transition-all shadow-lg shadow-blue-900/20">
                            Buka Kamera
                            <input type="file" id="camera-input" accept="image/*" capture="user" class="hidden">
                        </label>
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase text-slate-500 tracking-widest text-center block italic">Tanda Tangan</label>
                    <div class="bg-white rounded-2xl overflow-hidden shadow-lg border-4 border-[#0f172a]">
                        <canvas id="signature-pad" class="w-full h-40 cursor-crosshair"></canvas>
                    </div>
                    <div class="flex justify-center">
                        <button type="button" onclick="signaturePad.clear()" class="text-[10px] font-bold text-red-400 uppercase tracking-widest underline decoration-2 underline-offset-4">Hapus TTD</button>
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-black py-5 rounded-2xl shadow-xl shadow-blue-900/40 uppercase text-xs tracking-[0.3em] active:scale-95 transition-all">
                    Kirim Data Kunjungan
                </button>
            </form>
        </div>
    </div>

    <script>
        const canvas = document.getElementById('signature-pad');
        const signaturePad = new SignaturePad(canvas);
        function resizeCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
            signaturePad.clear();
        }
        window.addEventListener("resize", resizeCanvas);
        resizeCanvas();

        const cameraInput = document.getElementById('camera-input');
        const swafotoInput = document.getElementById('swafoto-input');
        cameraInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const img = new Image();
                    img.onload = function() {
                        const canvasComp = document.createElement('canvas');
                        const ctx = canvasComp.getContext('2d');
                        const MAX_WIDTH = 400;
                        let width = img.width; let height = img.height;
                        if (width > MAX_WIDTH) { height *= MAX_WIDTH / width; width = MAX_WIDTH; }
                        canvasComp.width = width; canvasComp.height = height;
                        ctx.drawImage(img, 0, 0, width, height);
                        const dataUrl = canvasComp.toDataURL('image/jpeg', 0.6);
                        swafotoInput.value = dataUrl;
                        document.getElementById('photo-preview').src = dataUrl;
                        document.getElementById('photo-preview').classList.remove('hidden');
                        document.getElementById('placeholder-icon').classList.add('hidden');
                    };
                    img.src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('guest-form').onsubmit = function() {
            if (signaturePad.isEmpty()) { alert("Tanda tangan wajib diisi."); return false; }
            if (!swafotoInput.value) { alert("Swafoto wajib diambil."); return false; }
            const sekarang = new Date();
            document.getElementById('jam-isi-input').value = String(sekarang.getHours()).padStart(2, '0') + ":" + String(sekarang.getMinutes()).padStart(2, '0');
            document.getElementById('signature-input').value = signaturePad.toDataURL('image/jpeg', 0.5);
            return true;
        };
        
        (function() {
            console.clear();
            console.log("%c🚀 IN-TOUCH GUESTBOOK", "background:#1e293b; color:#38bdf8; font-size:20px; font-weight:bold; padding:10px; border-left:5px solid #d61f26;");
            console.log("%cDeveloped by Danu Winartha | Diskominfo Karangasem", "color:#94a3b8; font-style:italic;");
        })();
    </script>
</body>
</html>