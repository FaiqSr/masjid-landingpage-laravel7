@extends('main_blog') {{-- Menggunakan layout utama Anda --}}

@section('title', 'Kontak Kami')

@section('top-style')
    <style>
        /* Gaya tambahan untuk mempercantik halaman kontak */
        .contact-icon {
            font-size: 20px;
            width: 50px;
            height: 50px;
            line-height: 50px;
            text-align: center;
            border-radius: 50%;
            color: #fff;
            background-color: #007c6c;
        }
        .contact-form .form-control {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
        }
        .contact-form .btn {
            padding: 0.75rem 1.5rem;
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
    <section class="pt-5 pb-5">
        <div class="container pt-5 pb-5">
            <div class="row mb-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <h2 class="fw-bold">Hubungi Kami</h2>
                    <p class="text-muted">Kami siap membantu Anda. Jangan ragu untuk menghubungi kami melalui informasi di bawah atau kirimkan pesan melalui formulir.</p>
                </div>
            </div>
            <div class="row d-flex justify-content-center">

                <div class="col-md-5 col-xl-4">
                    <div class="d-flex flex-column justify-content-center h-100">
                        
                        <div class="d-flex align-items-start p-3">
                            <div class="contact-icon me-3"><i class="fas fa-map-marker-alt"></i></div>
                            <div>
                                <h6 class="fw-bold mb-0">Alamat</h6>
                                <p class="text-muted mb-0">{{ $setting->alamat ?? 'Alamat belum diatur.' }}</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start p-3">
                            <div class="contact-icon me-3"><i class="fab fa-whatsapp"></i></div>
                            <div>
                                <h6 class="fw-bold mb-0">WhatsApp</h6>
                                <p class="text-muted mb-0">
                                    <a href="https://wa.me/{{ $setting->wa ?? '' }}" target="_blank">{{ $setting->wa ?? 'Nomor belum diatur.' }}</a>
                                </p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start p-3">
                            <div class="contact-icon me-3"><i class="fas fa-envelope"></i></div>
                            <div>
                                <h6 class="fw-bold mb-0">Email</h6>
                                <p class="text-muted mb-0"><a href="mailto:info@sekolah.com">info@sekolah.com</a></p>
                            </div>
                        </div>
                        
                         <div class="d-flex align-items-start p-3">
                            <div class="contact-icon me-3"><i class="fas fa-share-alt"></i></div>
                            <div>
                                <h6 class="fw-bold mb-0">Media Sosial</h6>
                                <p class="text-muted mb-0">
                                    @if($setting->fb)
                                        <a href="https://facebook.com/{{ $setting->fb }}" target="_blank" class="me-2">Facebook</a>
                                    @endif
                                    @if($setting->ig)
                                        <a href="https://instagram.com/{{ $setting->ig }}" target="_blank">Instagram</a>
                                    @endif
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container pb-5">
        <div class="row">
            <div class="col-12">
                 <div class="card shadow-sm border-0">
                    <div class="card-body p-2">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.053194977435!2d106.8288063153597!3d-6.387113164245645!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ebf56a52a3a5%3A0x24125f0e3831b017!2sMasjid%20Jami%20Al-Hidayah!5e0!3m2!1sen!2sid!4v1690000000000!5m2!1sen!2sid" 
                            width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection