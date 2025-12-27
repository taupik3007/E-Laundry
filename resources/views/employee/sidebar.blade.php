<aside class="left-sidebar with-vertical">
    <div>
        <!-- Sidebar Logo -->
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{ route('employee.dashboard') }}" class="text-nowrap logo-img">
                <img id="logo"
                 src="{{ asset('assets/images/logos/logooo.png')}}"
                 width="150"
                 alt="Logo">
           
            <script>
                const logo = document.getElementById('logo');
                const isDark = document.body.classList.contains('dark-theme');
            
                logo.src = isDark
                    ? "{{ asset('assets/images/logos/logooo.png')}}"
                    : "{{ asset('assets/images/logos/logooo.png')}}";
            </script>
             </a>
        </div>

        <nav class="sidebar-nav scroll-sidebar" data-simplebar>
            <ul id="sidebarnav">

                <!-- HOME -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Home</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->is('employee/dashboard') ? 'active' : '' }}"
                        href="{{ route('employee.dashboard') }}">
                        <span><i class="ti ti-aperture"></i></span>
                        <span class="hide-menu">Home</span>
                    </a>
                </li>

                <!-- PESANAN -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">PESANAN</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->is('employee/ordering') ? 'active' : '' }}"
                        href="/employee/ordering">
                        <span><i class="ti ti-shopping-cart"></i></span>
                        <span class="hide-menu">Pesanan</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->is('employee/ordering/history') ? 'active' : '' }}"
                        href="/employee/ordering/history">
                        <span><i class="ti ti-history"></i></span>
                        <span class="hide-menu">Histori Pesanan</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->is('employee/laundry-service') ? 'active' : '' }}"
                        href="/employee/laundry-service">
                        <span><i class="ti ti-file-text"></i></span>
                        <span class="hide-menu">Layanan</span>
                    </a>
                </li>

                <!-- KELOLA DATA -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">KELOLA DATA</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->is('employee/customers') ? 'active' : '' }}"
                        href="/employee/customers">
                        <span><i class="ti ti-user"></i></span>
                        <span class="hide-menu">Pelanggan</span>
                    </a>
                </li>

                <!-- PIUTANG -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Hutang Piutang</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->is('employee/debt') ? 'active' : '' }}"
                        href="/employee/debt">
                        <span><i class="ti ti-cash"></i></span>
                        <span class="hide-menu">Piutang</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link"
                        href="/employee/debt/history">
                        <span><i class="ti ti-cash"></i></span>
                        <span class="hide-menu">History Piutang</span>
                    </a>
                </li>

                <!-- LAPORAN -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">LAPORAN</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->is('employee/finance') ? 'active' : '' }}"
                        href="/employee/finance">
                        <span><i class="ti ti-cash"></i></span>
                        <span class="hide-menu">Keuangan</span>
                    </a>
                </li>

                {{-- <!-- KELUAR -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">KELUAR</span>
                </li>

                <li class="sidebar-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="sidebar-link border-0 bg-transparent w-100 text-start d-flex align-items-center">
                            <span><i class="ti ti-logout"></i></span>
                            <span class="hide-menu ms-1">Keluar</span>
                        </button>
                    </form>
                </li> --}}
            </ul>
        </nav>

        <!-- PROFILE FIXED -->
        <div class="fixed-profile p-3 mx-8 mb-2 bg-secondary-subtle rounded mt-3">
            <div class="hstack gap-3">
                <div>
                    <img src="{{ asset('assets/images/profile/user-1.jpg') }}"
                         class="rounded-circle" width="40" height="40" alt="profile" />
                </div>
                <div>
                    <h6 class="mb-0 fs-4 fw-semibold">
                        {{ Auth::user()->usr_name ?? 'Matthew' }}
                    </h6>
                    <span class="fs-2">
                        {{ ucfirst(Auth::user()->getRoleNames()->first() ?? 'Designer') }}
                    </span>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="ms-auto">
                    @csrf
                    <button type="submit" class="border-0 bg-transparent text-primary">
                        <i class="ti ti-power fs-6"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>
