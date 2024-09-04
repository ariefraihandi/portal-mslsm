@extends('IndexPortal.app')

@push('head-script')
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.css" />
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/select2/select2.css" />
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/tagify/tagify.css" />
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/bootstrap-select/bootstrap-select.css" />
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.css" />
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.css" /> 
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/css/pages/ptsp.css" />  
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
                    <span class="align-middle">Pemohon Informasi</span>
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
                                <span class="align-middle">Pemohon Informasi</span>
                            </h4>
                            <span>Daftar Pemohon Informasi</span>
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
                                                    <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#informasi">Tambah Permohonan</button>
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


    <div class="modal fade" id="informasi" tabindex="-1" aria-hidden="true">
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
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea name="alamat" id="alamat" class="form-control" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                <select id="pekerjaan" name="pekerjaan" class="form-select" data-placeholder="Pilih pekerjaan">
                                    <option value="">Pilih pekerjaan</option>
                                    <option value="70">Akuntan</option>
                                    <option value="50">Anggota BPK</option>
                                    <option value="49">Anggota DPD</option>
                                    <option value="48">Anggota DPR RI</option>
                                    <option value="63">Anggota DPRD Kab/Kota</option>
                                    <option value="62">Anggota DPRD Propinsi</option>
                                    <option value="54">Anggota Kabinet /Kementerian</option>
                                    <option value="53">Anggota Mahkamah Konstitusi</option>
                                    <option value="75">Apoteker</option>
                                    <option value="69">Arsitek</option>
                                    <option value="1">Belum/tidak bekerja</option>
                                    <option value="87">Biarawati</option>
                                    <option value="73">Bidan</option>
                                    <option value="58">Bupati</option>
                                    <option value="19">Buruh harian lepas</option>
                                    <option value="21">Buruh nelayan / perikanan</option>
                                    <option value="22">Buruh peternakan</option>
                                    <option value="20">Buruh tani / perkebunan</option>
                                    <option value="72">Dokter</option>
                                    <option value="64">Dosen</option>
                                    <option value="55">Duta Besar</option>
                                    <option value="56">Gubernur</option>
                                    <option value="65">Guru</option>
                                    <option value="41">Imam masjid</option>
                                    <option value="12">Industri</option>
                                    <option value="46">Juru masak</option>
                                    <option value="17">Karyawan BUMD</option>
                                    <option value="16">Karyawan BUMN</option>
                                    <option value="18">Karyawan Honorer</option>
                                    <option value="15">Karyawan swasta</option>
                                    <option value="86">Kepala Desa</option>
                                    <option value="7">Kepolisian RI</option>
                                    <option value="13">Konstruksi</option>
                                    <option value="71">Konsultan</option>
                                    <option value="88">Lainnya</option>
                                    <option value="34">Mekanik</option>
                                    <option value="2">Mengurus rumah tangga</option>
                                    <option value="11">Nelayan/perikanan</option>
                                    <option value="68">Notaris</option>
                                    <option value="38">Paraji</option>
                                    <option value="83">Paranormal</option>
                                    <option value="43">Pastur</option>
                                    <option value="84">Pedagang</option>
                                    <option value="5">Pegawai Negeri Sipil</option>
                                    <option value="3">Pelajar/Mahasiswa</option>
                                    <option value="79">Pelaut</option>
                                    <option value="23">Pembantu rumah tangga</option>
                                    <option value="33">Penata busana</option>
                                    <option value="31">Penata rambut</option>
                                    <option value="32">Penata rias</option>
                                    <option value="42">Pendeta</option>
                                    <option value="80">Peneliti</option>
                                    <option value="67">Pengacara</option>
                                    <option value="4">Pensiun</option>
                                    <option value="40">Penterjemah</option>
                                    <option value="78">Penyiar radio</option>
                                    <option value="77">Penyiar televisi</option>
                                    <option value="39">Perancang busana</option>
                                    <option value="85">Perangkat Desa</option>
                                    <option value="74">Perawat</option>
                                    <option value="8">Perdagangan</option>
                                    <option value="9">Petani/pekebun</option>
                                    <option value="10">Peternak</option>
                                    <option value="82">Pialang</option>
                                    <option value="66">Pilot</option>
                                    <option value="51">Presiden</option>
                                    <option value="47">Promotor acara</option>
                                    <option value="76">Psikiater/psikolog</option>
                                    <option value="36">Seniman</option>
                                    <option value="81">Sopir</option>
                                    <option value="37">Tabib</option>
                                    <option value="6">Tentara Nasional Indonesia</option>
                                    <option value="14">Transportasi</option>
                                    <option value="30">Tukang jahit</option>
                                    <option value="26">Tukang batu</option>
                                    <option value="24">Tukang cukur</option>
                                    <option value="35">Tukang gigi</option>
                                    <option value="27">Tukang kayu</option>
                                    <option value="29">Tukang las/pandai besi</option>
                                    <option value="25">Tukang listrik</option>
                                    <option value="28">Tukang sol sepatu</option>
                                    <option value="45">Ustadz/muballigh</option>
                                    <option value="59">Wakil Bupati</option>
                                    <option value="57">Wakil Gubernur</option>
                                    <option value="52">Wakil Presiden</option>
                                    <option value="61">Wakil Walikota</option>
                                    <option value="60">Walikota</option>
                                    <option value="44">Wartawan</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="whatsapp" class="form-label">Nomor Telepon / whatsapp</label>
                                <input type="text" name="whatsapp" id="whatsapp" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" name="email" id="email" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="jenis_permohonan" class="form-label">Jenis Permohonan</label>
                            <div class="col-md-6 mb-md-0 mb-2">
                                <div class="form-check custom-option custom-option-basic">
                                    <label class="form-check-label custom-option-content" for="gugatan">
                                        <input
                                            name="jenis_permohonan"
                                            class="form-check-input"
                                            type="radio"
                                            value="Gugatan"
                                            id="gugatan"
                                            required
                                            onclick="toggleSelectOptions()" />
                                        <span class="custom-option-header">
                                            <span class="h6 mb-0">Gugatan</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check custom-option custom-option-basic">
                                    <label class="form-check-label custom-option-content" for="permohonan">
                                        <input
                                            name="jenis_permohonan"
                                            class="form-check-input"
                                            type="radio"
                                            value="Permohonan"
                                            id="permohonan"
                                            required
                                            onclick="toggleSelectOptions()" />
                                        <span class="custom-option-header">
                                            <span class="h6 mb-0">Permohonan</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3" id="jenis_perkara_gugatan" style="display: none;">
                            <div class="col-12">
                                <label for="jenis_perkara_gugatan_select" class="form-label">Jenis Perkara Gugatan</label>
                                <select id="jenis_perkara_gugatan_select" name="jenis_perkara_gugatan" class="form-select">
                                    <option value="">Pilih jenis perkara gugatan</option>
                                    <!-- Tambahkan opsi perkara gugatan lainnya -->
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3" id="jenis_perkara_permohonan" style="display: none;">
                            <div class="col-12">
                                <label for="jenis_perkara_permohonan_select" class="form-label">Jenis Perkara Permohonan</label>
                                <select id="jenis_perkara_permohonan_select" name="jenis_perkara_permohonan" class="form-select">
                                    <option value="">Pilih jenis perkara permohonan</option>
                                    <!-- Tambahkan opsi perkara permohonan lainnya -->
                                </select>
                            </div>
                        </div> 
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="rincian-informasi" class="form-label">Rincian Informasi Yang Dibutuhkan</label>
                                <textarea name="rincian-informasi" id="rincian-informasi" class="form-control" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="tujuan-penggunaan" class="form-label">Tujuan Penggunaan Informasi</label>
                                <textarea name="tujuan-penggunaan" id="tujuan-penggunaan" class="form-control" rows="3" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>    
