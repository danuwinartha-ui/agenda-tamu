<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ON-TIME | Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root { --merah: #e62129; --navy: #1e293b; --kuning: #fecb00; }
        body { background: #f4f7f6; color: #333; font-family: sans-serif; }
        .sidebar { min-height: 100vh; background: var(--navy); color: white; padding: 20px; position: fixed; width: 240px; z-index: 100; display: flex; flex-direction: column; }
        .main-content { margin-left: 240px; width: calc(100% - 240px); }
        .nav-link { color: #ccc; padding: 10px; display: block; text-decoration: none; border-radius: 5px; margin-bottom: 5px; }
        .nav-link:hover, .nav-link.active { background: var(--merah); color: white; }
        .card-custom { border: none; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .header-top { background: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .status-badge { padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .bg-tampil { background: #d1fae5; color: #065f46; }
        .bg-sembunyi { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h4 class="mb-4 text-center fw-bold" style="color: var(--kuning);">ON-TIME</h4>
        <a href="{{ route('admin.dashboard') }}" class="nav-link active"><i class="bi bi-grid-fill me-2"></i> Dashboard</a>
        <a href="{{ route('home') }}" target="_blank" class="nav-link"><i class="bi bi-tv me-2"></i>Halaman Agenda</a>
        <a href="{{ route('password.edit') }}" class="nav-link"><i class="bi bi-key me-2"></i> Ganti Password</a>
        
        <div class="mt-auto">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-danger w-100"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <div class="header-top">
            <h5 class="m-0 fw-bold">Selamat Datang, {{ Auth::user()->name }}</h5>
            <span class="badge bg-primary">
                {{ Auth::user()->role == 1 ? 'Super Admin' : (Auth::user()->role == 2 ? 'Admin' : 'Operator') }}
            </span>
        </div>

        <div class="p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="d-flex gap-2 mb-4">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAgendaModal">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Agenda
                </button>
                <a href="{{ route('admin.generate-laporan') }}" target="_blank" class="btn btn-success">
                    <i class="bi bi-file-pdf me-1"></i> Cetak Laporan
                </a>
            </div>

            <div class="card card-custom mb-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">Daftar Agenda</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Waktu</th>
                                    <th>Kegiatan</th>
                                    <th>Tempat</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($agendas as $a)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ \Carbon\Carbon::parse($a->tanggal)->format('d M Y') }}</div>
                                        <small class="text-muted">{{ $a->waktu }} WITA</small>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $a->kegiatan }}</div>
                                        <small class="text-muted">{{ $a->perihal }}</small>
                                    </td>
                                    <td>{{ $a->tempat }}</td>
                                    <td>
                                        <span class="status-badge {{ $a->status == 'tampil' ? 'bg-tampil' : 'bg-sembunyi' }}">
                                            {{ strtoupper($a->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info text-white me-1" data-bs-toggle="modal" data-bs-target="#editModal{{$a->id}}"><i class="bi bi-pencil"></i></button>
                                        <a href="{{ route('agenda.toggle', $a->id) }}" class="btn btn-sm btn-warning text-white me-1" title="Sembunyikan/Tampilkan"><i class="bi bi-eye"></i></a>
                                        <a href="{{ route('agenda.delete', $a->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Hapus agenda ini?')"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @if(Auth::user()->role == 1 || Auth::user()->role == 2)
            <div class="card card-custom">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title fw-bold m-0">Manajemen User</h5>
                        @if(Auth::user()->role == 1)
                        <button class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#addUserModal">
                            <i class="bi bi-person-plus me-1"></i> Tambah User
                        </button>
                        @endif
                    </div>
                    
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $u)
                            <tr>
                                <td>{{ $u->name }}</td>
                                <td>{{ $u->email }}</td>
                                <td>
                                    @if($u->role == 1) <span class="badge bg-danger">Super Admin</span>
                                    @elseif($u->role == 2) <span class="badge bg-primary">Admin</span>
                                    @else <span class="badge bg-secondary">Operator</span> @endif
                                </td>
                                <td>
                                    @if(Auth::user()->role == 1)
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#resetPassModal{{$u->id}}">Reset Pass</button>
                                        
                                        @if($u->id != Auth::user()->id)
                                            <a href="{{ route('admin.delete-user', $u->id) }}" 
                                               class="btn btn-sm btn-danger" 
                                               onclick="return confirm('Hapus User {{ $u->name }}? Data tidak bisa kembali.')">
                                               Hapus
                                            </a>
                                        @endif
                                    @else
                                        <small class="text-muted">Akses Terbatas</small>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

        </div>
    </div>

    <div class="modal fade" id="addAgendaModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('agenda.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header bg-primary text-white"><h5 class="modal-title">Tambah Agenda Baru</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6"><label>Tanggal</label><input type="date" name="tanggal" class="form-control" required></div>
                        <div class="col-md-6"><label>Jam (WITA)</label><input type="time" name="waktu" class="form-control" required></div>
                        <div class="col-12"><label>Nama Kegiatan</label><textarea name="kegiatan" class="form-control" rows="2" required></textarea></div>
                        <div class="col-12"><label>Perihal</label><input type="text" name="perihal" class="form-control" required></div>
                        <div class="col-md-6"><label>Tempat</label><input type="text" name="tempat" class="form-control" required></div>
                        <div class="col-md-6"><label>Instansi</label><input type="text" name="dari_instansi" class="form-control" required></div>
                        <div class="col-12"><label>Disposisi / Keterangan</label><input type="text" name="disposisi" class="form-control"></div>
                    </div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary">Simpan Agenda</button></div>
            </form>
        </div>
    </div>

    @foreach($agendas as $a)
    <div class="modal fade" id="editModal{{$a->id}}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('agenda.update', $a->id) }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header bg-info text-white"><h5 class="modal-title">Edit Agenda</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6"><label>Tanggal</label><input type="date" name="tanggal" value="{{ $a->tanggal }}" class="form-control" required></div>
                        <div class="col-md-6"><label>Jam</label><input type="time" name="waktu" value="{{ $a->waktu }}" class="form-control" required></div>
                        <div class="col-12"><label>Nama Kegiatan</label><textarea name="kegiatan" class="form-control" rows="2" required>{{ $a->kegiatan }}</textarea></div>
                        <div class="col-12"><label>Perihal</label><input type="text" name="perihal" value="{{ $a->perihal }}" class="form-control" required></div>
                        <div class="col-md-6"><label>Tempat</label><input type="text" name="tempat" value="{{ $a->tempat }}" class="form-control" required></div>
                        <div class="col-md-6"><label>Instansi</label><input type="text" name="dari_instansi" value="{{ $a->dari_instansi }}" class="form-control" required></div>
                        <div class="col-12"><label>Disposisi</label><input type="text" name="disposisi" value="{{ $a->disposisi }}" class="form-control"></div>
                    </div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary">Simpan Perubahan</button></div>
            </form>
        </div>
    </div>
    @endforeach

    @if(Auth::user()->role == 1)
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('admin.add-user') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header bg-dark text-white"><h5 class="modal-title">Tambah User Baru</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3"><label>Nama</label><input type="text" name="name" class="form-control" required></div>
                    <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" required></div>
                    <div class="mb-3"><label>Password</label><input type="password" name="password" class="form-control" required></div>
                    <div class="mb-3">
                        <label>Role</label>
                        <select name="role" class="form-select">
                            <option value="1">Super Admin</option>
                            <option value="2">Admin</option>
                            <option value="3">Operator</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-dark">Tambah User</button></div>
            </form>
        </div>
    </div>

    @foreach($users as $u)
        <div class="modal fade" id="resetPassModal{{$u->id}}" tabindex="-1">
            <div class="modal-dialog">
                <form action="{{ route('admin.reset-user-password', $u->id) }}" method="POST" class="modal-content">
                    @csrf
                    <div class="modal-header bg-warning"><h5 class="modal-title">Reset Password {{ $u->name }}</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body">
                        <input type="text" name="new_password_reset" class="form-control" placeholder="Masukkan Password Baru..." required>
                    </div>
                    <div class="modal-footer"><button class="btn btn-primary">Simpan Password Baru</button></div>
                </form>
            </div>
        </div>
    @endforeach
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</body>

</html>