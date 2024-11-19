@extends('IndexPortal.app')

@push('head-script')
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.css" />
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/@form-validation/umd/styles/index.min.css" />
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.css" /> 
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/css/pages/page-faq.css" />
  <style>
    .badge {
        cursor: pointer;
    }
</style>

@endpush

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="faq-header d-flex flex-column justify-content-center align-items-center">
            <h1  class="text-center" style="color: white;">SIRAMASAKAN</h1>
        
            <p class="text-center mb-0 px-3" style="color: white;">Sistem Integrasi Mahkamah Syar'iyah Dengan Data Kependudukan</p>
            
        </div>

        <div class="row mt-4">
        <!-- Navigation -->
        <div class="col-lg-3 col-md-4 col-12 mb-md-0 mb-3">
            <div class="d-flex justify-content-between flex-column mb-2 mb-md-0">
            <ul class="nav nav-align-left nav-pills flex-column">
                <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#pengajuan">
                    <i class="bx bx-receipt faq-nav-icon me-1"></i>
                    <span class="align-middle">Pengajuan</span>
                </button>
                </li>
            </ul>
            <div class="d-none d-md-block">
                <div class="mt-5">
                <img
                    src="{{ asset('assets') }}//img/illustrations/sitting-girl-with-laptop-light.png"
                    class="img-fluid w-px-200"
                    alt="FAQ Image"
                    data-app-light-img="illustrations/sitting-girl-with-laptop-light.png"
                    data-app-dark-img="illustrations/sitting-girl-with-laptop-dark.png" />
                </div>
            </div>
            </div>
        </div>
        <!-- /Navigation -->

        <!-- FAQ's -->
        <div class="col-lg-9 col-md-8 col-12">
            <div class="tab-content py-0">
                <div class="tab-pane fade show active" id="pengajuan" role="tabpanel">
                    <div class="d-flex mb-3 gap-3">
                        <div>
                            <span class="badge bg-label-primary rounded-2">
                                <i class="bx bx-credit-card bx-md"></i>
                            </span>
                        </div>
                        <div>
                            <h4 class="mb-0">
                                <span class="align-middle">Pengajuan</span>
                            </h4>
                            <span>Daftar Pengajuan Perubahan Data Kependudukan</span>
                        </div>
                    </div>
                    <div id="accordionPayment" class="accordion">
                        <div class="card accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" aria-expanded="true" data-bs-target="#accordionPayment-1" aria-controls="accordionPayment-1">
                                    Permohonan Yang Belum Diproses
                                </button>
                            </h2>
                            <div id="accordionPayment-1" class="accordion-collapse collapse show">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4 text-center col-md-12 col-6 mb-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="card-title d-flex align-items-center justify-content-center">
                                                        <div class="avatar flex-shrink-0">
                                                            <i class='bx bx-task' style="font-size: 40px; color: #0d6efd;"></i>
                                                        </div>
                                                    </div>
                                                    <span class="fw-semibold d-block mb-1">Pengajuan Bulan Ini</span>
                                                    <h3 class="card-title mb-2">{{ $pemohonUbahStatuses->count() }}</h3>
                                                </div>
                                            </div>
                                        </div>                                        
                                        <div class="col-lg-4 text-center col-md-12 col-6 mb-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="card-title d-flex align-items-center justify-content-center">
                                                        <div class="avatar flex-shrink-0">
                                                            <i class='bx bx-task' style="font-size: 40px; color: #0dfd5d;"></i>
                                                        </div>
                                                    </div>
                                                    <span class="fw-semibold d-block mb-1">Selesai Diproses</span>
                                                    <h3 class="card-title mb-2">{{$successCount}}</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 text-center col-md-12 col-6 mb-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="card-title d-flex align-items-center justify-content-center">
                                                        <div class="avatar flex-shrink-0">
                                                            <i class='bx bx-task' style="font-size: 40px; color: #fd0d0d;"></i>
                                                        </div>
                                                    </div>
                                                    <span class="fw-semibold d-block mb-1">Gagal/Sedang Diproses</span>
                                                    <h3 class="card-title mb-2">{{$failedCount}}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="card">
                                            <h5 class="card-header">Daftar Tabel Pengajuan Perubahan Status</h5>
                                            <div class="table-responsive text-nowrap">
                                                <table class="table" id="myTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Pemohon</th>
                                                            <th>Perubahan</th>
                                                            <th>Receipt</th>
                                                            <th>Document</th>                                                        
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($pemohonUbahStatuses as $status)
                                                        <tr>
                                                            <!-- Pemohon -->
                                                            <td>{{ $status->pemohon->nama ?? 'Tidak ditemukan' }}<br>{{ $status->pemohon->NIK ?? 'Tidak ditemukan' }}</td>
                                            
                                                            <!-- NIK -->
                                                            <td>
                                                                @if ($status->cheklist_ubah_status && $status->cheklist_ubah_alamat)
                                                                    Ubah Status dan Alamat
                                                                @elseif ($status->cheklist_ubah_status)
                                                                    Ubah Status
                                                                @elseif ($status->cheklist_ubah_alamat)
                                                                    Ubah Alamat
                                                                @else
                                                                    Tidak ada perubahan
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a href="{{ url('cetak/receipt/ubahstatus', ['data' => $status->id]) }}" class="btn btn-sm btn-primary" target="_blank">Download</a>
                                                            </td>                                                            
                                                            <td>
                                                                <a href="{{ url($status->url_document) }}" class="btn btn-sm btn-info" target="_blank">Download</a>
                                                            </td>                                                                                                                                                                                                                                                                                          
                                                            <td>
                                                                @if ($status->status == 1)
                                                                    <span class="badge bg-primary" data-bs-toggle="modal" data-bs-target="#modalStatus{{ $status->id }}">Sedang Diproses</span>
                                                                @elseif ($status->status == 2)
                                                                    <span class="badge bg-danger" data-bs-toggle="modal" data-bs-target="#modalStatus{{ $status->id }}">Gagal Proses</span><br>Catatan: {{ $status->catatan ?? '' }}
                                                                @elseif ($status->status == 3)
                                                                    <span class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#modalStatus{{ $status->id }}">Selesai Proses</span><br>Belum Ambil
                                                                @elseif ($status->status == 4)
                                                                    <span class="badge bg-success" data-bs-toggle="modal" data-bs-target="#modalStatus{{ $status->id }}">SUCCESS</span>
                                                                @elseif ($status->status == 5)
                                                                    <span class="badge bg-danger" data-bs-toggle="modal" data-bs-target="#{{ $status->id }}">Dibatalkan</span>
                                                                @else
                                                                    <span class="badge bg-secondary" data-bs-toggle="modal" data-bs-target="#modalStatus{{ $status->id }}">Status Tidak Diketahui</span>
                                                                @endif
                                                            </td>
                                                                                                                        
                                                        </tr>
                                                       <!-- Modal for changing status -->
                                                            <div class="modal fade" id="modalStatus{{ $status->id }}" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="statusModalLabel">Ubah Status</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <!-- Traditional form submission -->
                                                                            <form action="{{ route('update.status.capil') }}" method="POST" id="formStatus{{ $status->id }}">                
                                                                                @csrf
                                                                                <!-- Hidden field to pass the pemohon ID -->
                                                                                <input type="hidden" name="id" value="{{ $status->id }}">

                                                                                <div class="mb-3">
                                                                                    <label for="selectStatus{{ $status->id }}" class="form-label">Pilih Status:</label>
                                                                                    <select name="status" id="selectStatus{{ $status->id }}" class="form-select">
                                                                                        <option value="1" {{ $status->status == 1 ? 'selected' : '' }}>Sedang Diproses</option>
                                                                                        <option value="2" {{ $status->status == 2 ? 'selected' : '' }}>Gagal Proses</option>
                                                                                        <option value="3" {{ $status->status == 3 ? 'selected' : '' }}>Selesai Proses</option>                            
                                                                                    </select>
                                                                                </div>

                                                                                <!-- Notes field (only appears if "Gagal Proses" is selected) -->
                                                                                <div class="mb-3" id="catatanField{{ $status->id }}" style="display: none;">
                                                                                    <label for="catatan{{ $status->id }}" class="form-label">Catatan:</label>
                                                                                    <textarea name="catatan" id="catatan{{ $status->id }}" class="form-control" placeholder="Masukkan catatan"></textarea>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                                            <!-- Submit form via traditional form submission -->
                                                                            <button type="submit" form="formStatus{{ $status->id }}" class="btn btn-primary">Simpan</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
    function showDeleteConfirmation(url, message) {
        Swal.fire({
            title: 'Are you sure?',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
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
  <script>
    // Function to show/hide additional input fields based on the checkbox state
    function toggleAdditionalFields(checkboxId, fieldsId) {
        const checkbox = document.getElementById(checkboxId);
        const fields = document.getElementById(fieldsId);
        fields.style.display = checkbox.checked ? 'block' : 'none';
    }

    // Add event listeners to the checkboxes
    const checkboxes = document.querySelectorAll('.form-check-input');
    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            if (checkbox.id === 'gantiNama') {
                toggleAdditionalFields('gantiNama', 'gantiNamaFields');
            } else if (checkbox.id === 'gantiAgama') {
                toggleAdditionalFields('gantiAgama', 'gantiAgamaFields');
            } else if (checkbox.id === 'gantiKelamin') {
                toggleAdditionalFields('gantiKelamin', 'gantiKelaminFields');
            } else if (checkbox.id === 'gantiKewarganegaraan') {
                toggleAdditionalFields('gantiKewarganegaraan', 'gantiKewarganegaraanFields');
            } else if (checkbox.id === 'gantiStatus') {
                toggleAdditionalFields('gantiStatus', 'gantiStatusFields');
            }  else if (checkbox.id === 'gantiStatus') {
                toggleAdditionalFields('gantiStatus', 'gantiStatusFields');
            }  else if (checkbox.id === 'gantiPindahTempatTinggal') {
                toggleAdditionalFields('gantiPindahTempatTinggal', 'gantiPindahTempatTinggalFields');
            }
            // Add similar conditions for other checkboxes and their respective fields
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Function to handle when the modal is opened
        $('[id^=modalStatus]').on('show.bs.modal', function (event) {
            var modalId = $(this).attr('id');
            var selectElement = $('#' + modalId + ' select');
            var catatanField = $('#' + modalId + ' #catatanField' + modalId.replace('modalStatus', ''));

            // When select changes, show or hide the notes field
            selectElement.change(function() {
                if ($(this).val() == '2') {
                    catatanField.show();
                } else {
                    catatanField.hide();
                }
            });

            // Trigger the change event on modal open to reset visibility of catatan field
            selectElement.trigger('change');
        });
    });
</script>

@endpush