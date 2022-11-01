@extends('template.forecourt-form')

@section('content')
<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">Reset Password</p>
        <form action="{{route('post.reset.password')}}" method="POST">
            @csrf
            <input type="hidden" name="reset-token" value="{{$token}}">
            <div class="input-group mb-3">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-key"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="current-password" placeholder="Password Confirmation">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-key"></span>
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
    </div>
</div>
@endsection