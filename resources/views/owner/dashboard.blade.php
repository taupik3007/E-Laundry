@extends('owner.master')

@push('link')
  <link rel="stylesheet" href="{{asset('assets/libs/owl.carousel/dist/assets/owl.carousel.min.css')}}" />
    
@endpush

@section('title')
    E-Laundry Garut | Tambah Pesanan
@endsection

@section('content')
   <div class="owl-carousel counter-carousel owl-theme">
            <div class="item">
              <div class="card border-0 zoom-in bg-primary-subtle shadow-none">
                <div class="card-body">
                  <div class="text-center">
                    <img src="../assets/images/svgs/icon-user-male.svg" width="50" height="50" class="mb-3" alt="modernize-img" />
                    <p class="fw-semibold fs-3 text-primary mb-1">
                      Pelaggan
                    </p>
                    <h5 class="fw-semibold text-primary mb-0">96</h5>
                  </div>
                </div>
              </div>
            </div>
            <div class="item">
              <div class="card border-0 zoom-in bg-warning-subtle shadow-none">
                <div class="card-body">
                  <div class="text-center">
                    <img src="../assets/images/svgs/icon-briefcase.svg" width="50" height="50" class="mb-3" alt="modernize-img" />
                    <p class="fw-semibold fs-3 text-warning mb-1">Layanan</p>
                    <h5 class="fw-semibold text-warning mb-0">3,650</h5>
                  </div>
                </div>
              </div>
            </div>
            <div class="item">
              <div class="card border-0 zoom-in bg-info-subtle shadow-none">
                <div class="card-body">
                  <div class="text-center">
                    <img src="../assets/images/svgs/icon-mailbox.svg" width="50" height="50" class="mb-3" alt="modernize-img" />
                    <p class="fw-semibold fs-3 text-info mb-1">Pesanan</p>
                    <h5 class="fw-semibold text-info mb-0">356</h5>
                  </div>
                </div>
              </div>
            </div>
            <div class="item">
              <div class="card border-0 zoom-in bg-danger-subtle shadow-none">
                <div class="card-body">
                  <div class="text-center">
                    <img src="../assets/images/svgs/icon-favorites.svg" width="50" height="50" class="mb-3" alt="modernize-img" />
                    <p class="fw-semibold fs-3 text-danger mb-1">Penjemputan</p>
                    <h5 class="fw-semibold text-danger mb-0">696</h5>
                  </div>
                </div>
              </div>
            </div>
            <div class="item">
              <div class="card border-0 zoom-in bg-success-subtle shadow-none">
                <div class="card-body">
                  <div class="text-center">
                    <img src="../assets/images/svgs/icon-speech-bubble.svg" width="50" height="50" class="mb-3" alt="modernize-img" />
                    <p class="fw-semibold fs-3 text-success mb-1">Keuangan</p>
                    <h5 class="fw-semibold text-success mb-0">$96k</h5>
                  </div>
                </div>
              </div>
            </div>
            <div class="item">
              <div class="card border-0 zoom-in bg-info-subtle shadow-none">
                <div class="card-body">
                  <div class="text-center">
                    <img src="../assets/images/svgs/icon-connect.svg" width="50" height="50" class="mb-3" alt="modernize-img" />
                    <p class="fw-semibold fs-3 text-info mb-1">Reports</p>
                    <h5 class="fw-semibold text-info mb-0">59</h5>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-8 d-flex align-items-stretch">
              <div class="card w-100 bg-primary-subtle overflow-hidden shadow-none">
                <div class="card-body position-relative">
                  <div class="row">
                    <div class="col-sm-7">
                      <div class="d-flex align-items-center mb-7">
                        <div class="rounded-circle overflow-hidden me-6">
                          <img src="../assets/images/profile/user-1.jpg" alt="modernize-img" width="40" height="40">
                        </div>
                        <h5 class="fw-semibold mb-0 fs-5">Welcome back Mathew Anderson!</h5>
                      </div>
                      <div class="d-flex align-items-center">
                        <div class="border-end pe-4 border-muted border-opacity-10">
                          <h3 class="mb-1 fw-semibold fs-8 d-flex align-content-center">$2,340<i class="ti ti-arrow-up-right fs-5 lh-base text-success"></i>
                          </h3>
                          <p class="mb-0 text-dark">Today’s Sales</p>
                        </div>
                        <div class="ps-4">
                          <h3 class="mb-1 fw-semibold fs-8 d-flex align-content-center">35%<i class="ti ti-arrow-up-right fs-5 lh-base text-success"></i>
                          </h3>
                          <p class="mb-0 text-dark">Overall Performance</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-5">
                      <div class="welcome-bg-img mb-n7 text-end">
                        <img src="../assets/images/backgrounds/welcome-bg.svg" alt="modernize-img" class="img-fluid">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-12 col-lg-4 d-flex align-items-stretch">
              <div class="card w-100">
                <div class="card-body p-4">
                  <h4 class="fw-semibold">$10,230</h4>
                  <p class="mb-2 fs-3">Expense</p>
                  <div id="expense"></div>
                </div>
              </div>
            </div>
            
            <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
              <div class="card w-100">
                <div class="card-body">
                  <h4 class="card-title fw-semibold">Revenue Updates</h4>
                  <p class="card-subtitle mb-4">Overview of Profit</p>
                  <div class="d-flex align-items-center">
                    <div class="me-4">
                      <span class="round-8 text-bg-primary rounded-circle me-2 d-inline-block"></span>
                      <span class="fs-2">Footware</span>
                    </div>
                    <div>
                      <span class="round-8 text-bg-secondary rounded-circle me-2 d-inline-block"></span>
                      <span class="fs-2">Fashionware</span>
                    </div>
                  </div>
                  <div id="revenue-chart" class="revenue-chart mx-n3"></div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
              <div class="card w-100">
                <div class="card-body">
                  <h4 class="card-title fw-semibold">Sales Overview</h4>
                  <p class="card-subtitle mb-2">Every Month</p>
                  <div id="sales-overview" class="mb-4"></div>
                  <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                      <div class="bg-primary-subtle text-primary rounded-2 me-8 p-8 d-flex align-items-center justify-content-center">
                        <i class="ti ti-grid-dots fs-6"></i>
                      </div>
                      <div>
                        <h6 class="fw-semibold text-dark fs-4 mb-0">$23,450</h6>
                        <p class="fs-3 mb-0 fw-normal">Profit</p>
                      </div>
                    </div>
                    <div class="d-flex align-items-center">
                      <div class="bg-secondary-subtle text-secondary rounded-2 me-8 p-8 d-flex align-items-center justify-content-center">
                        <i class="ti ti-grid-dots fs-6"></i>
                      </div>
                      <div>
                        <h6 class="fw-semibold text-dark fs-4 mb-0">$23,450</h6>
                        <p class="fs-3 mb-0 fw-normal">Expance</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="row">
                <div class="col-sm-6 d-flex align-items-stretch">
                  <div class="card w-100">
                    <div class="card-body">
                      <div class="p-2 bg-primary-subtle rounded-2 d-inline-block mb-3">
                        <img src="../assets/images/svgs/icon-cart.svg" alt="modernize-img" class="img-fluid" width="24" height="24">
                      </div>
                      <div id="sales-two" class="mb-3 mx-n4"></div>
                      <h4 class="mb-1 fw-semibold d-flex align-content-center">$16.5k<i class="ti ti-arrow-up-right fs-5 text-success"></i>
                      </h4>
                      <p class="mb-0">Sales</p>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 d-flex align-items-stretch">
                  <div class="card w-100">
                    <div class="card-body">
                      <div class="p-2 bg-info-subtle rounded-2 d-inline-block mb-3">
                        <img src="../assets/images/svgs/icon-bar.svg" alt="modernize-img" class="img-fluid" width="24" height="24">
                      </div>
                      <div id="growth" class="mb-3"></div>
                      <h4 class="mb-1 fw-semibold d-flex align-content-center">24%<i class="ti ti-arrow-up-right fs-5 text-success"></i>
                      </h4>
                      <p class="mb-0">Growth</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-body">
                  <div class="row alig n-items-start">
                    <div class="col-8">
                      <h4 class="card-title mb-9 fw-semibold"> Monthly Earnings </h4>
                      <div class="d-flex align-items-center mb-3">
                        <h4 class="fw-semibold mb-0 me-8">$6,820</h4>
                        <div class="d-flex align-items-center">
                          <span class="me-2 rounded-circle bg-success-subtle text-success round-20 d-flex align-items-center justify-content-center">
                            <i class="ti ti-arrow-up-left"></i>
                          </span>
                          <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="d-flex justify-content-end">
                        <div class="p-2 bg-primary-subtle rounded-2 d-inline-block">
                          <img src="../assets/images/svgs/icon-master-card-2.svg" alt="modernize-img" class="img-fluid" width="24" height="24">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div id="monthly-earning"></div>
                </div>
              </div>
            </div>
           
          </div>
    
@endsection



@push('script')
  <script src="../assets/libs/owl.carousel/dist/owl.carousel.min.js"></script>
  <script src="../assets/js/dashboards/dashboard.js"></script>
    
@endpush
