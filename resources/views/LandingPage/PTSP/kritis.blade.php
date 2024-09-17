
@extends('IndexLandingPage.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/nouislider/nouislider.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/css/pages/front-page-landing.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.css" />
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
        white-space: normal; /* Memastikan teks dapat membungkus */
        text-align: center;
        line-height: 1.5; /* Menambah jarak antar baris */
        padding: 0.5rem 1rem; /* Tambahkan padding untuk memastikan ruang cukup */
    }

    .badge-line-break {
        margin-top: 0.5em;
        display: block; /* Menampilkan baris baru dengan spasi */
    }

    @media (max-width: 576px) { /* Penyesuaian untuk perangkat kecil */
        .badge {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
            line-height: 1.6; /* Sedikit lebih besar pada perangkat kecil */
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
              <h1 class="text-primary hero-title display-8 fw-bold">{{$title}}<br>MS Lhokseumawe</h1>               
              <!-- Tombol Tambah Syarat -->
          
            </div>
          </div>
        </div>        
      </section>
             
      <!-- Daftar Syarat dengan DataTables -->
        <section id="syarat-list" class="section-py">
            <div class="container">                
                <!-- Laravel Blade Form -->
                <form action="{{ route('store.Kirtis') }}" id="addKritis" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control" required>
                        </div>
                    </div>
                
                       <!-- Inputan baru untuk nomor WhatsApp -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="whatsapp" class="form-label">Nomor WhatsApp</label>
                            <input type="text" name="whatsapp" id="whatsapp" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                    </div>

                    <!-- Checkbox untuk menyembunyikan identitas -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="hide_identity" id="hide_identity">
                                <label class="form-check-label" for="hide_identity">
                                    Sembunyikan Identitas
                                </label>
                            </div>
                        </div>
                    </div>
                
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="kritik" class="form-label">Kritik</label>
                            <textarea name="kritik" id="kritik" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="saran" class="form-label">Saran</label>
                            <textarea name="saran" id="saran" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="image" class="form-label">Gambar</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                    </div>
                
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </section>
    </div>
@endsection


@push('footer-script') 
    <script src="{{ asset('assets') }}/vendor/libs/select2/select2.js"></script>    
    <script src="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.js"></script>       
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