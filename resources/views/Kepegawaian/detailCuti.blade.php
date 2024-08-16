@extends('IndexPortal.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/css/pages/page-profile.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.css" /> 
@endpush

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Kepegawaian /</span> Cuti / {{$title}}</h4>     
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card card-action mb-4">
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
                        @else
                            Status Lain
                        @endif
                        
                        </span>
                    </h5>
                </div>
                
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
                        <div class="d-flex flex-wrap justify-content-center">
                            <button type="submit" class="btn btn-success m-2">Izinkan</button>
                            <button type="button" class="btn btn-warning m-2" id="btnPenanguhan">Penanguhan</button>
                            <button type="button" class="btn btn-danger m-2" id="btnTolak">Tolak</button>
                        </div>
                    </form>
                </div>
            </div>            
        </div>
    </div>
</div>
@endsection

@push('footer-script')            
<script src="{{ asset('assets') }}/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.js"></script>
@endpush

@push('footer-Sec-script')
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