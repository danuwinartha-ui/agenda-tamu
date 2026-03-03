<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IN-TOUCH Admin - Diskominfo Karangasem</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }

        @media print {
            .no-print { display: none !important; }
            body { background: white !important; color: black !important; padding: 0 !important; }
            .card-master { background: white !important; border: 1px solid #ddd !important; box-shadow: none !important; border-radius: 0 !important; }
            .text-white, .text-blue-400, .text-slate-400, .text-amber-400, .text-emerald-400 { color: black !important; }
            table { border-collapse: collapse !important; width: 100% !important; }
            th, td { border: 1px solid #ddd !important; padding: 10px !important; color: black !important; }
            img { max-height: 60px !important; }
            .print-header { display: block !important; text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        }
        .print-header { display: none; }
    </style>
</head>
<body class="bg-[#0f172a] font-sans text-slate-200">

    <div class="max-w-7xl mx-auto min-h-screen flex flex-col p-4 md:p-8">
        
        <div class="bg-[#1e293b] rounded-3xl shadow-xl border border-slate-700/50 p-6 mb-6 flex flex-col md:flex-row justify-between items-center gap-4 no-print">
            <div class="flex items-center gap-4">
                <img src="<?php echo e(asset('img/logo.png')); ?>" alt="Logo" class="max-h-12 w-auto object-contain">
                <div>
                    <h1 class="text-2xl font-black text-white italic uppercase leading-none tracking-tighter text-blue-400">IN-TOUCH</h1>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">Informasi Jejaring & Tata Urusan Central Hospitality</p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <button onclick="window.print()" class="flex items-center gap-2 bg-blue-600/10 text-blue-400 border border-blue-400/20 px-4 py-2.5 rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-blue-600 hover:text-white transition-all shadow-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak Laporan
                </button>
                <div class="h-8 w-px bg-slate-700 hidden md:block"></div>
                <form action="<?php echo e(route('logout')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="bg-red-500/10 text-red-500 p-3 rounded-2xl hover:bg-red-600 hover:text-white transition-all border border-red-500/20 shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>
            </div>
        </div>

        <div class="print-header text-black">
            <h2 class="text-xl font-bold uppercase">Laporan Kunjungan Tamu (IN-TOUCH)</h2>
            <p class="text-sm">Dinas Komunikasi dan Informatika Kabupaten Karangasem</p>
            <p class="text-xs font-bold mt-2 border-t pt-2 italic"><?php echo e($filterInfo); ?></p>
        </div>

        <div class="bg-[#1e293b] rounded-2xl border border-slate-700/50 p-4 mb-6 flex flex-col md:flex-row items-center justify-between gap-4 shadow-lg no-print">
            <form action="<?php echo e(route('admin.dashboard')); ?>" method="GET" id="filterForm" class="flex flex-col md:flex-row items-center gap-3 w-full md:w-auto">
                <div class="flex items-center gap-3 bg-[#0f172a] px-4 py-2 rounded-xl border border-slate-700 focus-within:border-blue-500 transition-all">
                    <label class="text-[10px] font-black uppercase text-slate-500 tracking-tighter">Pilih Tanggal:</label>
                    <input type="date" name="tanggal" id="inputTanggal" value="<?php echo e(request('tanggal')); ?>" 
                        onchange="this.form.submit()"
                        class="bg-transparent text-sm font-bold text-blue-400 outline-none cursor-pointer [color-scheme:dark]">
                </div>
                <?php if(request('tanggal')): ?>
                    <button type="button" onclick="clearFilter()" class="flex items-center gap-2 bg-slate-700/50 hover:bg-red-500/20 text-slate-400 hover:text-red-400 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all border border-slate-600/50 hover:border-red-500/50">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Reset Filter
                    </button>
                <?php endif; ?>
            </form>

            <div class="text-right">
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest"><?php echo e($filterInfo); ?></div>
                <div class="text-sm font-black text-white uppercase tracking-tighter">Total: <span class="text-blue-400"><?php echo e(count($guests)); ?></span> Pengunjung</div>
            </div>
        </div>

        <div class="bg-[#1e293b] rounded-[2.5rem] shadow-2xl border border-slate-700/50 overflow-hidden card-master">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-800/50 border-b border-slate-700/50">
                        <tr>
                            <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Waktu</th>
                            <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Identitas Tamu</th>
                            <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Tujuan & Pejabat</th>
                            <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center">Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/50">
                        <?php $__empty_1 = true; $__currentLoopData = $guests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $guest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-slate-800/40 transition-colors">
                            <td class="p-6">
                                <div class="text-blue-400 font-bold text-base leading-none"><?php echo e($guest->jam_isi ?? $guest->created_at->format('H:i')); ?></div>
                                <div class="text-[9px] text-slate-500 font-bold mt-1 tracking-tighter"><?php echo e($guest->created_at->format('d/m/Y')); ?></div>
                            </td>
                            <td class="p-6">
                                <div class="font-bold text-white uppercase text-base leading-tight"><?php echo e($guest->nama); ?></div>
                                <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $guest->whatsapp)); ?>" target="_blank" class="flex items-center gap-1.5 mt-1 group no-print">
                                    <span class="text-[11px] font-bold text-emerald-400 bg-emerald-400/10 px-2 py-0.5 rounded-lg group-hover:bg-emerald-400 group-hover:text-white transition-all">
                                        <?php echo e($guest->whatsapp); ?>

                                    </span>
                                    <svg class="w-3 h-3 text-emerald-400 opacity-0 group-hover:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.588-5.946 0-6.556 5.332-11.891 11.891-11.891 3.181 0 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.481 8.403 0 6.556-5.332 11.891-11.891 11.891-2.011 0-3.986-.511-5.732-1.483l-6.261 1.603zm6.216-3.804c1.473.873 3.12 1.336 4.805 1.336 5.176 0 9.387-4.212 9.387-9.387s-4.212-9.387-9.387-9.387c-2.508 0-4.866.977-6.641 2.751s-2.75 4.133-2.75 6.636c0 1.764.475 3.483 1.374 4.974l-.905 3.303 3.383-.867zm11.233-7.234c-.085-.143-.314-.23-.659-.402s-2.039-1.006-2.353-1.121-.544-.172-.773.172-.887 1.121-1.087 1.351-.401.258-.745.086c-.344-.172-1.454-.536-2.771-1.711-1.025-.913-1.717-2.042-1.917-2.387s-.022-.531.15-.702c.154-.154.344-.402.516-.603s.229-.344.344-.574c.115-.23.057-.43-.029-.603s-.773-1.866-1.059-2.555c-.279-.671-.563-.58-.773-.591-.199-.011-.429-.013-.659-.013s-.602.086-.917.43c-.315.344-1.203 1.177-1.203 2.871s1.232 3.33 1.404 3.56c.172.23 2.424 3.701 5.871 5.192.82.354 1.46.566 1.959.724.823.262 1.572.225 2.164.137.66-.098 2.039-.832 2.326-1.636s.287-1.492.201-1.636z"/></svg>
                                </a>
                                <div class="hidden print:block text-[10px] font-bold text-black"><?php echo e($guest->whatsapp); ?></div>
                                <div class="text-[11px] text-slate-400 uppercase tracking-tighter mt-1"><?php echo e($guest->instansi); ?></div>
                            </td>
                            <td class="p-6">
                                <div class="text-slate-200 italic line-clamp-2">"<?php echo e($guest->tujuan_kunjungan); ?>"</div>
                                <div class="text-[11px] text-amber-400 font-bold uppercase mt-1 tracking-tighter italic">Bertemu: <?php echo e($guest->pejabat_ditemui); ?></div>
                            </td>
                            <td class="p-6">
                                <div class="flex items-center justify-center gap-4">
                                    <div class="relative cursor-pointer no-print" onclick="openPreview('<?php echo e($guest->swafoto); ?>', 'Foto: <?php echo e($guest->nama); ?>')">
                                        <img src="<?php echo e($guest->swafoto); ?>" class="h-14 w-14 object-cover rounded-xl border-2 border-slate-600 shadow-lg hover:scale-110 transition-transform">
                                    </div>
                                    <img src="<?php echo e($guest->swafoto); ?>" class="hidden print:block h-14 w-14 object-cover rounded border border-black">
                                    <div class="relative cursor-pointer no-print" onclick="openPreview('<?php echo e($guest->tanda_tangan); ?>', 'TTD: <?php echo e($guest->nama); ?>')">
                                        <div class="bg-white p-1 rounded-xl shadow-lg hover:scale-110 transition-transform">
                                            <img src="<?php echo e($guest->tanda_tangan); ?>" class="h-10 w-20 object-contain">
                                        </div>
                                    </div>
                                    <div class="hidden print:block bg-white p-1 border border-black">
                                        <img src="<?php echo e($guest->tanda_tangan); ?>" class="h-10 w-20 object-contain">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="4" class="p-32 text-center text-slate-600 font-black uppercase text-xs tracking-widest">Data Kosong</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="imageModal" class="fixed inset-0 z-[100] hidden bg-black/95 flex items-center justify-center p-4 backdrop-blur-sm" onclick="closePreview()">
        <div class="relative max-w-4xl w-full flex flex-col items-center" onclick="event.stopPropagation()">
            <button onclick="closePreview()" class="absolute -top-12 right-0 text-white text-5xl font-light hover:text-red-500 transition-colors">&times;</button>
            <img id="modalImage" src="" class="max-h-[80vh] w-auto rounded-2xl shadow-2xl border-4 border-slate-800 object-contain bg-white">
            <h3 id="modalTitle" class="text-white mt-6 font-bold uppercase tracking-widest text-center"></h3>
        </div>
    </div>

    <script>
        <?php if(request('tanggal') == date('Y-m-d') || !request('tanggal')): ?>
            setTimeout(() => { location.reload(); }, 30000);
        <?php endif; ?>

        function clearFilter() {
            document.getElementById('inputTanggal').value = '';
            document.getElementById('filterForm').submit();
        }

        function openPreview(src, title) {
            const modal = document.getElementById('imageModal');
            document.getElementById('modalImage').src = src;
            document.getElementById('modalTitle').innerText = title;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closePreview() {
            document.getElementById('imageModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        (function() {
            console.clear();
            console.log("%c🚀 IN-TOUCH GUESTBOOK", "background:#1e293b; color:#38bdf8; font-size:20px; font-weight:bold; padding:10px; border-left:5px solid #d61f26;");
            console.log("%cDeveloped by Danu Winartha | Diskominfo Karangasem", "color:#94a3b8; font-style:italic;");
        })();
    </script>
</body>
</html><?php /**PATH D:\Danu\2026\diskominfo-buku-tamu\resources\views/admin.blade.php ENDPATH**/ ?>