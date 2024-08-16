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
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">User / Account /</span> Cuti</h4>
    {{-- {!! QrCode::size(256)->generate('https://google.com') !!} --}}
    <div class="row">   
      <div class="col-xl-12 col-lg-12 col-md-12 order-0 order-md-1">
        <ul class="nav nav-pills flex-column flex-md-row mb-3">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('user.account.detil') }}"><i class="bx bx-user me-1"></i>Details</a>          
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="{{ route('user.account.cuti') }}"><i class="bx bx-calendar-event me-1"></i>Cuti</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('user.account.activity') }}"><i class="bx bxs-timer me-1"></i>Aktifitas</a>
          </li>         
        </ul>

        <div class="row">
          <div class="col-sm-6 col-lg-3 mb-4">
            <div class="card card-border-shadow-primary h-100">
              <div class="card-body">
                <div class="d-flex align-items-center mb-2 pb-1">
                  <div class="avatar me-2">                      
                      <span class="avatar-initial rounded bg-label-primary">                    
                          <svg id="Layer_1" fill="currentColor" enable-background="new 0 0 480 480" width="25" height="25" viewBox="0 0 480 480" xmlns="http://www.w3.org/2000/svg"><g>
                              <path d="m180 51.285h34.198l2.735 20.681c3.559 26.914 42.574 26.913 46.133 0l5.283-39.949c5.601-42.348-62.367-42.856-56.699 0l.432 3.268h-32.082c-4.418 0-8 3.582-8 8s3.582 8 8 8zm72.488-21.366-5.283 39.948c-1.115 8.428-13.295 8.428-14.41 0l-5.283-39.949c-2.512-18.993 27.447-18.683 24.976.001z"/><path d="m448 35.285h-60.083l.432-3.268c5.601-42.348-62.367-42.856-56.699 0l.432 3.268h-35.961c-4.418 0-8 3.582-8 8s3.582 8 8 8h38.077l2.735 20.681c3.559 26.914 42.574 26.913 46.133 0l2.735-20.681h62.199c8.822 0 16 7.178 16 16v281.3h-49.35c-17.645 0-32 14.355-32 32v18.721c0 10.584 16 10.584 16 0v-18.721c0-8.822 7.178-16 16-16h38.036l-65.35 65.35h-355.336c-8.822 0-16-7.178-16-16v-346.65c0-8.822 7.178-16 16-16h62.198l2.735 20.681c3.559 26.914 42.574 26.913 46.133 0l5.283-39.949c5.601-42.348-62.367-42.856-56.699 0l.432 3.268h-60.082c-17.645 0-32 14.355-32 32v380.65c0 17.645 14.355 32 32 32h416c17.645 0 32-14.355 32-32v-380.65c0-17.645-14.355-32-32-32zm-95.205 34.583-5.283-39.949c-2.472-18.692 27.496-19.048 24.977 0l-5.283 39.948c-1.116 8.428-13.296 8.429-14.411.001zm-220.307-39.949-5.283 39.948c-1.115 8.428-13.295 8.428-14.41 0l-5.283-39.949c-2.464-18.625 27.495-19.042 24.976.001zm315.512 434.016h-416c-8.822 0-16-7.178-16-16v-6.305c4.711 2.732 10.174 4.305 16 4.305h358.65c2.122 0 4.156-.843 5.657-2.343l67.693-67.693v72.036c0 8.822-7.178 16-16 16z"/>
                              <path d="m434.807 317.58v-188.193c0-4.418-3.582-8-8-8h-373.614c-4.418 0-8 3.582-8 8v263.871c0 4.418 3.582 8 8 8h299.666c10.585 0 10.585-16 0-16h-291.666v-247.871h357.613v180.193c.001 10.584 16.001 10.584 16.001 0z"/>
                              <path d="m136.899 306.995v-38.73l26.188-42.76c5.527-9.025-8.119-17.383-13.645-8.356l-20.543 33.543-20.542-33.543c-5.527-9.027-19.172-.67-13.645 8.356l26.187 42.76v38.73c0 10.584 16 10.584 16 0z"/>
                              <path d="m225.374 229.327c10.585 0 10.585-16 0-16h-44.187c-4.418 0-8 3.582-8 8v85.668c0 4.418 3.582 8 8 8h44.187c10.585 0 10.585-16 0-16h-36.187v-26.834h14.093c10.585 0 10.585-16 0-16h-14.093v-26.834z"/>
                              <path d="m352.859 213.327h-18.382c-4.418 0-8 3.582-8 8v85.668c0 10.584 16 10.584 16 0v-26.06h6.388l23.205 30.868c6.22 8.273 19.213-1.07 12.789-9.614l-18.004-23.949c30.738-13.029 24.737-64.913-13.996-64.913zm0 51.608h-10.382v-35.608h10.382c23.243 0 23.837 35.608 0 35.608z"/>
                              <path d="m287.546 218.858c-2.385-7.354-12.834-7.354-15.219 0l-27.792 85.669c-3.266 10.067 11.955 15.006 15.219 4.938l3.813-11.755h32.738l3.813 11.755c3.265 10.068 18.485 5.131 15.219-4.938zm-18.788 62.851 11.178-34.458 11.178 34.458z"/></g>
                          </svg>
                      </span>  
                  </div>
                  <h2 class="ms-1 mb-0">3</h2>
                </div>
                <h5 class="mb-1">Cuti Tahunan</h5>           
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cutiTahunan" style="width: 100%; font-size: 12px; padding: 10px;">
                  Ajukan Cuti Tahunan
              </button>       
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3 mb-4">
            <div class="card card-border-shadow-warning h-100">
              <div class="card-body">
                <div class="d-flex align-items-center mb-2 pb-1">
                    <div class="avatar me-2">
                        <span class="avatar-initial rounded bg-label-warning">                                                           
                            <svg version="1.1" id="svg5880" fill="currentColor" xml:space="preserve" width="25" height="25" viewBox="0 0 682.66669 682.66669" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg"><defs id="defs5884">
                                  <clipPath clipPathUnits="userSpaceOnUse" id="clipPath5898"><path d="M 0,512 H 512 V 0 H 0 Z" id="path5896" /></clipPath></defs><g id="g5886" transform="matrix(1.3333333,0,0,-1.3333333,0,682.66667)"><g id="g5888" transform="translate(366.7607,180.4297)">
                                  <path d="M 0,0 V 254.239" style="fill:none;stroke:#ffab00;stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" id="path5890" /></g><g id="g5892"><g id="g5894" clip-path="url(#clipPath5898)"><g id="g5900" transform="translate(268.1104,420.54)"><path d="m 0,0 v 21.99 c 0,5.523 4.477,10.001 10,10.001 h 70.789" style="fill:none;stroke:#ffab00;stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" id="path5902" /></g><g id="g5904" transform="translate(268.1113,324.292)">
                                  <path d="m 0,0 c -19.997,0 -36.206,16.212 -36.206,36.208 v 57.011 c 0,1.673 1.356,3.028 3.028,3.028 h 66.359 c 1.672,0 3.028,-1.355 3.028,-3.028 V 36.208 C 36.209,16.212 19.996,0 0,0 Z" style="fill:none;stroke:#ffab00;stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" id="path5906" /></g><g id="g5908" transform="translate(231.9053,379.6201)">
                                  <path d="m 0,0 v -19.12 c 0,-19.996 16.209,-36.208 36.206,-36.208 19.996,0 36.209,16.212 36.209,36.208 V 0 Z" style="fill:none;stroke:#ffab00;stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" id="path5910" /></g><g id="g5912" transform="translate(268.1113,180.4297)">
                                  <path d="M 0,0 V 143.862" style="fill:none;stroke:#ffab00;stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" id="path5914" /></g><g id="g5916" transform="translate(466.6299,138.7197)">
                                  <path d="M 0,0 C 0,23.03 -18.67,41.71 -41.7,41.71 H -268.21" style="fill:none;stroke:#ffab00;stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" id="path5918" /></g><g id="g5920" transform="translate(176.8701,195.4004)">
                                  <path d="M 0,0 -13.15,28.189" style="fill:none;stroke:#ffab00;stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" id="path5922" /></g><g id="g5924" transform="translate(168.6084,129.6689)">
                                  <path d="M 0,0 43.93,20.484" style="fill:none;stroke:#ffab00;stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" id="path5926" /></g><g id="g5928" transform="translate(218.9814,136.3506)">
                                  <path d="M 0,0 -20.838,44.685 C -26.579,56.996 -41.493,62.672 -53.694,56.7 -65.526,50.909 -70.594,36.682 -65.002,24.692 l 31.087,-66.658 H 74.274 c 8.007,0 13.342,8.241 10.102,15.564 -5.978,13.509 -19.5,22.936 -35.225,22.936 H 5.44 C 3.107,-3.466 0.986,-2.114 0,0 Z" style="fill:none;stroke:#ffab00;stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" id="path5930" /></g><g id="g5932" transform="translate(466.6328,94.3848)">
                                  <path d="m 0,0 h -281.566 l -117.977,252.991 c -2.713,5.819 -9.629,8.335 -15.447,5.621 l -37.43,-17.458 c -5.817,-2.714 -8.334,-9.629 -5.621,-15.446 L -330.89,-46.956 c 1.659,-3.556 5.226,-5.827 9.149,-5.827 h 233.602" style="fill:none;stroke:#ffab00;stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" id="path5934" /></g><g id="g5936" transform="translate(413.8252,41.6016)">
                                  <path d="M 0,0 H 52.808" style="fill:none;stroke:#ffab00;stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" id="path5938" /></g><g id="g5940" transform="translate(494.4053,41.6016)">
                                  <path d="m 0,0 h -27.772 v 143.751 c 0,10.457 8.476,18.934 18.933,18.934 10.457,0 18.934,-8.477 18.934,-18.934 V 10.097 C 10.095,4.521 5.575,0 0,0 Z" style="fill:none;stroke:#ffab00;stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" id="path5942" /></g><g id="g5944" transform="translate(109.5752,103.542)">
                                  <path d="m 0,0 16.102,14.967 c 4.735,4.401 6.092,11.354 3.36,17.213 l -46.621,99.979 c -2.732,5.86 -8.931,9.288 -15.346,8.49 l -21.815,-2.713" style="fill:none;stroke:#ffab00;stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" id="path5946" /></g><g id="g5948" transform="translate(178.6396,302.96)">
                                  <path d="m 0,0 21.521,-46.16 c 3.429,-7.36 0.25,-16.1 -7.111,-19.53 l -61.29,-28.58" style="fill:none;stroke:#ffab00;stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" id="path5950" /></g><g id="g5952" transform="translate(116.0938,242.2881)">
                                  <path d="m 0,0 13.906,6.484 c 7.896,3.682 11.312,13.068 7.63,20.963 -2.819,6.046 -0.204,13.234 5.843,16.053 l 29.335,13.68 c 16.536,7.71 23.69,27.366 15.979,43.901 l -7.189,15.417 c -2.832,6.074 -10.052,8.702 -16.126,5.869 l -16.783,-7.826" style="fill:none;stroke:#ffab00;stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" id="path5954" /></g><g id="g5956" transform="translate(116.668,341.8975)">
                                  <path d="m 0,0 -29.459,-13.736 c -5.062,-2.361 -7.252,-8.377 -4.892,-13.44" style="fill:none;stroke:#ffab00;stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" id="path5958" /></g><g id="g5960" transform="translate(366.7646,470.3994)">
                                  <path d="m 0,0 c -9.867,0 -17.865,-8.001 -17.865,-17.868 0,-9.867 7.995,-17.862 17.861,-17.862 9.867,0 17.87,7.998 17.87,17.864 C 17.866,-7.999 9.867,0 0,0 Z" style="fill:none;stroke:#ffab00;stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" id="path5962" /></g></g></g></g>
                              </svg>
                        </span> 
                    </div>
                  <h2 class="ms-1 mb-0">12</h2>
                </div>
                <h5 class="mb-1">Cuti Sakit</h5>
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal" style="width: 100%; font-size: 12px; padding: 10px;">
                  Ajukan Cuti Sakit
                </button>       
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3 mb-4">
            <div class="card card-border-shadow-dark h-100">
              <div class="card-body">
                <div class="d-flex align-items-center mb-2 pb-1">
                  <div class="avatar me-2">
                    <span class="avatar-initial rounded bg-label-dark">                                                                            
                          <svg width="25" height="25" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g id="Page-1" fill="none" fill-rule="evenodd"> <g id="044---Important-Task" fill="rgb(0,0,0)" fill-rule="nonzero"><circle id="Oval" cx="17" cy="5" r="1"/>
                              <path id="Shape" d="m17 16h8c.5522847 0 1-.4477153 1-1s-.4477153-1-1-1h-8c-.5522847 0-1 .4477153-1 1s.4477153 1 1 1z"/>
                              <path id="Shape" d="m8 15c0 1.6568542 1.34314575 3 3 3 1.6568542 0 3-1.3431458 3-3s-1.3431458-3-3-3c-1.65685425 0-3 1.3431458-3 3zm3-1c.5522847 0 1 .4477153 1 1s-.4477153 1-1 1-1-.4477153-1-1 .4477153-1 1-1z"/>
                              <path id="Shape" d="m17 24h8c.5522847 0 1-.4477153 1-1s-.4477153-1-1-1h-8c-.5522847 0-1 .4477153-1 1s.4477153 1 1 1z"/>
                              <path id="Shape" d="m11 20c-1.65685425 0-3 1.3431458-3 3s1.34314575 3 3 3c1.6568542 0 3-1.3431458 3-3s-1.3431458-3-3-3zm0 4c-.5522847 0-1-.4477153-1-1s.4477153-1 1-1 1 .4477153 1 1-.4477153 1-1 1z"/>
                              <path id="Shape" d="m17 32h8c.5522847 0 1-.4477153 1-1s-.4477153-1-1-1h-8c-.5522847 0-1 .4477153-1 1s.4477153 1 1 1z"/>
                              <path id="Shape" d="m11 28c-1.65685425 0-3 1.3431458-3 3s1.34314575 3 3 3c1.6568542 0 3-1.3431458 3-3s-1.3431458-3-3-3zm0 4c-.5522847 0-1-.4477153-1-1s.4477153-1 1-1 1 .4477153 1 1-.4477153 1-1 1z"/>
                              <path id="Shape" d="m17 40h5c.5522847 0 1-.4477153 1-1s-.4477153-1-1-1h-5c-.5522847 0-1 .4477153-1 1s.4477153 1 1 1z"/>
                              <path id="Shape" d="m11 36c-1.65685425 0-3 1.3431458-3 3s1.34314575 3 3 3c1.6568542 0 3-1.3431458 3-3s-1.3431458-3-3-3zm0 4c-.5522847 0-1-.4477153-1-1s.4477153-1 1-1 1 .4477153 1 1-.4477153 1-1 1z"/>
                              <path id="Shape" d="m41.446 24.919c-.734081-1.19375-2.0356036-1.9204366-3.437-1.919h-.009c-1.405728-.0037556-2.7126576.7224006-3.452 1.918l-.548.882v-18.8c0-2.209139-1.790861-4-4-4h-5.278c-.3544126-.61675126-1.0106732-.997855-1.722-1l-2.542-.006c-.7135392-1.23492656-2.0319862-1.99507413-3.4582331-1.99383625-1.4262469.00123789-2.7433725.76367295-3.4547669 1.99983625h-2.545c-.7113268.002145-1.36758742.38324874-1.722 1h-5.278c-2.209139 0-4 1.790861-4 4v39c0 2.209139 1.790861 4 4 4h14.975l-2.36 3.8c-.775723 1.2518948-.8128693 2.8256531-.0970756 4.112753.7157936 1.2871 2.0723283 2.0857918 3.5450756 2.087247h35.879c1.4732073.0001398 2.8304778-.7991221 3.544907-2.0875051.7144291-1.2883831.6734967-2.862971-.106907-4.1124949zm-9.446-17.919v22.023l-2 3.221v-23.244c0-1.1045695-.8954305-2-2-2h-3v-2h5c1.1045695 0 2 .8954305 2 2zm-21-3h2.545c.7173548-.00212654 1.3786283-.38828278 1.733-1.012.3597951-.60908486 1.0145844-.98279009 1.722-.98279009s1.3622049.37370523 1.722.98279009c.3543717.62371722 1.0156452 1.00987346 1.733 1.012h2.545v4h-12zm12 6c.7113268-.002145 1.3675874-.38324874 1.722-1h3.278v26.465l-5.3 8.535h-16.7v-35h3.278c.35441258.61675126 1.0106732.997855 1.722 1zm-19 38c-1.1045695 0-2-.8954305-2-2v-39c0-1.1045695.8954305-2 2-2h5v2h-3c-1.1045695 0-2 .8954305-2 2v35c0 1.1045695.8954305 2 2 2h15.459l-1.242 2zm53.739 8.938c-.3571807.6584359-1.0479378 1.066663-1.797 1.062h-35.879c-.7463503-.0019212-1.4334039-.4070021-1.7963931-1.0591381-.3629891-.652136-.3452455-1.4495181.0463931-2.0848619l17.934-28.881c.3752608-.6074821 1.0389605-.9766248 1.753-.975.7115114-.0061577 1.3734163.3637639 1.741.973l17.942 28.887c.4007708.6292392.422299 1.428089.056 2.078z"/><path id="Shape" d="m38 31c-1.6568542 0-3 1.3431458-3 3v10c0 1.6568542 1.3431458 3 3 3s3-1.3431458 3-3v-10c0-1.6568542-1.3431458-3-3-3zm1 13c0 .5522847-.4477153 1-1 1s-1-.4477153-1-1v-10c0-.5522847.4477153-1 1-1s1 .4477153 1 1z"/>
                              <path id="Shape" d="m38 49c-1.6568542 0-3 1.3431458-3 3s1.3431458 3 3 3 3-1.3431458 3-3-1.3431458-3-3-3zm0 4c-.5522847 0-1-.4477153-1-1s.4477153-1 1-1 1 .4477153 1 1-.4477153 1-1 1z"/></g></g>
                          </svg>
                    </span> 
                  </div>
                  <h2 class="ms-1 mb-0">2</h2>
                </div>
                <h5 class="mb-1">Cuti Alasan Penting</h5>
                <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#myModal" style="width: 100%; font-size: 12px; padding: 10px;">
                  Ajukan Cuti Alasan Penting
                </button>       
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3 mb-4">
              <div class="card card-border-shadow-info h-100">
                <div class="card-body">
                  <div class="d-flex align-items-center mb-2 pb-1">
                    <div class="d-flex align-items-center justify-content-center">
                      <div class="avatar me-2">
                        <span class="avatar-initial rounded bg-label-info">
                          <svg id="Layer_1" width="25" height="25" enable-background="new 0 0 100 100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                            <g style="fill:none;stroke:#6ad0e7;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-width:3">
                              <g>
                                <path d="m50 88.981-45-10.679v-56.604l45-10.679z"/>
                                <path d="m5 30.719v6.596l45-7.476v-8.731z"/>
                                <path d="m14.581 43.102-9.581 1.366"/>
                                <path d="m50 38.06-11.686 1.666"/>
                                <path d="m31.717 40.663-10.837 1.545"/>
                              </g>
                              <path d="m50 88.981 45-10.679v-56.604l-45-10.679z"/>
                              <path d="m95 30.719v6.596l-45-7.476v-8.731z"/>
                              <path d="m95 44.468-9.581-1.366"/>
                              <path d="m61.686 39.726-11.686-1.666"/>
                              <path d="m79.12 42.208-10.837-1.545"/>
                              <path d="m58.264 49.831v37.189l14.236-3.379v-32.168z"/>
                            </g>
                          </svg>
                        </span>
                      </div>
                      <h2 class="ms-1 mb-0">12</h2>
                    </div>
                    <div class="separator mx-3">|</div>
                    <div class="d-flex align-items-center justify-content-center">
                      <div class="avatar me-2">
                        <span class="avatar-initial rounded bg-label-info">                           
                          <svg id="Layer_1" fill="currentColor" enable-background="new 0 0 512 512" width="25" height="25" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                              <path d="m415.08 415.66c-4.46-16.28-13.32-30.92-25.61-42.34-6.81-6.32-14.62-11.65-23.35-16 1.07-5.54.59-11.32-1.49-16.73-3.3-8.57-10.19-15.14-18.92-18.01-.26-.08-.52-.14-.77-.22-3.32-30.27-20.2-58.31-47.11-75.42-19.21-12.22-33.13-25.44-42.87-40.83l9.96 2.19c10.53 2.32 21.39-.74 29.05-8.17 13.96-13.54 21.42-29.76 22.81-49.58l6.11-2.37c4-1.55 7.02-4.79 8.29-8.89 1.27-4.09.62-8.48-1.78-12.02l-6.06-8.93c-4.52-6.66-6.44-14.72-5.42-22.71l2.42-18.81c2.35-18.27-2.92-36.67-14.47-50.92-.43-.73-.98-1.39-1.62-1.95-.04-.04-.07-.09-.11-.13-12.77-14.5-31.17-22.82-50.5-22.82h-47.14c-27.92 0-52.52 16.81-62.66 42.83-2.94 7.53-4.83 15.37-5.71 23.29-26.83 1.75-48.13 24.12-48.13 51.38 0 28.4 23.1 51.5 51.5 51.5 9.5 0 18.39-2.6 26.04-7.1l-.22 1.56c-3.45 24.68-5.48 49.81-6.04 74.73-3.35 5.85-5.28 12.61-5.28 19.82v78.17c0 32.32 9.33 63.38 26.68 89.95-.42 22.81-8.26 45.35-23.12 63.7l-5.78 7.14c-2.78 3.43-2.25 8.47 1.18 11.25 1.48 1.2 3.26 1.78 5.03 1.78 2.33 0 4.64-1.01 6.22-2.97l5.78-7.14c13.11-16.2 21.47-35.22 24.9-55.04 1.52 1.74 3.08 3.45 4.68 5.13l54.91 57.54c3.05 3.2 8.12 3.32 11.31.27 3.2-3.05 3.32-8.11.27-11.31l-54.91-57.54c-26.53-27.82-41.15-64.32-41.15-102.77v-78.17c0-13.23 10.77-24 24-24s24 10.77 24 24v102.54c0 21.47 7.43 42.49 20.91 59.19l70.48 87.3c1.58 1.96 3.89 2.98 6.23 2.98 1.76 0 3.54-.58 5.02-1.78 3.44-2.78 3.97-7.81 1.2-11.25l-70.48-87.3c-11.2-13.87-17.36-31.32-17.36-49.14v-102.54c0-2.05-.16-4.06-.45-6.03 15.05 5.74 30 8.59 45.16 8.59 3.2 0 6.41-.13 9.64-.38 21.48 14.11 35.17 36.53 38.44 60.85-6.28 1.57-12.07 5.1-16.3 10.31l-5.89 7.25c-6.41 7.9-8.46 18.42-5.49 28.15 2.98 9.73 10.56 17.3 20.29 20.26l1.5.46c2.98.91 6 1.34 8.97 1.34 10.72 0 20.84-5.67 26.4-15.43l1.35-2.37c20.34 10.33 34.23 26.76 40.02 47.91 7.54 27.53-.72 59.29-20.08 77.24-3.24 3-3.43 8.07-.43 11.31 1.58 1.7 3.72 2.56 5.87 2.56 1.95 0 3.9-.71 5.44-2.13 23.93-22.2 33.83-59.66 24.64-93.23zm-256.33-366.02c7.73-19.83 26.47-32.64 47.75-32.64h47.14c13.58 0 26.56 5.41 36.13 14.92-5.88 13.34-18.73 20.9-34.54 19.94-7.56-.45-14.47 4.49-16.44 11.76-3 11.09-9.01 21.64-18.35 32.25-10.28-7.25-19.31-5.12-25.08-2.04-9.63 5.14-15.23 15.78-14.27 27.1.49 5.79 1.79 10.26 3.96 13.61-1.62 2.01-3.86 3.64-6.87 5.05l-13.36-21.82c-12.48-20.39-14.75-45.86-6.07-68.13zm-52.75 68.86c0-18.3 13.92-33.41 31.73-35.3.92 15.04 5.44 29.84 13.44 42.92l12.35 20.18c-6.06 4.81-13.71 7.7-22.02 7.7-19.57 0-35.5-15.93-35.5-35.5zm71.85 104.87c.92-18.96 2.69-37.96 5.31-56.7l.45-3.21c.41-2.93.43-5.89.09-8.8 4.05-1.74 8.48-4.31 12.26-8.33 5.96 4.37 13.03 6.9 21.34 7.63.24.02.48.03.71.03 4.1 0 7.59-3.14 7.96-7.3.39-4.4-2.87-8.28-7.27-8.67-8.62-.76-14.62-4.17-19.37-11-.25-.38-.51-.74-.79-1.1-.04-.05-1.09-1.4-1.51-6.35-.42-4.94 1.88-9.5 5.86-11.63 2.38-1.27 4.71-1.58 8.39 1.04 6.63 4.72 15.72 3.64 21.14-2.5 11.03-12.51 18.17-25.17 21.87-38.66 19.24 1.15 35.91-6.98 45.7-21.44 4.13 8.76 5.75 18.59 4.49 28.38l-2.42 18.81c-1.53 11.86 1.33 23.84 8.04 33.73l4.65 6.86-4.4 1.71c-5.4 2.1-9.12 7.22-9.5 13.06-1.02 15.94-6.91 28.92-18.02 39.7-3.8 3.68-9.21 5.19-14.47 4.03l-38.63-8.5c-4.31-.95-8.58 1.78-9.53 6.09s1.78 8.58 6.09 9.53l7.92 1.74c7.7 16.29 18.62 30.39 33.58 43.16-14.58-1.82-29.12-6.7-43.96-14.75-.22-.12-.45-.23-.68-.33-7.16-6.56-16.69-10.6-27.15-10.6-6.53 0-12.7 1.58-18.15 4.37zm170.91 135.36-4.39 7.7c-3.38 5.93-10.29 8.68-16.82 6.7l-1.5-.46c-4.7-1.43-8.21-4.94-9.65-9.63s-.48-9.57 2.61-13.38l5.89-7.25c2.79-3.44 7-5.35 11.3-5.35 1.51 0 3.02.23 4.5.72 4.15 1.37 7.42 4.49 8.99 8.56 1.57 4.08 1.23 8.6-.93 12.39z"/>
                          </svg>
                        </span>
                      </div>
                      <h2 class="ms-1 mb-0">12</h2>
                    </div>
                  </div>
                  <h5 class="mb-1">Cuti Besar / Melahirkan</h5>
                  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" style="width: 100%; font-size: 12px; padding: 10px;">
                      Ajukan Cuti Besar / Melahirkan
                    </button>       
                </div>
              </div>
          </div>     
        </div>
          
        <div class="card mb-4">
            <h5 class="card-header">Daftar Cuti</h5>
            <div class="card-body">
              <div class="card-datatable table-responsive">
                <table id="daftarCuti-table" class="datatables-users table border-top">                
                    <thead>
                        <tr>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Atasan</th>
                                <th>Nomor Surat</th>
                                <th>Jenis</th>
                                <th>Tanggal Awal</th>
                                <th>Tanggal Akhir</th>                                
                                <th>Status</th>
                                <th>Action</th>
                            </tr>    
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

