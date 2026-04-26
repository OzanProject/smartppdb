<nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom-0 shadow-sm">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link text-muted" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="{{ route('applicant.dashboard') }}" class="nav-link font-weight-bold">Beranda</a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown user-menu">
      <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-toggle="dropdown">
        @if(auth()->user()->avatar)
            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="user-image img-circle shadow-sm" alt="Avatar" style="width: 32px; height: 32px; object-fit: cover;">
        @else
            <div class="user-image img-circle bg-gradient-success d-flex align-items-center justify-content-center mr-2 shadow-sm text-white font-weight-bold" style="width: 32px; height: 32px; font-size: 0.8rem;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
        @endif
        <span class="d-none d-md-inline font-weight-bold text-dark">{{ auth()->user()->name }}</span>
      </a>
      <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right border-0 shadow-lg" style="border-radius: 15px; overflow: hidden;">
        <li class="user-header bg-success d-flex flex-column align-items-center justify-content-center py-4">
          @if(auth()->user()->avatar)
              <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="img-circle elevation-2 mb-2 shadow" alt="Avatar" style="width: 60px; height: 60px; object-fit: cover; border: 3px solid rgba(255,255,255,0.8);">
          @else
              <div class="img-circle bg-white d-flex align-items-center justify-content-center mb-2 shadow font-weight-bold text-success" style="width: 60px; height: 60px; font-size: 1.5rem;">
                  {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
              </div>
          @endif
          <p class="mb-0 font-weight-bold">
            {{ auth()->user()->name }}
          </p>
          <small class="opacity-75">Calon Peserta Didik</small>
        </li>
        <li class="user-footer bg-light px-4 py-3 d-flex justify-content-between">
          <a href="{{ route('profile.edit', ['role' => auth()->user()->role]) }}" class="btn btn-white btn-sm rounded-pill shadow-sm px-3">
            <i class="fas fa-cog mr-1"></i> Profil
          </a>
          <a href="#" class="btn btn-success btn-sm rounded-pill shadow-sm px-3" 
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
             <i class="fas fa-sign-out-alt mr-1"></i> Logout
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </li>
      </ul>
    </li>
  </ul>
</nav>
