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
            <h1  class="text-center" style="color: white;">PORTAL LAYANAN KRITIS</h1>
        
            <p class="text-center mb-0 px-3" style="color: white;">Kritik & Saran Otomatis</p>
            
        </div>

        <div class="row mt-4">
        <!-- Navigation -->
        <div class="col-lg-3 col-md-4 col-12 mb-md-0 mb-3">
            <div class="d-flex justify-content-between flex-column mb-2 mb-md-0">
            <ul class="nav nav-align-left nav-pills flex-column">
                <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#pengajuan">
                    <i class="bx bx-group faq-nav-icon me-1"></i>
                    <span class="align-middle">Daftar Kritik & Saran</span>
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
                                <span class="align-middle">KRITIS</span>
                            </h4>
                            <span>Kritik & Saran Otomatis</span>
                        </div>
                    </div>
                    <div id="accordionPayment" class="accordion">
                        <div class="card accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" aria-expanded="true" data-bs-target="#accordionPayment-1" aria-controls="accordionPayment-1">
                                    Daftar Kritik & Saran
                                </button>
                            </h2>
                            <div id="accordionPayment-1" class="accordion-collapse collapse show">
                                <div class="card-body">                                    
                                    <div class="row">
                                        <div class="card">                                            
                                            <div class="table-responsive text-nowrap" style="max-width: 100%; overflow-x: auto;">
                                                <table class="table" id="kritis" style="width: 100%; table-layout: fixed;">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 25%;">Pemohon</th> <!-- Nama Pemohon -->                                                          
                                                            <th style="width: 25%;">WhatsApp</th> <!-- Nomor WhatsApp -->
                                                            <th style="width: 25%;">Email</th> <!-- Email Pemohon -->
                                                            <th style="width: 25%;">Kritik</th> <!-- Kritik -->
                                                            <th style="width: 25%;">saran</th> <!-- Kritik -->
                                                            <th style="width: 25%;">gambar</th> <!-- Kritik -->
                                                            <th style="width: 10%;">Actions</th> <!-- Actions -->                                                           
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
    $(document).ready(function() {
        $('#kritis').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('kritis.data') }}',
            columns: [
                { data: 'nama', name: 'nama' },
                { data: 'whatsapp', name: 'whatsapp' },
                { data: 'email', name: 'email' },
                { data: 'kritik', name: 'kritik' },
                { data: 'saran', name: 'saran' },
                { data: 'image', name: 'image', render: function(data, type, row) {         
                    var imagePath = '/assets/img/feedbacks/' + data; 
                    return '<img src="' + imagePath + '" alt="Gambar" width="50" height="50" />';
                }},

                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
    });
  

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
    function confirmDelete(id) {
        console.log('Delete confirmation triggered for id: ' + id);
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data ini akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {                
                window.location.href = '/delete/feedback/?id=' + id;
            }
            });
    }

</script>
@endpush