@extends('customer.master')

@push('link')
  <link rel="stylesheet" href="{{asset('assets/libs/owl.carousel/dist/assets/owl.carousel.min.css')}}" />
@endpush

@section('title')
    E-Laundry | Dashboard
@endsection

@section('content')
<div class="d-flex align-items-center gap-4 mb-4">
  <div class="position-relative">
    <div class="border border-2 border-primary rounded-circle">
      <img src="{{ auth()->check() && auth()->user()->usr_profile_photo
        ? asset('storage/' . auth()->user()->usr_profile_photo)
        : asset('assets/images/profile/user-1.jpg') }}" class="rounded-circle m-1" alt="user1" width="60" />
    </div>
      <span class="visually-hidden">unread messages</span>
    </span>
  </div>
  <div>
    <h3 class="fw-semibold">{{ Auth::user()->usr_name }}</span></h3>
    <span>Terima kasih sudah menggunakan layanan laundry kami. Hemat waktu, biarkan kami yang bekerja untuk Anda✨
    </span>
  </div>
</div>

<div class="row">
  <div class="col-xl-8 d-flex align-items-strech">
    <div class="card w-100">
      <div class="card-body p-4">
        <h4 class="card-title fw-semibold">Layanan Utama</h4>
        <p class="card-subtitle">Kelola pesanan dan pembayaran laundry Anda dengan mudah 😊</p>
        <div class="owl-carousel collectibles-carousel owl-theme mt-9">
          <div class="item">
            <div class="card overflow-hidden mb-4 mb-md-0 shadow-none border">
              <div class="position-relative">
                <img src="{{ asset('assets/images/hero-img/laundry.png')}}" class="img-fluid w-100" alt="1" />
                <div class="card-img-overlay">
                </div>
              </div>
              <div class="p-9 text-start">
                <h6 class="fw-semibold fs-4">Pesan Laundry</h6>
                <div class="d-flex align-items-center mt-3 justify-content-between">
                </div>
                <a href="/customer/laundry-order/create" class="btn btn-primary w-100 mt-3">Pesan</a>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="card overflow-hidden mb-4 mb-md-0 shadow-none border">
              <div class="position-relative">
                <img src="{{ asset('assets/images/hero-img/payment.png')}}" class="img-fluid w-100" alt="1" />
         
                <div class="card-img-overlay">
                  <div class="text-end">
                    <span class="badge rounded-pill fs-2 {{ $totalDebt > 0 ? 'bg-danger' : 'bg-success' }}">
                      {{ $totalDebt > 0 ? 'Rp '.number_format($totalDebt, 0, ',', '.') : 'Tidak Ada Utang' }}
                  </span>
                  </div>
                </div>
              </div>
              <div class="p-9 text-start">
                <h6 class="fw-semibold fs-4">Piutang</h6>
                <div class="d-flex align-items-center mt-3 justify-content-between">
                </div>
                <a href="/customer/debt" class="btn btn-primary w-100 mt-3">Bayar Utang</a>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="card overflow-hidden mb-4 mb-md-0 shadow-none border">
              <div class="position-relative">
                <img src="{{ asset('assets/images/hero-img/computer-engineer.png')}}" class="img-fluid w-100" alt="1" />
                <div class="card-img-overlay">
                </div>
              </div>
              <div class="p-9 text-start">
                <h6 class="ffw-semibold fs-4">History</h6>
                <div class="d-flex align-items-center mt-3 justify-content-between">
                </div>
                <a href="/customer/laundry-order/history" class="btn btn-primary w-100 mt-3">History</a>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="card overflow-hidden mb-4 mb-md-0 shadow-none border">
              <div class="position-relative">
                <img src="{{ asset('assets/images/hero-img/courier (1).png')}}" class="img-fluid w-100" alt="1" />
                <div class="card-img-overlay">
                </div>
              </div>
              <div class="p-9 text-start">
                <h6 class="ffw-semibold fs-4">Pengiriman & Penjemputan</h6>
                <div class="d-flex align-items-center mt-3 justify-content-between">
                </div>
                <a href="/customer/laundry-order" class="btn btn-primary w-100 mt-3">Lihat</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-4 d-flex align-items-stretch">
    <div class="card w-100">
      <img class="card-img" style="height:400px; object-fit:cover;" 
           src="{{ asset('assets/images/backgrounds/profilebg.jpg') }}" alt="Card image">
  
      <div class="card-img-overlay text-white d-flex flex-column justify-content-between" style="height:260px;">
        <div class="d-flex justify-content-between align-items-center">
          <h4 class="card-title text-white" id="local-date">Loading...</h4>
        </div>
  
        <div>
          <span><i class="display-6 ti ti-wind"></i></span>
          <div class="d-inline-block ms-3">
            <span class="display-6" id="local-time">--:--:--</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  





@endsection

@push('script')
  <script src="../assets/libs/owl.carousel/dist/owl.carousel.min.js"></script>
  <script src="../assets/js/dashboards/dashboard.js"></script>

  <script>
    // SHOW 4 ITEMS FRONT
    $('.counter-carousel').owlCarousel({
      loop: false,
      margin: 10,
      nav: false,
      dots: false,
      autoplay: false,
      responsive: {
        0:   { items: 1 },
        576: { items: 2 },
        768: { items: 3 },
        992: { items: 4 } // tampil 4 di desktop
      }
    });

    function updateClock() {
      const now = new Date();
      document.getElementById("local-time").innerHTML = now.toLocaleTimeString('en-US',{hour12:false});
      document.getElementById("local-date").innerHTML = now.toLocaleDateString('en-US',{weekday:"long",year:"numeric",month:"long",day:"numeric"});
    }
    setInterval(updateClock, 1000);
    updateClock();
  </script>
  <script>
    $('.counter-carousel').owlCarousel({
      loop:false,
      margin:10,
      nav:false,
      dots:false,
      autoplay:false,
      responsive:{
        0:{items:1},
        576:{items:2},
        768:{items:3},
        992:{items:4}
      }
    });
  
    // INI YANG BELUM ADA
    $('.collectibles-carousel').owlCarousel({
      loop:true,
      margin:20,
      nav:true,
      dots:false,
      autoplay:true,
      responsive:{
        0:{items:1},
        576:{items:2},
        768:{items:3},
        992:{items:4}
      }
    });
  </script>
  
  
@endpush
