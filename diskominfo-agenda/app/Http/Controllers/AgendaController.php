<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache; // <--- WAJIB ADA
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class AgendaController extends Controller
{
    // --- 1. MONITOR (PUBLIC) ---
    public function index()
    {
        $agendas = Agenda::where('status', 'tampil')
            ->whereDate('tanggal', '>=', Carbon::today())
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu', 'asc')
            ->get();
        
        // Mengirim waktu update terakhir ke view agar monitor tahu kapan harus refresh
        $lastUpdate = Cache::get('last_agenda_update', time());

        return view('agenda.index', compact('agendas', 'lastUpdate'));
    }

    // --- FUNGSI BARU: CEK UPDATE UNTUK MONITOR ---
    public function checkUpdate()
    {
        // Mengembalikan timestamp terakhir kali data diubah
        return response()->json([
            'last_update' => Cache::get('last_agenda_update', 0)
        ]);
    }

    // --- 2. AUTH (LOGIN/LOGOUT) ---
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->with('error', 'Login Gagal! Email atau Password salah.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // --- 3. DASHBOARD ---
    public function dashboard()
    {
        $agendas = Agenda::orderBy('tanggal', 'desc')->get();
        $users = User::all();
        return view('admin.dashboard', compact('agendas', 'users'));
    }

    // --- 4. CRUD AGENDA (DENGAN AUTO REFRESH TRIGGER) ---
    public function addAgenda(Request $request)
    {
        $request->validate([
            'kegiatan' => 'required',
            'perihal' => 'required',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'tempat' => 'required',
            'dari_instansi' => 'required',
        ]);

        Agenda::create([
            'user_id' => Auth::id(),
            'kegiatan' => $request->kegiatan,
            'perihal' => $request->perihal,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'tempat' => $request->tempat,
            'dari_instansi' => $request->dari_instansi,
            'disposisi' => $request->disposisi ?? '-',
            'status' => 'tampil'
        ]);

        // TRIGGER UPDATE KE MONITOR
        Cache::put('last_agenda_update', time());

        return back()->with('success', 'Agenda berhasil ditambahkan!');
    }

    public function updateAgenda(Request $request, $id)
    {
        $agenda = Agenda::findOrFail($id);
        
        if(Auth::user()->role == 3 && $agenda->user_id != Auth::id()){
            return back()->with('error', 'Anda tidak memiliki akses edit data ini!');
        }

        $agenda->update($request->all());

        // TRIGGER UPDATE KE MONITOR
        Cache::put('last_agenda_update', time());

        return back()->with('success', 'Agenda diperbarui!');
    }

    public function deleteAgenda($id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->delete();

        // TRIGGER UPDATE KE MONITOR
        Cache::put('last_agenda_update', time());

        return back()->with('success', 'Agenda dihapus!');
    }

    public function toggleStatus($id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->status = ($agenda->status == 'tampil') ? 'sembunyi' : 'tampil';
        $agenda->save();

        // TRIGGER UPDATE KE MONITOR
        Cache::put('last_agenda_update', time());

        return back()->with('success', 'Status agenda diubah!');
    }

    // --- 5. CETAK PDF ---
    public function generateLaporan()
    {
        $agendas = Agenda::orderBy('tanggal', 'asc')->orderBy('waktu', 'asc')->get();

        if ($agendas->isNotEmpty()) {
            $awal = Carbon::parse($agendas->min('tanggal'))->translatedFormat('d F Y');
            $akhir = Carbon::parse($agendas->max('tanggal'))->translatedFormat('d F Y');
            $tanggal_range = "$awal s/d $akhir";
        } else {
            $tanggal_range = '-';
        }

        $tanggal_sekarang = Carbon::now()->translatedFormat('d F Y');
        $pdf = Pdf::loadView('admin.cetak_laporan', compact('agendas', 'tanggal_range', 'tanggal_sekarang'));
        return $pdf->stream('Laporan-Agenda.pdf');
    }

    // --- 6. GANTI PASSWORD ---
    public function editPassword()
    {
        return view('admin.change_password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:5|confirmed',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->with('error', 'Password lama salah!');
        }

        User::whereId(Auth::id())->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Password berhasil diubah!');
    }

    // --- 7. MANAJEMEN USER ---
    public function addUser(Request $request)
    {
        if (Auth::user()->role != 1) return back()->with('error', 'Akses Ditolak: Hanya Super Admin!');

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5',
            'role' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return back()->with('success', 'User berhasil ditambahkan');
    }

    public function resetUserPassword(Request $request, $id)
    {
        if (Auth::user()->role != 1) return back()->with('error', 'Akses Ditolak: Hanya Super Admin!');
        User::whereId($id)->update(['password' => Hash::make($request->new_password_reset)]);
        return back()->with('success', 'Password user berhasil direset!');
    }

    public function deleteUser($id)
    {
        if (Auth::user()->role != 1) {
            return back()->with('error', 'Akses Ditolak: Hanya Super Admin yang boleh menghapus user!');
        }

        if ($id == Auth::id()) {
            return back()->with('error', 'Error: Anda tidak bisa menghapus akun sendiri!');
        }

        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'User berhasil dihapus!');
    }
}