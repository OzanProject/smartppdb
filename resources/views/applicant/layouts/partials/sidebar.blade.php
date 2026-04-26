<aside class="main-sidebar sidebar-dark-success elevation-4">
  <a href="{{ route('applicant.dashboard') }}" class="brand-link">
    <div class="brand-image img-circle elevation-3 bg-success d-flex align-items-center justify-content-center" style="width: 33px; height: 33px;">
        <i class="fas fa-user-graduate"></i>
    </div>
    <span class="brand-text font-weight-light">{{ $landingSettings['app_name'] ?? 'PPDB PRO' }}</span>
  </a>

  <div class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        @if(auth()->user()->avatar)
            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="img-circle elevation-2" alt="User Image" style="width: 34px; height: 34px; object-fit: cover;">
        @else
            <div class="img-circle elevation-2 bg-gradient-success d-flex align-items-center justify-content-center text-white" style="width: 34px; height: 34px; font-weight: bold;">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
        @endif
      </div>
      <div class="info">
        <a href="{{ route('profile.edit', ['role' => auth()->user()->role]) }}" class="d-block font-weight-bold">{{ auth()->user()->name }}</a>
      </div>
    </div>

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
        <li class="nav-item">
          <a href="{{ route('applicant.dashboard') }}" class="nav-link {{ request()->routeIs('applicant.dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('applicant.registration.create') }}" class="nav-link {{ request()->routeIs('applicant.registration.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-edit"></i>
            <p>Formulir Pendaftaran</p>
          </a>
        </li>
        <li class="nav-header">PENGATURAN</li>
        <li class="nav-item">
          <a href="{{ route('profile.edit', ['role' => auth()->user()->role]) }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user-cog"></i>
            <p>Profil Saya</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>
