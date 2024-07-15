
@extends('IndexMisc.app')

@push('head-script')
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.css" />
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/css/pages/page-misc.css" />
@endpush

@section('content')
    <div class="container-xxl container-p-y">
      <div class="misc-wrapper">
        <h2 class="mb-2 mx-2">Portal Sedang Sakit!</h2>
        <p class="mb-4 mx-2">Mohon Doa Untuk Kesembuhan Portal. Dan Doa Untuk Kesehatan Developernya 😭</p>
        <p class="mb-4 mx-2">TTD Abdullah S.H., M.Kn</p>
        <a href="{{ route('index') }}" class="btn btn-primary">Back to home</a>
        <div class="mt-4">
          <img
            src="{{ asset('assets') }}/img/illustrations/girl-doing-yoga-light.png"
            alt="girl-doing-yoga-light"
            width="250"
            class="img-fluid"
            data-app-dark-img="illustrations/girl-doing-yoga-dark.png"
            data-app-light-img="illustrations/girl-doing-yoga-light.png" />
        </div>
      </div>
    </div>
@endsection

@push('footer-script')  
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
