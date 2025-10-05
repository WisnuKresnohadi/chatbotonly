<!DOCTYPE html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

</head>
<body>
    <div class="container" style="margin-top: 50px">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ __('Set-Password Baru') }}</div>

                    <div class="card-body">
                        <form action="{{ url('mitra/set-password') }}" method="POST">
                            @csrf
                    
                            <!-- Password Reset Token -->
                            <input type="hidden" name="token" value="{{ $token }}">
                            
                            <div class="form-group m-2">
                                <label for="password">{{ __('Password baru') }}</label>
                                <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                    
                            <div class="form-group m-2">
                                <label for="password_confirmation">Konfirmasi Password:</label>
                                <input class="form-control @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation" required>
                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                    
                            <div class="form-group m-2">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Setel Ulang Kata Sandi') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>