<div class="tab-pane fade show" id="navs-pills-justified-keahlian-pengalaman" role="tabpanel">
    <div class="card mb-4">
        <div class="card-body accordion" id="accordionExample">
            <div class="d-flex justify-content-between">
                <h5 class="text-secondary">Keahlian</h5>
                <div class="text-end">
                    <a href="javascript:void(0)" class="text-warning" onclick="editData($(this));" data-target-modal="modalTambahKeahlian">
                        <i class="ti ti-edit"></i>
                    </a>
                </div>
            </div>
            <div id="container-keahlian">
                @include('profile/components/badge_skills') 
            </div>
            <div class="border-bottom mt-3"></div>

            {{-- Pengalaman Proyek --}}
            <div class="d-flex justify-content-between pt-3 pb-3">
                <h5 class="text-secondary">Pengalaman Proyek</h5>
                <div class="text-end">
                    <a href="javascript:void(0)" class="cursor-pointer text-primary" data-bs-toggle="modal" data-bs-target="#modalTambahProyek">
                        <i class="ti ti-plus fw-bolder"></i>
                    </a>
                </div>
            </div>    
            <div id="container-project">
                @include('profile/components/timeline_pengalaman_proyek')
            </div>    
            {{-- Pengalaman Proyek --}}
            
            <div class="border-bottom mt-3"></div>

            {{-- Pengalaman Profesional --}}            
            <div class="d-flex justify-content-between pt-3 pb-3">
                <h5 class="text-secondary">Pengalaman Profesional</h5>
                <div class="text-end">
                    <a href="javascript:void(0)" class="cursor-pointer text-primary" data-bs-toggle="modal" data-bs-target="#modalTambahPengalaman">
                        <i class="ti ti-plus fw-bolder"></i>
                    </a>
                </div>
            </div>   
            <div id="container-pengalaman">
                @include('profile/components/timeline_pengalaman')
            </div>  
            {{-- Pengalaman Profesional --}}

            <div class="border-bottom mt-3"></div>
            
            {{-- Kompetisi --}}
            <div class="d-flex justify-content-between pt-3 pb-3">
                <h5 class="text-secondary">Kompetisi</h5>
                <div class="text-end">
                    <a href="javascript:void(0)" class="cursor-pointer text-primary" data-bs-toggle="modal" data-bs-target="#modalTambahKompetisi">
                        <i class="ti ti-plus fw-bolder"></i>
                    </a>
                </div>
            </div>   
            <div id="container-competition">
                @include('profile/components/timeline_kompetisi')
            </div>    
            {{-- Kompetisi --}}      
        </div>
    </div>
</div>


