<div class="p-6 bg-slate-50 min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-ontime-blue">Daftar Tamu Hari Ini</h1>
        <span class="bg-ontime-orange text-white px-4 py-1 rounded-full text-xs font-bold uppercase">
            <?php echo e(date('d M Y')); ?>

        </span>
    </div>

    <div class="bg-white rounded-3xl shadow-sm overflow-hidden border border-gray-100">
        <table class="w-full text-left">
            <thead class="bg-blue-50 text-ontime-blue uppercase text-[10px] font-black">
                <tr>
                    <th class="p-4">Jam</th>
                    <th class="p-4">Nama / Instansi</th>
                    <th class="p-4 text-center">Tanda Tangan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                <?php $__currentLoopData = $guests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $guest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="p-4 font-bold text-gray-400"><?php echo e($guest->created_at->format('H:i')); ?></td>
                    <td class="p-4">
                        <div class="font-bold text-ontime-blue"><?php echo e($guest->nama); ?></div>
                        <div class="text-xs text-gray-500 uppercase"><?php echo e($guest->instansi); ?></div>
                    </td>
                    <td class="p-4 flex justify-center">
                        <img src="<?php echo e($guest->tanda_tangan); ?>" class="h-10 opacity-80 hover:opacity-100">
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div><?php /**PATH D:\Danu\2026\diskominfo-buku-tamu\resources\views/admin/index.blade.php ENDPATH**/ ?>