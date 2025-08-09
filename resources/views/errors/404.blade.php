<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found - Halaman Tidak Ditemukan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Define Custom Properties for your main colors */
        :root {
            --kamcup-primary: #cb2786; /* Merah Muda Keunguan */
            --kamcup-secondary: #00617a; /* Biru Kehijauan Tua */
            --kamcup-accent: #f4b704; /* Kuning Cerah */
            --text-dark: #212529; /* Umumnya teks gelap */
            --text-muted: #6c757d; /* Teks abu-abu untuk deskripsi */
        }

        body {
            background-color: #f8f9fa; /* Light grey background */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            text-align: center;
            font-family: 'Montserrat', sans-serif; /* Menggunakan font yang sporty/modern jika tersedia */
            /* Jika Montserrat tidak tersedia secara default, browser akan menggunakan Arial */
            padding: 20px; /* Padding agar tidak terlalu mepet di layar kecil */
        }

        .container-404 {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px; /* Sedikit lebih membulat untuk kesan modern/sporty */
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08); /* Shadow lebih menonjol */
            max-width: 500px; /* Batasi lebar container */
            width: 100%;
            border-top: 5px solid var(--kamcup-primary); /* Garis atas dengan warna primer */
        }

        h1 {
            font-size: 6rem; /* Ukuran lebih besar untuk angka 404 */
            font-weight: 800; /* Lebih tebal */
            color: var(--kamcup-accent); /* Menggunakan warna kuning cerah sebagai aksen untuk angka 404 */
            margin-bottom: 10px;
            line-height: 1; /* Hapus spasi ekstra */
        }

        h2 {
            font-size: 2.2rem;
            color: var(--kamcup-secondary); /* Menggunakan warna biru kehijauan tua untuk judul utama */
            margin-bottom: 20px;
            font-weight: 700;
        }

        p {
            font-size: 1.1rem;
            color: var(--text-dark); /* Teks deskripsi menggunakan warna teks gelap */
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .cta-button {
            display: inline-block;
            background-color: var(--kamcup-primary); /* Warna primer untuk tombol */
            color: var(--text-light); /* Teks putih untuk tombol */
            padding: 12px 25px;
            border-radius: 50px; /* Sangat membulat untuk kesan modern/sporty */
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .cta-button:hover {
            background-color: var(--kamcup-secondary); /* Ubah ke warna sekunder saat hover */
            transform: translateY(-2px); /* Efek sedikit terangkat saat hover */
            color: var(--text-light); /* Pastikan teks tetap putih */
        }

        .footer-text {
            margin-top: 30px;
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container-404 {
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
            .container-404 {
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
    <div class="container-404">
        <h1>404</h1>
        <h2>Oops! Halaman Tidak Ditemukan</h2>
        <p>Sepertinya Anda tersesat. Halaman yang Anda cari mungkin telah dihapus, namanya diubah, atau tidak pernah ada.</p>
        <p>Jangan khawatir, mari kita bawa Anda kembali ke jalur yang benar.</p>
        <a href="{{ url('/') }}" class="cta-button">Kembali ke Halaman Utama</a>
        <p class="footer-text">Kami berkomitmen pada pertumbuhan dan semangat kompetisi yang sehat.</p>
    </div>
</body>
</html>
