@extends('partials_admin.template')

@section('meta_header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('page_style')
    <link rel="stylesheet" href="../../app-assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <style>
        .swal2-icon {
            border-color: transparent !important;
        }

        .swal2-title {
            font-size: 20px !important;
            text-align: center !important;
            margin-top: 0px !important;
            margin-bottom: 0px !important;
        }

        .swal2-modal.swal2-popup .swal2-title {
            max-width: 100% !important;
        }

        .swal2-html-container {
            font-size: 16px !important;
        }
    </style>
@endsection

@section('main')
    <div class="col-md-12" id="modal-mitraa">
        <h4 class="fw-bold py-3 mb-4">Profil Perusahaan</h4>
        <div class="card mb-4">
            <form action="{{ url('company/profile-company/' . $industri->id_industri) }}" class="default-form"
                autocomplete="off" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <h5 class="card-header">Informasi Dasar Perusahaan</h5>
                <!-- Account -->
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        @if ($industri->image)
                            <img src="{{ asset('storage/' . $industri->image) }}" alt="user-avatar"
                                class="d-block w-px-100 h-px-100 rounded" id="imgPreview">
                        @else
                            <img src="../../app-assets/img/avatars/14.png" alt="user-avatar"
                                class="d-block w-px-100 h-px-100 rounded" id="imgPreview">
                        @endif
                        <div class="button-wrapper">
                            <label for="changePicture" class="btn btn-white text-success me-2 mb-3 waves-effect waves-light"
                                tabindex="0">
                                <i class="ti ti-upload d-block pe-2"></i>
                                <span class="d-none d-sm-block">Unggah Baru Logo Perusahaan</span>
                                <input type="file" id="changePicture" name="image" class="account-file-input" hidden
                                    accept="image/png, image/jpeg">
                            </label>
                            <button type="button" class="btn btn-white text-danger account-image-reset mb-3 waves-effect"
                                onclick="removeImage()">
                                <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Remove</span>
                            </button>

                            <div class="text-muted">Format FIle JPG, GIF atau PNG. Ukuran Maksimal 800KB</div>
                        </div>
                    </div>
                </div>
                <hr class="my-0">
                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 col-md-12 fv-plugins-icon-container">
                            <label for="namaperusahaan" class="form-label">Nama Perusahaan <span
                                    class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="namaindustri" name="namaindustri"
                                placeholder="Nama Perusahaan" readonly autofocus="" value="{{ $industri->namaindustri }}">
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                        <div class="mb-3 col-md-12 fv-plugins-icon-container">
                            <label for="alamat" class="form-label">Alamat Perusahaan <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control" rows="2" placeholder="Masukan Alamat Perusahaan" id="alamatindustri"
                                name="alamatindustri"></textarea>
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                        <div class="mb-3 col-md-12 fv-plugins-icon-container">
                            <label for="deskripsi" class="form-label">Deskripsi Perusahaan <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control" rows="2" placeholder="Masukan Deskripsi Perusahaan" id="description"
                                name="description"></textarea>
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="border rounded p-3">
                        <label class="form-label">Kontak Perusahaan</label>
                        <div class="mb-3 col-md-12 fv-plugins-icon-container">
                            <label for="notelp" class="form-label">No. Telepon Perusahaan <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="notelpon"
                                name="notelpon"placeholder="Masukan Nomor Telepon" aria-describedby="floatingInputHelp">
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                            <label for="lastName" class="form-label">E-mail Perusahaan <span
                                    class="text-danger">*</span></label>
                            <input type="text" id="email" name="email" class="form-control"
                                placeholder="Masukan E-mail Perusahaan" aria-label="john.doe"
                                aria-describedby="basic-default-email2" readonly value="{{ $industri->email }}">
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="modal-button" class="btn btn-success me-2">Simpan Data</button>
                </div>
                <input type="hidden">
            </form>
        </div>
    </div>
    <!-- /Account -->
    </div>
    </div>

    <script>
        changePicture.onchange = evt => {
            const [file] = changePicture.files
            if (file) {
                imgPreview.src = URL.createObjectURL(file)
            } else {
                imgPreview.src = "../../app-assets/img/avatars/14.png"
            }
        }

        function edit(e) {
            let id = e.attr('data-id');

            let action = `{{ url('company/kelola-mitra/update/') }}/${id}`;
            var url = `{{ url('company/kelola-mitra/edit/') }}/${id}`;
            $.ajax({
                type: 'GET',
                url: url,
                success: function(response) {
                    $("#simpanButton").html("Update Data");
                    $('#modal-mitraa form').attr('action', action);
                    $('#nama').val(response.namaindustri);
                    $('#email').val(response.email);
                    $('#alamatindustri').val(response.alamatindustri);
                    $('#notelpon').val(response.notelpon);
                    $('#kategori').val(response.kategori_industri).trigger('change');
                    $('#statuskerjasama').val(response.statuskerjasama).trigger('change');
                }
            });
        }

        function removeImage() {
            // Hapus kode yang tidak diperlukan di sini

            // Ganti foto dengan sumber aset yang diinginkan
            document.getElementById('imgPreview').src = "{{ asset('storage/' . $industri->image) }}";
        }

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.default-form');
            const modalButton = document.getElementById('modal-button');

            modalButton.addEventListener('click', function(event) {
                event.preventDefault(); // Mencegah tindakan default tombol submit

                // Kirim formulir menggunakan AJAX
                fetch(form.action, {
                        method: 'PUT',
                        body: new FormData(form)
                    })
                    .then(response => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Data berhasil disimpan',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            window.location.href =
                                '{{ url('company/summary-profile') }}';
                        });

                    })
            });
        });
    </script>
@endsection

@section('page_script')
    <script src="{{ url('app-assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ url('app-assets/js/extended-ui-sweetalert2.js') }}"></script>
@endsection
