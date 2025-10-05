@extends('partials.guest')

@section('content')
<div class="authentication-wrapper authentication-cover authentication-bg" style="background-image: url({{ asset('app-assets/img/branding/bg_password.png') }});background-size: cover; background-repeat: no-repeat; min-width:100%;">
    <div class="authentication-inner row">
        <div class="p-4 d-flex col-12 align-items-center p-sm-5">
            <div class="mx-auto w-px-400">
                @yield('conten')
                <div class="text-center card" style="width: 450px;">
                    <div class="card-header">
                        <div class="text-center">
                            <img src="{{ asset('app-assets/img/branding/Talentern.png') }}" style="width:250px">
                        </div>
                    </div>
                    <form id="updatePasswordForm" action="{{ route('register.set-password.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{$token}}">
                        <div class="text-start ps-5 pe-5">
                            <h5>Silakan buat kata sandi anda</h5>
                            @error('token')
                            <div class="alert alert-danger fw-semibold" role="alert">{{ $message }}</div>
                            @enderror
                            <div class="mb-3 ">
                                <label class="form-label">Email <span style="color: red;">*</span> </label>
                                <div class="input-group">
                                    <input id="email" type="text" class="form-control @error('password') is-invalid @enderror" value="{{ $email }}" disabled>
                                </div>
                                @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 ">
                                <label class="form-label">Kata sandi <span style="color: red;">*</span> </label>
                                <div class="form-password-toggle">
                                    <div class="input-group">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Kata sandi" autocomplete="current-password">
                                        <span id="basic-default-password2" class="cursor-pointer input-group-text"><i class="ti ti-eye-off"></i></span>
                                    </div>
                                </div>
                                @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 ">
                                <label class="form-label">Konfirmasi Kata sandi <span style="color: red;">*</span> </label>
                                <div class="form-password-toggle">
                                    <div class="input-group">
                                        <input id="password_confirmation" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" placeholder="Konfirmasi Kata sandi">
                                        <span id="basic-default-password2" class="cursor-pointer input-group-text"><i class="ti ti-eye-off"></i></span>
                                    </div>
                                </div>
                                @error('password_confirmation')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <h6>Password Requirements:</h6>
                            <li>Panjang minimal 8 karakter</li>
                            <li>Setidaknya satu karakter huruf kecil</li>
                            <li>Setidaknya satu angka, simbol atau karakter</li>
                        </div>
                        <button type="submit" class="m-5 btn btn-primary">Atur kata sandi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
