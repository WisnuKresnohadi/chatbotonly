<div class="mx-3">
    <h4>{{ $title }}</h4>
    <div class="border rounded mb-4">
        <div class="mx-4" id="container-change-password">
            <h5 class="border-bottom font-light text-secondary mb-4 py-3">Ubah Password</h5>
            <form class="default-form" action="{{ route('profile_detail.change_password') }}" function-callback="afterChangePassword">
                @csrf
                <div class="row">
                    <div class="col-12 mb-3 form-group">
                        <label for="form-label">Password Saat Ini<span class="text-danger">*</span></label>
                        <input class="form-control" type="password" name="current_password" id="current_password">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-12 mb-3 form-group">
                        <label for="form-label">Password Baru<span class="text-danger">*</span></label>
                        <input class="form-control" type="password" name="new_password" id="new_password">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-12 mb-5 form-group">
                        <label for="form-label">Konfirmasi Password Baru<span class="text-danger">*</span></label>
                        <input class="form-control" type="password" name="new_password_confirmation" id="new_password_confirmation">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-12 mb-3">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
