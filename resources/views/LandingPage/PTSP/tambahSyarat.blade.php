
@extends('IndexLandingPage.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/nouislider/nouislider.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/swiper/swiper.css" />
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
              <h1 class="text-primary hero-title display-8 fw-bold">{{$title}}<br>Perkara {{$perkara->perkara_name}}</h1>               
              <!-- Tombol Tambah Syarat -->
              <a href="{{ url()->previous() }}" class="btn btn-warning mt-3">
                <i class="bx bx-arrow-back"></i> Kembali
              </a>      
              <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#tambahSyaratModal">Tambah Syarat</button>
            </div>
          </div>
        </div>        
      </section>
             
      <!-- Daftar Syarat dengan DataTables -->
      <section id="syarat-list" class="section-py">
        <div class="container">     
          <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Syarat</th>
                <th>Deskripsi</th>
                <th>URL</th>
                <th>Urutan</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                @forelse ($syaratPerkara as $index => $syarat)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $syarat->name_syarat }}</td>
                        <td>{{ $syarat->discretion_syarat }}</td>
                        <td><a href="{{ $syarat->url_syarat }}" target="_blank">Lihat Syarat</a></td>
                        <td>{{ $syarat->urutan }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-primary">Edit</a>
                            <a href="#" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Syarat Perkara belum ditambahkan</td>
                    </tr>
                @endforelse
            </tbody>
          </table>
        </div>
      </section>
    </div>

    <!-- Modal Tambah Syarat -->
    <div class="modal fade" id="tambahSyaratModal" tabindex="-1" aria-labelledby="tambahSyaratModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahSyaratModalLabel">Tambah Syarat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formTambahSyarat" method="POST" action="{{ route('syarat.store') }}">
                        @csrf <!-- Token CSRF Laravel -->
                        <div class="mb-3">
                            <label for="name_syarat" class="form-label">Nama Syarat</label>
                            <input type="text" class="form-control" id="name_syarat" name="name_syarat" required>
                        </div>
                        <div class="mb-3">
                            <label for="discretion_syarat" class="form-label">Deskripsi Syarat</label>
                            <textarea class="form-control" id="discretion_syarat" name="discretion_syarat" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="url_syarat" class="form-label">Contoh Dokumen (URL)</label>
                            <input type="text" class="form-control" id="url_syarat" name="url_syarat" placeholder="isi Strip (-) Jika Belum Ada Dokumen" required>
                        </div>
                        <input type="hidden" class="form-control" id="id_perkara" name="id_perkara" value="{{ $perkara->id }}">
                        <button type="submit" class="btn btn-primary">Simpan Syarat</button>
                    </form>
                                   
                </div>
            </div>
        </div>
    </div>
@endsection


@push('footer-script') 
    <script src="{{ asset('assets') }}/js/front-page-landing.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.js"></script>   
    <script src="{{ asset('assets') }}/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
@endpush