{{-- //Modal CUti Tahunan --}}
    <div class="modal fade" id="cutiTahunan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cutiTahunanTitle">Form Pengajuan Cuti Tahunan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formcuti" method="post" action="{{ route('submit-cutiTahunan') }}">
                  @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" id="name" name="name" required class="form-control" value="{{$users->detail->name}}" readonly />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="code" class="form-label">Jenis Cuti</label>
                                <select name="code" id="code" readonly class="form-control">                                
                                    <option selected value="CT">Cuti Tahunan</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="alcut" class="form-label">Alasan Cuti</label>
                                <textarea id="alcut" required name="alcut" class="form-control" placeholder="Alasan Pengajuan Cuti"></textarea>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col mb-3">
                              <label for="ataslang" class="form-label">Pilih Atasan</label>
                              <select name="ataslang" id="ataslang" class="form-control" required>
                                  @if($atasanDetail)
                                      <option value="{{ $atasanDetail->id }}" @if($atasanCuti) disabled @endif>
                                          {{ $atasanDetail->name }} @if($atasanCuti) | Cuti @endif
                                      </option>
                                  @endif
                                  @foreach($atasanLainnya as $atasan)
                                    <option value="{{ $atasan->user_id }}">{{ $atasan->name }}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col mb-3">
                              <label for="id_pimpinan" class="form-label">Pejabat Yang Berwenang Memeberikan Cuti</label>
                              <select name="id_pimpinan" id="id_pimpinan" class="form-control" required>
                                  @if($atasanDuaDetail)
                                      <option value="{{ $atasanDuaDetail->id }}" @if($atasanDuaCuti) disabled @endif>
                                          {{ $atasanDuaDetail->name }} @if($atasanDuaCuti) | Cuti @endif
                                      </option>
                                           @foreach($atasanLainnya as $atasan)
                                    <option value="{{ $atasan->user_id }}">{{ $atasan->name }}</option>
                                  @endforeach
                                  @else
                                      <option value="{{$users->id}}">Tidak ada Atasan 2</option>
                                  @endif
                              </select>
                          </div>
                      </div>
                        <div class="row g-2">
                            <div class="col mb-0">
                                <label for="tglawal" class="form-label">Dari Tanggal</label>
                                <input type="date" id="tglawal" name="tglawal" required class="form-control" value="2024-08-01" />
                            </div>
                            <div class="col mb-0">
                                <label for="tglakhir" class="form-label">Sampai Tanggal</label>
                                <input type="date" id="tglakhir" name="tglakhir" required class="form-control" value="2024-08-05" />
                            </div>
                        </div>
                        <div class="row" id="saldo_cuti_row" style="display: none;">
                            <div class="col mb-3">
                                <label for="saldo_cuti" class="form-label">Sisa Cuti & Jumlah Hari Cuti</label>
                                <input type="text" id="saldo_cuti" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="alamat" class="form-label">Alamat Selama Cuti</label>
                                <input type="text" id="alamat" name="alamat" class="form-control" value="{{$users->detail->alamat}}" />
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="id_pegawai" name="id_pegawai" class="form-control" value="{{$users->id}}" />
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button id="submitButton" type="submit" class="btn btn-success">Ajukan Cuti</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
{{-- //Modal CUti Tahunan --}}
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
    <script type="text/javascript">
      $(document).ready(function() {
          var table = $('#daftarCuti-table').DataTable({
              processing: true,
              serverSide: true,
              ajax: '{!! route('cutis.daftarCutidetData') !!}',
              columns: [
                  {data: 'no', name: 'no'},
                  {data: 'user_name', name: 'user_name'},
                  {data: 'atasan_name', name: 'atasan_name'},
                  {data: 'no_surat', name: 'no_surat'},
                  {data: 'jenis', name: 'jenis'},
                  {data: 'tglawal', name: 'tglawal'},
                  {data: 'tglakhir', name: 'tglakhir'},
                  {data: 'status', name: 'status'},
                  {data: 'action', name: 'action', orderable: false, searchable: false},
              ]
          });
  
          // Handle action button click
          $('#permohonanCuti-table').on('click', '.edit', function () {
              var data = table.row($(this).parents('tr')).data();
              $('#id').val(data.id);
              $('#jenisCuti').val(data.jenis);
              $('#name').val(data.user_name);
              $('#tglAwal').val(data.tglawal);
              $('#tglAkhir').val(data.tglakhir);
              $('#alasan').val(data.alasan); // Assuming you have an 'alasan' field in your data
              $('#permohonanCuti').modal('show');
          });
  
          // Handle Perubahan button click
          $('#btnPerubahan').on('click', function () {
              $('#permohonanCuti').modal('hide');
              $('#idPerubahan').val($('#id').val());
              $('#perubahanModal').modal('show');
          });
  
          // Handle Penanguhan button click
          $('#btnPenanguhan').on('click', function () {
              $('#permohonanCuti').modal('hide');
              $('#idPenanguhan').val($('#id').val());
              $('#penanguhanModal').modal('show');
          });
  
          // Handle Tolak button click
          $('#btnTolak').on('click', function () {
              $('#permohonanCuti').modal('hide');
              $('#idTolak').val($('#id').val());
              $('#tolakModal').modal('show');
          });
  
          // Handle Back button click in Perubahan modal
          $('#backToMainModal1').on('click', function () {
              $('#perubahanModal').modal('hide');
              $('#permohonanCuti').modal('show');
          });
  
          // Handle Back button click in Penanguhan modal
          $('#backToMainModal2').on('click', function () {
              $('#penanguhanModal').modal('hide');
              $('#permohonanCuti').modal('show');
          });
  
          // Handle Back button click in Tolak modal
          $('#backToMainModal3').on('click', function () {
              $('#tolakModal').modal('hide');
              $('#permohonanCuti').modal('show');
          });
      });
    </script>

    <script>
      window.OneSignalDeferred = window.OneSignalDeferred || [];
      OneSignalDeferred.push(async function(OneSignal) {
        await OneSignal.init({
          // appId: "1bcbea20-e5e8-4378-8873-136dc3a7b87c",
          appId: "c058f61a-07ba-4a97-ae80-5620ef410850",
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
          let response = await fetch('/check-device', {
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

        function monitorNotificationPermission() {
            let currentPermission = checkNotificationPermission();

            setInterval(() => {
                let newPermission = checkNotificationPermission();
                if (newPermission !== currentPermission) {
                    location.reload(); 
                }
            }, 1000);
        }
        monitorNotificationPermission();
    </script>
    
    <script>
      document.addEventListener('DOMContentLoaded', function () {
          const tglAwalInput = document.getElementById('tglawal');
          const tglAkhirInput = document.getElementById('tglakhir');
          const saldoCutiInput = document.getElementById('saldo_cuti');
          const saldoCutiRow = document.getElementById('saldo_cuti_row');

          // Ambil data sisa cuti dari PHP
          const sisaCuti = @json($cutiSisa->cuti_n + $cutiSisa->cuti_nsatu + $cutiSisa->cuti_ndua);

          tglAwalInput.addEventListener('change', calculateLeaveDays);
          tglAkhirInput.addEventListener('change', calculateLeaveDays);

          async function calculateLeaveDays() {
              const tglAwal = tglAwalInput.value;
              const tglAkhir = tglAkhirInput.value;

              if (!tglAwal || !tglAkhir) {
                  return;
              }

              const startDate = new Date(tglAwal);
              const endDate = new Date(tglAkhir);

              if (startDate > endDate) {
                  saldoCutiInput.value = 'Tanggal awal tidak boleh lebih besar dari tanggal akhir.';
                  saldoCutiRow.style.display = 'block';
                  return;
              }

              let totalHari = 0;
              let hariLibur = [];
              let currentDate = new Date(startDate);

              while (currentDate <= endDate) {
                  const dayOfWeek = currentDate.getDay();
                  if (dayOfWeek !== 6 && dayOfWeek !== 0) { // Exclude Saturdays (6) and Sundays (0)
                      totalHari++;
                  }
                  currentDate.setDate(currentDate.getDate() + 1);
              }

              let currentYear = startDate.getFullYear();
              while (currentYear <= endDate.getFullYear()) {
                  let response = await fetch(`https://api-harilibur.vercel.app/api?year=${currentYear}`);
                  let data = await response.json();
                  hariLibur = hariLibur.concat(data.filter(libur => libur.is_national_holiday));
                  currentYear++;
              }

              const hariLiburDalamRentang = hariLibur.filter(libur => {
                  const tanggalLibur = new Date(libur.holiday_date);
                  return tanggalLibur >= startDate && tanggalLibur <= endDate;
              });

              const jumlahHariLibur = hariLiburDalamRentang.length;
              const jumlahHariCuti = totalHari - jumlahHariLibur;
              const sisaCutiAkhir = sisaCuti - jumlahHariCuti;
              const sisaCutiMessage = sisaCutiAkhir < 0 ? " | Sisa Cuti Anda Tidak Mencukupi" : "";

              saldoCutiInput.value = `Jumlah Hari Cuti: ${jumlahHariCuti} | Sisa Cuti: ${sisaCutiAkhir}${sisaCutiMessage}`;
              saldoCutiRow.style.display = 'block';
          }
      });
    </script>
    
   
    
@endpush