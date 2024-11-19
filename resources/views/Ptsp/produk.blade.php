@extends('IndexPortal.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/tagify/tagify.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/bootstrap-select/bootstrap-select.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.css" /> 
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/css/pages/ptsp.css" />  
    <style>
        table {
            table-layout: fixed;
            width: 100%;
        }
    
        th, td {
            word-wrap: break-word; /* Force long text to wrap inside the cell */
        }
    
        td {
            white-space: normal; /* Allow text to wrap */       
        }
    </style>
@endpush

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="faq-header d-flex flex-column justify-content-center align-items-center">
            <h1  class="text-center" style="color: white;">PTSP Elektronik</h1>
        
            <p class="text-center mb-0 px-3" style="color: white;">Pelayanan Terpadu Satu Pintu Elektronik</p>
            
        </div>

        <div class="row mt-4">
        <!-- Navigation -->
        <div class="col-lg-3 col-md-4 col-12 mb-md-0 mb-3">
            <div class="d-flex justify-content-between flex-column mb-2 mb-md-0">
            <ul class="nav nav-align-left nav-pills flex-column">
                <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#pengajuan">
                    <i class="bx bx-group faq-nav-icon me-1"></i>
                    <span class="align-middle">Pemohon Ubah Status</span>
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
                                <span class="align-middle">Pemohon Ubah Status</span>
                            </h4>
                            <span>Daftar Pemohon Ubah Status</span>
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
                                        <div class="card">                                            
                                            <div class="table-responsive text-nowrap" style="max-width: 100%; overflow-x: auto;">
                                                <table class="table" id="pemohonInformasi" style="width: 100%; table-layout: fixed;">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 25%;">Pemohon</th> <!-- Adjust width as needed -->                                                          
                                                            <th style="width: 25%;">Perkara</th> <!-- Adjust width as needed -->
                                                            <th style="width: 25%;">Status</th> <!-- Adjust width as needed -->                                                           
                                                            <th style="width: 10%;">Actions</th> <!-- Adjust width as needed -->                                                           
                                                        </tr>
                                                    </thead>
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
        
        <!-- /FAQ's -->
        </div>

        <!-- Contact -->
        <div class="row mt-5">
        <div class="col-12 text-center mb-4">
            <div class="badge bg-label-primary">Question?</div>
            <h4 class="my-2">You still have a question?</h4>
            <p>If you can't find question in our FAQ, you can contact us. We'll answer you shortly!</p>
        </div>
        </div>
        <div class="row text-center justify-content-center gap-sm-0 gap-3">
        <div class="col-sm-6">
            <div class="py-3 rounded bg-faq-section text-center">
            <span class="badge bg-label-primary rounded-2 my-3">
                <i class="bx bx-phone bx-sm"></i>
            </span>
            <h4 class="mb-2"><a class="h4" href="tel:+(810)25482568">+ (62) 822 7662 4504</a></h4>
            <p>We are always happy to help</p>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="py-3 rounded bg-faq-section text-center">
            <span class="badge bg-label-primary rounded-2 my-3">
                <i class="bx bx-envelope bx-sm"></i>
            </span>
            <h4 class="mb-2"><a class="h4" href="mailto:help@help.com">help@help.com</a></h4>
            <p>Best way to get a quick answer</p>
            </div>
        </div>
        </div>  
    </div>

<!-- Modal for Upload Document or External URL -->
<div class="modal fade" id="uploadDocumentModal" tabindex="-1" aria-labelledby="uploadDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="uploadDocumentForm" action="{{ route('pemohon.upload.document') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadDocumentModalLabel">Upload Document or External URL</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="pemohon_id" id="pemohon_id">

                    <!-- Select option for document upload method -->
                    <div class="form-group mb-3">
                        <label for="uploadOption">Choose Upload Method</label>
                        <select class="form-control" id="uploadOption" name="upload_option" required onchange="toggleUploadOption()">
                            <option value="manual">Upload Document</option>
                            <option value="url">External URL</option>
                        </select>
                    </div>

                    <!-- Manual Document Upload Field -->
                    <div class="form-group mb-3" id="manualUploadDiv">
                        <label for="document">Upload Document</label>
                        <input type="file" class="form-control" name="document" id="document">
                    </div>

                    <!-- External URL Field (Hidden by default) -->
                    <div class="form-group mb-3" id="urlUploadDiv" style="display: none;">
                        <label for="externalUrl">External URL</label>
                        <input type="url" class="form-control" name="external_url" id="externalUrl" placeholder="https://drive.google.com/">
                    </div>

                    <!-- Checkbox for Ubah Status -->
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="ubahStatus" name="ubah_status" onchange="toggleStatusFields()">
                        <label class="form-check-label" for="ubahStatus">Ubah Status</label>
                    </div>

                    <!-- Input fields for Status Awal and Status Baru (hidden by default) -->
                    <div class="row mt-3" id="statusFields" style="display: none;">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="statusAwal">Status Awal (Status Di KTP)</label>
                                <input type="text" class="form-control" id="statusAwal" name="status_awal" placeholder="Masukkan Status Awal">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="statusBaru">Status Baru (Setelah Putusan)</label>
                                <input type="text" class="form-control" id="statusBaru" name="status_baru" placeholder="Masukkan Status Baru">
                            </div>
                        </div>
                    </div>

                    <!-- Checkbox for Ubah Alamat -->
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="ubahAlamat" name="ubah_alamat" onchange="toggleAlamatFields()">
                        <label class="form-check-label" for="ubahAlamat">Ubah Alamat</label>
                    </div>

                    <!-- Input fields for Alamat Awal dan Alamat Baru (hidden by default) -->
                    <div class="row mt-3" id="alamatFields" style="display: none;">
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="jalanAwal">Jalan Awal</label>
                                <input type="text" class="form-control" id="jalanAwal" name="jalan_awal" placeholder="Masukkan Jalan Awal">
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="jalanBaru">Jalan Baru</label>
                                <input type="text" class="form-control" id="jalanBaru" name="jalan_baru" placeholder="Masukkan Jalan Baru">
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="rtRwAwal">RT/RW Awal</label>
                                <input type="text" class="form-control" id="rtRwAwal" name="rt_rw_awal" placeholder="Masukkan RT/RW Awal">
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="rtRwBaru">RT/RW Baru</label>
                                <input type="text" class="form-control" id="rtRwBaru" name="rt_rw_baru" placeholder="Masukkan RT/RW Baru">
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="kelDesAwal">Kel/Des Awal</label>
                                <input type="text" class="form-control" id="kelDesAwal" name="kel_des_awal" placeholder="Masukkan Kel/Des Awal">
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="kelDesBaru">Kel/Des Baru</label>
                                <input type="text" class="form-control" id="kelDesBaru" name="kel_des_baru" placeholder="Masukkan Kel/Des Baru">
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="kecAwal">Kecamatan Awal</label>
                                <input type="text" class="form-control" id="kecAwal" name="kec_awal" placeholder="Masukkan Kecamatan Awal">
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="kecBaru">Kecamatan Baru</label>
                                <input type="text" class="form-control" id="kecBaru" name="kec_baru" placeholder="Masukkan Kecamatan Baru">
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="kabKotaAwal">Kab/Kota Awal</label>
                                <input type="text" class="form-control" id="kabKotaAwal" name="kab_kota_awal" placeholder="Masukkan Kab/Kota Awal">
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="kabKotaBaru">Kab/Kota Baru</label>
                                <input type="text" class="form-control" id="kabKotaBaru" name="kab_kota_baru" placeholder="Masukkan Kab/Kota Baru">
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="provinsiAwal">Provinsi Awal</label>
                                <input type="text" class="form-control" id="provinsiAwal" name="provinsi_awal" placeholder="Masukkan Provinsi Awal">
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="provinsiBaru">Provinsi Baru</label>
                                <input type="text" class="form-control" id="provinsiBaru" name="provinsi_baru" placeholder="Masukkan Provinsi Baru">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('footer-script')            
    <script src="{{ asset('assets') }}/vendor/libs/select2/select2.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/tagify/tagify.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/bloodhound/bloodhound.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.js"></script>
@endpush

@push('footer-Sec-script')
<script>
    function openUploadModal(pemohonId) {
        $('#pemohon_id').val(pemohonId); // Set the pemohon ID in the hidden field
        $('#uploadDocumentModal').modal('show'); // Show the modal
    }

    $(document).ready(function() {
        $('#pemohonInformasi').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('pemohon.ubahStatus.data') }}',
            columns: [
                { data: 'pemohon', name: 'pemohon' },                  
                { data: 'perkara', name: 'perkara' },
                { data: 'status', name: 'status' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false },                                   
            ]
        });
    });

    function cancelSubmission(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Pengajuan dengan ini akan dibatalkan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, batalkan!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika pengguna mengonfirmasi, tampilkan input textarea
                Swal.fire({
                    title: 'Alasan Pembatalan',
                    input: 'textarea',
                    inputPlaceholder: 'Masukkan alasan pembatalan di sini...',
                    inputAttributes: {
                        'aria-label': 'Masukkan alasan pembatalan'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Kirim',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    preConfirm: (reason) => {
                        if (!reason) {
                            Swal.showValidationMessage('Alasan pembatalan wajib diisi!');
                            return false;
                        }
                        return reason;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const reason = result.value; // Alasan pembatalan dari textarea
                        // Lakukan permintaan POST
                        fetch("{{ route('batal.siramasakan') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}" // Token CSRF
                            },
                            body: JSON.stringify({ id: id, reason: reason }) // Kirim ID dan alasan
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire(
                                    'Dibatalkan!',
                                    'Pengajuan berhasil dibatalkan.',
                                    'success'
                                ).then(() => {
                                    // Reload DataTable setelah sukses
                                    $('#pemohonInformasi').DataTable().ajax.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Gagal',
                                    'Pengajuan gagal dibatalkan.',
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            Swal.fire(
                                'Error',
                                'Terjadi kesalahan pada server.',
                                'error'
                            );
                        });
                    }
                });
            }
        });
    }



    function toggleUploadOption() {
        const uploadOption = document.getElementById('uploadOption').value;
        document.getElementById('manualUploadDiv').style.display = uploadOption === 'manual' ? 'block' : 'none';
        document.getElementById('urlUploadDiv').style.display = uploadOption === 'url' ? 'block' : 'none';
    }

    function toggleStatusFields() {
        const isChecked = document.getElementById('ubahStatus').checked;
        document.getElementById('statusFields').style.display = isChecked ? 'flex' : 'none';
    }

    function toggleAlamatFields() {
        const isChecked = document.getElementById('ubahAlamat').checked;
        document.getElementById('alamatFields').style.display = isChecked ? 'block' : 'none';
    }

    document.getElementById('ubahStatus').addEventListener('change', toggleStatusFields);
    document.getElementById('ubahAlamat').addEventListener('change', toggleAlamatFields);

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