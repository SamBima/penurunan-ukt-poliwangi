<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Politeknik Negeri Banyuwangi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background: linear-gradient(135deg, #4A90E2 0%, #357ABD 50%, #2E5A87 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow: hidden;
        }

        .bg-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('{{ asset('assets/img/pnb.jpg') }}');
            background-size: cover;
            opacity: 0.3;
        }

        .login-container {
            position: relative;
            z-index: 10;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 3rem 2.5rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .logo-container {
            margin-bottom: 2rem;
        }

        .logo {
            width: 100px;
            height: 100px;
            margin: 0 auto 1.5rem;
            background: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-inner {
            width: 60px;
            height: 60px;
            background: #e74c3c;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        .institution-title {
            color: #2c3e50;
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .system-title {
            color: #34495e;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 2.5rem;
        }

        .form-floating {
            margin-bottom: 1.5rem;
        }

        .form-floating > .form-control {
            height: 60px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        .form-floating > .form-control:focus {
            border-color: #4A90E2;
            box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.25);
            background: #fff;
        }

        .form-floating > label {
            font-weight: 500;
            color: #6c757d;
            padding-left: 1rem;
        }

        .btn-login {
            background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%);
            border: none;
            border-radius: 12px;
            padding: 15px 0;
            font-size: 1.1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            width: 100%;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(74, 144, 226, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(74, 144, 226, 0.4);
            background: linear-gradient(135deg, #357ABD 0%, #2E5A87 100%);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        @media (max-width: 576px) {
            .login-card {
                margin: 1rem;
                padding: 2rem 1.5rem;
            }

            .institution-title {
                font-size: 1.2rem;
            }

            .system-title {
                font-size: 1rem;
            }
        }

        .login-card {
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="bg-overlay"></div>

    <div class="login-container">
        <div class="login-card">
            <div class="logo-container">
                <div class="logo">
                    <div class="logo-inner">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="logo-img" width="120">
                    </div>
                </div>
            </div>

            <h1 class="institution-title">Politeknik Negeri Banyuwangi</h1>
            <h2 class="system-title">Penyesuaian Uang Kuliah Tunggal</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-floating">
                    <input type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           id="email"
                           name="email"
                           placeholder="Email"
                           value="{{ old('email') }}"
                           required
                           autofocus>
                    <label for="email">Email</label>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-floating">
                    <input type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           id="password"
                           name="password"
                           placeholder="Password"
                           required>
                    <label for="password">Password</label>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-login">
                    Login
                </button>
            </form>

            @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status'))
                <div class="alert alert-success mt-3">
                    {{ session('status') }}
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-2px)';
            });

            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateY(0)';
            });
        });

        document.querySelector('form').addEventListener('submit', function() {
            const button = this.querySelector('.btn-login');
            button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
            button.disabled = true;
        });
    </script>
</body>
</html>
