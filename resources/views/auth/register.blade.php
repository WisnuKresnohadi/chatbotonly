@extends('partials.guest')

@section('content')
    <div class="authentication-wrapper authentication-cover authentication-bg">
        <div class="authentication-inner row">
            <!-- Register -->
            <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
                <div class="w-px-400 mx-auto">
                    <!-- Logo -->
                    <div class="logo mr-3"><a href="{{ url('/') }}"><img src={{ asset('app-assets/img/logo_talentern.svg') }} alt="icon" style="margin-bottom: 10px;" width="auto" height="35px"></a></div>
                    <h3 class="mb-1 fw-bold">Selamat Datang Di Talentern!👋</h3>
                    <p class="mb-4" style="font-size: 10pt">Silahkan melakukan pendaftaran dengan mengisi data diri berikut</p>
                    <!-- /Logo -->

                    <form method="POST" action="{{ url('register') }}">
                        @csrf
                        <div class="row">
                            <div class="col-12 form-group">
                                <label for="roleregister" class="form-label">Role Registrasi</label>
                                <select class="form-select select2 @error('roleregister') is-invalid @enderror" id="roleregister" name="roleregister" data-placeholder="Pilih Role Anda Terlebih Dahulu" onchange="loadField('clear');" autofocus>
                                    <option disabled selected value="">Pilih Role Anda Terlebih Dahulu</option>
                                    <option value="dosen" @selected(old('roleregister') == 'dosen')>Dosen</option>
                                    <option value="user" @selected(old('roleregister') == 'user')>Mahasiswa</option>
                                    <option value="mitra" @selected(old('roleregister') == 'mitra')>Company</option>
                                </select>
                                @error('roleregister')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="dosen-section" style="display: none;">
                                <div class="col-12 mt-2 form-group">
                                    <label for="nip" class="form-label">NIP</label>
                                    <input id="nip" type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" autocomplete="nip" value="{{ old('nip') }}" placeholder="Masukkan NIP">
                                    @error('nip')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mahasiswa-section" style="display: none;">
                                <div class="col-12 mt-2 form-group">
                                    <label for="nim" class="form-label">NIM</label>
                                    <input id="nim" type="text" class="form-control @error('nim') is-invalid @enderror" name="nim" autocomplete="nim" value="{{ old('nim') }}" placeholder="Masukkan NIM">
                                    @error('nim')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="company-section" style="display: none;">
                                <div class="col-12 mt-2 form-group">
                                    <label for="namaindustri" class="form-label">Nama Instansi/Perusahaan</label>
                                    <input id="namaindustri" type="text" class="form-control @error('namaindustri') is-invalid @enderror" name="namaindustri" autocomplete="namaindustri" value="{{ old('namaindustri') }}" placeholder="Masukkan Nama Instansi/Perusahaan">
                                    @error('namaindustri')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 mt-2 form-group">
                                    <label for="name" class="form-label">Nama Penanggung Jawab Perusahaan</label>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" autocomplete="name" value="{{ old('name') }}" placeholder="Masukkan Nama Penanggung Jawab">
                                    @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 mt-2 form-group">
                                    <label for="email" class="form-label">Email Penanggung Jawab</label>
                                    <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" autocomplete="email" value="{{ old('email') }}" placeholder="Masukkan Email Penanggung Jawab">
                                    @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 mt-2 form-group">
                                    <label for="notelpon" class="form-label">No Hp Penanggung Jawab</label>
                                    <input id="notelpon" type="text" class="form-control @error('notelpon') is-invalid @enderror" name="notelpon" autocomplete="notelpon" value="{{ old('notelpon') }}" placeholder="Masukkan No Hp Penanggung Jawab">
                                    @error('notelpon')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 mt-2 form-group">
                                    <label for="kategori_industri" class="form-label">Kategori Mitra</label>
                                    <select class="form-select select2 @error('kategori_industri') is-invalid @enderror" id="kategori_industri" name="kategori_industri" data-placeholder="Pilih Kategori Industri">
                                        <option disabled selected value="">Pilih Status Kerjasama</option>
                                        <option value="Internal" @selected(old('kategori_industri') == 'Internal')>Internal</option>
                                        <option value="Eksternal" @selected(old('kategori_industri') == 'Eksternal')>Eksternal</option>
                                    </select>
                                    @error('kategori_industri')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 mt-2 form-group">
                                    <label for="statuskerjasama" class="form-label">Status Kerjasama</label>
                                    <select class="form-select select2 @error('statuskerjasama') is-invalid @enderror" id="statuskerjasama" name="statuskerjasama" data-placeholder="Pilih Status Kerjasama">
                                        <option disabled selected value="">Pilih Status Kerjasama</option>
                                        <option value="Iya" @selected(old('statuskerjasama') == 'Iya')>Iya</option>
                                        <option value="Tidak" @selected(old('statuskerjasama') == 'Tidak')>Tidak</option>
                                    </select>
                                    @error('statuskerjasama')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <div class="col-sm-12 mt-4">
                                <button id="modal-button" type="submit" class="btn btn-primary d-grid w-100" name="register">Buat Akun</button>
                            </div>
                            <div class="col-sm-12 mt-2">
                                <a href="{{ url('/') }}" class="btn btn-outline-primary w-100">
                                    <i class="ti ti-arrow-left me-2 text-primary"></i> {{ __('Back to Landing page') }}
                                </a>
                            </div>
                        </div>
                    </form>

                    <p class="text-center mt-2">
                        <span>Already have an account?</span>
                        <a href="{{ route('login') }}">
                            <span>Sign in instead</span>
                        </a>
                    </p>
                </div>
            </div>
            <!-- /Register -->
            <!-- /Left Text -->
            <div class="d-none d-lg-flex col-lg-7 p-0">
                <div class="auth-cover-bg d-flex justify-content-center align-items-center" style="margin-right: 30px">
                    <img alt="auth-login-cover" class="img-fluid my-5 auth-illustration" style="background-image "
                        src="{{ asset('assets/images/background/register.svg') }}" alt="Login" />
                </div>
            </div>
            <!-- /Left Text -->
        </div>
    </div>
@endsection

@section('page_script')
<script>
    $(document).ready(function () {
        loadField('load_all');

        $('select.select2').each(function () {
            if ($(this).hasClass("select2-hidden-accessible")) {
                $(this).removeClass('select2-hidden-accessible').next('.select2-container').remove();
                $(this).removeAttr('data-select2-id tabindex aria-hidden');
                $(this).parent().removeAttr('data-select2-id');
            }

            if (!$(this).parent().hasClass('position-relative')) $(this).wrap('<div class="position-relative"></div>');

            $(this).select2({
                minimumResultsForSearch: Infinity,
                placeholder: $(this).attr('data-placeholder') ?? null,
                dropdownAutoWidth: true,
                width: '100%',
                dropdownParent: $(this).parent(),
            });
        });
    });

    function loadField(section = 'load_all') {
        let role = $('#roleregister').val();

        if (section != 'load_all') {
            $('form').find('.is-invalid').removeClass('is-invalid');
            $('form').find('.invalid-feedback').html(null).removeClass('d-block');
        }

        if (role == 'dosen') {
            $('.dosen-section').show();
            $('.mahasiswa-section').hide();
            $('.company-section').hide();
        } else if (role == 'user') {
            $('.dosen-section').hide();
            $('.mahasiswa-section').show();
            $('.company-section').hide();
        } else if (role == 'mitra') {
            $('.dosen-section').hide();
            $('.mahasiswa-section').hide();
            $('.company-section').show();
        }
    }
</script>
@endSection
