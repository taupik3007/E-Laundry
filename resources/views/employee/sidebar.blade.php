 <aside class="left-sidebar with-vertical">
     <div><!-- ---------------------------------- -->
         <!-- Start Vertical Layout Sidebar -->
         <!-- ---------------------------------- -->
         <div class="brand-logo d-flex align-items-center justify-content-between">
             <a href="../main/index.html" class="text-nowrap logo-img">
                 <img src="../assets/images/logos/dark-logo.svg" class="dark-logo" alt="Logo-Dark" />
                 <img src="../assets/images/logos/light-logo.svg" class="light-logo" alt="Logo-light" />
             </a>
             <a href="javascript:void(0)" class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
                 <i class="ti ti-x"></i>
             </a>
         </div>

         <nav class="sidebar-nav scroll-sidebar" data-simplebar>
             <ul id="sidebarnav">
                 <!-- ---------------------------------- -->
                 <!-- Home -->
                 <!-- ---------------------------------- -->
                 <li class="nav-small-cap">
                     <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                     <span class="hide-menu">Home</span>
                 </li>
                 <!-- ---------------------------------- -->
                 <!-- Dashboard -->
                 <!-- ---------------------------------- -->
                 <li class="sidebar-item">
                     <a class="sidebar-link" href="{{ route('employee.dashboard') }}" aria-expanded="false">
                         <span>
                             <i class="ti ti-aperture"></i>
                         </span>
                         <span class="hide-menu">Home</span>
                     </a>
                 </li>

                 <li class="nav-small-cap">
                     <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                     <span class="hide-menu">PESANAN</span>
                 </li>
                 <li class="sidebar-item">
                     <a class="sidebar-link" href="/employee/ordering" aria-expanded="false">
                         <span>
                             <i class="ti ti-shopping-cart"></i>
                         </span>
                         <span class="hide-menu">Pesanan</span>
                     </a>
                 </li>

                 <li class="sidebar-item">
                     <a class="sidebar-link" href="/employee/pick-up" aria-expanded="false">
                         <span>
                             <i class="ti ti-truck"></i>
                         </span>
                         <span class="hide-menu">Penjemputan</span>
                     </a>
                 </li>
                 <li class="sidebar-item">
                     <a class="sidebar-link" href="/employee/ordering/history" aria-expanded="false">
                         <span>
                             <i class="ti ti-history"></i>
                         </span>
                         <span class="hide-menu">Histori Pesanan</span>
                     </a>
                 </li>

                <li class="sidebar-item">
                     <a class="sidebar-link" href="/employee/laundry-service" aria-expanded="false">
                         <span>
                             <i class="ti ti-file-text"></i>
                         </span>
                         <span class="hide-menu">Layanan</span>
                     </a>
                 </li>
                 
                  <li class="nav-small-cap">
                     <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                     <span class="hide-menu">KELOLA DATA</span>
                 </li>


                 <li class="sidebar-item">
                     <a class="sidebar-link" href="/employee/customers" aria-expanded="false">
                         <span>
                             <i class="ti ti-user"></i>
                         </span>
                         <span class="hide-menu">Pelanggan</span>
                     </a>
                 </li>
                 <li class="nav-small-cap">
                     <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                     <span class="hide-menu">Hutang piutang</span>
                 </li>
                 <li class="sidebar-item">
                     <a class="sidebar-link" href="/employee/debt" aria-expanded="false">
                         <span>
                             <i class="ti ti-cash"></i>
                         </span>
                         <span class="hide-menu">Piutang</span>
                     </a>
                 </li>
                 
                 <li class="nav-small-cap">
                     <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                     <span class="hide-menu">LAPORAN</span>
                 </li>
                 <li class="sidebar-item">
                     <a class="sidebar-link" href="/employee/finance" aria-expanded="false">
                         <span>
                             <i class="ti ti-cash"></i>
                         </span>
                         <span class="hide-menu">Keuangan</span>
                     </a>
                 </li>


                <li class="nav-small-cap">
                     <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                     <span class="hide-menu">KELUAR</span>
                 </li>
                 <li class="sidebar-item">
                     <a class="sidebar-link" href="/employee/finance" aria-expanded="false">
                         <span>
                             <i class="ti ti-logout"></i>
                         </span>
                         <span class="hide-menu">Keluar</span>
                     </a>
                 </li>
              
                

             </ul>
             
         </nav>

         <div class="fixed-profile p-3 mx-8 mb-2 bg-secondary-subtle rounded mt-3">
             <div class="hstack gap-3">
                 <div class="john-img">
                     <img src="{{ asset('assets/images/profile/user-1.jpg')}}"class="rounded-circle" width="40" height="40"
                         alt="modernize-img" />
                 </div>
                 <div class="john-title">
                     {{-- <h6 class="mb-0 fs-4 fw-semibold">{{ Auth::user()->usr_name }}</h6> --}}
                     <h6 class="mb-0 fs-4 fw-semibold">Matthew</h6>
                     {{-- <span class="fs-2">{{ ucfirst(Auth::user()->getRoleNames()->first()) }}</span> --}}
                     <span class="fs-2">Designer</span>
                 </div>
                 <form method="POST" action="{{ route('logout') }}">
                    @csrf
                 <button type="submit" class="border-0 bg-transparent text-primary ms-auto" tabindex="0" type="button"
                     aria-label="logout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="logout">
                     <i class="ti ti-power fs-6"></i>
                 </button>
                </form>
             </div>
         </div>

         <!-- ---------------------------------- -->
         <!-- Start Vertical Layout Sidebar -->
         <!-- ---------------------------------- -->
     </div>
 </aside>
