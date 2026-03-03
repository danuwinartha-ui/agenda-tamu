<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - IN-TOUCH</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0f172a] font-sans text-slate-200 flex items-center justify-center min-h-screen p-4">

    <div class="max-w-md w-full">
        <div class="text-center mb-8">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-20 mx-auto drop-shadow-2xl mb-4">
            <h1 class="text-3xl font-black italic uppercase tracking-tighter text-white leading-none">IN-TOUCH</h1>
            <p class="text-[10px] font-bold text-blue-400 uppercase tracking-[0.3em] mt-2">Administrator Access</p>
        </div>

        <div class="bg-[#1e293b] rounded-[2.5rem] shadow-2xl border border-slate-700/50 p-8">
            <form action="{{ route('login.auth') }}" method="POST" class="space-y-5">
                @csrf
                
                @if($errors->any())
                    <div class="bg-red-500/10 border border-red-500/20 text-red-500 text-xs font-bold p-4 rounded-2xl text-center">
                        Username atau Password salah!
                    </div>
                @endif

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-slate-500 tracking-widest ml-1">Username</label>
                    <input type="text" name="email" required autofocus
                        class="w-full p-4 bg-[#0f172a] border border-slate-700 rounded-2xl outline-none text-sm text-white focus:border-blue-500 transition-all placeholder:text-slate-700" 
                        placeholder="Masukkan username...">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-slate-500 tracking-widest ml-1">Password</label>
                    <input type="password" name="password" required
                        class="w-full p-4 bg-[#0f172a] border border-slate-700 rounded-2xl outline-none text-sm text-white focus:border-blue-500 transition-all placeholder:text-slate-700" 
                        placeholder="••••••••">
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-black py-4 rounded-2xl shadow-xl shadow-blue-900/40 uppercase text-xs tracking-[0.2em] active:scale-95 transition-all">
                        Masuk Dashboard
                    </button>
                </div>
            </form>
        </div>

        <p class="text-center mt-8 text-[10px] font-bold text-slate-600 uppercase tracking-widest">
            &copy; 2026 Diskominfo Karangasem <br> 
            
        </p>
    </div>

</body>
</html>