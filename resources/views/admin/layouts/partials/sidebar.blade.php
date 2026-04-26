<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('admin.dashboard') }}" class="brand-link">
    @if(optional(auth()->user()->school)->logo)
      <img src="{{ asset('storage/' . auth()->user()->school->logo) }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    @elseif(!empty($landingSettings['app_logo']))
      <img src="{{ asset('storage/' . $landingSettings['app_logo']) }}" alt="Logo" class="brand-image elevation-3" style="opacity: .8">
    @else
      <div class="brand-image img-circle elevation-3 bg-indigo d-flex align-items-center justify-content-center" style="width: 33px; height: 33px;">
          <i class="fas fa-university"></i>
      </div>
    @endif
    <span class="brand-text font-weight-light">{{ auth()->user()->school->name ?? 'PPDB PRO' }}</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        @if(auth()->user()->avatar)
            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="img-circle elevation-2" alt="User Image" style="width: 34px; height: 34px; object-fit: cover;">
        @else
            <div class="img-circle elevation-2 bg-gradient-primary d-flex align-items-center justify-content-center text-white" style="width: 34px; height: 34px; font-weight: bold;">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
        @endif
      </div>
      <div class="info">
        <a href="{{ route('profile.edit', ['role' => auth()->user()->role]) }}" class="d-block font-weight-bold">{{ auth()->user()->name }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-header">MENU UTAMA</li>
        <li class="nav-item">
          <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.subscriptions.index') }}" class="nav-link {{ request()->routeIs('admin.subscriptions.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-gem text-purple"></i>
            <p>Langganan & Paket</p>
          </a>
        </li>

        <li class="nav-header">NAVIGASI SISTEM</li>
        
        @if(auth()->user()->role === 'admin_school')
        @php $hasMasterAccess = auth()->user()->school->hasModuleAccess('master_data'); @endphp
        <!-- DATA MASTER -->
        <li class="nav-item {{ $hasMasterAccess ? 'has-treeview' : '' }} {{ request()->routeIs('admin.academic-years.*', 'admin.batches.*', 'admin.announcements.*') ? 'menu-open' : '' }}">
          <a href="{{ $hasMasterAccess ? '#' : 'javascript:void(0)' }}" class="nav-link {{ request()->routeIs('admin.academic-years.*', 'admin.batches.*', 'admin.announcements.*') ? 'active' : '' }}" {!! !$hasMasterAccess ? 'onclick="alert(\'Fitur Data Master terkunci. Silakan upgrade paket langganan Anda.\')"' : '' !!}>
            <i class="nav-icon fas fa-database text-warning"></i>
            <p>
              Data Master
              @if(!$hasMasterAccess)
                <i class="fas fa-lock right text-xs text-secondary mt-1"></i>
              @else
                <i class="right fas fa-angle-left"></i>
              @endif
            </p>
          </a>
          @if($hasMasterAccess)
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.academic-years.index') }}" class="nav-link {{ request()->routeIs('admin.academic-years.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon text-sm"></i>
                <p>Tahun Ajaran</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.batches.index') }}" class="nav-link {{ request()->routeIs('admin.batches.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon text-sm"></i>
                <p>Gelombang</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.announcements.index') }}" class="nav-link {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon text-sm"></i>
                <p>Pengumuman Lulus</p>
              </a>
            </li>
          </ul>
          @endif
        </li>
        @endif

        @php $hasPendaftaranAccess = auth()->user()->school->hasModuleAccess('pendaftaran'); @endphp
        <!-- DATA PENDAFTARAN -->
        <li class="nav-item {{ $hasPendaftaranAccess ? 'has-treeview' : '' }} {{ request()->routeIs('admin.registrations.*', 'admin.students.*') ? 'menu-open' : '' }}">
          <a href="{{ $hasPendaftaranAccess ? '#' : 'javascript:void(0)' }}" class="nav-link {{ request()->routeIs('admin.registrations.*', 'admin.students.*') ? 'active' : '' }}" {!! !$hasPendaftaranAccess ? 'onclick="alert(\'Fitur Data Pendaftaran terkunci. Silakan upgrade paket langganan Anda.\')"' : '' !!}>
            <i class="nav-icon fas fa-user-edit text-info"></i>
            <p>
              Pendaftaran
              @if(!$hasPendaftaranAccess)
                <i class="fas fa-lock right text-xs text-secondary mt-1"></i>
              @else
                <i class="right fas fa-angle-left"></i>
              @endif
            </p>
          </a>
          @if($hasPendaftaranAccess)
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.registrations.index') }}" class="nav-link {{ request()->routeIs('admin.registrations.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon text-sm"></i>
                <p>Data Pendaftar</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.students.index') }}" class="nav-link {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon text-sm"></i>
                <p>Siswa Diterima</p>
              </a>
            </li>
          </ul>
          @endif
        </li>

        @if(auth()->user()->role === 'admin_school')
        @php $hasPengaturanAccess = auth()->user()->school->hasModuleAccess('pengaturan'); @endphp
        <!-- PENGATURAN -->
        <li class="nav-item {{ $hasPengaturanAccess ? 'has-treeview' : '' }} {{ request()->routeIs('admin.school.*', 'admin.form-builder.*', 'admin.landing-page.*', 'admin.users.*') ? 'menu-open' : '' }}">
          <a href="{{ $hasPengaturanAccess ? '#' : 'javascript:void(0)' }}" class="nav-link {{ request()->routeIs('admin.school.*', 'admin.form-builder.*', 'admin.landing-page.*', 'admin.users.*') ? 'active' : '' }}" {!! !$hasPengaturanAccess ? 'onclick="alert(\'Fitur Pengaturan terkunci. Silakan upgrade paket langganan Anda.\')"' : '' !!}>
            <i class="nav-icon fas fa-tools text-danger"></i>
            <p>
              Pengaturan
              @if(!$hasPengaturanAccess)
                <i class="fas fa-lock right text-xs text-secondary mt-1"></i>
              @else
                <i class="right fas fa-angle-left"></i>
              @endif
            </p>
          </a>
          @if($hasPengaturanAccess)
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.school.edit') }}" class="nav-link {{ request()->routeIs('admin.school.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon text-sm"></i>
                <p>Profil Sekolah</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.form-builder.index') }}" class="nav-link {{ request()->routeIs('admin.form-builder.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon text-sm"></i>
                <p>Form Builder</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.landing-page.index') }}" class="nav-link {{ request()->routeIs('admin.landing-page.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon text-sm"></i>
                <p>Desain Landing</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon text-sm"></i>
                <p>Manajemen Pengguna</p>
              </a>
            </li>
          </ul>
          @endif
        </li>
        @endif
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