@endsection

@push('footer-script')            
    <script src="{{ asset('assets') }}/vendor/libs/select2/select2.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/tagify/tagify.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/bloodhound/bloodhound.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.js"></script>
@endpush

@push('footer-Sec-script')
    <script>
        $(document).ready(function() {
            $('#informasi').on('shown.bs.modal', function () {
                // Initialize select2 for Pekerjaan
                $('#pekerjaan').select2({
                    placeholder: $('#pekerjaan').data('placeholder'),
                    allowClear: true,
                    dropdownParent: $('#informasi .modal-content'),
                    width: '100%'
                });

                // Initialize select2 for Jenis Perkara Gugatan
                $('#jenis_perkara_gugatan_select').select2({
                    placeholder: 'Pilih jenis perkara gugatan',
                    allowClear: true,
                    dropdownParent: $('#informasi .modal-content'),
                    width: '100%'
                });

                // Initialize select2 for Jenis Perkara Permohonan
                $('#jenis_perkara_permohonan_select').select2({
                    placeholder: 'Pilih jenis perkara permohonan',
                    allowClear: true,
                    dropdownParent: $('#informasi .modal-content'),
                    width: '100%'
                });

                // Initialize select2 for Jenis Perkara based on Permohonan
                $('#jenis_perkara_permohonan_select').select2({
                    placeholder: 'Pilih jenis perkara berdasarkan permohonan',
                    allowClear: true,
                    dropdownParent: $('#informasi .modal-content'),
                    width: '100%'
                });
            });
            
            function toggleSelectOptions() {
                var gugatan = document.getElementById("gugatan");
                var permohonan = document.getElementById("permohonan");
                var jenisPerkaraGugatan = document.getElementById("jenis_perkara_gugatan");
                var jenisPerkaraPermohonan = document.getElementById("jenis_perkara_permohonan");

                if (gugatan.checked) {
                    jenisPerkaraGugatan.style.display = "block";
                    jenisPerkaraPermohonan.style.display = "none";
                    $('#jenis_perkara_gugatan_select').select2().trigger('change');
                } else if (permohonan.checked) {
                    jenisPerkaraGugatan.style.display = "none";
                    jenisPerkaraPermohonan.style.display = "block";
                    $('#jenis_perkara_permohonan_select').select2().trigger('change');
                } else {
                    jenisPerkaraGugatan.style.display = "none";
                    jenisPerkaraPermohonan.style.display = "none";
                }
            }
        });

    </script> 
@endpush