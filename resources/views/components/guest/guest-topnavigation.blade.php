<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('images/logo-vis.png') }}" alt="" height="40">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('images/logo-vis.png') }}" alt="" height="17">
                    </span>
                </a>

                <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('images/logo-vis.png') }}" alt="" height="35">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('images/logo-vis.png') }}" alt="" height="48">
                    </span>
                </a>
            </div>

           
        </div>

        <div class="d-flex">
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="initials"> support@gmail.com</span>
                    <span class="d-none d-xl-inline-block ms-1" key="t-henry">
                        +91 998788 99177
                    </span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('admin.editProfile') }}">
                        <i class="bx bx-user font-size-16 align-middle me-1"></i> 
                        <span key="t-profile">Profile</span>
                    </a>

                    <a class="dropdown-item" href="{{ route('admin.changeAdminPassword') }}">
                        <i class="bx bx-key font-size-16 align-middle me-1"></i> 
                        <span key="t-my-key">Change Password</span>
                    </a>

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="{{ route('admin.logout') }}">
                        <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> 
                        <span key="t-logout">Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
