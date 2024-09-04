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
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Kepegawaian /</span> Daftar / {{$title}}</h4>    

    <!-- Card Border Shadow -->
    <div class="row">
      <div class="col-sm-6 col-lg-3 mb-4">
        <div class="card card-border-shadow-primary h-100">
          <div class="card-body">
            <div class="d-flex align-items-center mb-2 pb-1">
              <div class="avatar me-2">
                <span class="avatar-initial rounded bg-label-primary">
                  <span class="avatar-initial rounded bg-label-primary">                    
                    <svg id="svg9960" width="35" height="35" viewBox="0 0 16.933333 16.933334" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg">
                        <g id="layer1" transform="translate(0 -280.067)">
                            <path id="path3778" d="m6.3505153 280.59583c-1.7503696 0-3.175516 1.42566-3.175516 3.17603 0 .10133.00468.20143.011377.30282.00299.37309.5718148.33688.5276162-.0336-.00602-.0935-.00983-.18294-.00983-.26923 0-1.46438 1.1819704-2.64635 2.6463493-2.64635 1.464392 0 2.6442826 1.18196 2.6442826 2.64635 0 .32707-.04469.68442-.1286719 1.0542-.057317.006-.1152605.0165-.1710505.0341-.099677-.32543-.4029789-.56121-.7586107-.56121-.4443201 0-.7927155-.3484-.7927155-.79272.00212-.14846-.1192239-.26935-.2676842-.26768-.1461691.002-.2631334.12151-.2614824.26768 0 .44431-.3489326.79272-.7932341.79272h-1.0588458c-.3556212 0-.6568599.24198-.7565443.56741-.1549612-.0488-.3201458-.0538-.4697386-.0145-.3226488.0848-.6117775.37055-.6247659.76636 0 .76437.5560166 1.26277 1.1901064 1.31981.1338342.38462.3643471.71838.6609424.98496v.6103c-.0005292 0-.00106 0-.00159 0-.069704.00055-.1363715.0286-.1855179.078l-.5296826.52968c-.068916.069-.094332.17022-.066146.26355l1.6986038 5.51801-1.9502702-2.48202.2330609-.93276c.022437-.0902-.00402-.18548-.069763-.25115l-.689364-.68936.2547647-1.08675c.038931-.16595-.086897-.32488-.257347-.32505-.021431 0-.042767.003-.063563.008-1.5004493.37088-2.60651093 1.72485-2.60652143 3.33882v3.70416c.0000158.14612.1184645.26457.2645833.26459h9.78958613c.357801.005.357801-.53423 0-.52917h-3.6886651l2.5740045-3.27629c.05041-.0642.06833-.14814.04858-.22737l-.22841-.91312.687814-.68782c.06247-.0625.08961-.15207.07235-.23874l-.1503786-.75913c.4478306.19105.8492966.50201 1.1518656.9002.213921.27876.632916-.0396.421683-.32039-.462968-.60926-1.090147-1.03863-1.8598356-1.22887-.188412-.0466-.361244.11874-.322977.30903l.212905 1.06402-.6934967.69349c-.065733.0657-.092213.16099-.069763.25115l.2330607.93276-1.950786 2.48305 1.6986039-5.51904c.028054-.0934.00238-.1947-.066662-.26355l-.5291666-.52968c-.049739-.0498-.1172396-.0776-.187587-.0775v-.60978c.296926-.26674.5276612-.59876.6614584-.98392.6430033-.0484 1.1921753-.5576 1.1921753-1.32188-.01-.30481-.184232-.54196-.41031-.67489.09084-.39966.144695-.79619.144695-1.17151 0-1.75037-1.4235881-3.17603-3.1739682-3.17603zm.5286507 3.70468c.241382.32393.6237975.52761 1.0572988.52762.1511803 0 .2656179.11497.2656179.26613v1.05833c0 1.03064-.8209254 1.85157-1.8515674 1.85157-1.0306183 0-1.8536339-.82093-1.8536339-1.85157v-1.05833c0-.15116.1144667-.26613.2656179-.26613h1.0588493c.433615-.00001.8164459-.20354 1.0578174-.52762zm-2.9114512 1.1467v.70538c0 .0759.00442.15073.011377.2248-.2954973-.0875-.5364004-.33721-.5364004-.75035 0-.27487.4096332-.35526.5250234-.17983zm5.2911506.18191c0 .39291-.243186.6616-.5389852.7488.00699-.0742.011377-.14926.011377-.22531v-.70435c.1216422-.17945.5276082-.0945.5276082.18086zm-1.8494982 2.65462v.60927l-1.0588519.88263-1.0583334-.88212v-.60926c.3188309.1589.6779128.24908 1.0583334.24908.3808386 0 .7399628-.0904 1.0588519-.2496zm-2.6308474.87282 1.1384307.94826-.9575642.68368-.426847-1.38803zm3.1424431 0 .2459805.24391-.426847 1.38751-.9575642-.68368zm-5.0880619.66352-.1798347.76946c-.020981.0891.00561.18274.070281.24753l.6878135.68782-.2284095.91312c-.019764.0792-.00185.16314.048575.22738l2.5740043 3.27627h-2.8938801v-1.85157c.00299-.15001-.1197425-.27256-.2697505-.26975-.1461876.003-.2626731.12357-.2599347.26975v1.85157h-1.3234326v-3.43958c0-1.20111.7456223-2.23515 1.7745683-2.68201zm11.860258 2.10892-.912606 2.05362c-.01461.0339-.0217.0706-.02119.10749 0 0-.004.31878.159679.64647.163851.32769.506833.67541 1.162204.67541.655359 0 .997847-.34772 1.161684-.67541.163902-.32769.160198-.64647.160198-.64647.000529-.0369-.007-.0736-.02119-.10749l-.913125-2.05517c.148021-.0335.41819-.12826.59273-.29663.23609-.22774-.101716-.62523-.372586-.37517-.0975.09-.362262.18759-.608232.18759-.668071-.01-.959668-.45831-1.851568-.51677v-.54156c.0021-.14623-.114794-.26609-.260966-.26769v-.001c-.0021-.00001-.0031-.001-.0041-.001-.146179.002-.262607.12151-.260966.26768v.54157c-.8919.0585-1.183497.50709-1.851568.51677-.24598 0-.51069-.0975-.608232-.18759-.2708696-.25006-.6086866.14742-.3725856.37517.1745296.16837.4446976.26312.5927296.29662l-.9131246 2.05518c-.0146.0339-.02159.0706-.02119.10748 0 0-.004.31878.160197.64647.163841.32769.5063176.67542 1.1616876.67542.65536 0 .998352-.34773 1.162204-.67542.163848-.32769.159678-.64647.159678-.64647.000529-.0369-.007-.0736-.02119-.10748l-.912603-2.05363c.541028-.0859.858798-.48439 1.724959-.48472.869508.001 1.187143.40074 1.729091.48679zm-8.3431597-1.48261.414446.2961-.2909385.4377h-.2459805l-.291973-.4377zm-.8449098.60358.3023076.45372-.2211758 1.32343-.4625049-1.50482zm1.6908542.00053.3798199.2713-.4625022 1.50275-.2201439-1.31982zm-.8867696.65887h.08165l.3741367 2.24689-.4159964 1.35083-.4144433-1.34773zm6.6579939.25735c-.132321 0-.264068.0882-.264068.26458v3.70831h-1.071768c-.357222.0243-.332899.5379.01241.52916h1.320335v.002h1.324467c.345289.009.369612-.5049.01241-.52917h-1.071785v-3.7083c0-.17503-.129717-.26267-.260966-.26407v-.003zm-2.116151.39068.650089 1.46451h-1.299662zm4.230233.002.649573 1.46451h-1.299663zm-4.97644 1.99213h1.49293s-.0933.52916-.746207.52916c-.652949 0-.746723-.52916-.746723-.52916zm4.229714.002h1.492933s-.0938.52917-.746723.52917c-.652952 0-.74621-.52917-.74621-.52917z" font-variant-ligatures="normal" font-variant-position="normal" font-variant-caps="normal" font-variant-numeric="normal" font-variant-alternates="normal" font-feature-settings="normal" text-indent="0" text-align="start" text-decoration-line="none" text-decoration-style="solid" text-decoration-color="rgb(0,0,0)" text-transform="none" text-orientation="mixed" fill="currentColor" white-space="normal" shape-padding="0" isolation="auto" mix-blend-mode="normal" solid-color="rgb(0,0,0)" solid-opacity="1" vector-effect="none"/>
                        </g>
                    </svg>
                </span>  
              </div>
              <h2 class="ms-1 mb-0">{{$hakimCount+$cakimCount}}</h2>
            </div>
            <h4 class="mb-1">Hakim / Cakim</h4>           
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3 mb-4">
        <div class="card card-border-shadow-warning h-100">
          <div class="card-body">
            <div class="d-flex align-items-center mb-2 pb-1">
                <div class="avatar me-2">
                    <span class="avatar-initial rounded bg-label-warning">                               
                        <svg id="Layer_3" enable-background="new 0 0 64 64" width="35" height="35" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="m61 39h-6v-3c0-1.654-1.346-3-3-3h-10c-.862 0-1.635.371-2.183.955l-10.817-1.802v-2.506c2.984-1.732 5-4.955 5-8.647h1c1.654 0 3-1.346 3-3s-1.346-3-3-3h-.48l.548-1.271c1.028-2.381.844-5.131-.49-7.355-.846-1.41-2.083-2.515-3.579-3.195l-2.791-1.271c-3.295-1.5-7.334-1.061-10.231 1.11l-1.577 1.182.002.003c-1.56.407-2.937 1.411-3.783 2.821-1.101 1.836-1.187 4.075-.23 5.99l.993 1.986h-.382c-1.654 0-3 1.346-3 3s1.346 3 3 3h1c0 3.692 2.016 6.915 5 8.647v2.506l-12.151 2.025c-3.389.565-5.849 3.468-5.849 6.905v20.917c0 .553.448 1 1 1h31 1 27c1.103 0 2-.897 2-2v-20c0-1.103-.897-2-2-2zm-8-3v3h-6.332c-.536-1.711-1.706-3.133-3.239-4h8.571c.551 0 1 .448 1 1zm-12 .195c1.575.323 2.874 1.381 3.53 2.805h-3.53zm-5-18.195c0 .551-.449 1-1 1h-1v-2h1c.551 0 1 .449 1 1zm-21.666-9.947c.76-1.266 2.15-2.053 3.626-2.053 1.568 0 3.023.779 3.894 2.083l.314.471 1.664-1.109-.314-.471c-.902-1.352-2.247-2.302-3.772-2.724 2.264-1.404 5.197-1.632 7.633-.523l2.791 1.271c1.125.512 2.056 1.343 2.693 2.404 1.004 1.673 1.142 3.742.369 5.534l-.067.156-1.27-2.54c-.133-.265-.376-.458-.665-.526-.288-.069-.592-.004-.83.173l-1.6 1.2c-1.376 1.033-3.081 1.601-4.8 1.601s-3.424-.568-4.8-1.6l-1.6-1.2c-.238-.179-.543-.243-.83-.173-.289.068-.532.261-.665.526l-1.355 2.711-.572-1.144c-.65-1.3-.592-2.821.156-4.067zm-1.334 10.947c-.551 0-1-.449-1-1s.449-1 1-1h1v2zm3 2v-5.764l1.358-2.717.642.481c1.72 1.29 3.851 2 6 2s4.28-.71 6-2l.642-.481 1.358 2.717v5.764c0 4.411-3.589 8-8 8s-8-3.589-8-8zm8 10c1.045 0 2.052-.162 3-.461v2.047l-3 3-3-3v-2.047c.948.299 1.955.461 3 .461zm-.323 11h.646l1.632 4.08-1.955 8.473-1.955-8.473zm2.219-4.147-1.431 2.147h-.93l-1.432-2.147.334-1.001.856.856c.195.194.451.292.707.292s.512-.098.707-.293l.856-.856zm-12.896 23.147v-17h-2v17h-8v-19.917c0-2.454 1.757-4.529 4.178-4.933l12.479-2.079 1.199 1.199-.805 2.414c-.098.293-.055.614.117.871l1.708 2.562-1.805 4.512c-.076.189-.091.397-.046.596l3 13c.105.454.509.775.975.775s.87-.321.975-.775l3-13c.045-.198.03-.406-.046-.596l-1.805-4.512 1.708-2.562c.171-.257.214-.578.117-.871l-.805-2.414 1.199-1.199 10.672 1.778c-.002.051-.015.099-.015.151v3h-6c-1.103 0-2 .897-2 2v20zm21 0h-1v-2h28.001v2zm27.001-4h-28.001v-8.111c1.272 1.301 3.042 2.111 5 2.111h6v1c0 1.654 1.346 3 3 3s3-1.346 3-3v-1h6c1.958 0 3.729-.811 5.001-2.111zm-15.001-5v-5h2v5c0 .552-.449 1-1 1s-1-.448-1-1zm15-8c0 2.757-2.243 5-5 5h-6v-3c0-.553-.448-1-1-1h-4c-.552 0-1 .447-1 1v3h-6c-2.757 0-5-2.243-5-5v-3h28z" fill="currentColor"/>
                        </svg>
                    </span> 
                </div>
              <h2 class="ms-1 mb-0">{{$pegawaiCount+$cpnsCount}}</h2>
            </div>
            <h4 class="mb-1">Pegawai / CPNS</h4>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3 mb-4">
        <div class="card card-border-shadow-dark h-100">
          <div class="card-body">
            <div class="d-flex align-items-center mb-2 pb-1">
              <div class="avatar me-2">
                <span class="avatar-initial rounded bg-label-dark">                                                  
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" fill="none" width="35" height="35" xml:space="preserve">
                        <g><g><path d="M421.054,414.843c-4.142,0-7.5,3.358-7.5,7.5v70.514c0,2.283-1.858,4.141-4.141,4.141h-40.317V349.301
                            c0-4.142-3.358-7.5-7.5-7.5c-4.142,0-7.5,3.358-7.5,7.5v147.698h-81.185l23.543-25.9c2.572-2.83,3.785-6.861,3.244-10.787
                            c-0.01-0.076-0.022-0.152-0.035-0.228L277.24,327.617l6.041-9.094c3.34,2.372,5.913,4.656,10.738,4.656
                            c4.908,0,9.497-2.747,11.755-7.269v-0.001l23.65-47.4l53.876,20.865c1.949,0.836,30.252,13.582,30.252,47.238v50.73
                            c-0.001,4.141,3.357,7.5,7.5,7.5c4.142,0,7.5-3.358,7.5-7.5v-50.73c0-44.344-37.969-60.463-39.585-61.128
                            c-0.047-0.02-0.095-0.039-0.143-0.057l-89.668-34.726v-21.03c14.242-11.076,24.117-27.495,26.596-46.227
                            c7.101-0.5,13.69-3.152,19.071-7.779c7.027-6.043,11.059-14.838,11.059-24.126c0-7.708-2.781-15.068-7.737-20.803V92.953
                            C348.144,41.699,306.446,0,255.192,0c-51.254,0-92.952,41.699-92.952,92.953v28.511c-5.009,5.677-7.733,12.665-7.733,20.074
                            c0,9.291,4.03,18.085,11.059,24.129c5.377,4.625,11.962,7.274,19.061,7.775c2.499,19.083,12.662,36.114,28.117,47.339v19.92
                            l-89.571,34.725c-0.047,0.018-0.094,0.037-0.141,0.056c-1.617,0.665-39.585,16.784-39.585,61.128v156.245
                            c0,10.555,8.587,19.142,19.142,19.142h71.457c4.142,0,7.5-3.358,7.5-7.5c0-4.142-3.358-7.5-7.5-7.5h-16.137V349.301
                            c0-4.142-3.358-7.5-7.5-7.5c-4.142,0-7.5,3.358-7.5,7.5v147.698h-40.319c-2.283,0-4.141-1.858-4.141-4.141V336.611
                            c0-33.769,28.493-46.486,30.243-47.234l53.834-20.87l23.652,47.402c2.263,4.533,6.858,7.27,11.756,7.27
                            c4.801,0,7.349-2.249,10.738-4.656l6.041,9.094l-22.421,132.468c-0.013,0.075-0.024,0.15-0.035,0.226
                            c-0.542,3.924,0.671,7.957,3.244,10.789l23.543,25.9h-29.995c-4.142,0-7.5,3.358-7.5,7.5s3.358,7.5,7.5,7.5h200.365
                            c10.555,0,19.142-8.588,19.142-19.142v-70.514C428.554,418.201,425.196,414.843,421.054,414.843z M315.375,263.069l-22.049,44.19
                            c-0.548-0.389-12.233-8.691-26.517-18.834c6.198-7.651-1.053,1.299,27.235-33.617L315.375,263.069z M271.043,309.833l-5.718,8.607
                            h-18.703l-5.718-8.607l15.07-10.703L271.043,309.833z M227.743,243.121v-14.036c9.112,3.673,18.85,5.376,28.36,5.376
                            c9.833,0,19.476-2.096,28.052-5.846v14.567l-28.181,34.785L227.743,243.121z M340.881,141.539
                            c-0.001,4.913-2.129,9.562-5.839,12.753c-2.453,2.11-5.416,3.459-8.661,3.987v-33.477
                            C335.001,126.202,340.881,133.352,340.881,141.539z M184.007,158.279c-8.718-1.415-14.5-8.623-14.5-16.741
                            c0-8.018,6.647-14.544,14.5-16.359V158.279z M184.41,109.896c-2.389,0.274-5.127,0.921-7.168,1.615V92.953
                            c0-42.983,34.968-77.952,77.951-77.952c42.983,0,77.951,34.969,77.951,77.952v18.043c-2.18-0.663-4.441-1.101-6.762-1.307
                            c0-7.237,0.063-5.841-23.612-31.294c-4.354-4.678-11.556-5.658-17.037-2.077c-26.13,17.069-58.005,25.644-87.415,23.532 C191.867,99.367,185.991,103.616,184.41,109.896z M199.008,164.184v-46.792v-2.465c32.375,1.896,66.318-7.722,93.739-25.283 c10.858,11.658,16.738,17.773,18.634,20.099c0,5.884,0,47.705,0,54.44c0,30.447-24.826,55.276-55.277,55.276 C221.91,219.46,199.008,192.934,199.008,164.184z M218.623,307.259l-22.049-44.19l21.293-8.247l27.241,33.625 C231.255,298.284,219.88,306.366,218.623,307.259z M227.228,461.702l21.709-128.263h14.071l21.709,128.263l-28.744,31.623 L227.228,461.702z" fill="currentColor"/></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g>                                
                        </g>
                    </svg>
                </span> 
              </div>
              <h2 class="ms-1 mb-0">{{$ppnpnCount}}</h2>
            </div>
            <h4 class="mb-1">PPNPN</h4>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3 mb-4">
        <div class="card card-border-shadow-info h-100">
          <div class="card-body">
            <div class="d-flex align-items-center mb-2 pb-1">
              <div class="avatar me-2">
                <span class="avatar-initial rounded bg-label-info">                                                 
                    <svg xmlns="http://www.w3.org/2000/svg" id="Icons" viewBox="0 0 60 60" width="35" height="35" fill="none">
                        <path d="M7,42.74V53a7.009,7.009,0,0,0,7,7H46a7.009,7.009,0,0,0,7-7V42.74A12.989,12.989,0,0,0,41.436,29.819l-6.248-.694c.457-.3.886-.6,1.279-.876.251-.177.489-.345.712-.495A7.025,7.025,0,0,0,40.162,23.1l.3-1.812A3.407,3.407,0,0,0,43,18V13a13,13,0,1,0-26,0v5a3.407,3.407,0,0,0,2.535,3.289l.3,1.812a7.027,7.027,0,0,0,2.982,4.653c.224.15.462.318.713.495.393.277.822.578,1.279.876l-6.248.694A12.989,12.989,0,0,0,7,42.74ZM16,53V37a1,1,0,0,1,1-1H43a1,1,0,0,1,1,1V53a1,1,0,0,1-1,1H17A1,1,0,0,1,16,53ZM27,31v-.681a6.948,6.948,0,0,0,6,0V31a3,3,0,0,1-6,0ZM16,58V56H44l0,2H16ZM51,42.74V53a5.006,5.006,0,0,1-5,5V56a1.983,1.983,0,0,0-.513-1.324A2.982,2.982,0,0,0,46,53V37a3,3,0,0,0-3-3H33.974a4.943,4.943,0,0,0,1.014-2.884l6.227.692A10.989,10.989,0,0,1,51,42.74ZM22.217,5.217A11.007,11.007,0,0,1,41,13v1.9a3.311,3.311,0,0,0-.479-.178,3.823,3.823,0,0,0-3.035-3.242,16.405,16.405,0,0,1-6.263-2.129,2.281,2.281,0,0,0-2.446,0,16.407,16.407,0,0,1-6.262,2.129,3.823,3.823,0,0,0-3.036,3.242,3.311,3.311,0,0,0-.479.178V13A10.933,10.933,0,0,1,22.217,5.217ZM23.938,26.1a5.021,5.021,0,0,1-2.127-3.325l-.424-2.536A1,1,0,0,0,20.4,19.4a1.4,1.4,0,0,1,0-2.8,1,1,0,0,0,1-1,2.029,2.029,0,0,1,1.4-2.134,18.454,18.454,0,0,0,7.045-2.416.275.275,0,0,1,.316,0A18.452,18.452,0,0,0,37.2,13.466,2.029,2.029,0,0,1,38.6,15.6a1,1,0,0,0,1,1,1.4,1.4,0,0,1,0,2.8,1,1,0,0,0-.987.835l-.424,2.536A5.019,5.019,0,0,1,36.061,26.1c-.234.158-.484.334-.747.519C33.808,27.678,31.933,29,30,29s-3.808-1.322-5.314-2.385C24.423,26.43,24.173,26.254,23.938,26.1Zm1.074,5.02A4.943,4.943,0,0,0,26.026,34H17a3,3,0,0,0-3,3V53a2.982,2.982,0,0,0,.513,1.676A1.983,1.983,0,0,0,14,56v2a5.006,5.006,0,0,1-5-5V42.74a10.989,10.989,0,0,1,9.785-10.932Z" fill="currentColor"/>
                        <path d="M30,42a4,4,0,1,0,4,4A4,4,0,0,0,30,42Zm0,6a2,2,0,1,1,2-2A2,2,0,0,1,30,48Z"/>
                    </svg>
                </span> 
              </div>
              <h2 class="ms-1 mb-0">{{$magangCount}}</h2>
            </div>
            <h4 class="mb-1">Magang</h4>
          </div>
        </div>
      </div>
    </div>
    <!--/ Card Border Shadow -->
    <div class="row">
      <!-- Vehicles overview -->
      <div class="col-xxl-12 mb-4 order-5 order-xxl-0">
        <div class="card h-100">
          <div class="card-header">
            <div class="card-title mb-3">
              <h5 class="m-0">Daftar Pegawai MS Lhokseumawe</h5>
            </div>           
            <button
            data-bs-target="#addEmployeeModal"
            data-bs-toggle="modal"
            class="btn btn-primary text-nowrap add-new-employee">
            Tambah Pegawai
          </button>
          </div>
          <div class="card-body">
            <div class="d-none d-lg-flex vehicles-progress-labels mb-3">
                @if ($hakimCakimPercentage > 0)
                    <div class="vehicles-progress-label on-the-way-text" style="width: {{ $hakimCakimPercentage }}%">Hakim & CAKIM</div>
                @endif
                @if ($pegawaiCpnsPercentage > 0)
                    <div class="vehicles-progress-label unloading-text" style="width: {{ $pegawaiCpnsPercentage }}%">Pegawai & CPNS</div>
                @endif
                @if ($ppnpnPercentage > 0)
                    <div class="vehicles-progress-label loading-text" style="width: {{ $ppnpnPercentage }}%">PPNPN</div>
                @endif
                @if ($magangPercentage > 0)
                    <div class="vehicles-progress-label waiting-text" style="width: {{ $magangPercentage }}%">Magang</div>
                @endif
            </div>
            <div class="vehicles-overview-progress progress rounded-2 mb-3" style="height: 46px">
                @if ($hakimCakimPercentage > 0)
                    <div
                        class="progress-bar fs-big fw-medium text-start bg-primary px-1 px-lg-3 shadow-none"
                        role="progressbar" style="width: {{ $hakimCakimPercentage }}%" aria-valuenow="{{ $hakimCakimPercentage }}" aria-valuemin="0" aria-valuemax="100">{{ number_format($hakimCakimPercentage, 2) }}% | {{ number_format($hakimCakimCount) }} Orang
                    </div>
                @endif
                @if ($pegawaiCpnsPercentage > 0)
                    <div
                        class="progress-bar fs-big fw-medium text-start bg-warning px-1 px-lg-3 shadow-none"
                        role="progressbar" style="width: {{ $pegawaiCpnsPercentage }}%" aria-valuenow="{{ $pegawaiCpnsPercentage }}" aria-valuemin="0" aria-valuemax="100">{{ number_format($pegawaiCpnsPercentage, 2) }}% | {{ number_format($pegawaiCpnsCount) }} Orang
                    </div>
                @endif
                @if ($ppnpnPercentage > 0)
                    <div
                        class="progress-bar fs-big fw-medium text-start text-bg-dark px-1 px-lg-3 shadow-none"
                        role="progressbar" style="width: {{ $ppnpnPercentage }}%" aria-valuenow="{{ $ppnpnPercentage }}" aria-valuemin="0" aria-valuemax="100">{{ number_format($ppnpnPercentage, 2) }}% | {{ number_format($ppnpnCount) }} Orang
                    </div>
                @endif
                @if ($magangPercentage > 0)
                    <div
                        class="progress-bar fs-big fw-medium text-start text-bg-info px-1 px-lg-3 rounded-end shadow-none"
                        role="progressbar" style="width: {{ $magangPercentage }}%" aria-valuenow="{{ $magangPercentage }}" aria-valuemin="0" aria-valuemax="100">{{ number_format($magangPercentage, 2) }}% | {{ number_format($magangCount) }} Orang
                    </div>
                @endif
            </div>
        
            <div class="card-datatable table-responsive">
                <table id="pegawai-table" class="datatables-users table border-top">              
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pegawai</th>
                            <th>Jabatan dan<br>Posisi</th>                                                                                                       
                            <th>Kontak</th>
                            <th>Role</th>
                            <th>Aksi</th>       
                        </tr>
                    </thead>
                </table>
            </div>
          </div>
        </div>
      </div>
     
    </div>
    <!--/ On route vehicles Table -->
  </div>
 
    <!-- Modal -->
    <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEmployeeModalLabel">Tambah Pegawai Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addMenuForm" action="{{ route('pegawai.add') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Nama Lengkap, S.H., M.H" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="namalengkap" required>
                        </div>
                        <div class="mb-3">
                            <label for="whatsapp" class="form-label">Whatsapp</label>
                            <input type="text" class="form-control" id="whatsapp" name="whatsapp" placeholder="08xxxxxxxx" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="namalengkap@gmail.com" required>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <select  name="jabatan" id="jabatan" class="form-control">
                                    <option selected>Jabatan</option>
                                    <option value="Ketua">Ketua</option>
                                    <option value="Wakil Ketua">Wakil Ketua</option>
                                    <option value="Panitera">Panitera</option>
                                    <option value="Sekretaris">Sekretaris</option>
                                    <option value="Hakim">Hakim</option>
                                    <option value="Panitera Muda Hukum">Panitera Muda Hukum</option>
                                    <option value="Panitera Muda Gugatan">Panitera Muda Gugatan</option>
                                    <option value="Panitera Muda Permohonan">Panitera Muda Permohonan</option>
                                    <option value="Panitera Muda Jinayat">Panitera  Muda Jinayat</option>
                                    <option value="Panitera Pengganti">Panitera Pengganti</option>
                                    <option value="Kasubbag Keuangan / Umum">Kasubbag Keuangan / Umum</option>
                                    <option value="Kasubbag Perencanaan / IT"> Kasubbag Perencanaan / IT</option>
                                    <option value="Kasubbag Kepegawaian">Kasubbag Kepegawaian</option>
                                    <option value="Juru Sita">Juru Sita</option>
                                    <option value="Juru Sita Pengganti">Juru Sita Pengganti</option>                                    
                                    <option value="Pranata Komputer Ahli Pertama">Pranata Komputer Ahli Pertama</option>
                                    <option value="Analis Perkara Peradilan">Analis Perkara Peradilan</option>
                                    <option value="Arsiparis Pelaksana">Arsiparis Pelaksana</option>
                                    <option value="Calon Hakim">Calon Hakim</option>
                                    <option value="CPNS">CPNS</option>
                                    <option value="PPNPN">PPNPN</option>
                                    <option value="Magang">Magang</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="posisi" class="form-label">Status</label>
                                <select  name="posisi" id="posisi" class="form-control">
                                    <option selected>Status</option>
                                    <option value="HAKIM">Hakim</option>
                                    <option value="PEGAWAI">Pegawai</option>
                                    <option value="CAKIM">CAKIM</option>
                                    <option value="CPNS">CPNS</option>
                                    <option value="PPNPN">PPNPN</option>
                                    <option value="MAGANG">Magang</option>                            
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select name="role" id="role" class="form-control">
                                    <option selected>Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nip" class="form-label">NIP</label>
                                <input type="text" class="form-control" name="nip" id="nip" placeholder="nip" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="tglahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" name="tglahir" id="tglahir" placeholder="Tanggal">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="tlahir" class="form-label">Tempat Kelahiran</label>
                                <input type="text" class="form-control" name="tlahir" id="tlahir" placeholder="Tempat Kelahiran" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="kelamin" class="form-label">Jenis Kelamin</label>
                                <select  name="kelamin" id="kelamin" class="form-control">
                                    <option selected>Jenis Kelamin</option>
                                    <option value="L">Laki-Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea type="text" class="form-control" name="alamat" id="alamat" placeholder="alamat"required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="instansi" class="form-label">Instansi</label>
                                <select name="instansi" id="instansi" class="form-control">
                                    <option value="">Pilih Instansi</option>
                                    @foreach($instansi as $item)
                                        <option value="{{ $item->id }}">{{ $item->igusername }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        {{-- <input type="hidden" name="instansi" id="instansi" placeholder="Instansi" value="1"> --}}
                        <button type="submit" class="btn btn-primary">Tambah Pegawai</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Structure -->
    <div class="modal fade" id="roleModal" tabindex="-1" aria-labelledby="roleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="roleModalLabel">Ganti Role Pegawai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="roleForm" action="{{ route('changeRole') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" id="userId">
                        <div class="mb-3">
                            <label for="roleSelect" class="form-label">Role</label>
                            <select class="form-select" id="roleSelect" name="role_id" required>
                                @foreach(\App\Models\Role::all() as $role)
                                    <option value="{{ $role->id }}">{{ ucwords($role->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="roleForm" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Structure -->


    
@endsection

@push('footer-script')            
<script src="{{ asset('assets') }}/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.js"></script>
@endpush

@push('footer-Sec-script')

    <script type="text/javascript">
        $(document).ready(function() {
            $('#pegawai-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('user.getData') !!}',
                columns: [
                    { data: 'no', name: 'no' }, 
                    { data: 'pegawai', name: 'pegawai' },
                    { data: 'jabatan', name: 'jabatan' },         
                    { data: 'kontak', name: 'kontak' },
                    { data: 'role', name: 'role' },                    
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            // Event listener for showing the modal with pre-selected role
            $('#roleModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var userId = button.data('user-id'); // Extract user ID from data-* attributes
                var roleId = button.data('role-id'); // Extract role ID from data-* attributes
                
                $('#userId').val(userId);

                // Set the selected role in the dropdown
                $('#roleSelect').val(roleId);
            });
        });
    </script>


  <script>
   function showDeleteConfirmation(url, message) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
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
@endpush