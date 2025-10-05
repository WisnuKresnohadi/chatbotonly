@extends('partials_auth.register_mitra')
@section('conten')

    <form method="POST" action="{{ url('company/register') }}">
        @csrf
        <div class="row">
            <div class="col mb-2 form-input">
                <label for="roleregister" class="form-label mt-3">Silahkan Pilih Role Untuk Registrasi</label>
                <select class="form-select select2" id="roleregister" name="roleregister" data-placeholder="Pilih Role Anda Terlebih Dahulu" onchange="redirectToPage()">
                    <option value="mitra">Company</option>
                    <option value="user">Mahasiswa</option>
                </select>
            </div>
        </div>

        {{-- form-control --}}
        <div class="form-group">
            <div class="col">
                <label for="name" class="form-label mt-3">{{ __('Nama Penanggung Jawab Perusahaan') }}</label>

                <div class="md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" placeholder="Masukkan Nama" autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col">
                <label for="namaindustri" class="form-label mt-3">{{ __('Nama Instansi/Perusahaan') }}</label>
                <div class="md-6">
                    <input id="namaindustri" type="text" class="form-control @error('namaindustri') is-invalid @enderror" name="namaindustri" value="{{ old('namaindustri') }}"  autocomplete="namaindustri" placeholder="Masukkan nama perusahaan/instansi" autofocus>

                    @error('namaindustri')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        {{-- form-control --}}
        <div class="form-group">
            <div class="col">
                <label for="email" class="form-label mt-3">{{ __('Email Penanggung Jawab') }}</label>

                <div class="md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" placeholder="Enter your Email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        {{-- form-control --}}
        <div class="form-group">
            <div class="col">
                <label for="notelpon" class="form-label mt-3">{{ __('No Hp ') }}</label>

                <div class="md-6">
                    <input id="notelpon" type="numeric" class="form-control @error('notelpon') is-invalid @enderror" name="notelpon" value="{{ old('notelpon') }}" autocomplete="notelpon" placeholder="No. Hp Penanggung Jawab" autofocus>

                    @error('notelpon')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        {{-- form-control --}}
        <div class="mt-3">
            <div class="col-sm-12 mt-4">
            <button type="submit" onclick="success()" class="btn btn-primary d-grid w-100" style="background: var(--primary-500-base, #4EA971);">Buat Akun</button>
            </div>
        </div>
    </form>
@endsection
@section('page_script')
    <script>
        function redirectToPage() {
            
        }
    </script>
@endsection
