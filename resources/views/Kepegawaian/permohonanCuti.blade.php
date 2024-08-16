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
<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">    
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Kepegawaian /</span> Cuti / {{$title}}</h4>    

    <!--/ Card Border Shadow -->
    <div class="row g-4">
      <!-- Vehicles overview -->
      <div class="col-xl-12 col-lg-12 col-md-12 order-0 order-md-1">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item col-3">
                    <a class="nav-link" href="{{ route('kepegawaian.cuti.sisa') }}"><i class="bx bx-menu-alt-left me-1"></i>Sisa Cuti</a>
                </li>
                <li class="nav-item col-3">
                    <a class="nav-link active" href="{{ route('kepegawaian.cuti.permohonan') }}"><i class="bx bx-menu me-1"></i>Permohonan Cuti</a>
                </li>
                <li class="nav-item col-3">
                    <a class="nav-link" href="/admin/menu/childmenulist"><i class="bx bx-menu-alt-right me-1"></i>Penomoran Cuti</a>
                </li>
                <li class="nav-item col-3">
                    <a class="nav-link" href="/admin/menu/role"><i class="bx bx-lock-open-alt me-1"></i>Role</a>
                </li>
            </ul>             
            <div class="card">    
                <div class="card-datatable table-responsive">
                    <table id="permohonanCuti-table" class="datatables-users table border-top">                
                        <thead>
                            <tr>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Atasan</th>
                                    <th>No Surat</th>
                                    <th>Jenis</th>
                                    <th>Tanggal Awal</th>
                                    <th>Tanggal Akhir</th>                                
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>    
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="permohonanCuti" tabindex="-1" aria-labelledby="sisaCutiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="permohonanCuti">Permohonan Cuti</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Isi modal -->
                <form id="cutiForm" method="POST" action="{{ route('cuti.approve') }}">
                    @csrf
                    <!-- Tambahkan elemen form sesuai kebutuhan -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Pegawai</label>
                        <input type="text" class="form-control" id="name" name="name" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="jenisCuti" class="form-label">Jenis Cuti</label>
                        <input type="text" class="form-control" id="jenisCuti" name="jenisCuti" readonly>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-0">
                            <label for="tglAwal" class="form-label">Tanggal Awal</label>
                            <input type="date" class="form-control" id="tglAwal" name="tglAwal" readonly>
                        </div>
                        <div class="col mb-0">
                            <label for="tglAkhir" class="form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="tglAkhir" name="tglAkhir" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="alasan" class="form-label">Alasan Cuti</label>
                        <input type="text" class="form-control" id="alasan" name="alasan" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Selama Cuti</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" readonly>
                    </div>
                    <input type="hidden" id="id" name="id" readonly>
                    
                    <div class="d-flex flex-wrap justify-content-center">
                        <button type="submit" class="btn btn-success m-2">Izinkan</button>
                        <button type="button" class="btn btn-info m-2" id="btnPerubahan">Perubahan</button>
                        <button type="button" class="btn btn-warning m-2" id="btnPenanguhan">Penanguhan</button>
                        <button type="button" class="btn btn-danger m-2" id="btnTolak">Tolak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Perubahan -->
<div class="modal fade" id="perubahanModal" tabindex="-1" aria-labelledby="perubahanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="perubahanModalLabel">Perubahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Isi modal -->
                <form id="perubahanForm" method="POST" action="{{ route('cuti.perubahan') }}">
                    @csrf
                    <input type="hidden" id="idPerubahan" name="idPerubahan" readonly>
                    <div class="row g-2">
                        <div class="col mb-0">
                            <label for="tglAwalBaru" class="form-label">Tanggal Awal Baru</label>
                            <input type="date" class="form-control" id="tglAwalBaru" name="tglAwalBaru">
                        </div>
                        <div class="col mb-0">
                            <label for="tglAkhirBaru" class="form-label">Tanggal Akhir Baru</label>
                            <input type="date" class="form-control" id="tglAkhirBaru" name="tglAkhirBaru">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="perubahanComment" class="form-label">Komentar</label>
                        <textarea class="form-control" id="perubahanComment" name="perubahanComment" rows="3"></textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" id="backToMainModal1">Kembali</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Penanguhan -->
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
                    <input type="hidden" id="idPenanguhan" name="idPenanguhan" readonly>
                    <div class="mb-3">
                        <label for="tglAwalBaruPenanguhan" class="form-label">Tanggal Awal Baru</label>
                        <input type="date" class="form-control" id="tglAwalBaruPenanguhan" name="tglAwalBaruPenanguhan">
                    </div>
                    <div class="mb-3">
                        <label for="tglAkhirBaruPenanguhan" class="form-label">Tanggal Akhir Baru</label>
                        <input type="date" class="form-control" id="tglAkhirBaruPenanguhan" name="tglAkhirBaruPenanguhan">
                    </div>
                    <div class="mb-3">
                        <label for="penanguhanComment" class="form-label">Komentar</label>
                        <textarea class="form-control" id="penanguhanComment" name="penanguhanComment" rows="3"></textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" id="backToMainModal2">Kembali</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Tolak -->
