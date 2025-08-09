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
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
            background-color: rgba(255, 255, 255, 0.95);
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
        }
        .btn-primary {
            background: linear-gradient(135deg, #5B93FF 0%, #4A7FD9 100%);
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <div class="logo-container mb-3">
                                <i class="fas fa-unlock-alt logo-icon"></i>
                            </div>
                            <h3 class="h4 fw-bold text-dark mb-2">Reset Your Password</h3>
                            <p class="text-muted mb-4">Enter a new password below to reset your account.</p>
                        </div>

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">
                            <input type="hidden" name="email" value="{{ $email ?? old('email') }}">

                            <div class="mb-3">
                                <label for="password" class="form-label text-dark">New Password</label>
                                <input type="password" class="form-control" name="password" required autocomplete="new-password" placeholder="Enter new password">
                                @error('password')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password-confirm" class="form-label text-dark">Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm new password">
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    Reset Password
                                </button>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <a href="{{ route('login') }}" class="text-decoration-none text-primary">Back to login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
