<div class="p-6 bg-slate-50 min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-ontime-blue">Daftar Tamu Hari Ini</h1>
        <span class="bg-ontime-orange text-white px-4 py-1 rounded-full text-xs font-bold uppercase">
            {{ date('d M Y') }}
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
                @foreach($guests as $guest)
                <tr>
                    <td class="p-4 font-bold text-gray-400">{{ $guest->created_at->format('H:i') }}</td>
                    <td class="p-4">
                        <div class="font-bold text-ontime-blue">{{ $guest->nama }}</div>
                        <div class="text-xs text-gray-500 uppercase">{{ $guest->instansi }}</div>
                    </td>
                    <td class="p-4 flex justify-center">
                        <img src="{{ $guest->tanda_tangan }}" class="h-10 opacity-80 hover:opacity-100">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>