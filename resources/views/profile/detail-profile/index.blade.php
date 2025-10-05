@extends('partials.vertical_menu')
@section('content')
    <div class="nav-align-top mb-4">
        <ul class="nav nav-pills mb-3" role="tablist">
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                    data-bs-target="#nav-informasi-pribadi" aria-controls="nav-informasi-pribadi" aria-selected="true">
                    <i class="ti ti-news"></i>
                    Informasi Pribadi
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                    data-bs-target="#nav-ubah-password" aria-controls="nav-ubah-password" aria-selected="false"
                    tabindex="-1">
                    <i class="ti ti-key"></i>
                    Ubah Password
                </button>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade active show" id="nav-informasi-pribadi" role="tabpanel">
                @include('profile.detail-profile.profile-content')            
            </div>
            <div class="tab-pane fade" id="nav-ubah-password" role="tabpanel">
                @include('profile.detail-profile.ubah-password')      
            </div>
        </div>
    </div>
    @include('profile.detail-profile.ubah-profile')
@endsection

@section('page_script')
    <script>
        function getData() {
            let modal = $('#largeModal');
            $.ajax({
                url: `{{ route('profile_detail.show') }}`,
                type: 'GET',
                success: function(response) {
                    res = response.data;
                    $.each(res, function(key, value) {
                        let elementGetted = $(`[name="${key}"]`);
                        if (elementGetted.is('select')) {
                            elementGetted.html(`<option>${value}</option>`);
                        }
                        elementGetted.val(value).change();
                    });
                }
            });
            modal.modal('show');
        }

        function afterAction(response) {
            $('#container-detail').html(response.data.view);
            $('#largeModal').modal('hide');
        }

        function afterChangePassword(response) {
            $('#container-change-password').find('input').val(null).change();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const toggleButtons = document.querySelectorAll('.toggle-password');

            const svgVisible =
                `<svg width="22" height="16" viewBox="0 0 22 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11 5C10.2044 5 9.44129 5.31607 8.87868 5.87868C8.31607 6.44129 8 7.20435 8 8C8 8.79565 8.31607 9.55871 8.87868 10.1213C9.44129 10.6839 10.2044 11 11 11C11.7956 11 12.5587 10.6839 13.1213 10.1213C13.6839 9.55871 14 8.79565 14 8C14 7.20435 13.6839 6.44129 13.1213 5.87868C12.5587 5.31607 11.7956 5 11 5ZM11 13C9.67392 13 8.40215 12.4732 7.46447 11.5355C6.52678 10.5979 6 9.32608 6 8C6 6.67392 6.52678 5.40215 7.46447 4.46447C8.40215 3.52678 9.67392 3 11 3C12.3261 3 13.5979 3.52678 14.5355 4.46447C15.4732 5.40215 16 6.67392 16 8C16 9.32608 15.4732 10.5979 14.5355 11.5355C13.5979 12.4732 12.3261 13 11 13ZM11 0.5C6 0.5 1.73 3.61 0 8C1.73 12.39 6 15.5 11 15.5C16 15.5 20.27 12.39 22 8C20.27 3.61 16 0.5 11 0.5Z" fill="#535353"/></svg>`;

            const svgHidden =
                `<svg width="22" height="19" viewBox="0 0 22 19" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.83 6L14 9.16V9C14 8.20435 13.6839 7.44129 13.1213 6.87868C12.5587 6.31607 11.7956 6 11 6H10.83ZM6.53 6.8L8.08 8.35C8.03 8.56 8 8.77 8 9C8 9.79565 8.31607 10.5587 8.87868 11.1213C9.44129 11.6839 10.2044 12 11 12C11.22 12 11.44 11.97 11.65 11.92L13.2 13.47C12.53 13.8 11.79 14 11 14C9.67392 14 8.40215 13.4732 7.46447 12.5355C6.52678 11.5979 6 10.3261 6 9C6 8.21 6.2 7.47 6.53 6.8ZM1 1.27L3.28 3.55L3.73 4C2.08 5.3 0.78 7 0 9C1.73 13.39 6 16.5 11 16.5C12.55 16.5 14.03 16.2 15.38 15.66L15.81 16.08L18.73 19L20 17.73L2.27 0M11 4C12.3261 4 13.5979 4.52678 14.5355 5.46447C15.4732 6.40215 16 7.67392 16 9C16 9.64 15.87 10.26 15.64 10.82L18.57 13.75C20.07 12.5 21.27 10.86 22 9C20.27 4.61 16 1.5 11 1.5C9.6 1.5 8.26 1.75 7 2.2L9.17 4.35C9.74 4.13 10.35 4 11 4Z" fill="#535353"/></svg>`;

            const passwordInputs = document.querySelectorAll('input[type="password"]');

            toggleButtons.forEach(button => {
                const input = button.previousElementSibling;
                button.style.display = 'none'
                // Add input event listener to show/hide button based on input content
                input.addEventListener('input', function() {
                    button.style.display = this.value ? 'block' : 'none';
                });

                button.addEventListener('click', function() {
                    if (input.type === 'password') {
                        input.type = 'text';
                        this.innerHTML = svgVisible;
                    } else {
                        input.type = 'password';
                        this.innerHTML = svgHidden;
                    }
                });
            });

            $('#changePicture').on('change', function(event) {
                $('#container-change-image').find(`[name="foto"]`).removeClass('is-invalid');
                $('#container-change-image').find(`[name="foto"]`).parents('.form-group').find('.invalid-feedback').removeClass('d-block');

                let file = event.target.files[0];
                if (file) {
                    let fd = new FormData();
                    fd.append('_token', '{{ csrf_token() }}');
                    fd.append('foto', file);

                    $.ajax({
                        url: `{{ route('profile_detail.ganti_foto') }}`,
                        type: 'POST',
                        cache: false,
                        processData: false,
                        contentType: false,
                        data: fd,
                        success: function(result) {
                            $('.profile-pic').attr('src', URL.createObjectURL(file));
                        },
                        error: function(xhr, status, error) {
                            let res = xhr.responseJSON;
                            if (res.errors) {
                                $.each(res.errors, function(key, value) {
                                    if ($('#container-change-image').find(`[name="foto"]`).length > 0) {
                                        $('#container-change-image').find(`[name="foto"]`).addClass('is-invalid');
                                        $('#container-change-image').find(`[name="foto"]`).parents('.form-group').find('.invalid-feedback').html(value[0]).addClass('d-block');
                                    }
                                });
                            } else {
                                showSweetAlert({
                                    title: 'Gagal!',
                                    text: res.message,
                                    icon: 'error'
                                });
                            }
                        }
                    });
                }
            });
        });

        function deleteImage() {
            sweetAlertConfirm({
                title: 'Apakah anda yakin?',
                text: 'Ingin menghapus foto ini.',
                icon: 'warning',
                confirmButtonText: 'Ya, saya yakin!',
                cancelButtonText: 'Batal'
            }, function() {
                $.ajax({
                    url: `{{ route('profile_detail.delete_foto') }}`,
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'hapus': 'hapus',
                    },
                    success: function(data) {
                        $('.profile-pic').attr('src', "{{ asset('app-assets/img/avatars/user.png') }}");
                    }
                });
            });
        }
    </script>
@endsection
