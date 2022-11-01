@extends('template.forecourt-form')

@section('content')
<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">Ajukan Reset Password</p>
        <form action="{{route('post.request.reset.password')}}" method="POST">
            @csrf
            <div class="input-group mb-3">
                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus placeholder="Email">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 offset-md-8">
                    <button type="submit" class="btn btn-primary btn-block">
                        {{ __('Submit') }}
                    </button>
                </div>
            </div>
        </form>
        <p class="mb-1">
            <a href="{{route('login')}}">Login</a>
        </p>
    </div>
</div>
@endsection