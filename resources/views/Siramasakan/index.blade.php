@extends('IndexPortal.app')

@push('head-script')
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.css" />
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/@form-validation/umd/styles/index.min.css" />
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.css" /> 
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/css/pages/page-faq.css" />
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
                <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#delivery">
                    <i class="bx bx-shopping-bag faq-nav-icon me-1"></i>
                    <span class="align-middle">Delivery</span>
                </button>
                </li>
                <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#cancellation">
                    <i class="bx bx-rotate-left faq-nav-icon me-1"></i>
                    <span class="align-middle">Cancellation & Return</span>
                </button>
                </li>
                <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#orders">
                    <i class="bx bx-cube faq-nav-icon me-1"></i>
                    <span class="align-middle">My Orders</span>
                </button>
                </li>
                <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#product">
                    <i class="bx bx-cog faq-nav-icon me-1"></i>
                    <span class="align-middle">Product & Services</span>
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
                                                    <h3 class="card-title mb-2">4</h3>
                                                    <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#siramasakan">Tambah Permohonan</button>
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
                                                    <span class="fw-semibold d-block mb-1">Permohonan Selesai Diproses</span>
                                                    <h3 class="card-title mb-2">3</h3>
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
                                                    <span class="fw-semibold d-block mb-1">Permohonan Gagal/Belum Diproses</span>
                                                    <h3 class="card-title mb-2">5</h3>
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
                                                            <th>NIK</th>
                                                            <th>Alamat</th>
                                                            <th>Actions</th>
                                                            <th>Download</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Tabel body data -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        <!-- Accordion Item 2 -->
                        <div class="card accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordionPayment-2" aria-controls="accordionPayment-2">
                                    How do I pay for my order?
                                </button>
                            </h2>
                            <div id="accordionPayment-2" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    We accept Visa®, MasterCard®, American Express®, and PayPal®. Our servers encrypt all information submitted to them, so you can be confident that your credit card information will be kept safe and secure.
                                </div>
                            </div>
                        </div>
        
                        <!-- Tambahan Accordion Item lainnya -->
                    </div>
                </div>
        
                <!-- Tambahan Tab lainnya -->
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
            <h4 class="mb-2"><a class="h4" href="tel:+(810)25482568">+ (810) 2548 2568</a></h4>
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
        <!-- /Contact -->
    </div>


    <div class="modal fade" id="siramasakan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSubMenuTitle">Tambah Permohonan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
    
                <!-- Laravel Blade Form -->
                <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Nama Lengkap" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" name="nik" id="nik" class="form-control" placeholder="NIK" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="whatsapp" class="form-label">Nomor WhatsApp</label>
                            <input type="text" name="whatsapp" id="whatsapp" class="form-control" placeholder="08xx-xxxx-xxxx" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="alamat" class="form-label">Alamat KTP</label>
                            <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Alamat KTP" required>
                        </div>
                    </div>
    
                    <!-- Checkbox and Conditional Fields for Ganti Status -->
                    <div class="form-check">
                        <input type="checkbox" name="gantiStatus" id="gantiStatus" class="form-check-input" value="5">
                        <label for="gantiStatus" class="form-check-label">Ganti Status</label>
                    </div>
                    <div id="gantiStatusFields" class="col mb-3" style="display: none;">
                        <div class="row g-2">
                            <div class="col mb-0">
                                <label for="semula_lima" class="form-label">SEMULA</label>
                                <input type="text" id="semula_lima" name="semula_lima" class="form-control" placeholder="Status Awal"/>
                            </div>
                            <div class="col mb-0">
                                <label for="menjadi_lima" class="form-label">MENJADI</label>
                                <input type="text" id="menjadi_lima" name="menjadi_lima" class="form-control" placeholder="Menjadi"/>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-0">
                                <label for="dasa_lima" class="form-label">DASAR</label>
                                <input type="text" id="dasa_lima" name="dasar_lima" class="form-control" placeholder="Nomor Surat Keputusan"/>
                            </div>
                            <div class="col mb-0">
                                <label for="tgl_lima" class="form-label">TANGGAL</label>
                                <input type="date" id="tgl_lima" name="tgl_lima" class="form-control"/>
                            </div>
                        </div>
                    </div>
    
                    <!-- Checkbox and Conditional Fields for Ganti Pindah Tempat Tinggal -->
                    <div class="form-check">
                        <input type="checkbox" name="gantiPindahTempatTinggal" id="gantiPindahTempatTinggal" class="form-check-input" value="6">
                        <label for="gantiPindahTempatTinggal" class="form-check-label">Ganti Pindah Tempat Tinggal</label>
                    </div>
                    <div id="gantiPindahTempatTinggalFields" class="col mb-3" style="display: none;">
                        <label for="gantiPindahTempatTinggalFields" class="form-label">Semula</label>
                        <div class="row g-3">
                            <div class="col mb-0">
                                <label for="jalan" class="form-label">Jalan</label>
                                <input type="text" id="jalan" name="jalan" class="form-control" placeholder="Jalan Awal"/>
                            </div>
                            <div class="col mb-0">
                                <label for="desa" class="form-label">Desa</label>
                                <input type="text" id="desa" name="desa" class="form-control" placeholder="Desa Awal"/>
                            </div>
                            <div class="col mb-0">
                                <label for="rt" class="form-label">RT</label>
                                <input type="text" id="rt" name="rt" class="form-control" placeholder="RT Awal"/>
                            </div>
                            <div class="col mb-0">
                                <label for="rw" class="form-label">RW</label>
                                <input type="text" id="rw" name="rw" class="form-control" placeholder="RW Awal"/>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col mb-0">
                                <label for="kec" class="form-label">Kecamatan</label>
                                <input type="text" id="kec" name="kec" class="form-control" placeholder="Kecamatan Awal"/>
                            </div>
                            <div class="col mb-0">
                                <label for="kab" class="form-label">Kabupaten</label>
                                <input type="text" id="kab" name="kab" class="form-control" placeholder="Kabupaten Awal"/>
                            </div>
                            <div class="col mb-0">
                                <label for="prov" class="form-label">Provinsi</label>
                                <input type="text" id="prov" name="prov" class="form-control" placeholder="Provinsi Awal"/>
                            </div>
                        </div>
                        <label for="gantiPindahTempatTinggalFields" class="form-label">Menjadi</label>
                        <div class="row g-3">
                            <div class="col mb-0">
                                <label for="jalan_satu" class="form-label">Jalan</label>
                                <input type="text" id="jalan_satu" name="jalan_satu" class="form-control" placeholder="Jalan Baru"/>
                            </div>
                            <div class="col mb-0">
                                <label for="desa_satu" class="form-label">Desa</label>
                                <input type="text" id="desa_satu" name="desa_satu" class="form-control" placeholder="Desa Baru"/>
                            </div>
                            <div class="col mb-0">
                                <label for="rt_satu" class="form-label">RT</label>
                                <input type="text" id="rt_satu" name="rt_satu" class="form-control" placeholder="RT Baru"/>
                            </div>
                            <div class="col mb-0">
                                <label for="rw_satu" class="form-label">RW</label>
                                <input type="text" id="rw_satu" name="rw_satu" class="form-control" placeholder="RW Baru"/>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col mb-0">
                                <label for="kec_satu" class="form-label">Kecamatan</label>
                                <input type="text" id="kec_satu" name="kec_satu" class="form-control" placeholder="Kecamatan Baru"/>
                            </div>
                            <div class="col mb-0">
                                <label for="kab_satu" class="form-label">Kabupaten</label>
                                <input type="text" id="kab_satu" name="kab_satu" class="form-control" placeholder="Kabupaten Baru"/>
                            </div>
                            <div class="col mb-0">
                                <label for="prov_satu" class="form-label">Provinsi</label>
                                <input type="text" id="prov_satu" name="prov_satu" class="form-control" placeholder="Provinsi Baru"/>
                            </div>
                        </div>
                    </div>
    
                    <!-- File Input -->
                    <div class="row">
                        <label for="permohonan" class="form-label">Lampiran</label>
                        <div class="col mb-3">
                            <input type="file" id="permohonan" name="permohonan" accept=".pdf" required/>
                        </div>
                    </div>
                </div>
    
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Proses</button>
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
@endpush