
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
                            @elseif($cutiDetail->status == 11)
                            <span class="badge bg-danger">
                                Status: Cuti Ditolak
                                <div class="badge-line-break">Menunggu Konfirmasi Selanjutnya</div>
                            @elseif($cutiDetail->status == 12)
                            <span class="badge bg-danger">
                                Status: Cuti Ditolak
                                <div class="badge-line-break">Menunggu Penomoran Surat</div>
                            @elseif($cutiDetail->status == 13)
                            <span class="badge bg-danger">
                                Status: Cuti Ditolak                             
                            @elseif($cutiDetail->status == 21)
                            <span class="badge bg-warning">
                                Status: Cuti Ditangguhkan
                                <div class="badge-line-break">Menunggu Konfirmasi Selanjutnya</div>
                            @elseif($cutiDetail->status == 22)
                            <span class="badge bg-warning">
                                Status: Cuti Ditangguhkan
                                <div class="badge-line-break">Menunggu Penomoran Surat</div>
                            @elseif($cutiDetail->status == 23)
                            <span class="badge bg-warning">
                                Status: Cuti Ditangguhkan                             
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
                                @if($cutiDetail->status == 21)
                                    <div class="col-sm-6">
                                        <label class="form-label" for="tglAwal">Tanggal Awal Setelah Penangguhan</label>
                                        <input type="text" name="tglAwal" id="tglAwal" class="form-control" value="{{ $cutiDetail->tglawal_per_atasan }}" readonly />
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="tglAkhir">Tanggal Akhir Setelah Penangguhan</label>
                                        <input type="text" name="tglAkhir" id="tglAkhir" class="form-control" value="{{ $cutiDetail->tglakhir_per_atasan }}" readonly />
                                    </div>
                                @endif
                            
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
                        <input type="hidden" id="user_id" name="user_id" value="{{$users->id}}">
                        @if (($cutiDetail->status == 1 && $users->id === $cutiDetail->atasan_id) || 
                            ($cutiDetail->status == 2 && $users->id === $cutiDetail->atasan_dua_id))
                            <div class="d-flex flex-wrap justify-content-center mt-3">
                                <button type="submit" class="btn btn-success m-2">Izinkan</button>
                                <button type="button" class="btn btn-warning m-2" id="btnPenanguhan" data-bs-toggle="modal" data-bs-target="#penanguhanModal">Penanguhan</button>
                                <button type="button" class="btn btn-danger m-2" data-bs-toggle="modal" data-bs-target="#tolakModal">Tolak</button>
                            </div>
                        @endif
                        @if ($cutiDetail->status == 11 && $users->id === $cutiDetail->atasan_dua_id)
                            <div class="d-flex flex-wrap justify-content-center mt-3">
                                <button type="button" id="confirmButton" class="btn btn-danger m-2">Setujui Penolakan</button>
                            </div>
                        @endif
                        @if ($cutiDetail->status == 11 && $users->id === $cutiDetail->atasan_dua_id)
                            <div class="d-flex flex-wrap justify-content-center mt-3">
                                <button type="button" id="confirmButton" class="btn btn-danger m-2">Setujui Penolakan</button>
                            </div>
                        @endif
                        @if ($cutiDetail->status == 21 && $users->id === $cutiDetail->atasan_dua_id)
                            <div class="d-flex flex-wrap justify-content-center mt-3">
                                <button type="button" id="confirmPenangguhan" class="btn btn-warning m-2">Setujui Penanguhan</button>
                                <button type="button" class="btn btn-warning m-2" data-bs-toggle="modal" data-bs-target="#rubahPenangguhan">Rubah Penangguhan</button>
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

    <div class="modal fade" id="penanguhanModal" tabindex="-1" aria-labelledby="penanguhanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="penanguhanModalLabel">Penanguhan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Isi modal -->
                    <form id="penanguhanForm" method="POST" action="{{ route('cuti.penanguhan') }}">
                        @csrf                       
                        <div class="mb-3">
                            <label for="tglAwalBaruPenanguhan" class="form-label">Tanggal Awal Baru</label>
                            <input type="date" class="form-control" id="tglAwalBaruPenanguhan" name="tglAwalBaruPenanguhan">
                        </div>
                        <div class="mb-3">
                            <label for="tglAkhirBaruPenanguhan" class="form-label">Tanggal Akhir Baru</label>
                            <input type="date" class="form-control" id="tglAkhirBaruPenanguhan" name="tglAkhirBaruPenanguhan">
                        </div>
                        <div class="mb-3">
                            <label for="penanguhanComment" class="form-label">Alasan</label>
                            <textarea class="form-control" id="penanguhanComment" name="penanguhanComment" rows="3"></textarea>
                        </div>
                        <input type="hidden" id="id" name="id" value="{{$cutiDetail->id}}">
                        <input type="hidden" id="user_id" name="user_id" value="{{$users->id}}">
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tolakModal" tabindex="-1" aria-labelledby="tolakModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="penanguhanModalLabel">Berikan Alasan Penolakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Isi modal -->
                    <form id="penanguhanForm" method="POST" action="{{ route('cuti.tolak') }}">
                        @csrf                        
                        <div class="mb-3">
                            <label for="penanguhanComment" class="form-label">Alasan</label>
                            <textarea class="form-control" id="penanguhanComment" name="penanguhanComment" rows="3"></textarea>
                        </div>
                        <input type="hidden" id="id" name="id" value="{{$cutiDetail->id}}">
                        <input type="hidden" id="user_id" name="user_id" value="{{$users->id}}">
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rubahPenangguhan" tabindex="-1" aria-labelledby="rubahPenangguhanLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="penanguhanForm" method="POST" action="{{ route('cuti.penanguhan.update') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="rubahPenangguhanLabel">Rubah Penangguhan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tglAwalBaruPenanguhan" class="form-label">Tanggal Awal Baru</label>
                            <input type="date" class="form-control" id="tglAwalBaruPenanguhan" name="tglAwalBaruPenanguhan">
                        </div>
                        <div class="mb-3">
                            <label for="tglAkhirBaruPenanguhan" class="form-label">Tanggal Akhir Baru</label>
                            <input type="date" class="form-control" id="tglAkhirBaruPenanguhan" name="tglAkhirBaruPenanguhan">
                        </div>
                        <div class="mb-3">
                            <label for="penanguhanComment" class="form-label">Alasan</label>
                            <textarea class="form-control" id="penanguhanComment" name="penanguhanComment" rows="3"></textarea>
                        </div>
                        <input type="hidden" id="id" name="id" value="{{ $cutiDetail->id }}">
                        <input type="hidden" id="user_id" name="user_id" value="{{ $users->id }}">
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
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

        document.getElementById('confirmButton').addEventListener('click', function() {
            const cutiId = document.getElementById('id').value;
            const userId = document.getElementById('user_id').value;

            Swal.fire({
                title: 'Setujui Penolakan Cuti?',
                text: "Permohonan Cuti Ini Tidak Disetujui Atasan Sebelumnya",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, setujui!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('{{ route("cuti.tolak.pejabat") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            id: cutiId,
                            user_id: userId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire(
                                data.title,
                                data.message,
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                data.title,
                                data.message,
                                'error'
                            );
                        }
                    })
                    .catch(error => {
                        Swal.fire(
                            'Error!',
                            'Ada kesalahan dalam pengajuan.',
                            'error'
                        );
                    });
                }
            });
        });

        document.getElementById('confirmPenangguhan').addEventListener('click', function () {
            const cutiId = document.getElementById('id').value;
            const userId = document.getElementById('user_id').value;

            Swal.fire({
                title: 'Setujui Penangguhan Cuti?',
                text: "Permohonan Cuti Ini Ditangguhkan Atasan Sebelumnya",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Setujui!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('{{ route("cuti.tangguh.pejabat") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            id: cutiId,
                            user_id: userId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire(
                                'Berhasil!',
                                'Penangguhan Cuti Disetujui.',
                                'success'
                            );
                            // Optional: Redirect or update the page
                        } else {
                            Swal.fire(
                                'Gagal!',
                                data.message || 'Terjadi kesalahan, silakan coba lagi.',
                                'error'
                            );
                        }
                    })
                    .catch(error => {
                        Swal.fire(
                            'Gagal!',
                            'Terjadi kesalahan saat mengirim permintaan.',
                            'error'
                        );
                        console.error('Error:', error);
                    });
                }
            });
        });


    </script>
@endpush