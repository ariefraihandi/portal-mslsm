
@extends('IndexMisc.app')

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