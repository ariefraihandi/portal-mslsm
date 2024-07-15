
@extends('IndexLandingPage.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/nouislider/nouislider.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/swiper/swiper.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/css/pages/front-page-landing.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.css" />
@endpush

@section('content')
    <div data-bs-spy="scroll" class="scrollspy-example">
      <!-- Hero: Start -->
      <section id="hero-animation">
        <div id="landingHero" class="section-py landing-hero position-relative">
          <div class="container">
            <div class="hero-text-box text-center">
              <h1 class="text-primary hero-title display-8 fw-bold">Buku Tamu MS Lhokseumawe</h1>
              <p class="text-muted">Silakan isi buku tamu di bawah ini untuk bergabung dengan komunitas kami.</p>              
            </div>
         
          </div>
        </div>        
      </section>
      <!-- Hero: End -->

      <!-- Contact Us: Start -->
      <section id="landingContact" class="section-py landing-contact">
        <div class="container">
          
          <div class="row gy-4">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">                
                  <form id="guestbookForm" action="{{ route('submit-guestbook') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">
                      <div class="col-md-12">
                        <label class="form-label" for="name">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama Lengkap" required>
                      </div>
                      <div class="col-md-12">
                        <label class="form-label" for="pekerjaan">Jenis Pekerjaan</label>
                        <select class="form-select" name="pekerjaan" id="pekerjaan" required>
                          <option value="">Pilih Jenis Pekerjaan</option>
                          <option value="1">PNS/TNI/POLRI</option>
                          <option value="2">Pegawai Swasta</option>
                          <option value="3">Wiraswasta/Usahawan</option>
                          <option value="4">Advokat</option>
                          <option value="5">Petani/Nelayan</option>
                          <option value="6">Mengurus Rumah Tangga</option>
                          <option value="7">Mahasiswa</option>
                          <option value="8">Lainnya</option>
                        </select>
                      </div>
                      <div class="col-md-12">
                        <label class="form-label" for="satker">Satuan Kerja</label>
                        <input type="text" class="form-control" id="satker" name="satker" placeholder="Satuan Kerja" required>
                      </div>
                      <div class="col-md-12">
                        <label class="form-label" for="tujuan">Tujuan</label>
                        <select class="form-select" name="tujuan" id="tujuan" required>
                          <option value="">Pilih Tujuan</option>
                          <option value="Silaturrahmi">Silaturrahmi</option>
                          <option value="Konsultasi">Konsultasi</option>
                          <option value="Koordinasi">Koordinasi</option>
                          <option value="Pengawasan">Pengawasan</option>
                          <option value="Pemeriksaan">Pemeriksaan</option>
                          <option value="Sosialisasi">Sosialisasi</option>
                          <option value="Konfirmasi">Konfirmasi</option>
                          <option value="Keluarga">Keluarga</option>
                          <option value="Informasi">Informasi</option>
                          <option value="Pendaftaran">Pendaftaran</option>
                          <option value="Pengambilan Produk">Pengambilan Produk</option>
                          <option value="Pengambilan Sisa Panjar">Pengambilan Sisa Panjar</option>
                          <option value="Lain-Lain">Lain-Lain</option>
                        </select>
                      </div>
                      <div class="col-md-12">
                        <label class="form-label" for="ditemui">Yang Ingin Ditemui</label>
                        <input type="text" class="form-control" id="ditemui" name="ditemui" placeholder="Yang Ingin Ditemui" required>
                      </div>
                      <div class="col-md-12">
                        <label class="form-label" for="image">Foto Pengunjung</label>
                        <input type="file" class="form-control" id="image" name="image" required>
                        <img id="imagePreview" src="#" alt="Preview Gambar" style="display:none; margin-top: 10px; max-width: 100%;">
                      </div>            
                      <div class="col-md-12">
                        <label class="form-label" for="signature">Tanda Tangan</label>  
                      </div>      
                      <div class="col-12">
                        <canvas id="signatureCanvas"  style="border: 1px solid #ced4da;"></canvas>
                        <input type="hidden" name="signature" id="signatureInput">
                      </div>
                      
                      <div class="col-12 d-flex justify-content-left">
                        <button type="button" class="btn btn-secondary" onclick="resetSignature()">Reset Tanda Tangan</button>
                      </div>
                      <div class="col-12 d-flex justify-content-center">
                        
                        <button type="submit" class="btn btn-primary">Simpan</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Contact Us: End -->
    </div>
@endsection

@push('footer-script') 
    <script src="{{ asset('assets') }}/js/front-page-landing.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script>
        var canvas = document.getElementById('signatureCanvas');
        var signatureInput = document.getElementById('signatureInput');
        var context = canvas.getContext('2d');
        var isDrawing = false;
        var lastX = 0;
        var lastY = 0;
    
        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('mouseout', stopDrawing);
    
        canvas.addEventListener('touchstart', startDrawing);
        canvas.addEventListener('touchmove', draw);
        canvas.addEventListener('touchend', stopDrawing);
    
        function getTouchPos(canvas, touchEvent) {
            var rect = canvas.getBoundingClientRect();
            return {
                x: touchEvent.touches[0].clientX - rect.left,
                y: touchEvent.touches[0].clientY - rect.top
            };
        }
    
        function startDrawing(e) {
            e.preventDefault();
    
            if (e.touches) {
                var touchPos = getTouchPos(canvas, e);
                [lastX, lastY] = [touchPos.x, touchPos.y];
            } else {
                [lastX, lastY] = [e.offsetX, e.offsetY];
            }
    
            isDrawing = true;
        }
    
        function draw(e) {
            e.preventDefault();
    
            if (!isDrawing) return;
    
            if (e.touches) {
                var touchPos = getTouchPos(canvas, e);
                var touchX = touchPos.x;
                var touchY = touchPos.y;
            } else {
                var touchX = e.offsetX;
                var touchY = e.offsetY;
            }
    
            context.beginPath();
            context.moveTo(lastX, lastY);
            context.lineTo(touchX, touchY);
            context.stroke();
    
            [lastX, lastY] = [touchX, touchY];
        }
    
        function stopDrawing() {
            isDrawing = false;
            signatureInput.value = canvas.toDataURL();
        }
    
        function resetSignature() {
            context.clearRect(0, 0, canvas.width, canvas.height);
            signatureInput.value = '';
        }
    
        // Adjust canvas size based on media screen width
        function adjustCanvasSize() {
            var screenWidth = window.innerWidth;
            var canvasWidth = Math.min(screenWidth * 0.9, 400); // Set maximum width of 400px or 90% of screen width
            var canvasHeight = canvasWidth * 0.5; // Set height to 50% of width
    
            canvas.width = canvasWidth;
            canvas.height = canvasHeight;
        }
    
        // Call adjustCanvasSize on page load and window resize
        window.addEventListener('load', adjustCanvasSize);
        window.addEventListener('resize', adjustCanvasSize);
    </script>
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