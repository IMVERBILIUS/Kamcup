<footer class="text-white pt-5 pb-4 border-top border-secondary" style="background: linear-gradient(to bottom, #0F62FF 62%, #01205E 100%);">
    <div class="container">
      <div class="row gy-4 align-items-start">

        <div class="col-md-4 text-md-start text-center">
          <a class="navbar-brand d-flex align-items-center" href="{{ route('front.index') }}"
           style="width: 265px; overflow: hidden; height: 110px;">
            {{-- ^^^^^ Perubahan di sini: tambahkan width, overflow: hidden, dan height ^^^^^ --}}

            {{-- KAMCUP Logo with KAMCUP's primary color --}}
            {{-- Assuming you have a KAMCUP logo at public/images/kamcup_logo.png --}}
            <img src="{{ asset('assets/img/logo4.png') }}" alt="KAMCUP Logo" class="me-2 brand-logo"
                 style="height: 100%; width: 100%; object-fit: cover;">
                 {{-- ^^^^^ Perubahan di sini: height: 100% dan width: 100% ^^^^^ --}}
        </a>
          <p class="mb-1 small">By KAMCUP Official</p> {{-- Ganti Ankara Cipta ke KAMCUP Official (atau sesuai keinginan) --}}
          <p class="mb-1">&copy; 2025 KAMCUP by KAMCUP Official</p> {{-- Ganti Kersa by Ankara Cipta ke KAMCUP by KAMCUP Official --}}
          <p class="small mb-1" >Di Sini Bakat Berkembang, Juara Terlahir.</p> {{-- Teks ini bisa disesuaikan dengan slogan Kamcup --}}
        </div>

        <div class="col-md-4 text-center">
          <h5 class="fw-bold mb-3">Navigation</h5>
          <ul class="list-unstyled d-flex flex-column gap-2 align-items-center">
            <li><a href="{{ route('front.index') }}" class="text-white text-decoration-none hover-link">Home</a></li>
            <li><a href="#" class="text-white text-decoration-none hover-link">About Us</a></li>
            <li><a href="{{ route('front.articles') }}" class="text-white text-decoration-none hover-link">Articles</a></li>
            <li><a href="{{ route('front.contact') }}" class="text-white text-decoration-none hover-link">Contact</a></li>
          </ul>
        </div>

        <div class="col-md-4 text-md-end text-center">
          <h5 class="fw-bold mb-3">Contact Us</h5>
          <p class="mb-1">Email:
            <a href="mailto:kamcupofficial@gmail.com" class="text-warning text-decoration-none">kamcupofficial@gmail.com</a> {{-- Ganti email --}}
          </p>
          <p class="mb-3">Phone:
            <a href="tel:+6281234567890" class="text-warning text-decoration-none">+62 812-3456-7890</a> {{-- Ganti nomor telepon (ini nomor contoh) --}}
          </p>
          <div class="d-flex justify-content-center justify-content-md-end gap-3">
            <a href="#" class="btn btn-outline-light btn-sm rounded-circle border-0 shadow-sm" title="Facebook">
              <i class="bi bi-facebook"></i>
            </a>
            <a href="https://www.instagram.com/kamcup_official/" class="btn btn-outline-light btn-sm rounded-circle border-0 shadow-sm" title="Instagram">
              <i class="bi bi-instagram"></i>
            </a>
            <a href="#" class="btn btn-outline-light btn-sm rounded-circle border-0 shadow-sm" title="Twitter">
              <i class="bi bi-twitter"></i>
            </a>
          </div>
        </div>

      </div>
    </div>
  </footer>
