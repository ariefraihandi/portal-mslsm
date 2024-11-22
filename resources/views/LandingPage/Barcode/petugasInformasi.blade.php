@extends('IndexLandingPage.app')

@push('head-script')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/nouislider/nouislider.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/front-page-landing.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endpush

@push('style-head')
<style>
    .card-header {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 1rem;
    }

    .badge {
        display: inline-block;
        max-width: 100%;
        word-wrap: break-word;
        text-align: center;
        line-height: 1.5;
        padding: 0.5rem 1rem;
    }

    @media (max-width: 576px) {
        .badge {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
        }
    }
</style>
@endpush

@section('content')
<div data-bs-spy="scroll" class="scrollspy-example">
    <!-- Hero: Start -->
    <section id="hero-animation">
        <div id="landingHero" class="section-py landing-hero position-relative">
            <div class="container">
                <div class="hero-text-box text-center">
                    <div class="d-flex align-items-center flex-column">
                        <img class="img-fluid rounded my-4"
                             src="{{ $user->detail && $user->detail->image ? asset('assets/img/avatars/' . $user->detail->image) : asset('assets/img/avatars/default.jpeg') }}"
                             height="110" width="110" alt="{{ $user->nama ?? 'Avatar' }}" />
                    </div>                    
                    <div class="card mb-3">
                        <div class="card-header align-items-center">
                            <h5 class="card-action-title mb-0">
                                <span class="text-success">
                                    {{ $user->detail->kelamin == 'L' ? 'Bapak' : 'Ibu' }}
                                    <strong>{{ $user->detail->name ? ucwords(strtolower($user->detail->name)) : 'Nama tidak tersedia' }}</strong> telah menandatangani dokumen ini dengan eSign.
                                    Berikut adalah detail dokumen:
                                </span>
                            </h5>
                        </div>
                    </div>
                    <h4 class="text-primary hero-title display-8 fw-bold">
                        @if($pemohon)
                            Persetujuan Informasi:
                            <br>
                            Nomor Permohonan: <strong>{{ $pemohon->id }}/PTSP/Informasi</strong>
                            <br>
                            Bahwa benar <strong>{{ $user->detail->name ? ucwords(strtolower($user->detail->name)) : 'Nama tidak tersedia' }}</strong> 
                            telah memberikan informasi kepada 
                            <strong>{{ $pemohon->nama ? ucwords(strtolower($pemohon->nama)) : 'Nama tidak tersedia' }}</strong> 
                            pada tanggal 
                            <strong>{{ $pemohon->created_at ? \Carbon\Carbon::parse($pemohon->created_at)->translatedFormat('d F Y') : 'N/A' }}</strong>
                            di PTSP Mahkamah Syar'iyah Lhokseumawe.
                        @else
                            Data permohonan tidak ditemukan.
                        @endif
                    </h4>                                 
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('footer-script')
<script src="{{ asset('assets/js/front-page-landing.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>

<script>
    function showSweetAlert(response) {
        Swal.fire({
            icon: response.success ? 'success' : 'error',
            title: response.title,
            text: response.message,
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        @if(session('response'))
            var response = @json(session('response'));
            showSweetAlert(response);
        @endif
    });
</script>
@endpush
