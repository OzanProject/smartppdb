<style>
  .sa-sidebar { font-family: 'Inter', 'Segoe UI', system-ui, sans-serif; }
  .sa-sidebar .nav-sidebar > .nav-item { margin-bottom: 2px; }
  .sa-sidebar .nav-sidebar > .nav-item > .nav-link {
    border-radius: 10px !important;
    padding: 10px 14px;
    color: rgba(255,255,255,0.6);
    font-size: 0.88rem;
    font-weight: 500;
    transition: all 0.25s ease;
    border: 1px solid transparent;
  }
  .sa-sidebar .nav-sidebar > .nav-item > .nav-link:hover {
    background: rgba(255,255,255,0.06);
    color: #fff;
  }
  .sa-sidebar .nav-sidebar > .nav-item > .nav-link.active {
    background: linear-gradient(135deg, rgba(220, 53, 69, 0.2), rgba(220, 53, 69, 0.1)) !important;
    color: #fff !important;
    border-color: rgba(220, 53, 69, 0.3);
    font-weight: 600;
  }
  .sa-sidebar .nav-sidebar > .nav-item > .nav-link > .nav-icon { font-size: 1rem; width: 24px; text-align: center; }
  .sa-sidebar .nav-sidebar > .nav-item.menu-open > .nav-link { background: rgba(255,255,255,0.04); color: #fff; }
  .sa-sidebar .nav-treeview { padding: 4px 0 4px 8px; }
  .sa-sidebar .nav-treeview > .nav-item > .nav-link {
    padding: 7px 12px 7px 36px;
    font-size: 0.82rem;
    color: rgba(255,255,255,0.5);
    border-radius: 8px !important;
    transition: all 0.2s ease;
    border: 1px solid transparent;
  }
  .sa-sidebar .nav-treeview > .nav-item > .nav-link:hover {
    color: #fff;
    background: rgba(255,255,255,0.05);
    padding-left: 40px;
  }
  .sa-sidebar .nav-treeview > .nav-item > .nav-link.active {
    color: #fff !important;
    background: rgba(220, 53, 69, 0.12) !important;
    font-weight: 600;
    border-color: rgba(220, 53, 69, 0.15);
  }
  .sa-sidebar .nav-treeview > .nav-item > .nav-link > .nav-icon { font-size: 0.45rem; margin-right: 8px; }
  .sa-divider { height: 1px; background: rgba(255,255,255,0.06); margin: 12px 14px; }
  .sa-label { color: #4b5563; font-size: 0.6rem; font-weight: 800; letter-spacing: 1.8px; text-transform: uppercase; padding: 8px 16px 4px; }
  .sa-user-card {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.06);
    border-radius: 14px;
    padding: 14px;
    margin: 14px 6px 20px;
    transition: all 0.3s ease;
  }
  .sa-user-card:hover { background: rgba(255,255,255,0.08); }
</style>

<aside class="main-sidebar sidebar-dark-danger elevation-4 sa-sidebar" style="background: #0f172a;">
  <!-- Brand Logo -->
  <a href="{{ route('superadmin.dashboard') }}" class="brand-link border-bottom-0 py-3 px-3" style="background: rgba(0,0,0,0.15);">
    @if(!empty($landingSettings['app_logo']))
        <img src="{{ asset('storage/' . $landingSettings['app_logo']) }}" alt="Logo" class="brand-image img-circle elevation-2" style="opacity: .95; width: 34px; height: 34px; object-fit: contain; background: white;">
    @else
        <div class="brand-image img-circle elevation-2 bg-danger d-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
            <i class="fas fa-shield-alt text-xs text-white"></i>
        </div>
    @endif
    <span class="brand-text font-weight-bold ml-2" style="font-size: 1.05rem; letter-spacing: -0.5px;">{{ $landingSettings['app_name'] ?? 'PPDB PRO' }}</span>
  </a>

  <div class="sidebar" style="padding: 0 8px;">
    <!-- User Panel -->
    <div class="sa-user-card d-flex align-items-center">
      <div class="mr-3 flex-shrink-0">
        @if(auth()->user()->avatar)
            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="img-circle" alt="Avatar" style="width: 38px; height: 38px; object-fit: cover; border: 2px solid rgba(220, 53, 69, 0.5);">
        @else
            <div class="img-circle bg-gradient-danger d-flex align-items-center justify-content-center text-white" style="width: 38px; height: 38px; font-weight: 700; font-size: 0.85rem;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
        @endif
      </div>
      <div style="min-width: 0;">
        <a href="{{ route('profile.edit', ['role' => auth()->user()->role]) }}" class="d-block font-weight-bold text-white text-truncate" style="font-size: 0.85rem;">{{ auth()->user()->name }}</a>
        <span style="font-size: 0.65rem; font-weight: 700; color: #ef4444; letter-spacing: 0.5px;">● SUPER ADMIN</span>
      </div>
    </div>

    <!-- Navigation -->
    <nav>
      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">

        <!-- Dashboard -->
        <li class="nav-item">
          <a href="{{ route('superadmin.dashboard') }}" class="nav-link {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-th-large"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <div class="sa-divider"></div>
        <li class="sa-label">Manajemen</li>

        <!-- Manajemen Sekolah -->
        <li class="nav-item {{ request()->routeIs('superadmin.schools.*', 'superadmin.admin-users.*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->routeIs('superadmin.schools.*', 'superadmin.admin-users.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-university"></i>
            <p>Sekolah & Admin <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('superadmin.schools.index') }}" class="nav-link {{ request()->routeIs('superadmin.schools.*') ? 'active' : '' }}">
                <i class="fas fa-circle nav-icon"></i>
                <p>Database Sekolah</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('superadmin.admin-users.index') }}" class="nav-link {{ request()->routeIs('superadmin.admin-users.*') ? 'active' : '' }}">
                <i class="fas fa-circle nav-icon"></i>
                <p>Akun Administrator</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Produk & Billing -->
        <li class="nav-item {{ request()->routeIs('superadmin.pricing-plans.*', 'superadmin.subscriptions.*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->routeIs('superadmin.pricing-plans.*', 'superadmin.subscriptions.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-credit-card"></i>
            <p>Produk & Billing <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('superadmin.pricing-plans.index') }}" class="nav-link {{ request()->routeIs('superadmin.pricing-plans.*') ? 'active' : '' }}">
                <i class="fas fa-circle nav-icon"></i>
                <p>Paket Langganan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('superadmin.subscriptions.index') }}" class="nav-link {{ request()->routeIs('superadmin.subscriptions.*') ? 'active' : '' }}">
                <i class="fas fa-circle nav-icon"></i>
                <p>Invoices & Langganan</p>
              </a>
            </li>
          </ul>
        </li>

        <div class="sa-divider"></div>
        <li class="sa-label">Konten</li>

        <!-- Konten Website -->
        <li class="nav-item {{ request()->routeIs('superadmin.landing-settings.*', 'superadmin.static-pages.*', 'superadmin.testimonials.*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->routeIs('superadmin.landing-settings.*', 'superadmin.static-pages.*', 'superadmin.testimonials.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-palette"></i>
            <p>Konten Website <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('superadmin.landing-settings.index') }}" class="nav-link {{ request()->routeIs('superadmin.landing-settings.*') ? 'active' : '' }}">
                <i class="fas fa-circle nav-icon"></i>
                <p>Landing Page CMS</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('superadmin.static-pages.index') }}" class="nav-link {{ request()->routeIs('superadmin.static-pages.*') ? 'active' : '' }}">
                <i class="fas fa-circle nav-icon"></i>
                <p>Halaman Statis</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('superadmin.testimonials.index') }}" class="nav-link {{ request()->routeIs('superadmin.testimonials.*') ? 'active' : '' }}">
                <i class="fas fa-circle nav-icon"></i>
                <p>Manajemen Testimoni</p>
              </a>
            </li>
          </ul>
        </li>

        <div class="sa-divider"></div>
        <li class="sa-label">Sistem</li>

        <!-- Konfigurasi Sistem -->
        <li class="nav-item {{ request()->routeIs('superadmin.payment-settings.*', 'superadmin.smtp-settings.*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->routeIs('superadmin.payment-settings.*', 'superadmin.smtp-settings.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-cogs"></i>
            <p>Konfigurasi <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('superadmin.payment-settings.index') }}" class="nav-link {{ request()->routeIs('superadmin.payment-settings.*') ? 'active' : '' }}">
                <i class="fas fa-circle nav-icon"></i>
                <p>Payment Gateway</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('superadmin.smtp-settings.index') }}" class="nav-link {{ request()->routeIs('superadmin.smtp-settings.*') ? 'active' : '' }}">
                <i class="fas fa-circle nav-icon"></i>
                <p>SMTP Email</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Profil -->
        <li class="nav-item">
          <a href="{{ route('profile.edit', ['role' => auth()->user()->role]) }}" class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user-circle"></i>
            <p>Profil Saya</p>
          </a>
        </li>

        <div class="sa-divider"></div>

        <!-- Logout -->
        <li class="nav-item">
          <form action="{{ route('logout') }}" method="POST" id="sidebar-logout-form">
            @csrf
          </form>
          <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();" style="color: rgba(239, 68, 68, 0.7);">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Keluar</p>
          </a>
        </li>

      </ul>
    </nav>
  </div>
</aside>
