
@extends('IndexLandingPage.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/nouislider/nouislider.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/select2/select2.css" />
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
              <h1 class="text-primary hero-title display-8 fw-bold">{{$title}}<br>MS Lhokseumawe</h1>               
              <!-- Tombol Tambah Syarat -->
          
            </div>
          </div>
        </div>        
      </section>
             
      <!-- Daftar Syarat dengan DataTables -->
        <section id="syarat-list" class="section-py">
            <div class="container">                
                <!-- Laravel Blade Form -->
                <form action="" id="formTambahPermohonan" method="POST" enctype="multipart/form-data">
                    @csrf                 
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
                            <label for="whatsapp" class="form-label">Nomor Telepon / WhatsApp</label>
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
                                        required />
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
                                        required />
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
                            <select id="gugatan_select" name="jenis_perkara_gugatan" class="form-select">
                                <option value="">Pilih jenis perkara gugatan</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3" id="jenis_perkara_permohonan" style="display: none;">
                        <div class="col-12">
                            <label for="jenis_perkara_permohonan_select" class="form-label">Jenis Perkara Permohonan</label>
                            <select id="permohonan_select" name="jenis_perkara_permohonan" class="form-select">
                                <option value="">Pilih jenis perkara permohonan</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="ubah_status" name="ubah_status">
                                <label class="form-check-label" for="ubah_status">
                                    Ubah Status (Hanya di Centang Jika Memilih Perkara Yang Ada Ubah Status)
                                </label>
                            </div>
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
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </section>
    </div>

@endsection


@push('footer-script') 
    <script src="{{ asset('assets') }}/vendor/libs/select2/select2.js"></script>    
    <script src="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.js"></script>       
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jenisPermohonanRadios = document.querySelectorAll('input[name="jenis_permohonan"]');
            const jenisPerkaraGugatan = document.getElementById('jenis_perkara_gugatan');
            const jenisPerkaraPermohonan = document.getElementById('jenis_perkara_permohonan');

            // Inisialisasi select2 pada elemen select
            $('#gugatan_select').select2();
            $('#permohonan_select').select2();
            $('#pekerjaan').select2(); // Inisialisasi select2 untuk elemen pekerjaan

            jenisPermohonanRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'Gugatan') {
                        jenisPerkaraGugatan.style.display = 'block';
                        jenisPerkaraPermohonan.style.display = 'none';
                        loadJenisPerkara('Gugatan', '#gugatan_select');
                    } else if (this.value === 'Permohonan') {
                        jenisPerkaraGugatan.style.display = 'none';
                        jenisPerkaraPermohonan.style.display = 'block';
                        loadJenisPerkara('Permohonan', '#permohonan_select');
                    }
                });
            });

            function loadJenisPerkara(tipe, selectId) {
                $.ajax({
                    url: '{{ route('jenis.perkara') }}',
                    type: 'GET',
                    data: { tipe: tipe },
                    success: function(data) {                       
                        const select = $(selectId);
                        select.empty(); // Kosongkan opsi sebelumnya
                        select.append('<option value="">Pilih Jenis Perkara</option>'); // Opsi default
                        $.each(data, function(index, item) {
                            select.append('<option value="' + item.id + '">' + item.perkara_name + '</option>');
                        });
                        select.select2(); // Perbarui select2 dengan data baru
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', status, error); // Log error untuk debug
                    }
                });
            }

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
                            $('#gugatan_select').val(null).trigger('change');
                            $('#permohonan_select').val(null).trigger('change');
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
        });
    </script>
    

@endpush