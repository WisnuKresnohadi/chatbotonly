<div class="tab-pane fade show" id="navs-pills-justified-dokumen-pendukung" role="tabpanel">
    <div class="card mb-4">
        <div class="d-flex justify-content-between border-bottom pt-3 ps-3 pe-3">
            <h5 class="text-secondary">Dokumen Pendukung</h5>
            <a class="cursor-pointer text-primary" data-bs-target="#modalTambahDokumen" data-bs-toggle="modal">
                <i class="ti ti-plus fw-bolder"></i>   
            </a>
        </div>
        <div class="card-body">
            <div class="d-flex flex-column" id="container-dokumen-pendukung">
                @include('profile/components/card_dokumen_pendukung')
            </div>
        </div>
    </div>
</div>
