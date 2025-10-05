<div class="card mb-4">
    <div class="card-body pb-0">
        <div class="d-flex justify-content-between border-bottom">
            <h5 class="text-secondary">Informasi Pribadi</h5>
            <a class="text-warning cursor-pointer" onclick="editData($(this));" data-target-modal="modalEditInformasi">
                <i class="menu-icon tf-icons ti ti-edit"></i>
            </a>
        </div>
        <div class="user-avatar-section">
            <div class="d-flex align-items-center flex-column">
                <div class="rounded-circle text-center my-4" style="overflow: hidden; width: 100px; height: 100px;">
                    @if ($mahasiswa->profile_picture)
                        <img src="{{ asset('storage/' . $mahasiswa->profile_picture) }}" alt="user-avatar" class="d-block" width="100" id="image_industri">
                    @else
                        <img src="{{ asset('app-assets/img/avatars/user.png') }}" alt="user-avatar" class="d-block" width="100" id="image_industri" data-default-src="{{ asset('app-assets/img/avatars/user.png') }}">
                    @endif
                </div>
                <div class="user-info text-center">
                    <h4 class="mb-2">{{ $mahasiswa->namamhs }}</h4>
                    {{-- <p>Rekomendasi posisi magang untuk anda</p>
                    <span class="badge bg-label-success mt-1">{{ $jobCategory }}</span> --}}
                </div>
            </div>
        </div>
        <div class="border-bottom mb-3">
            <p class="mt-4 mb-0">{{ $mahasiswa->deskripsi_diri }}</p>
        </div>
        <div class="info-container">
            <ul class="list-unstyled">
                <li class="mb-1">
                    <span class="fw-semibold me-1">NIM:</span>
                    <span>{{ $mahasiswa->nim }}</span>
                </li>
                <li class="mb-2 pt-1">
                    <span class="fw-semibold me-1">Universitas:</span>
                    <span>{{ $mahasiswa->univ->namauniv }}</span>
                </li>
                <li class="mb-2 pt-1">
                    <span class="fw-semibold me-1">Fakultas:</span>
                    <span>{{ $mahasiswa->fakultas->namafakultas }}</span>
                </li>
                <li class="mb-2 pt-1">
                    <span class="fw-semibold me-1">Program Studi:</span>
                    <span>{{ $mahasiswa->prodi->namaprodi }}</span>
                </li>
                <li class="mb-2 pt-1">
                    <span class="fw-semibold me-1">Dosen Wali:</span>
                    @php
                        $dosen = $mahasiswa->dosen_wali;
                    @endphp
                    <span>{{ $dosen->kode_dosen }} | {{ $dosen->namadosen }}</span>
                </li>
                <li class="mb-2 pt-1">
                    <span class="fw-semibold me-1">Angkatan:</span>
                    <span>{{ $mahasiswa->angkatan }}</span>
                </li>
                <li class="mb-2 pt-1">
                    <span class="fw-semibold me-1">IPK:</span>
                    <span>{{ $mahasiswa->ipk }}</span>
                </li>
                <li class="mb-2 pt-1">
                    <span class="fw-semibold me-1">Tes Bahasa:</span>
                    <span>{{ $mahasiswa->tesbahasa ? ($mahasiswa->tipetesbahasa . ' - ' . $mahasiswa->tesbahasa) : '-' }}</span>
                </li>
                <li class="mb-2 pt-1">
                    <span class="fw-semibold me-1">TAK:</span>
                    <span>{{ $mahasiswa->tak }}</span>
                </li>
                <li class="mb-2 pt-1">
                    <span class="fw-semibold me-1">Email:</span>
                    <span>{{ $mahasiswa->emailmhs }}</span>
                </li>
                <li class="mb-2 pt-1">
                    <span class="fw-semibold me-1">No.Telp:</span>
                    <span>{{ $mahasiswa->nohpmhs }}</span>
                </li>
                <li class="mb-2 pt-1">
                    <span class="fw-semibold me-1">Tanggal Lahir:</span>
                    <span>{{ $mahasiswa->tgl_lahir }}</span>
                </li>
                <li class="mb-2 pt-1">
                    <span class="fw-semibold me-1">Jenis Kelamin:</span>
                    <span>{{ $mahasiswa->gender }}</span>
                </li>
                <hr>
                <h5 class="my-3">Domisili</h5>
                @if($mahasiswa->kota_id != null)
                <li class="mb-2">
                    <span class="fw-semibold me-1">Warga Negara:</span>
                    <span>{{ $mahasiswa->kota->provinsi->negara->id == '1' ? 'WNI' : 'WNA' }}</span>
                </li>
                <li class="mb-2">
                    <span class="fw-semibold me-1">Negara:</span>
                    <span>{{ $mahasiswa->kota->provinsi->negara->name }}</span>
                </li>
                <li class="mb-2">
                    <span class="fw-semibold me-1">Provinsi:</span>
                    <span>{{ $mahasiswa->kota->provinsi->name }}</span>
                </li>
                <li class="mb-2">
                    <span class="fw-semibold me-1">Kota:</span>
                    <span>{{ $mahasiswa->kota->name }}</span>
                </li>
                @endif
                @if($mahasiswa->kodepos != null)
                <li class="mb-2">
                    <span class="fw-semibold me-1">Kode Pos:</span>
                    <span>{{ $mahasiswa->kodepos }}</span>
                </li>
                @endif
                <li class="mb-2">
                    <span class="fw-semibold me-1">Alamat:</span>
                    <span>{{ $mahasiswa->alamatmhs }}</span>
                </li>
            </ul>
        </div>
    </div>
</div>
