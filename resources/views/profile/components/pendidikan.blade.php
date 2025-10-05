<div class="tab-pane fade show active" id="navs-pills-justified-pendidikan" role="tabpanel">
    <div class="card mb-4">
        <div class="d-flex justify-content-between border-bottom pt-3 ps-3 pe-3">
            <h5 class="text-secondary">Pendidikan</h5>
            <a href="#" class="cursor-pointer text-primary" data-bs-toggle="modal" data-bs-target="#modalTambahPendidikan">
                <i class="ti ti-plus fw-bolder"></i>
            </a>
        </div>
        <div class="card-body" id="container-pendidikan">
            @include('profile/components/timeline_pendidikan')
        </div>
    </div>
</div>
