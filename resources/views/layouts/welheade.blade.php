<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('welcome') }}" class="logo d-flex align-items-center">
            <img src="{{ asset('assets/admin/img/switch-favicon.png') }}" alt="">
            <span class="d-none d-lg-block" translate="no">Switch Maker</span>
        </a>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            @if (auth()->check())
                <!-- Search Icon -->
                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle" href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li>

                <!-- Profile Dropdown -->
                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="{{ route('profil.user') }}" data-bs-toggle="dropdown">
                        <img src="{{ auth()->user()->photo ? asset(auth()->user()->photo) : asset('img/logo.png') }}" alt="Profile" class="rounded-circle" style="width: 30px; height: 30px; object-fit: cover;">
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{ auth()->user()->nom }}</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>{{ auth()->user()->nom }}</h6>
                            <span>{{ auth()->user()->role }}</span>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('profil.user') }}">
                                <i class="bi bi-person"></i>
                                <span>Mon profile</span>
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="nav-item">
                            <form action="{{ route('deconnexion') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="nav-link collapsed" style="border: none; background: transparent;">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Déconnexion</span>
                                </button>
                            </form>
                        </li>

                    </ul>
                    <!-- End Profile Dropdown Items -->
                </li>
                <!-- End Profile Nav -->
            @endif
        </ul>
    </nav>


</header><!-- End Header -->