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
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Aplikasi /</span> Wasbid / {{$title}}</h4>    

    <!--/ Card Border Shadow -->
    <div class="row g-4">
      <!-- Vehicles overview -->
      <div class="col-xl-12 col-lg-12 col-md-12 order-0 order-md-1">
        <ul class="nav nav-pills flex-column flex-md-row mb-3">
            <li class="nav-item col-12">
                <button type="button" class="nav-link btn btn-primary" data-bs-toggle="modal" data-bs-target="#temuanModal">
                    <i class="bx bxs-bell-plus me-1"></i>Tambah Temuan
                </button>
            </li>                            
        </ul>           
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item col-6">
                    <a class="nav-link active" href="{{ route('aplikasi.wasbid.temuan') }}"><i class="bx bx-hard-hat me-1"></i>Temuan</a>
                </li>              
                <li class="nav-item col-6">
                    <a class="nav-link" href="/admin/menu/role"><i class="bx bx-lock-open-alt me-1"></i>Role</a>
                </li>
            </ul>             
            <div class="card">    
                <div class="card-datatable table-responsive">
                    @if($wasbidTriwulan->isEmpty())
                    <p>Tidak ada data temuan pada triwulan ini.</p>
                    @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Bidang</th>
                                <th>Subbidang</th>
                                <th>Tajuk</th>
                                <th>Kondisi</th>
                                <th>Pengawas</th>
                                <th>Eviden</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($wasbidTriwulan as $index => $wasbid)
                            <tr class="{{ in_array($wasbid->id, $wasbidIdsInTindak) ? 'table-success' : 'table-danger' }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $wasbid->tgl }}</td>
                                <td>{{ $wasbid->bidang }}</td>
                                <td>{{ $wasbid->subbidang }}</td>
                                <td>{{ $wasbid->tajuk }}</td>
                                <td>{{ $wasbid->kondisi }}</td>
                                <td>{{ $wasbid->pengawas }}</td>
                                <td>
                                    @if($wasbid->eviden)
                                        <a href="{{ asset('assets/img/pengawasan/'.$wasbid->eviden) }}" target="_blank">
                                            <img src="{{ asset('assets/img/pengawasan/'.$wasbid->eviden) }}" alt="Eviden" style="width: 100px; height: auto;">
                                        </a>
                                    @else
                                        <span>Tidak ada eviden</span>
                                    @endif
                                </td>
                                <td style="width: 15%;">
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#tindakLanjutModal{{ $wasbid->id }}">
                                                <i class='bx bx-log-in-circle'></i> Tindak Lanjut
                                            </a>
                                           
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editModal{{ $wasbid->id }}">
                                                <i class="bx bx-edit-alt me-1"></i> Edit Temuan
                                            </a>
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editEviden{{ $wasbid->id }}">
                                                <i class="bx bx-edit-alt me-1"></i> Edit Eviden
                                            </a>
                                            <a class="dropdown-item" href="" target="_blank">
                                                <i class="bx bx-download me-1"></i> Eviden Temuan
                                            </a>
                                            <a class="dropdown-item" href="" target="_blank">
                                                <i class="bx bx-download me-1"></i> Eviden Tindak Lanjut
                                            </a>
                                            <a class="dropdown-item" href="">
                                                <i class="bx bx-trash me-1"></i> Delete
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>            
        </div>
    </div>
</div>

<!-- Modal dengan Form -->
<div class="modal fade" id="temuanModal" tabindex="-1" aria-labelledby="temuanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="temuanModalLabel">Isi Data Wasbid</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form untuk mengisi data wasbid -->
                <form action="{{ route('wasbid.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="tgl" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tgl" name="tgl" required>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="bidang" class="form-label">Bidang Temuan</label>
                            <select  name="bidang" id="bidang" class="form-control">
                                <option selected>Bidang</option>
                                <option value="Manajemen Peradilan">Manajemen Peradilan</option>
                                <option value="Administrasi Perkara">Administrasi Perkara</option>
                                <option value="Administrasi Persidangan">Administrasi Persidangan</option>
                                <option value="Pelayanan Publik">Pelayanan Publik</option>
                                <option value="Administrasi Umum">Administrasi Umum</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="subbidang" class="form-label">Subbidang Temuan</label>
                            <input type="text" class="form-control" name="subbidang" id="subbidang" placeholder="Sub Bidang" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="tajuk" class="form-label">Tajuk Temuan</label>
                            <input type="text" class="form-control" name="tajuk" id="tajuk" placeholder="Tajuk Temuan" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="kondisi" class="form-label">Kondisi</label>
                            <textarea type="text" class="form-control" name="kondisi" id="kondisi" placeholder="Kondisi"required></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="kriteria" class="form-label">Kriteria</label>
                            <textarea type="text" class="form-control" name="kriteria" id="kriteria" placeholder="Kriteria Temuan"required></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="Sebab" class="form-label">Sebab</label>
                            <textarea type="text" class="form-control" name="sebab" id="sebab" placeholder="Sebab Dari Temuan"required></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="akibat" class="form-label">Akibat</label>
                            <textarea type="text" class="form-control" name="akibat" id="akibat" placeholder="Akibat Dari Temuan"required></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="akibat" class="form-label">Rekomendasi</label>
                            <textarea type="text" class="form-control" name="rekomendasi" id="rekomendasi" placeholder="Rekomendasi Untuk Temuan"required></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="penangung" class="form-label">Penangung Jawab</label>
                            <select name="penangung" id="penangung" class="form-control">
                                <option selected>Pilih</option>
                                <option value="1">Sekretaris</option>
                                <option value="2">Panitera</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="image" class="form-label">Eviden</label>
                            <input type="file" class="form-control" name="image" id="image" required>
                        </div>
                    </div>              
                    <input type="hidden" class="form-control" name="pengawas" id="pengawas" value="{{ $users->detail->name }}" required>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


 
