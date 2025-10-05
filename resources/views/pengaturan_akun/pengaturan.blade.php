@extends('partials_mahasiswa.template')

@section('page_style')
<style>
  .hidden {
    display: none;
  }
  .btn-success {
      color: #fff;
      background-color: #4EA971 !important;
      border-color: #4EA971 !important;
    }
</style>

@endsection

@section('main')
<div class="sec-title mt-4 mb-3" style="margin-left:60px;">
  <h4>Pengaturan Akun</h4>
</div>
<div class="row ms-5 me-5 mb-5">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h6>Ubah Kata Sandi</h6>
        <div class="row g-3">
          <div class="col-md-4">
            <div class="form-password-toggle">
              <label class="form-label" for="multicol-password">Kata Sandi Saat Ini</label>
              <div class="input-group input-group-merge">
                <input type="password" id="multicol-password" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="multicol-password2" />
                <span class="input-group-text cursor-pointer" id="multicol-password2"><i class="ti ti-eye-off"></i></span>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-password-toggle">
              <label class="form-label" for="multicol-confirm-password">Kata Sandi Baru</label>
              <div class="input-group input-group-merge">
                <input type="password" id="multicol-confirm-password" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="multicol-confirm-password2" />
                <span class="input-group-text cursor-pointer" id="multicol-confirm-password2"><i class="ti ti-eye-off"></i></span>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-password-toggle">
              <label class="form-label" for="multicol-confirm-password">Konfirmasi Kata Sandi Baru</label>
              <div class="input-group input-group-merge">
                <input type="password" id="multicol-confirm-password" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="multicol-confirm-password2" />
                <span class="input-group-text cursor-pointer" id="multicol-confirm-password2"><i class="ti ti-eye-off"></i></span>
              </div>
            </div>
          </div>
        </div>
        <div class="text-end">
          <button type="submit" class="btn btn-success waves-effect waves-light mt-3">Simpan</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row ms-5 me-5 mb-5">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h6>Ubah Email</h6>
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label" for="multicol-username">Email Saat Ini</label>
            <input type="text" id="multicol-username" class="form-control" placeholder="Email Saat Ini" />
          </div>
          <div class="col-md-6">
            <label class="form-label" for="multicol-username">Email Baru</label>
            <input type="text" id="multicol-username" class="form-control" placeholder="Email Baru" />
          </div>
          <div class="text-end">
            <button type="submit" class="btn btn-success waves-effect waves-light mt-3">Simpan</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection

@section('page_script')
<script>


</script>
@endsection