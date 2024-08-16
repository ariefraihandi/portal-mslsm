
@extends('IndexLandingPage.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/nouislider/nouislider.css" />
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
              <h1 class="text-primary hero-title display-8 fw-bold">{{$title}}<br>{{$userName}}</h1>
              <div class="card">
                    <div class="card-header align-items-center">
                        <h5 class="card-action-title mb-0">
                            @if($cutiDetail->status == 1)
                            <span class="badge bg-info">
                                Status: Menunggu Persetujuan Atasan Langsung
                            @elseif($cutiDetail->status == 2)
                            <span class="badge bg-primary">
                                Status: Menunggu Persetujuan
                                <div class="badge-line-break">Pejabat Yang Berwenang</div>
                                <div class="badge-line-break">Memberikan Cuti</div>
                            @elseif($cutiDetail->status == 3)
                            <span class="badge bg-danger">
                                Status: Ditolak
                            @elseif($cutiDetail->status == 9)
                            <span class="badge bg-dark">
                                Status: Menunggu Penomoran Surat Cuti
                            @elseif($cutiDetail->status == 10)
                            <span class="badge bg-success">
                                Status: Cuti Disetujui
                            @else
                                Status Lain
                            @endif
                            
                            </span>
                        </h5>
                    </div>
                </div>
            </div>
          </div>
        </div>        
      </section>
          
      <section id="landingContact" class="section-py landing-contact">
        <div class="container">
          <div class="row gy-4">
            <div class="col-lg-12">
              <div class="card">              
                <div class="card-body">                
                    <form id="formChangePassword" method="POST" action="{{ route('cuti.approve') }}" enctype="multipart/form-data">                        
                        @csrf                        
                        <div class="row g-3">
                            <!-- Display Cuti Detail data -->
                            @if ($cutiDetail)
                                <div class="col-sm-6">
                                    <label class="form-label" for="name">Nama</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $cutiDetail->userDetails->name ?? 'Nama tidak ditemukan' }}" readonly />
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="jenisCuti">Jenis</label>
                                    <input type="text" name="jenisCuti" id="jenisCuti" class="form-control" value="{{$cutiDetail->cuti->name}}" readonly />
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="alasan">Alasan</label>
                                    <textarea name="alasan" id="alasan" class="form-control" readonly>{{$cutiDetail->alasan}}</textarea>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="alamat">Alamat Selama Cuti</label>
                                    <textarea name="alamat" id="alamat" class="form-control" readonly>{{$cutiDetail->alamat}}</textarea>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="tglAwal">Tanggal Awal</label>
                                    <input type="text" name="tglAwal" id="tglAwal" class="form-control" value="{{$cutiDetail->tglawal}}" readonly />
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="tglAkhir">Tanggal Akhir</label>
                                    <input type="text" name="tglAkhir" id="tglAkhir" class="form-control" value="{{$cutiDetail->tglakhir}}" readonly />
                                </div>                                
                                <div class="col-sm-{{ $cutiDetail->user_id !== $cutiDetail->atasan_dua_id ? '6' : '12' }}">
                                    <label class="form-label" for="atasan">Atasan</label>
                                    <input type="text" name="atasan" id="atasan" class="form-control" value="{{ $cutiDetail->atasan->name }}" readonly />
                                </div>                             
                                @if ($cutiDetail->user_id !== $cutiDetail->atasan_dua_id)
                                    <div class="col-sm-6">
                                        <label class="form-label" for="pejabat_cuti">Pejabat Yang Memberikan Cuti</label>
                                        <input type="text" name="pejabat_cuti" id="pejabat_cuti" class="form-control" value="{{$cutiDetail->atasanDua->name}}" readonly />
                                    </div>
                                @endif                              
                            @else
                                <p>Data cuti tidak ditemukan.</p>
                            @endif
                        </div>
                        <input type="hidden" id="id" name="id" value="{{$cutiDetail->id}}">
                        @if ($cutiDetail->status == 9)
                        <div class="d-flex flex-wrap justify-content-center mt-3">                               
                            <button type="button" class="btn btn-dark m-2" id="btnPenanguhan" data-bs-toggle="modal" data-bs-target="#penomoranModal">
                                Berikan Nomor Surat
                            </button>                               
                        </div>
                    @endif
                    
                    </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <!-- Modal -->
<div class="modal fade" id="penomoranModal" tabindex="-1" aria-labelledby="penomoranModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="penomoranModalLabel">Penomoran Surat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="penomoranForm" action="{{ route('penomoran.store') }}" method="POST">
                    @csrf
                    <input type="hidden" id="id" name="id" value="{{$cutiDetail->id}}">
                    <div class="mb-3">
                        <label for="nomorSurat" class="form-label">Nomor Surat</label>
                        <input type="text" class="form-control" id="nomorSurat" name="nomorSurat" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('footer-script') 
    <script src="{{ asset('assets') }}/js/front-page-landing.js"></script>
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