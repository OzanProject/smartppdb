<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 Akses Ditolak | {{ $landingSettings['app_name'] ?? 'PPDB PRO' }}</title>
    <!-- Google Font: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Inter', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .error-container {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
            padding: 3rem;
            max-width: 550px;
            width: 90%;
            text-align: center;
            position: relative;
        }
        .error-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg, #ff416c 0%, #ff4b2b 100%);
            border-radius: 24px 24px 0 0;
        }
        .error-icon {
            font-size: 80px;
            color: #ff4b2b;
            margin-bottom: 1.5rem;
            text-shadow: 0 10px 20px rgba(255, 75, 43, 0.2);
        }
        h1 {
            font-size: 2.5rem;
            font-weight: 800;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }
        .error-message {
            color: #718096;
            font-size: 1.1rem;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        .btn-custom {
            border-radius: 50px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        .btn-primary-custom {
            background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%);
            border: none;
            color: white;
            box-shadow: 0 4px 15px rgba(79, 172, 254, 0.3);
        }
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(79, 172, 254, 0.4);
            color: white;
        }
        .btn-outline-custom {
            border: 2px solid #e2e8f0;
            color: #4a5568;
            background: transparent;
        }
        .btn-outline-custom:hover {
            border-color: #cbd5e0;
            background: #f8fafc;
            color: #2d3748;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">
            <i class="fas fa-user-lock"></i>
        </div>
        <h1>Akses Ditolak</h1>
        <p class="error-message">
            Maaf, kredensial peran Anda (<strong>{{ auth()->check() ? auth()->user()->role : 'Guest' }}</strong>) tidak memiliki izin untuk membuka halaman ini.
            <br><small class="text-muted mt-2 d-block">Kode Kesalahan: 403 Forbidden</small>
        </p>
        
        <div class="d-flex justify-content-center">
            <a href="{{ url()->previous() !== url()->current() ? url()->previous() : url('/dashboard') }}" class="btn btn-outline-custom btn-custom mr-3">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            <a href="{{ url('/dashboard') }}" class="btn btn-primary-custom btn-custom">
                <i class="fas fa-home mr-2"></i> Ke Dashboard
            </a>
        </div>
    </div>
</body>
</html>