<div class="modal fade" id="tolakModal" tabindex="-1" aria-labelledby="tolakModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tolakModalLabel">Tolak</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Isi modal -->
                <form id="tolakForm" method="POST" action="{{ route('cuti.tolak') }}">
                    @csrf
                    <input type="hidden" id="idTolak" name="idTolak" readonly>
                    <div class="mb-3">
                        <label for="tolakComment" class="form-label">Komentar</label>
                        <textarea class="form-control" id="tolakComment" name="tolakComment" rows="3"></textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" id="backToMainModal3">Kembali</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Penomoran -->
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
                    <input type="hidden" id="id" name="id">
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
<script src="{{ asset('assets') }}/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.js"></script>
@endpush

@push('footer-Sec-script')

<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#permohonanCuti-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('cutis.permohonangetData') !!}',
            columns: [
                {data: 'no', name: 'no'},
                {data: 'user_name', name: 'user_name'},
                {data: 'atasan_name', name: 'atasan_name'},
                {data: 'no_surat', name: 'no_surat'},
                {data: 'jenis', name: 'jenis'},
                {data: 'tglawal', name: 'tglawal'},
                {data: 'tglakhir', name: 'tglakhir'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        // Handle action button click
        $('#permohonanCuti-table').on('click', '.edit', function () {
            var data = table.row($(this).parents('tr')).data();
            $('#id').val(data.id);
            $('#jenisCuti').val(data.jenis);
            $('#name').val(data.user_name);
            $('#tglAwal').val(data.tglawal);
            $('#tglAkhir').val(data.tglakhir);
            $('#alasan').val(data.alasan); 
            $('#alamat').val(data.alamat); 
            $('#permohonanCuti').modal('show');
        });

        // Handle Perubahan button click
        $('#btnPerubahan').on('click', function () {
            $('#permohonanCuti').modal('hide');
            $('#idPerubahan').val($('#id').val());
            $('#perubahanModal').modal('show');
        });

        // Handle Penanguhan button click
        $('#btnPenanguhan').on('click', function () {
            $('#permohonanCuti').modal('hide');
            $('#idPenanguhan').val($('#id').val());
            $('#penanguhanModal').modal('show');
        });

        // Handle Tolak button click
        $('#btnTolak').on('click', function () {
            $('#permohonanCuti').modal('hide');
            $('#idTolak').val($('#id').val());
            $('#tolakModal').modal('show');
        });

        // Handle Back button click in Perubahan modal
        $('#backToMainModal1').on('click', function () {
            $('#perubahanModal').modal('hide');
            $('#permohonanCuti').modal('show');
        });

        // Handle Back button click in Penanguhan modal
        $('#backToMainModal2').on('click', function () {
            $('#penanguhanModal').modal('hide');
            $('#permohonanCuti').modal('show');
        });

        // Handle Back button click in Tolak modal
        $('#backToMainModal3').on('click', function () {
            $('#tolakModal').modal('hide');
            $('#permohonanCuti').modal('show');
        });

        $('#permohonanCuti-table').on('click', '.nomor', function () {
        var data = table.row($(this).parents('tr')).data();
        var id = data.id; // Retrieve the id from the data
        
        // Set the hidden input value in the modal and display it in a readable format
        $('#penomoranModal').find('#id').val(id);
        $('#penomoranModal').find('#displayId').text('ID: ' + id);
        
        // Show the modal
        $('#penomoranModal').modal('show');
    });    

    });
</script>


  <script>
   function showDeleteConfirmation(url, message) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }


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