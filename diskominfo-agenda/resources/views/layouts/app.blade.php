<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - DISKOMINFO Karangasem</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #0a0a0a; margin: 0; color: #fff; }
        
        /* Header Konsisten dengan Warna Logo Karangasem */
        .main-header { 
            height: 100px; 
            display: flex; 
            align-items: center; 
            padding: 0 30px;
            background: linear-gradient(135deg, #e62129 50%, #008ecc 50%);
            border-bottom: 5px solid #fecb00;
        }

        .logo-container { display: flex; align-items: center; }
        .logo-container img { height: 70px; margin-right: 15px; }
        .logo-container h2 { margin: 0; font-size: 24px; text-transform: uppercase; letter-spacing: 1px; }

        .content { padding: 20px; }
    </style>
</head>
<body>
    <header class="main-header">
        <div class="logo-container">
            <img src="{{ asset('img/logo.png') }}" alt="Logo Karangasem">
            <div>
                <h2>DISKOMINFO</h2>
                <small>KABUPATEN KARANGASEM</small>
            </div>
        </div>
    </header>

    <div class="content">
        @yield('content')
    </div>
</body>
</html>