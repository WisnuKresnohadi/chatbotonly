<div class="tab-pane fade show" id="navs-pills-justified-informasi-tambahan" role="tabpanel">
    <div class="card mb-4">
        <div class="d-flex justify-content-between border-bottom pt-3 ps-3 pe-3">
            <h5 class="text-secondary">Informasi Tambahan</h5>
            <a class="cursor-pointer text-warning" onclick="editData($(this))" data-target-modal="modalEditInformasiTambahan">
                <i class="ti ti-edit"></i>
            </a>
        </div>
        <div class="card-body pb-0">
            <div class="d-flex flex-column mb-2" id="container-informasi-tambahan">
                @include('profile/components/detail_info_tambahan')
            </div>
        </div>
    </div>
</div>