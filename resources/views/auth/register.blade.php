<x-guest-layout :school="$school ?? null">
    <div class="card card-outline card-primary">
        <div class="card-header text-center py-4">
            <h4 class="font-weight-bold mb-0">Daftar Akun Baru</h4>
            <p class="text-muted small mb-0">Lengkapi data untuk mulai mendaftar PPDB</p>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('register', isset($school) ? ['school' => $school->slug] : []) }}">
                <input type="hidden" name="school_id" value="{{ isset($school) ? $school->id : '' }}">
                @csrf

                <!-- Name -->
                <div class="input-group mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" value="{{ old('name') }}" required autofocus autocomplete="name">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    @if($errors->has('name'))
                        <div class="invalid-feedback d-block">{{ $errors->first('name') }}</div>
                    @endif
                </div>

                <!-- Email Address -->
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email (Aktif)" value="{{ old('email') }}" required autocomplete="username">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @if($errors->has('email'))
                        <div class="invalid-feedback d-block">{{ $errors->first('email') }}</div>
                    @endif
                </div>

                <!-- Password -->
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required autocomplete="new-password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @if($errors->has('password'))
                        <div class="invalid-feedback d-block">{{ $errors->first('password') }}</div>
                    @endif
                </div>

                <!-- Confirm Password -->
                <div class="input-group mb-3">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required autocomplete="new-password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @if($errors->has('password_confirmation'))
                        <div class="invalid-feedback d-block">{{ $errors->first('password_confirmation') }}</div>
                    @endif
                </div>

                <div class="row items-center mb-3">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block btn-lg font-weight-bold shadow-sm" style="border-radius: 10px;">
                            DAFTAR AKUN SEKARANG
                        </button>
                    </div>
                </div>
            </form>

            <hr>

            <p class="mb-0 text-center">
                Sudah punya akun? <a href="{{ route('login', isset($school) ? ['school' => $school->slug] : []) }}" class="text-primary font-weight-bold">Silakan Masuk</a>
            </p>
        </div>
    </div>
</x-guest-layout>
