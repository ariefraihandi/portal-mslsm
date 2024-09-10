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
                    <i class="bx bx-list-plus faq-nav-icon me-1"></i>
                    <span class="align-middle">Daftar Perkara</span>
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
                                        <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#informasi">Tambah Permohonan</button>
                                    </div>
                                    <div class="row">
                                        <div class="card">
                                            <h5 class="card-header">Daftar Tabel Pemohon Informasi</h5>
                                            <div class="table-responsive text-nowrap">
                                                <table class="table" id="pemohonInformasi">
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
                                                </table>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                     
                    </div>
                </div>
                <div class="tab-pane fade" id="delivery" role="tabpanel">
                    <div class="d-flex mb-3 gap-3">
                      <div>
                        <span class="badge bg-label-primary rounded-2">
                          <i class="bx bx-list-plus bx-md"></i>
                        </span>
                      </div>
                      <div>
                        <h4 class="mb-0">
                          <span class="align-middle">Daftar Perkara</span>
                        </h4>
                        <span>List Perkara MS Lhokseumawe</span>
                      </div>
                    </div>                   
                    <div id="accordionDelivery" class="accordion">
                        <div class="card accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" aria-expanded="true" data-bs-target="#accordionPayment-1" aria-controls="accordionPayment-1">
                                    Tabel Daftar Perkara
                                </button>
                            </h2>
                            <div id="accordionPayment-1" class="accordion-collapse collapse show">
                                <div class="card-body">                                  
                                    <div class="row">
                                        <div class="card">
                                            {{-- <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahPerkara">Tambah Perkara</button> --}}
                                            <div class="table-responsive text-nowrap">
                                                <table class="table" id="tabelPerkara">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Nama Perkara</th>
                                                            <th>Jenis</th>                                                            
                                                            <th>Syarat</th>                                                            
                                                            <th>Action</th>
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

{{-- tambah Pemohoan --}}
    <div class="modal fade" id="informasi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSubMenuTitle">Tambah Permohonan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Laravel Blade Form -->
                <form action="" id="formTambahPermohonan" method="POST" enctype="multipart/form-data">
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
                                <label for="NIK" class="form-label">NIK</label>
                                <input type="text" id="NIK" name="NIK" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="umur" class="form-label">Umur</label>
                                <input type="number" id="umur" name="umur" class="form-control" required>
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
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="whatsapp_connected" name="whatsapp_connected" checked>
                                    <label class="form-check-label" for="whatsapp_connected">
                                        Terkoneksi WhatsApp
                                    </label>
                                </div>
                            </div>
                        </div>  
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="ubah_status" name="ubah_status">
                                    <label class="form-check-label" for="ubah_status">
                                        Ubah Status
                                    </label>
                                </div>
                            </div>
                        </div>                                              
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" name="email" id="email" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="pendidikan" class="form-label">Pendidikan</label>
                                <select id="pendidikan" name="pendidikan" class="form-select" required>
                                    <option value="">Pilih pendidikan</option>
                                    <option value="1">Tidak Sekolah</option>
                                    <option value="2">Sekolah Dasar (Sederajat)</option>
                                    <option value="3">Sekolah Menengah Pertama (Sederajat)</option>
                                    <option value="4">Sekolah Menengah Atas / Sekolah Menengah Kejuruan (Sederajat)</option>
                                    <option value="5">Akademi/Diploma</option>
                                    <option value="6">Diploma IV/Strata I</option>
                                    <option value="7">Strata II</option>
                                    <option value="8">Strata III</option>
                                </select>
                            </div>
                        </div>
                        
                      
                        
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <select id="jenis_kelamin" name="jenis_kelamin" class="form-select" required>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
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
                                <label for="rincian-informasi" class="form-label">Rincian Informasi Yang Dibutuhkan (Optional)</label>
                                <textarea name="rincian_informasi" id="rincian-informasi" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="tujuan-penggunaan" class="form-label">Tujuan Penggunaan Informasi</label>
                                <textarea name="tujuan_penggunaan" id="tujuan-penggunaan" class="form-control" rows="3"></textarea>
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
{{-- tambah Pemohoan --}}

{{-- tambah Perkara --}}
    <div class="modal fade" id="tambahPerkara" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSubMenuTitle">Tambah Perkara</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Laravel Blade Form -->
                <form id="formTambahPerkara" method="POST">
                    <div class="modal-body">
                        <!-- Input untuk Nama Perkara -->
                        <div class="mb-3">
                            <label for="perkara_name" class="form-label">Nama Perkara</label>
                            <input type="text" name="perkara_name" class="form-control" id="perkara_name" required>
                        </div>

                        <!-- Select Jenis Permohonan -->
                        <div class="row mb-3">
                            <label for="jenis_permohonan" class="form-label">Jenis Perkara</label>
                            <div class="col-md-6 mb-md-0 mb-2">
                                <div class="form-check custom-option custom-option-basic">
                                    <label class="form-check-label custom-option-content" for="gugatan">
                                        <input name="perkara_jenis" class="form-check-input" type="radio" value="Gugatan" id="gugatan" required />
                                        <span class="custom-option-header">
                                            <span class="h6 mb-0">Gugatan</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check custom-option custom-option-basic">
                                    <label class="form-check-label custom-option-content" for="permohonan">
                                        <input name="perkara_jenis" class="form-check-input" type="radio" value="Permohonan" id="permohonan" required />
                                        <span class="custom-option-header">
                                            <span class="h6 mb-0">Permohonan</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="submitPerkara" class="btn btn-primary">Simpan Perkara</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
{{-- tambah Perkara --}}

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
            $('#pemohonInformasi').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('pemohon.informasi.data') }}',
                columns: [
                    { data: 'nama', name: 'nama' },
                    { data: 'NIK', name: 'NIK' },
                    { data: 'alamat', name: 'alamat' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false },
                    { data: 'download', name: 'download', orderable: false, searchable: false },
                    { data: 'ubah_status', name: 'ubah_status' },
                ]
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#formTambahPermohonan').on('submit', function(e) {
                e.preventDefault();
                
                // Disable the submit button and change the text
                var submitButton = $(this).find('button[type="submit"]');
                submitButton.attr('disabled', true).text('On Process...');

                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('permohonan.store') }}",
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Berhasil!', response.message, 'success');
                            // Clear the form
                            $('#formTambahPermohonan')[0].reset();
                            // Hide the modal
                            $('#informasi').modal('hide');
                            // Reset Select2 elements (if using Select2)
                            $('#pekerjaan').val(null).trigger('change');
                            $('#jenis_perkara_gugatan_select').val(null).trigger('change');
                            $('#jenis_perkara_permohonan_select').val(null).trigger('change');
                        } else {
                            Swal.fire('Gagal!', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Gagal!', 'Terjadi kesalahan, silakan coba lagi.', 'error');
                    },
                    complete: function() {
                        // Re-enable the submit button and reset text after the process is done
                        submitButton.attr('disabled', false).text('Submit');
                    }
                });
            });

            $('#informasi').on('shown.bs.modal', function () {
                // Initialize select2 for Pekerjaan
                $('#pekerjaan').select2({
                    placeholder: $('#pekerjaan').data('placeholder'),
                    allowClear: true,
                    dropdownParent: $('#informasi .modal-content'),
                    width: '100%'
                });
            });
            
            $('#jenis_perkara_gugatan_select').select2({
                placeholder: 'Pilih jenis perkara gugatan',
                allowClear: true,
                ajax: {
                    url: "{{ route('jenis.perkara') }}",
                    dataType: 'json',
                    data: function () {
                        return {
                            tipe: 'Gugatan'  // Filter untuk Gugatan
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.map(function(item) {
                                return { id: item.id, text: item.perkara_name };
                            })
                        };
                    }
                },
                dropdownParent: $('#informasi .modal-content'),
                width: '100%'
            });

            $('#jenis_perkara_permohonan_select').select2({
                placeholder: 'Pilih jenis perkara permohonan',
                allowClear: true,
                ajax: {
                    url: "{{ route('jenis.perkara') }}",
                    dataType: 'json',
                    data: function () {
                        return {
                            tipe: 'Permohonan'  // Filter untuk Permohonan
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.map(function(item) {
                                return { id: item.id, text: item.perkara_name };
                            })
                        };
                    }
                },
                dropdownParent: $('#informasi .modal-content'),
                width: '100%'
            });

            function toggleSelectOptions() {
                var gugatanChecked = $('#gugatan').is(':checked');
                var permohonanChecked = $('#permohonan').is(':checked');

                if (gugatanChecked) {
                    $('#jenis_perkara_gugatan').show();
                    $('#jenis_perkara_permohonan').hide();
                } else if (permohonanChecked) {
                    $('#jenis_perkara_gugatan').hide();
                    $('#jenis_perkara_permohonan').show();
                } else {
                    $('#jenis_perkara_gugatan').hide();
                    $('#jenis_perkara_permohonan').hide();
                }
            }

            toggleSelectOptions();
            $('input[name="jenis_permohonan"]').on('change', toggleSelectOptions);
        });
    </script> 

    <script>
        $(document).ready(function() {
            // Inisialisasi DataTables dan simpan di variabel `table`
            var table = $('#tabelPerkara').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('perkara.data') }}",
                columns: [
                    { data: null, name: 'No', orderable: false, searchable: false },
                    { data: 'perkara_name', name: 'perkara_name' },
                    { data: 'perkara_jenis', name: 'perkara_jenis' },
                    { data: 'syarat', name: 'syarat' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                dom: '<"d-flex justify-content-between align-items-center"lBf>rtip',
                buttons: [
                    {
                        text: 'Tambah Perkara',
                        className: 'btn btn-primary',
                        action: function (e, dt, node, config) {
                            $('#tambahPerkara').modal('show');
                        }
                    }
                ],
                language: {
                    lengthMenu: "Show _MENU_ entries",
                    search: "Search:",
                },
                rowCallback: function(row, data, index) {
                    var pageInfo = table.page.info();
                    $('td:eq(0)', row).html(pageInfo.start + index + 1);
                }
            });

            // Handle form submission for adding perkara
            $('#formTambahPerkara').on('submit', function(e) {
                e.preventDefault(); // Mencegah form submit normal

                // Disable tombol submit
                $('#submitPerkara').prop('disabled', true);

                // Ambil data dari form
                var perkaraName = $('#perkara_name').val();
                var perkaraJenis = $('input[name="perkara_jenis"]:checked').val();

                // Kirim data dengan AJAX
                $.ajax({
                    url: "{{ route('perkara.store') }}", // URL menuju route controller
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Tambahkan CSRF token
                    },
                    data: {
                        perkara_name: perkaraName,
                        perkara_jenis: perkaraJenis
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#tambahPerkara').modal('hide'); // Hide modal
                            Swal.fire(
                                'Berhasil!',
                                'Perkara baru telah ditambahkan.',
                                'success'
                            );
                            table.ajax.reload(null, false); // Reload DataTables tanpa reset pagination
                        } else {
                            Swal.fire(
                                'Gagal!',
                                'Gagal menambahkan perkara: ' + response.message,
                                'error'
                            );
                        }
                        $('#submitPerkara').prop('disabled', false); // Enable tombol kembali jika gagal
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan, silakan coba lagi.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        $('#submitPerkara').prop('disabled', false); // Enable tombol kembali jika error
                    }
                });
            });


            // Handle edit button click
            $('#tabelPerkara').on('click', '.edit-btn', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var jenis = $(this).data('jenis');

                // SweetAlert2 form for editing with select box
                Swal.fire({
                    title: 'Edit Perkara',
                    html:
                        '<div style="display: flex; flex-direction: column; align-items: center;">' +
                            '<input id="swal-input1" class="swal2-input" placeholder="Nama Perkara" style="margin-bottom: 10px;" value="' + name + '">' +
                            '<select id="swal-input2" class="swal2-input" style="margin-bottom: 10px;">' +
                                '<option value="Gugatan" ' + (jenis === 'Gugatan' ? 'selected' : '') + '>Gugatan</option>' +
                                '<option value="Permohonan" ' + (jenis === 'Permohonan' ? 'selected' : '') + '>Permohonan</option>' +
                            '</select>' +
                        '</div>',
                    focusConfirm: false,
                    showCancelButton: true,
                    confirmButtonText: 'Update',
                    preConfirm: () => {
                        const namaPerkara = document.getElementById('swal-input1').value;
                        const jenisPerkara = document.getElementById('swal-input2').value;

                        if (!namaPerkara || !jenisPerkara) {
                            Swal.showValidationMessage('Semua kolom harus diisi!');
                        }
                        return {
                            name: namaPerkara,
                            jenis: jenisPerkara
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Lakukan request AJAX untuk update data
                        $.ajax({
                            url: '/perkara/update/' + id,
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Tambahkan CSRF token
                            },
                            data: {
                                perkara_name: result.value.name,
                                perkara_jenis: result.value.jenis
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire(
                                        'Berhasil!',
                                        'Perkara berhasil diupdate.',
                                        'success'
                                    );
                                    table.ajax.reload(null, false); // Reload tabel setelah update
                                } else {
                                    Swal.fire(
                                        'Gagal!',
                                        'Terjadi kesalahan, silakan coba lagi.',
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan pada server.',
                                    'error'
                                );
                            }
                        });
                    }
                });

            });
            $('#tabelPerkara').on('click', '.delete-btn', function() {
                var deleteUrl = $(this).data('url');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data ini akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Kirim request AJAX untuk delete data
                        $.ajax({
                            url: deleteUrl,
                            method: 'GET',
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire(
                                        'Terhapus!',
                                        'Data telah berhasil dihapus.',
                                        'success'
                                    );
                                    table.ajax.reload(null, false); // Reload DataTables tanpa reset pagination
                                } else {
                                    Swal.fire(
                                        'Gagal!',
                                        'Gagal menghapus data: ' + response.message,
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan pada server.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush