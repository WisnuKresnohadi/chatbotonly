<div class="mx-3">
    <h4 class="">{{ $title }}</h4>
    <div id="profile" class="border rounded mb-4">
        <div class="mx-4">
            <h5 class="border-bottom font-light text-secondary mb-0 py-3">Foto Profile</h5>
            <div class="d-flex align-items-center my-4 py-1">
                <div class="rounded-circle w-px-100 h-px-100 text-center" style="overflow: hidden; width: 100px; height: 100px;">
                    @if ($user->foto)
                        <img src="{{ asset('storage/' . $user->foto) }}" alt="user-avatar" class="d-block profile-pic" width="100" id="photo_profile">
                    @else
                        <img src="{{ asset('app-assets/img/avatars/user.png') }}" alt="user-avatar" class="d-block profile-pic" width="100" id="photo_profile" data-default-src="{{ asset('app-assets/img/avatars/user.png') }}">
                    @endif
                </div>
                <div class="form-group">
                    <div class="d-flex mx-4 justify-content-start" id="container-change-image">
                        <label for="changePicture" class="btn btn-primary mx-0 btn-primary" id="btn-change-picture">
                            <i class="ti ti-upload  pe-2"></i>
                            <span class="d-none d-sm-block">Ganti</span>
                            <input type="file" id="changePicture" name="foto" class="form-control-file" hidden
                                accept="image/png, image/jpeg">
                        </label>
                        <button type="button" class="btn btn-danger mx-2" onclick="deleteImage()">
                            <i class="ti ti-refresh-dot d-sm-none"></i>
                            <span class="d-none d-sm-block">Hapus</span>
                        </button>
                    </div>
                    <div class="mx-4 invalid-feedback"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="about" class="border rounded mb-5">
        <div id="header_about" class="d-flex align-items-center justify-content-between border-bottom mx-4">
            <h5 class="mb-0 font-light text-secondary py-3">Informasi Pribadi dan Kontak</h5>
            <a class="cursor-pointer text-warning" href="javascript: void(0)" onclick="getData();">
                <i class="ti ti-edit ti-sm"></i>
            </a>
        </div>
        <div id="container-detail">
            @include('profile/detail-profile/components/card_detail')
        </div>
    </div>
</div>
