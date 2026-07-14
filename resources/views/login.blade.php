<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Politeknik Negeri Banyuwangi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background-color: #0b1a30; /* Deep navy bottom background */
            font-family: 'Inter', 'Segoe UI', Roboto, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
        }

        /* Top slanted gradient background */
        .bg-top {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 42vh;
            background: linear-gradient(90deg, #cbe0ff 0%, #8ca2ff 100%);
            clip-path: polygon(0 0, 100% 0, 100% 32vh, 0 40vh);
            z-index: 1;
        }

        .login-container {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 480px;
            padding: 20px;
        }

        .login-card {
            background: #ffffff;
            border-radius: 8px;
            padding: 2.5rem 2.25rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
            border: none;
            animation: slideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* Header Style (Logo left, Text right, centered group) */
        .login-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 2.25rem;
        }

        .logo-img {
            width: 42px;
            height: 42px;
            object-fit: contain;
        }

        .header-text {
            display: flex;
            flex-direction: column;
            text-align: left;
        }

        .system-subtitle {
            font-size: 13px;
            color: #4b5563;
            margin: 0;
            font-weight: 500;
            line-height: 1.2;
        }

        .institution-title {
            font-size: 15px;
            color: #0b1a30;
            font-weight: 700;
            margin: 2px 0 0 0;
            line-height: 1.2;
        }

        /* Custom Input Groups */
        .input-group-custom {
            display: flex;
            align-items: center;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            background: #ffffff;
            margin-bottom: 1.25rem;
            overflow: hidden;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .input-group-custom:focus-within {
            border-color: #2096dc;
            box-shadow: 0 0 0 3px rgba(32, 150, 220, 0.15);
        }

        .input-group-custom input {
            flex: 1;
            border: none;
            padding: 12px 14px;
            font-size: 14px;
            color: #374151;
            outline: none;
            background: transparent;
        }

        .input-group-custom input::placeholder {
            color: #9ca3af;
            opacity: 1;
        }

        .input-icon-container {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-left: 1px solid #e5e7eb;
            color: #0ea5e9; /* Cyan icon color */
            flex-shrink: 0;
            background: #ffffff;
        }

        .input-icon-container svg {
            width: 18px;
            height: 18px;
            fill: currentColor;
        }

        /* Action bar (Masuk button on the right) */
        .action-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 1.5rem;
        }

        .btn-submit {
            background-color: #2096dc;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            padding: 8px 24px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.15s ease, transform 0.1s ease;
        }

        .btn-submit:hover {
            background-color: #1a7ebc;
        }

        .btn-submit:active {
            transform: scale(0.98);
        }

        .btn-submit:disabled {
            background-color: #93c5fd;
            cursor: not-allowed;
        }

        /* Animation */
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Background top slanted -->
    <div class="bg-top"></div>

    <div class="login-container">
        <div class="login-card">
            <!-- Header -->
            <div class="login-header">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="logo-img">
                <div class="header-text">
                    <span class="system-subtitle">Sistem Informasi Akademik</span>
                    <h1 class="institution-title">Politeknik Negeri Banyuwangi</h1>
                </div>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Username/Email input -->
                <div class="input-group-custom @error('email') border-danger @enderror">
                    <input type="email"
                           id="email"
                           name="email"
                           placeholder="username"
                           value="{{ old('email') }}"
                           required
                           autofocus>
                    <div class="input-icon-container">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                </div>
                @error('email')
                    <div class="text-danger text-start mb-3 small" style="margin-top: -10px; font-size: 12px;">
                        {{ $message }}
                    </div>
                @enderror

                <!-- Password input -->
                <div class="input-group-custom @error('password') border-danger @enderror">
                    <input type="password"
                           id="password"
                           name="password"
                           placeholder="Password"
                           required>
                    <div class="input-icon-container">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                        </svg>
                    </div>
                </div>
                @error('password')
                    <div class="text-danger text-start mb-3 small" style="margin-top: -10px; font-size: 12px;">
                        {{ $message }}
                    </div>
                @enderror

                <!-- Submit Button -->
                <div class="action-container">
                    <button type="submit" class="btn-submit">
                        Masuk
                    </button>
                </div>
            </form>

            <!-- Alerts for other errors -->
            @if ($errors->any() && !$errors->has('email') && !$errors->has('password'))
                <div class="alert alert-danger mt-3 py-2 px-3" style="font-size: 13px; border-radius: 6px;">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status'))
                <div class="alert alert-success mt-3 py-2 px-3" style="font-size: 13px; border-radius: 6px;">
                    {{ session('status') }}
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelector('form').addEventListener('submit', function() {
            const button = this.querySelector('.btn-submit');
            button.innerHTML = '<span class="spinner-border spinner-border-sm me-2" style="width: 14px; height: 14px;"></span>Masuk...';
            button.disabled = true;
        });
    </script>
</body>
</html>
