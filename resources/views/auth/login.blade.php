@extends('layouts.app')

@section('content')
<div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form method="POST" action="{{ route('login') }}">
            @csrf
              <h1>Login Form</h1>
              <div>
              <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
              </div>
              <div>
              <label for="password" class="col-md-2 col-form-label text-md-end">{{ __('Password') }}</label>
              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div>
              <button type="submit" class="btn btn-primary">
                    {{ __('Login') }}
                </button>
                <a class="reset_pass" href="#">Lost your password?</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Belum punya akun ?
                  <a href="{{ route('register') }}" class="to_register"> Daftar </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-paw"></i> DigitalLibrary!</h1>
                  <p>©2024 All Rights Reserved. Baradamanik. Privacy and Terms</p>
                </div>
              </div>
            </form>
          </section>
        </div>

@endsection
