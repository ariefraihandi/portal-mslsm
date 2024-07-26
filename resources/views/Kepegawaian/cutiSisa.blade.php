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
    <div class="row">
      <!-- Vehicles overview -->
        <div class="col-xxl-6 mb-4 order-5 order-xxl-0">      
            <div class="card-datatable table-responsive">
                <table id="pegawai-table" class="datatables-users table border-top">              
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pegawai</th>
                            <th>C. N1</th>                                                    
                            <th>C. N2</th>                            
                            <th>C. N3</th>
                            <th>C. Sakit</th>
                            <th>CAP</th>       
                            <th>CB</th>       
                            <th>CM</th>    
                            <th>Action</th>       
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="sisaCutiModal" tabindex="-1" aria-labelledby="sisaCutiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sisaCutiModalLabel">Ubah Sisa Cuti</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="cutiForm" action="{{ route('editCutiSisa') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="cuti-n1" class="form-label">Cuti N1</label>
                        <input type="number" class="form-control" id="cuti-n1" name="cuti_n1" value="0">
                    </div>
                    <div class="mb-3">
                        <label for="cuti-n2" class="form-label">Cuti N2</label>
                        <input type="number" class="form-control" id="cuti-n2" name="cuti_n2" value="0">
                    </div>
                    <div class="mb-3">
                        <label for="cuti-n3" class="form-label">Cuti N3</label>
                        <input type="number" class="form-control" id="cuti-n3" name="cuti_n3" value="0">
                    </div>
                    <div class="mb-3">
                        <label for="cuti-sakit" class="form-label">Cuti Sakit</label>
                        <input type="number" class="form-control" id="cuti-sakit" name="cuti_sakit" value="0">
                    </div>
                    <div class="mb-3">
                        <label for="cap" class="form-label">CAP</label>
                        <input type="number" class="form-control" id="cap" name="cap" value="0">
                    </div>
                    <div class="mb-3">
                        <label for="cuti-besar" class="form-label">Cuti Besar</label>
                        <input type="number" class="form-control" id="cuti-besar" name="cuti_besar" value="0">
                    </div>
                    <div class="mb-3">
                        <label for="cuti-melahirkan" class="form-label">Cuti Melahirkan</label>
                        <input type="number" class="form-control" id="cuti-melahirkan" name="cuti_melahirkan" value="0">
                    </div>
                    <input type="hidden" id="user-id" name="user_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
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
        $('#pegawai-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('cutis.getData') !!}',
            columns: [
                { data: 'no', name: 'no' },
                { data: 'pegawai', name: 'pegawai', orderable: false, searchable: false },
                { data: 'cutinsatu', name: 'cutinsatu' },         
                { data: 'cutindua', name: 'cutindua' },
                { data: 'cutintiga', name: 'cutintiga' },
                { data: 'cs', name: 'cs' },
                { data: 'cap', name: 'cap' },
                { data: 'cb', name: 'cb' },
                { data: 'cm', name: 'cm' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Event listener untuk ikon action
        $('#sisaCutiModal').on('show.bs.modal', function (event) {
            var icon = $(event.relatedTarget); // Icon yang mengaktifkan modal
            var userId = icon.data('id'); // Ekstrak info dari data-* attributes
            var userName = icon.data('name'); // Ekstrak info dari data-* attributes
            var cutiN1 = icon.data('cutinsatu');
            var cutiN2 = icon.data('cutindua');
            var cutiN3 = icon.data('cutintiga');
            var cutiSakit = icon.data('cs');
            var cap = icon.data('cap');
            var cutiBesar = icon.data('cb');
            var cutiMelahirkan = icon.data('cm');

            var modal = $(this);
            modal.find('.modal-title').text('Ubah Sisa Cuti (' + userName + ')');
            modal.find('#cuti-n1').val(cutiN1);
            modal.find('#cuti-n2').val(cutiN2);
            modal.find('#cuti-n3').val(cutiN3);
            modal.find('#cuti-sakit').val(cutiSakit);
            modal.find('#cap').val(cap);
            modal.find('#cuti-besar').val(cutiBesar);
            modal.find('#cuti-melahirkan').val(cutiMelahirkan);
            modal.find('#user-id').val(userId);
        });

        // Handle form submission
        $('#cutiForm').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message + ' for ' + response.userName,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                    $('#sisaCutiModal').modal('hide');
                    $('#pegawai-table').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan. Silakan coba lagi.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
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