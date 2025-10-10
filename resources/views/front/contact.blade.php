@extends('../layouts/master_nav')

@section('content')
    {{-- MODIFICATION: Added inline style 'margin-top: 140px;' to push content below the absolute navbar --}}
    <section class="pb-5" style="margin-top: 140px;">
        <div class="container">
            <div class="d-flex justify-content-between scroll-animate" data-animation="fadeInLeft">
                <a href="{{ route('front.index') }}" class="btn px-4 py-2"
                    style="background-color: #F0F5FF; border-radius: 8px;">
                    <i class="fas fa-arrow-left me-2"></i> Back
                </a>
            </div>

            <div class="text-center mb-5 p-4 rounded-4 scroll-animate" data-animation="fadeInUp" data-delay="100">
                <h1 class="fw-bold mb-3 article-text">Terhubung dengan Semangat KAMI</h1>
                <p class="text-muted w-75 mx-auto article-text">Punya pertanyaan, ide kolaborasi, atau ingin bergabung dalam
                    kompetisi yang inspiratif? Tim KAMCUP siap melayani Anda dengan antusiasme dan komitmen penuh untuk
                    pertumbuhan bersama. Kami adalah komunitas aktif dan sporty, dengan visi youthful untuk masa depan yang
                    refreshing.</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-7 mb-4 mb-lg-0 scroll-animate" data-animation="fadeInLeft" data-delay="200">
                    <div class="p-4 p-lg-5 rounded-4 h-100"
                        style="background-color: #ffffff; box-shadow: 0 10px 30px rgba(108, 99, 255, 0.08);">
                        <h4 class="fw-semibold mb-4 article-text">Send us a message</h4>
                        <form>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control border-0"
                                            style="background-color: #f4f4f4;" id="nameInput" placeholder="Your name"
                                            required>
                                        <label for="nameInput" class="text-muted article-text">Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-1">
                                        <input type="email" class="form-control border-0"
                                            style="background-color: #f4f4f4;" id="emailInput" placeholder="you@example.com"
                                            required>
                                        <label for="emailInput" class="text-muted">Email</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control border-0"
                                            style="background-color: #f4f4f4;" id="subjectInput"
                                            placeholder="How can we help you?">
                                        <label for="subjectInput" class="text-muted">Subject</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-1">
                                        <textarea class="form-control border-0" style="background-color: #f4f4f4; height: 140px;" id="messageInput"
                                            placeholder="Tell us more about your inquiry..." required></textarea>
                                        <label for="messageInput" class="text-muted">Message</label>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <button class="btn btn-lg px-4 py-2 rounded-pill text-white d-flex align-items-center"
                                        style="background: linear-gradient(135deg, #161616 0%, #4e4e4e 100%); border: none; box-shadow: 0 4px 12px rgba(108, 99, 255, 0.25); transition: all 0.3s ease;">
                                        <span>Send Message</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            fill="currentColor" class="bi bi-send ms-2" viewBox="0 0 16 16">
                                            <path
                                                d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="p-4 p-lg-4 rounded-4 mb-4 scroll-animate" data-animation="fadeInRight" data-delay="300"
                        style="background-color: #ffffff; box-shadow: 0 10px 30px rgba(108, 99, 255, 0.08);">
                        <h4 class="fw-semibold mb-4 article-text">Our Locations</h4>

                        <div class="d-flex mb-4 align-items-start scroll-animate" data-animation="fadeInRight"
                            data-delay="400">
                            <div class="me-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center"
                                    style="background: linear-gradient(135deg, #eae7ff 0%, #f0f8ff 100%); width: 50px; height: 50px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#00000"
                                        class="bi bi-building" viewBox="0 0 16 16">
                                        <path
                                            d="M4 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v10.5a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5V2.5Z" />
                                        <path
                                            d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2Zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Kantor Pusat KAMCUP</h6>
                                <p class="mb-1 text-muted">Jl. Sadar Dusun I Kampung Padang,<br>Riau - 28557</p>
                            </div>
                        </div>

                        <div class="d-flex mb-4 align-items-start scroll-animate" data-animation="fadeInRight"
                            data-delay="500">
                            <div class="me-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center"
                                    style="background: linear-gradient(135deg, #eae7ff 0%, #f0f8ff 100%); width: 50px; height: 50px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#00000"
                                        class="bi bi-building-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M3 0a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h3v-3.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V16h3a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1H3Zm1 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3.5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5ZM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM7.5 5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5Zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM4.5 8h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5Zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3.5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5Z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Kantor Cabang KAMCUP</h6>
                                <p class="mb-1 text-muted">Ngadiwinatan NG I/1106 Yogyakarta,<br>DIY 55261</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start scroll-animate" data-animation="fadeInRight"
                            data-delay="600">
                            <div class="me-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center"
                                    style="background: linear-gradient(135deg, #eae7ff 0%, #f0f8ff 100%); width: 50px; height: 50px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#00000"
                                        class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Phone</h6>
                                <p class="mb-1">
                                    <a href="tel:+6282220955595" class="text-decoration-none text-muted"
                                        style="transition: color 0.3s ease;">+62 822-2095-5595</a>
                                 </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 p-lg-4 rounded-4 scroll-animate" data-animation="fadeInRight" data-delay="700"
                        style="background-color: #ffffff; box-shadow: 0 10px 30px rgba(108, 99, 255, 0.08);">
                        <h4 class="fw-semibold mb-4 article-text">Connect With Us</h4>
                        <div class="d-flex flex-column gap-3">
                            <a href="https://www.instagram.com/kamcup_official/"
                                class="d-flex align-items-center text-decoration-none p-3 rounded-3 scroll-animate"
                                data-animation="fadeInRight" data-delay="800" style="transition: all 0.3s ease; ">
                                <div class="me-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                                        style=" background: linear-gradient(135deg, #eae7ff 0%, #f0f8ff 100%);width: 50px; height: 50px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                            fill="#00000" class="bi bi-instagram" viewBox="0 0 16 16">
                                            <path
                                                d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z" />
                                        </svg>
                                    </div>
                                </div>
                                <span class="fw-medium" style="color: #424242;">kamcup_official</span>
                            </a>

                            <a href="https://www.linkedin.com/company/kamcup/"
                                class="d-flex align-items-center text-decoration-none p-3 rounded-3 scroll-animate"
                                data-animation="fadeInRight" data-delay="900" style="transition: all 0.3s ease; ">
                                <div class="me-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                                        style="background: linear-gradient(135deg, #eae7ff 0%, #f0f8ff 100%); width: 50px; height: 50px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                            fill="#00000" class="bi bi-linkedin" viewBox="0 0 16 16">
                                            <path
                                                d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z" />
                                        </svg>
                                    </div>
                                </div>
                                <span class="fw-medium" style="color: #424242;">KAMCUP Official</span>
                            </a>

                            <a href="mailto:kamcupofficial@gmail.com"
                                class="d-flex align-items-center text-decoration-none p-3 rounded-3 scroll-animate"
                                data-animation="fadeInRight" data-delay="1000" style="transition: all 0.3s ease; ">
                                <div class="me-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                                        style="background: linear-gradient(135deg, #eae7ff 0%, #f0f8ff 100%); width: 50px; height: 50px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                            fill="#00000" class="bi bi-envelope" viewBox="0 0 16 16">
                                            <path
                                                d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
                                        </svg>
                                    </div>
                                </div>
                                <span class="fw-medium" style="color: #424242;">kamcupofficial@gmail.com</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <style>
        /* Custom hover effects */
        .hover-link:hover {
            opacity: 1 !important;
            transition: all 0.3s ease;
        }

        .hover-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(108, 99, 255, 0.15);
            transition: all 0.3s ease;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(108, 99, 255, 0.15);
            border-color: #00000;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(108, 99, 255, 0.3);
        }

        /* Smooth transitions */
        .form-control,
        .btn,
        a {
            transition: all 0.3s ease;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('js/animate.js') }}"></script>
@endpush