@foreach ($wasbidTriwulan as $edittem)
    <div class="modal fade" id="editModal{{ $edittem->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $edittem->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel{{ $edittem->id }}">Edit Temuan {{ $edittem->tajuk }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('wasbid.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="tanggal_pengawasan" class="form-label">Tanggal Pengawasan</label>
                            <input type="date" class="form-control" id="tanggal_pengawasan" name="tanggal_pengawasan" required value="{{ $edittem->tgl }}">
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="bidang" class="form-label">Bidang Temuan</label>
                                <select name="bidang" id="bidang" class="form-control" required>
                                    <option value="" disabled>Pilih Bidang</option>
                                    <option value="Manajemen Peradilan" {{ $edittem->bidang == 'Manajemen Peradilan' ? 'selected' : '' }}>Manajemen Peradilan</option>
                                    <option value="Administrasi Perkara" {{ $edittem->bidang == 'Administrasi Perkara' ? 'selected' : '' }}>Administrasi Perkara</option>
                                    <option value="Administrasi Persidangan" {{ $edittem->bidang == 'Administrasi Persidangan' ? 'selected' : '' }}>Administrasi Persidangan</option>
                                    <option value="Pelayanan Publik" {{ $edittem->bidang == 'Pelayanan Publik' ? 'selected' : '' }}>Pelayanan Publik</option>
                                    <option value="Administrasi Umum" {{ $edittem->bidang == 'Administrasi Umum' ? 'selected' : '' }}>Administrasi Umum</option>
                                </select>
                            </div>
                        </div>                        

                        <div class="mb-3">
                            <label for="subbidang" class="form-label">Subbidang</label>
                            <input type="text" class="form-control" id="subbidang" name="subbidang" required value="{{ $edittem->subbidang }}">
                        </div>

                        <div class="mb-3">
                            <label for="tajuk" class="form-label">Tajuk</label>
                            <input type="text" class="form-control" id="tajuk" name="tajuk" required value="{{ $edittem->tajuk }}">
                        </div>

                        <div class="mb-3">
                            <label for="kondisi" class="form-label">Kondisi</label>
                            <textarea class="form-control" id="kondisi" name="kondisi" required placeholder="Masukkan kondisi">{{ $edittem->kondisi }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="kriteria" class="form-label">Kriteria</label>
                            <textarea class="form-control" id="kriteria" name="kriteria" required placeholder="Masukkan kriteria">{{ $edittem->kriteria }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="sebab" class="form-label">Sebab</label>
                            <textarea class="form-control" id="sebab" name="sebab" required placeholder="Masukkan sebab">{{ $edittem->sebab }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="akibat" class="form-label">Akibat</label>
                            <textarea class="form-control" id="akibat" name="akibat" required placeholder="Masukkan akibat">{{ $edittem->akibat }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="rekomendasi" class="form-label">Rekomendasi</label>
                            <textarea class="form-control" id="rekomendasi" name="rekomendasi" required placeholder="Masukkan rekomendasi">{{ $edittem->rekomendasi }}</textarea>
                        </div>

                      
                        <div class="row">
                            <div class="col mb-3">
                                <label for="pengawas" class="form-label">Pengawas</label>
                                <input type="text" class="form-control" name="pengawas" id="pengawas" value="{{ $edittem->pengawas }}" required>
                            </div>
                        </div>
                        <div class="col mb-3">
                            <label for="penanggung" class="form-label">Penanggung Jawab</label>
                            @if($edittem->penanggung == 1)
                                <select name="penanggung" id="penanggung" class="form-control" required>
                                    <option value="1" selected>Sekretaris</option>
                                    <option value="2">Panitera</option>
                                </select>
                            @else
                                <input type="text" class="form-control" name="penanggung" id="penanggung" value="{{ $edittem->penanggung }}" required>
                            @endif
                        </div>                              

                        <input type="hidden" id="id" name="id" value="{{ $edittem->id }}">
                      

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

@foreach ($wasbidTriwulan as $edittem)
    <div class="modal fade" id="editEviden{{ $edittem->id }}" tabindex="-1" aria-labelledby="editEvidenLabel{{ $edittem->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEvidenLabel{{ $edittem->id }}">Edit Eviden untuk Temuan: {{ $edittem->tajuk }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Bagian untuk menampilkan eviden -->
                    <div class="mb-3">
                        <label class="form-label">Eviden Awal</label>
                        <div class="d-flex flex-wrap">
                            @if($edittem->eviden)
                                @php
                                    // Memisahkan nama-nama file eviden yang dipisahkan dengan koma, jika ada lebih dari satu
                                    $evidenFiles = explode(',', $edittem->eviden);
                                @endphp
                                @foreach ($evidenFiles as $file)
                                    <div class="eviden-item m-2">
                                        <img src="{{ asset('assets/img/pengawasan/' . $file) }}" alt="Eviden {{ $file }}" class="img-fluid" style="max-width: 150px; max-height: 150px;">
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted">Tidak ada eviden yang diunggah.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Form untuk mengedit temuan -->
                    <form action="{{ route('wasbid.updateEviden') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="eviden_new" class="form-label">Pilih Eviden Baru (Opsional)</label>
                            <input type="file" class="form-control" id="eviden_new" name="eviden_new">
                        </div>
                        
                        <input type="hidden" id="id" name="id" value="{{ $edittem->id }}">

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach




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