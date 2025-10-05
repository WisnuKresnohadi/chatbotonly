<style>
    span.select2-dropdown.select2-dropdown--below {
        width: auto !important;
        max-width: 200px !important; 
        position: relative !important;
    }
</style>
<div class="offcanvas offcanvas-end" tabindex="-1" id="detail_pelamar_offcanvas" style="width: 45%;">
    <div class="offcanvas-header">
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        {{-- <div class="d-flex justify-content-end w-100">
            <button class="btn btn-sm btn-primary" type="button">
                <i class="tf-icons ti ti-file-symlink me-2"></i>
                Unduh Format CV
            </button>
            <div class="col-8" style="max-width:230px;">
                <select name="change_status" id="change_status" class="select2 form-select form-select-sm" data-placeholder="Ubah Status" disabled>
                    <option value="" disabled selected>Ubah Status</option>
                    @foreach ($listStatus as $key => $item)
                        <option value="{{ $item['value'] }}">{{ $item['label'] }}</option>
                    @endforeach
                </select>
            </div>
        </div> --}}
    </div>
    <div class="offcanvas-body pt-1 flex-grow-0 h-100" id="container_detail_pelamar"></div>
</div>