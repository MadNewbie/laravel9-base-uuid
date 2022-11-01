@extends('template.forecourt-form')

@section('content')
<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">Login</p>
        <form action="{{route('login')}}" method="POST">
            @csrf
            <div class="input-group mb-3">
                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus placeholder="Username / Email">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-key"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 offset-md-8">
                    <button type="submit" class="btn btn-primary btn-block">
                        {{ __('Login') }}
                    </button>
                </div>
            </div>
        </form>
        <p class="mb-1">
            <a href="{{route('request.reset.password')}}">Lupa Password</a>
        </p>
        <p class="mb-1">
            <a href="{{route('request.verification')}}">Verifikasi Akun</a>
        </p>
        <p class="mb-0">
            <a href="{{route('register')}}" class="text-center">Daftar Akun Baru</a>
        </p>
    </div>
</div>
@endsection
