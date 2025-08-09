<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - Kersa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e6f7f1 100%);
            min-height: 100vh;
        }

        .card {
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.9);
        }

        .card-body {
            padding: 2.5rem;
        }

        .logo-container {
            width: 80px;
            height: 80px;
            background-color: #e6f7f1;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 16px rgba(102, 126, 234, 0.2);
        }

        .logo-icon {
            font-size: 2.5rem;
            color: #36b37e;
        }

        .form-control {
            border-radius: 12px;
            padding: 0.75rem 1rem;
            border: 1px solid rgba(102, 126, 234, 0.2);
            background-color: rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.15);
        }

        .input-group-text {
            background-color: transparent;
            border-right: none;
        }

        .form-control.border-start-0 {
            border-left: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #5B93FF 0%, #4A7FD9 100%);
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(102, 126, 234, 0.3);
        }

        .alert {
            border-radius: 12px;
            border: none;
        }

        .alert-success {
            background-color: rgba(52, 199, 89, 0.1);
            color: #34c759;
        }

        .alert-danger {
            background-color: rgba(255, 59, 48, 0.1);
            color: #ff3b30;
        }

        @media (max-width: 576px) {
            .card-body {
                padding: 1.5rem;
            }

            .logo-container {
                width: 60px;
                height: 60px;
            }

            .logo-icon {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center py-4 py-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <div class="logo-container mb-3">
                                <i class="fas fa-key logo-icon"></i>
                            </div>
                            <h3 class="h4 fw-bold text-dark mb-2">Reset Password</h3>
                            <p class="text-muted mb-4">Enter your email to receive a password reset link.</p>
                        </div>

                        @if (session('status'))
                            <div class="alert alert-success text-center mb-4" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label fw-medium text-dark">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter your email">
                                </div>
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2 mb-4">
                                <button type="submit" class="btn btn-primary">
                                    Send Password Reset Link
                                </button>
                            </div>
                        </form>

                        <div class="text-center">
                            <p class="text-muted mb-0">Remember your password? <a href="{{ route('login') }}" class="text-decoration-none text-primary">Login here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
