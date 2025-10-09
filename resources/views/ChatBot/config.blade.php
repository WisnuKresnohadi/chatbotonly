    @extends("partials.horizontal_menu")
    @section('content')
    <div class = "container-xxl flex-grow-1 container-p-y">
        <button
    class="button-kembali"
    onclick="history.back()"
    style="width: 126px;
        height: 38px;
        border-radius: 6px;
        border-width: 1px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4EA971;
        gap: 8px;
        background-color: white;
        border-color: #4EA971;
        cursor: pointer;

        "
    >
    <i class="fas fa-arrow-left"></i>
        Kembali
    </button>
        <form action="{{ route('wawancara-flow.editconfig', $id_lowongan) }}" method="POST">
            @csrf
    <div class="persyaratan-tambahan-repeater col-lg-12 col-sm-6 form-group" data-limit="3">
        <div class="px-3 pt-2 pb-3">
            {{-- Softskill select --}}
            <div class="mb-3 col-12 form-group">
                <label for="softskill" class="form-label">
                    Softskills yang akan digali lebih dalam (minimal 1 dan maksimal 3)<span style="color: red;">*</span>
                </label>
                <select class="form-select select2" name="softskill[]" id="softskill" data-placeholder="Pilih Soft Skills" data-tags="true" multiple>
                    <option value="Adaptasi">Adaptasi</option>
                    <option value="Komunikasi">Komunikasi</option>
                    <option value="Kepemimpinan">Kepemimpinan</option>
                    <option value="Kepercayaan Diri">Kepercayaan Diri</option>
                    <option value="Manajemen Waktu">Manajemen Waktu</option>
                    <option value="Pemecahan Masalah">Pemecahan Masalah</option>
                </select>
            </div>

            {{-- Repeater --}}
            <div data-repeater-list="persyaratan_tambahan">
                <div data-repeater-item>
                    <div class="gap-3 mb-3 justify-content-between d-flex">
                        <div class="w-100">
                            <h6>Pertanyaan Tambahan</h6>
                            <label class="form-label">Pertanyaan tambahan tidak akan diproses sebagai penilaian...</label>
                            <input type="text" name="persyaratan_tambah" class="form-control" placeholder="Tulis Pertanyaan">
                        </div>
                        <button type="button" class="mt-4 btn btn-outline-danger" data-repeater-delete>
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-4 border-top">
                <button class="mt-4 btn btn-outline-warning" type="button" data-repeater-create>
                    <i class="ti ti-plus me-1"></i>
                    <span class="align-middle">Pertanyaan</span>
                </button>
            </div>

            <button type="submit" class="btn btn-primary mt-2">Config Chatbot</button>
        </div>
    </div>
</form>
</div>
@endsection

@section('page_script')
    <script>
    $(document).ready(function() {
        initFormPersyaratanTambahanRepeater();
        initSoftskillSelect();
    });
    let formRepeater = $('.persyaratan-tambahan-repeater');

        function initFormPersyaratanTambahanRepeater() {
            var row = 2;
            var col = 1;

            if (formRepeater.length == 0) return;

            formRepeater.repeater({
                show: function() {
                    let dataCallback = $(this).attr('data-callback');
                    if (typeof window[dataCallback] === "function") window[dataCallback](this);

                    var fromControl = $(this).find('.form-control, .form-select, .form-check-input');
                    var formLabel = $(this).find('.form-label, .form-check-label');

                    fromControl.each(function(i) {
                        if (!$(this).hasClass('flatpickr-date')) {
                            var id = 'form-repeater-' + row + '-' + col;
                            $(fromControl[i]).attr('id', id);
                            $(formLabel[i]).attr('for', id);
                            col++;
                        }
                    });

                    row++;

                    var limitcount = $(this).parents(".persyaratan-tambahan-repeater").data("limit");
                    var itemcount = $('[data-repeater-list="persyaratan_tambahan"] [data-repeater-item]').length

                    if (limitcount) {
                        if (itemcount <= limitcount) {
                            $(this).slideDown();
                        } else {
                            $(this).remove();
                        }
                    } else {
                        $(this).slideDown();
                    }

                    if (itemcount >= limitcount) {
                        $(".persyaratan-tambahan-repeater [data-repeater-create]").parent().addClass("d-none");
                    }
                },
                hide: function(e) {
                    var limitcount = $(this).parents(".persyaratan-tambahan-repeater").data("limit");
                    var itemcount = $('[data-repeater-list="persyaratan_tambahan"] [data-repeater-item]')
                        .length;

                    const element = $(this)
                    sweetAlertConfirm({
                        title: 'Apakah Anda yakin ingin menghapus pertanyaan ini?',
                        text: "",
                        icon: 'warning',
                        confirmButtonText: 'Ya, saya yakin!',
                        cancelButtonText: 'Batal'
                    }, function() {
                        let dataCallback = $(this).attr('data-callback');
                        if (typeof window[dataCallback] === "function") window[dataCallback](this);
                        element.slideUp(e);
                        if (itemcount <= limitcount) {
                            $(".persyaratan-tambahan-repeater [data-repeater-create]").parent()
                                .removeClass('d-none');
                        }
                    })
                },
                isFirstItemUndeletable: true
            });

        }
        function initSoftskillSelect() {
        let $select = $('#softskill');

        $select.select2({
            maximumSelectionLength: 3,
            placeholder: "Pilih Soft Skills"
        });

        // When selecting
        $select.on('select2:select', function () {
            let selected = $(this).val() || [];
            if (selected.length >= 3) {
                $select.find('option:not(:selected)').prop('disabled', true);
            } else {
                $select.find('option').prop('disabled', false);
            }
            $select.trigger('change.select2');
        });

        // When unselecting
        $select.on('select2:unselect', function () {
            $select.find('option').prop('disabled', false);
            $select.trigger('change.select2');
        });
    }
</script>
@endsection


