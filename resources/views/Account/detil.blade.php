@extends('IndexPortal.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/@form-validation/umd/styles/index.min.css" />        
@endpush

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">User / Account /</span> Details</h4>
    <div class="row">
      <!-- User Sidebar -->
      <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
        <!-- User Card -->
        <div class="card mb-4">
          <div class="card-body">
            <div class="user-avatar-section">
              <div class="d-flex align-items-center flex-column">
                <img
                  class="img-fluid rounded my-4"
                  src="{{ asset('assets') }}/img/avatars/{{ $users->detail->image }}"
                  height="110"
                  width="110"
                  alt="User avatar" />
                <div class="user-info text-center">
                  <h4 class="mb-2">{{$users->detail->name}}</h4>
                  <span class="badge bg-label-secondary">{{$users->detail->instansi}}</span>
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-around flex-wrap my-4 py-3">
              <div class="d-flex align-items-start me-4 mt-3 gap-3">
                <span class="badge bg-label-primary p-2 rounded"><i class="bx bxs-time bx-sm"></i></span>
                <div>
                  <h5 class="mb-0">
                      @if ($users->detail->nip == 'default_nip')
                          Not set
                      @else
                          {{ $users->detail->nip }}
                      
                      @endif
                  </h5>
                  <span>Masa Kerja</span>
                </div>
              </div>
              <div class="d-flex align-items-start mt-3 gap-3">
                <span class="badge bg-label-primary p-2 rounded"><i class="bx bx-user-pin bx-sm"></i></span>
                <div>
                  <h5 class="mb-0">{{$users->detail->jabatan}}</h5>
                  <span>Status</span>
                </div>
              </div>
            </div>
            <h5 class="pb-2 border-bottom mb-4">Details</h5>
            <div class="info-container">
              <ul class="list-unstyled">
                <li class="mb-3">
                  <span class="fw-medium me-2">Username:</span>
                  <span>{{$users->username}}</span>
                </li>
                <li class="mb-3">
                  <span class="fw-medium me-2">Email:</span>
                  <span>{{$users->email}}</span>
                </li>
                <li class="mb-3">
                  <span class="fw-medium me-2">Status:</span>
                  <span class="badge bg-label-success">Active</span>
                </li>
                <li class="mb-3">
                  <span class="fw-medium me-2">Jabatan:</span>
                  <span>{{$users->detail->jabatan}}</span>
                </li>
                <li class="mb-3">
                  <span class="fw-medium me-2">Whatsapp:</span>
                  <span>{{$users->detail->jabatan}}</span>
                </li>                
              </ul>              
            </div>
          </div>
        </div>
        <!-- /User Card -->
        <!-- Plan Card -->
        <div class="card mb-4">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
              <span class="badge bg-label-primary">Sisa Cuti</span>
              <div class="d-flex justify-content-center">                
                <h1 class="display-5 mb-0 text-primary">99</h1>
                <sub class="fs-6 pricing-duration mt-auto mb-3">&nbsp;Hari</sub>
              </div>
            </div>     
                  
            <div class="d-flex justify-content-between align-items-center mb-1 mt-2">
              <span>Cuti 2024</span>
              <span>65% Completed</span>
            </div>
            <div class="progress mb-3" style="height: 8px">
              <div
                class="progress-bar"
                role="progressbar"
                style="width: 95%"
                aria-valuenow="65"
                aria-valuemin="0"
                aria-valuemax="100"></div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
              <span>Cuti 2023</span>
              <span>65% Completed</span>
            </div>
            <div class="progress mb-3" style="height: 8px">
              <div
                class="progress-bar"
                role="progressbar"
                style="width: 65%"
                aria-valuenow="65"
                aria-valuemin="0"
                aria-valuemax="100"></div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
              <span>Cuti 2022</span>
              <span>65% Completed</span>
            </div>
            <div class="progress mb-3" style="height: 8px">
              <div
                class="progress-bar"
                role="progressbar"
                style="width: 55%"
                aria-valuenow="65"
                aria-valuemin="0"
                aria-valuemax="100"></div>
            </div>
            <div class="d-grid w-100 mt-4 pt-2">
              <button class="btn btn-primary" data-bs-target="#upgradePlanModal" data-bs-toggle="modal">
                Ajukan Cuti
              </button>
            </div>
          </div>
        </div>
        <!-- /Plan Card -->
      </div>
      <!--/ User Sidebar -->

      <!-- User Content -->
      <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
        <!-- User Pills -->
        <ul class="nav nav-pills flex-column flex-md-row mb-3">
          <li class="nav-item">
            <a class="nav-link active" href="{{ route('user.account.detil') }}"><i class="bx bx-user me-1"></i>Details</a>          
          </li>
          <li class="nav-item">
            <a class="nav-link" href="app-user-view-security.html"
              ><i class="bx bxs-timer me-1"></i>Aktifitas</a
            >
          </li>
          <li class="nav-item">
            <a class="nav-link" href="app-user-view-security.html"
              ><i class="bx bx-lock-alt me-1"></i>Security</a
            >
          </li>
          <li class="nav-item">
            <a class="nav-link" href="app-user-view-billing.html"
              ><i class="bx bxs-devices me-1"></i>Device</a
            >
          </li>          
        </ul>
        <!--/ User Pills -->

          <div class="card mb-4">      
            <form id="uploadForm" action="{{ route('upload.avatar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="{{ asset('assets') }}/img/avatars/{{ $users->detail->image }}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                        <div class="button-wrapper">
                            <label for="upload" class="btn btn-secondary me-2 mb-4" tabindex="0">
                                <span class="d-none d-sm-block">Ganti photo</span>
                                <i class="bx bx-upload d-block d-sm-none"></i>
                                <input type="file" id="upload" name="avatar" hidden class="account-file-input" accept="image/png, image/jpeg" />
                            </label>
                            <p class="text-muted mb-0">Allowed Square JPG, GIF or PNG. Max size of 2MB</p>
                            <small class="error-message text-danger">
                              @if($users->image == 'default.webp')
                                  <span class="badge badge-dot bg-danger me-1"></span> Anda belum mengganti foto profile
                              @endif
                          </small>
                        </div>
                    </div>
                </div>
            </form>
          </div>
          <div class="card mb-4">
            <h5 class="card-header">Profil Details</h5>
            <div class="card-body">
                <form id="formChangePassword" method="POST" action="{{ route('account.update') }}" enctype="multipart/form-data">                        
                    @csrf                        
                  <div class="row g-3">                      
                    <div class="col-sm-6">
                        <label class="form-label" for="multiStepsName">Nama Lengkap</label>
                        <input type="text" required name="multiStepsName" id="multiStepsName" class="form-control" value="{{$users->detail->name}}" />
                        <small class="error-message text-danger"></small>
                    </div>
                    <!-- Username -->
                    <div class="col-sm-6">
                        <label class="form-label" for="multiStepsUsername">Username</label>
                        <input type="text" required name="multiStepsUsername" id="multiStepsUsername" class="form-control" value="{{$users->username}}" readonly/>
                        <small class="error-message text-danger"></small>
                    </div>
                    <!-- Email -->
                    <div class="col-sm-6">                        
                        <label class="form-label me-3" for="multiStepsEmail">Email</label>
                        <input type="email" readonly name="multiStepsEmail" id="multiStepsEmail" class="form-control" value="{{ $users->email }}" readonly aria-label="john.doe" />
                        <small class="error-message text-danger">
                            @if($users->email_verified_at === null)
                                <span class="badge badge-dot bg-danger me-1"></span> Not Verified
                            @endif
                        </small>
                    </div>
                    <!-- Whatsapp -->
                    <div class="col-sm-6">
                      <label class="form-label" for="multiStepsWhatsapp">Whatsapp</label>
                      <input type="text" readonly name="whatsapp" id="whatsapp" class="form-control" 
                      value="{{ $users->whatsapp == 'default_value' ? '08xxxxxxxxxx' : $users->whatsapp }}" />
                      <small class="error-message text-danger">
                          @if($users->whatsapp_verified_at === null)
                              <span class="badge badge-dot bg-danger me-1"></span> Not Verified
                          @endif
                      </small>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="gender">Jenis Kelamin</label>
                        <select class="form-select" required id="gender" name="gender">
                            <option value="" selected disabled>Pilih Jenis Kelamin</option>
                            <option value="L" {{ $users->detail->kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ $users->detail->kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        <small class="error-message text-danger">
                            @if($users->gender == 'default_value')
                                <span class="badge badge-dot bg-danger me-1"></span> Not Set
                            @endif
                        </small>
                    </div>                   
                    <div class="col-sm-6">
                      <label class="form-label" for="nip">NIP</label>
                      <input type="text" readonly name="nip" id="nip" class="form-control" value="{{$users->detail->nip}}" readonly/>
                      <small class="error-message text-danger"></small>
                    </div>
                    <div class="col-sm-6">
                        <label for="dob" class="form-label">Tanggal Lahir</label>
                        @php
                              use Carbon\Carbon;
                            $userDob = optional($users->detail)->tglahir ? Carbon::parse($users->detail->tglahir)->format('Y-m-d') : '';
                        @endphp
                        <input type="date" class="form-control" required placeholder="YYYY-MM-DD" id="flatpickr-date" name="dob" value="{{ $userDob }}" />
                        <small class="error-message text-danger">
                            @if(!optional($users->detail)->tglahir)
                                <span class="badge badge-dot bg-danger me-1"></span> Not Set
                            @endif
                        </small>
                    </div>
                    <div class="col-sm-6">
                      <label class="form-label" for="tlahir">Tempat Lahir</label>
                      <input type="text" required name="tlahir" id="tlahir" class="form-control" value="{{$users->detail->tlahir}}"/>
                      <small class="error-message text-danger"></small>
                    </div>
                    <div class="col-sm-6">
                      <label class="form-label" for="alamat">Alamat</label>
                      <input type="text" required name="alamat" id="alamat" class="form-control" value="{{$users->detail->alamat}}"/>
                      <small class="error-message text-danger"></small>
                    </div>
                    <div class="col-sm-6">
                      <label class="form-label" for="instansi">Intansi</label>
                      <input type="text" name="instansi" id="instansi" class="form-control" value="{{$users->detail->instansi}}" readonly/>
                      <small class="error-message text-danger"></small>
                    </div>
                    <div class="col-sm-6">
                      <label class="form-label" for="jabatan">Jabatan</label>
                      <input type="text" name="jabatan" id="jabatan" class="form-control" value="{{$users->detail->jabatan}}" readonly/>
                      <small class="error-message text-danger"></small>
                    </div>
                    <div class="col-sm-6">
                      <label class="form-label" for="posisi">Status</label>
                      <input type="text" name="posisi" id="posisi" class="form-control" value="{{$users->detail->posisi}}" readonly/>
                      <small class="error-message text-danger"></small>
                    </div>
                                             
                </div>                       
                <div class="row g-3 mt-1">
                    <div class="d-grid gap-2 col-lg-12 mx-auto">    
                        <button type="submit" class="btn btn-success">Update Data</button>
                    </div>
                </div>
              </form>
            </div>
          </div>
        <!-- /Project table -->
      </div>
      <!--/ User Content -->
    </div>
    {{-- Modal --}}
  </div>
@endsection

@push('footer-script') 
    <script src="{{ asset('assets') }}/vendor/libs/moment/moment.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/cleavejs/cleave.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/cleavejs/cleave-phone.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/select2/select2.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/@form-validation/umd/bundle/popular.min.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js"></script>
@endpush

@push('footer-Sec-script')
    {{-- <script src="{{ asset('assets') }}/js/modal-edit-user.js"></script> --}}
 
    <script src="{{ asset('assets') }}/js/app-ecommerce-customer-detail.js"></script>
    <script src="{{ asset('assets') }}/js/app-ecommerce-customer-detail-overview.js"></script>
    <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
    <script>
      window.OneSignalDeferred = window.OneSignalDeferred || [];
      OneSignalDeferred.push(async function(OneSignal) {
        await OneSignal.init({
          appId: "1bcbea20-e5e8-4378-8873-136dc3a7b87c",
        });
    
        let deviceToken = OneSignal.User.PushSubscription.id;
    
        if (deviceToken !== undefined) {
          checkDeviceToken(deviceToken);
        } else {
          console.log("ID tidak ada");
        }
      });
    
      async function checkDeviceToken(deviceToken) {
        try {
          let response = await fetch('/check-divice', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
              'X-CSRF-TOKEN': '{{ csrf_token() }}' // Add CSRF token for security if needed
            },
            body: new URLSearchParams({ device_token: deviceToken })
          });
    
          let data = await response.text();
    
          if (!data.includes('success":true')) {
            await addDeviceToken(deviceToken);
          } 
        } catch (error) {
          console.error('Error checking device token:', error);
        }
      }
    
      async function addDeviceToken(deviceToken) {
        try {
          let response = await fetch('/store-device-token', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
              'X-CSRF-TOKEN': '{{ csrf_token() }}' // Add CSRF token for security if needed
            },
            body: new URLSearchParams({ device_token: deviceToken })
          });
    
          let data = await response.text();
    
          if (data.includes('success":true')) {
            Swal.fire({
              title: 'Success!',
              text: 'Perangkat Berhasil Ditambahkan',
              icon: 'success',
              confirmButtonText: 'OK'
            });
          } else {
            Swal.fire({
              title: 'Error!',
              text: 'Gagal Menambahkan Perangkat',
              icon: 'error',
              confirmButtonText: 'OK'
            });
          }
        } catch (error) {
          console.error('Error adding device token:', error);
          Swal.fire({
            title: 'Error!',
            text: 'Gagal Menambahkan Perangkat',
            icon: 'error',
            confirmButtonText: 'OK'
          });
        }
      }
    </script>
                                          
    <script>
      
      function checkNotificationPermission() {
          return Notification.permission;
      }

      // Fungsi untuk memantau perubahan izin notifikasi
      function monitorNotificationPermission() {
          let currentPermission = checkNotificationPermission();

          setInterval(() => {
              let newPermission = checkNotificationPermission();
              if (newPermission !== currentPermission) {
                  location.reload();  // Reload halaman jika izin berubah
              }
          }, 1000); // Memeriksa setiap 1 detik
      }

      // Memulai pemantauan izin notifikasi
      monitorNotificationPermission();
    </script>
    <script>
      document.getElementById('upload').addEventListener('change', function() {
          document.getElementById('uploadForm').submit();
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
    
@endpush