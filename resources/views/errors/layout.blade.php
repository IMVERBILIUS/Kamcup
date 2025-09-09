<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Terjadi Kesalahan') | Kamcup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --kamcup-primary: #cb2786;
            --kamcup-secondary: #00617a;
            --kamcup-accent: #f4b704;
            --text-dark: #212529;
            --text-muted: #6c757d;
        }

        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            text-align: center;
            font-family: 'Montserrat', sans-serif;

            padding: 20px;
        }

        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            max-width: 500px;
            width: 100%;
            border-top: 5px solid var(--kamcup-primary);
        }

        h1 {
            font-size: 6rem;
            font-weight: 800;
            color: var(--kamcup-accent);
            margin-bottom: 10px;
            line-height: 1;
        }

        h2 {
            font-size: 2.2rem;
            color: var(--kamcup-secondary);
            margin-bottom: 20px;
            font-weight: 700;
        }

        p {
            font-size: 1.1rem;
            color: var(--text-dark);
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .cta-button {
            display: inline-block;
            background-color: var(--kamcup-primary);
            color: var(--text-light);
            padding: 12px 25px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .cta-button:hover {
            background-color: var(--kamcup-secondary);
            transform: translateY(-2px);
            color: var(--text-light);
        }

        .footer-text {
            margin-top: 30px;
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        @media (max-width: 768px) {
            .container {
                padding: 30px;
            }

            h1 {
                font-size: 4.5rem;
            }

            h2 {
                font-size: 1.8rem;
            }

            p {
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 20px;
            }

            h1 {
                font-size: 3.5rem;
            }

            h2 {
                font-size: 1.5rem;
            }

            .cta-button {
                padding: 10px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container" data-aos="zoom-in-down">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1200,
            easing: 'ease-in-out',
            once: true,
            mirror: false
        });
    </script>
</body>

</html>
