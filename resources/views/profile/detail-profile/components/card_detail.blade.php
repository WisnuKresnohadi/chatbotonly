@if (auth()->user()->hasAnyRole(['Dosen', 'Kaprodi', 'Koordinator Magang']))
<div class="py-4 mx-4 row">
    <div class="px-0 col-7 row">
        <h5>Informasi Pribadi</h5>
        <div class="col-6">
            <p class="mb-1 fw-bolder">Universitas</p>
            <p>{{ $dosen->namauniv }}</p>
        </div>
        <div class="col-6">
            <p class="mb-1 fw-bolder">Fakultas</p>
            <p>{{ $dosen->namafakultas }}</p>
        </div>
        <div class="col-6">
            <p class="mb-1 fw-bolder">Program Studi</p>
            <p>{{ $dosen->namaprodi }}</p>
        </div>
        <div class="col-6">
            <p class="mb-1 fw-bolder">NIP</p>
            <p>{{ $dosen->nip }}</p>
        </div>
        <div class="col-6">
            <p class="mb-1 fw-bolder">Kode Dosen</p>
            <p>{{ $dosen->kode_dosen }}</p>
        </div>
        <div class="col-6">
            <p class="mb-1 fw-bolder">Nama Dosen</p>
            <p>{{ $dosen->namadosen }}</p>
        </div>
    </div>
    <div class="col-5">
        <h5>Kontak</h5>
        <div class="row">
            <div class="col-6">
                <p class="mb-1 fw-bolder">No Telp</p>
                <p>{{ $dosen->nohpdosen }}</p>
            </div>
            <div class="col-6">
                <p class="mb-1 fw-bolder">Email</p>
                <p>{{ $dosen->emaildosen }}</p>
            </div>
        </div>
    </div>
</div>
@elseif (auth()->user()->hasAnyRole(['Mitra', 'Pembimbing Lapangan']))
<div class="py-3 mx-4">
    <table class="table mb-0 table-borderless">
        <tbody>
            <tr>
                <td class="ps-0">
                    <p class="mb-1 fw-bolder">Nama Pegawai</p>
                    <p>{{ $pegawai->namapeg }}</p>
                </td>
                <td class="ps-0">
                    <p class="mb-1 fw-bolder">No Telp</p>
                    <p>{{ $pegawai->nohppeg }}</p>
                </td>
            </tr>
            <tr>
                <td class="ps-0">
                    <p class="mb-1 fw-bolder">Jabatan</p>
                    <p>{{ $pegawai->jabatan }}</p>
                </td>
                <td class="ps-0">
                    <p class="mb-1 fw-bolder">Email</p>
                    <p>{{ $pegawai->emailpeg }}</p>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@elseif(auth()->user()->hasAnyRole(['LKM', 'Super Admin']))
<div class="py-3 mx-3 row">
    <div class="col-6">
        <p class="mb-1 fw-bolder">Email</p>
        <p>{{ auth()->user()->email }}</p>
    </div>
    <div class="col-6">
        <p class="mb-1 fw-bolder">Name</p>
        <p>{{ auth()->user()->username }}</p>
    </div>
</div>
@endif
