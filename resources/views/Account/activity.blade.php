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
                          @php
                              // Ambil NIP dari user
                              $nip = $users->detail->nip;
                              
                              // Pisahkan NIP menjadi bagian-bagian yang sesuai
                              $tglLahir = substr($nip, 0, 8); // 19920521
                              $tglMasuk = substr($nip, 8, 8); // 20220310
              
                              // Ubah tanggal menjadi format yang bisa diolah oleh Carbon
                              $tglMasukKerja = Carbon::createFromFormat('Ymd', $tglMasuk);
                              $today = Carbon::today();
              
                              // Hitung selisih masa kerja
                              $masaKerja = $tglMasukKerja->diff($today);
                              echo $masaKerja->y . " tahun, " . $masaKerja->m . " bulan, " . $masaKerja->d . " hari";
                          @endphp
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
            <a class="nav-link" href="{{ route('user.account.detil') }}"><i class="bx bx-user me-1"></i>Details</a>          
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="{{ route('user.account.activity') }}"
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
            <h5 class="card-header">User Activity Timeline</h5>
            <div class="card-body">
              <ul class="timeline">
                @foreach ($activities as $activity)
                    <li class="timeline-item timeline-item-transparent">
                        <span class="timeline-point-wrapper">
                            <span class="timeline-point timeline-point-success"></span>
                        </span>
                        <div class="timeline-event">
                            <div class="timeline-header mb-1">
                                <h6 class="mb-0">{{ $activity->activity }}</h6>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}
                                </small>
                            </div>
                            <p class="mb-0">
                                Description: {{ $activity->description }}<br>
                                Device: <i class="{{ $activity->deviceIcon ?? 'bx bx-question-mark' }}"></i> | <i class="{{ $activity->browserIcon ?? 'bx bx-question-mark' }}"></i>
                            </p>
                        </div>
                    </li>
                @endforeach
                @foreach ($sessions as $session)
                    <li class="timeline-item timeline-item-transparent">
                        <span class="timeline-point-wrapper">
                            <span class="timeline-point timeline-point-primary"></span>
                        </span>
                        <div class="timeline-event">
                            <div class="timeline-header mb-1">
                                <h6 class="mb-0">Login Activity</h6>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::createFromTimestamp($session->last_activity)->diffForHumans() }}
                                </small>
                            </div>
                            <p class="mb-0">
                                Device: <i class="{{ $session->deviceIcon ?? 'bx bx-question-mark' }}"></i> | <i class="{{ $session->browserIcon ?? 'bx bx-question-mark' }}"></i>
                            </p>
                        </div>
                    </li>
                @endforeach
                <li class="timeline-end-indicator">
                  <i class="bx bx-check-circle"></i>
                </li>
              </ul>
            </div>
          </div>
          
            </div>
        </div>
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