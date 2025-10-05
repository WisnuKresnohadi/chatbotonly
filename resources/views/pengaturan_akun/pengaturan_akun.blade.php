@extends('partials_mahasiswa.template')

@section('page_style')
<style>
  .hidden {
  display: none;
}
</style>
  
@endsection

@section('main')
<div class="sec-title mt-4 mb-4">
    <h4>Pengaturan</h4>
</div>
<div class="row">
   <div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between border-bottom">
                <h5 class="text-secondary">INFORMASI PRIBADI</h5>
                <div class="col-md-2 col-12 text-end">
                <i class="menu-icon tf-icons ti ti-edit text-success" data-bs-toggle="modal" data-bs-target="#modalEditInformasi"></i>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-4 col-12 border-end">
                    <div class="user-avatar-section">
                        <div class="d-flex align-items-center flex-column">
                          <img class="rounded-circle w-px100 mb-3 pt-1 mt-4" src="../../app-assets/img/avatars/15.png" height="150" width="150" alt="User avatar"/>
                          <div class="user-info text-center">
                            <h4 class="mb-2">Violet Mendoza</h4>
                            <span class="badge bg-label-success mt-1">Mahasiswa</span>
                            <p class="text-secondary2 mt-3">7708202028</p>
                          </div>
                        </div>
                      </div>
                </div>
                <div class="col-md-7 col-12">
                    <div class="row ms-5 mt-4">
                        <div class="col-6">
                            <h6>Program Studi</h6>
                            <p>D4 Teknologi Rekayasa</p>
                        </div>
                        <div class="col-6">
                            <h6>Fakultas</h6>
                            <p>Fakultas Ilmu Terapan</p>
                        </div>
                        <div class="col-6">
                            <h6>Tanggal Lahir</h6>
                            <p>12 Juli 2002</p>
                        </div>
                        <div class="col-6">
                            <h6>Jenis Kelamin</h6>
                            <p>Laki-laki</p>
                        </div>
                        <div class="col-6">
                            <h6>No Telepon</h6>
                            <p>089612345678</p>
                        </div>
                        <div class="col-6">
                            <h6>Dosen Wali</h6>
                            <p>Ahmad Jamal S.T,M.Si</p>
                        </div>
                        <div class="col-6">
                            <h6>Jenis Magang</h6>
                            <p>Magang 2 Semester</p>
                        </div>
                        <div class="col-6">
                            <h6>Periode Magang</h6>
                            <p>Genap 23-24(Jan-Jul 2024)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   </div>
</div>

<!-- Pengalaman dan Keahlian -->

<div class="row mt-4">
    <div class="col-12">
     <div class="card">
         <div class="card-body">
             <div class="d-flex justify-content-between border-bottom pb-2">
                 <h5 class="text-secondary">PENGALAMAN DAN KEAHLIAN</h5>
                 <span class="badge bg-label-success rounded-pill p-2">
                    <i class="ti ti-plus ti-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPengalaman"></i>
                  </span>
             </div>
             <div class="border-bottom item">
                <ul class="timeline ms-4 mb-0 mt-4">
                    <li class="timeline-item timeline-item-transparent" style="border-left: 0px solid">
                        <span class="timeline-point timeline-point-success"></span>
                        <div class="timeline-event">
                                <div class="timeline-header d-flex justify-content-between">
                                <h6 class="mb-0">Content Creator</h6> 
                                <div>
                                <i class="menu-icon tf-icons ti ti-edit text-success" data-bs-toggle="modal" data-bs-target="#modalEditPengalaman"></i>
                                <i class="menu-icon tf-icons ti ti-trash text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"></i>
                            </div>
                                </div>
                                <p class="mb-1">Techno Infinity - Intership</p>
                                <p class="mb-1">Aug 2018 - Aug 2022</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tristique eros eget mauris blandit, vel gravida turpis molestie.</p>
                                <div class="d-flex align-items-start">
                                    <div>
                                      <img src="../../app-assets/img/avatars/2.png">
                                    </div>
                                    <div class="me-2 ms-4">
                                      <h6 class="mt-5">Gambar.jpg</h6>
                                    </div>
                                  </div>
                        </div>
                    </li>
                </ul> 
             </div>
             <div class="border-bottom item">
                <ul class="timeline ms-4 mb-0 mt-4">
                    <li class="timeline-item timeline-item-transparent" style="border-left: 0px solid">
                        <span class="timeline-point timeline-point-success"></span>
                        <div class="timeline-event">
                                <div class="timeline-header d-flex justify-content-between">
                                <h6 class="mb-0">UKM Badminton</h6> 
                                <div>
                                <i class="menu-icon tf-icons ti ti-edit text-success"></i>
                                <i class="menu-icon tf-icons ti ti-trash text-danger"></i>
                            </div>
                                </div>
                                <p class="mb-1">Telkom University</p>
                                <p class="mb-1">Aug 2018 - Aug 2022</p>
                                <ul>
                                    <li class="mb-0"> Lorem ipsum dolor sit ame</li>
                                    <li class="mb-0"> consectetur adipiscing elit.</li>
                                    <li class="mb-0"> Praesent tristique eros eget mauris</li>
                                    <li class="mb-0"> vel gravida turpis molestie</li>
                                </ul>
                        </div>
                    </li>
                </ul> 
             </div>
             <div class="border-bottom item hidden-item hidden">
                <ul class="timeline ms-4 mb-0 mt-4">
                    <li class="timeline-item timeline-item-transparent" style="border-left: 0px solid">
                        <span class="timeline-point timeline-point-success"></span>
                        <div class="timeline-event">
                                <div class="timeline-header d-flex justify-content-between">
                                <h6 class="mb-0">UKM Badminton</h6> 
                                <div>
                                <i class="menu-icon tf-icons ti ti-edit text-success"></i>
                                <i class="menu-icon tf-icons ti ti-trash text-danger"></i>
                            </div>
                                </div>
                                <p class="mb-1">Telkom University</p>
                                <p class="mb-1">Aug 2018 - Aug 2022</p>
                                <ul>
                                    <li class="mb-0"> Lorem ipsum dolor sit ame</li>
                                    <li class="mb-0"> consectetur adipiscing elit.</li>
                                    <li class="mb-0"> Praesent tristique eros eget mauris</li>
                                    <li class="mb-0"> vel gravida turpis molestie</li>
                                </ul>
                        </div>
                    </li>
                </ul> 
             </div>
             <div class="border-bottom item hidden-item hidden">
                <ul class="timeline ms-4 mb-0 mt-4">
                    <li class="timeline-item timeline-item-transparent" style="border-left: 0px solid">
                        <span class="timeline-point timeline-point-success"></span>
                        <div class="timeline-event">
                                <div class="timeline-header d-flex justify-content-between">
                                <h6 class="mb-0">UKM Badminton</h6> 
                                <div>
                                <i class="menu-icon tf-icons ti ti-edit text-success"></i>
                                <i class="menu-icon tf-icons ti ti-trash text-danger"></i>
                            </div>
                                </div>
                                <p class="mb-1">Telkom University</p>
                                <p class="mb-1">Aug 2018 - Aug 2022</p>
                                <ul>
                                    <li class="mb-0"> Lorem ipsum dolor sit ame</li>
                                    <li class="mb-0"> consectetur adipiscing elit.</li>
                                    <li class="mb-0"> Praesent tristique eros eget mauris</li>
                                    <li class="mb-0"> vel gravida turpis molestie</li>
                                </ul>
                        </div>
                    </li>
                </ul> 
             </div>
            <a href='/detail-informasi-pengalaman'>
              <button class="btn btn-outline-success btn-lg toggle-button" style="width: 1350px" type="button">Selengkapnya</button>
            </a>
         </div>
     </div>
    </div>
</div>

<!-- Dokumen Pendukung -->

<div class="row mt-4 mb-4">
    <div class="col-12">
     <div class="card">
         <div class="card-body">
             <div class="d-flex justify-content-between border-bottom pb-2">
                 <h5 class="text-secondary">DOKUMEN PENDUKUNG</h5>
                 <span class="badge bg-label-success rounded-pill p-2">
                    <i class="ti ti-plus ti-sm" data-bs-toggle="modal" data-bs-target="#modalTambahDokumen"></i>
                  </span>
             </div>
             <div class=" border-bottom item2">
                <ul class="timeline ms-4 mb-0 mt-4">
                    <li class="timeline-item timeline-item-transparent" style="border-left: 0px solid">
                        <span class="timeline-point timeline-point-success"></span>
                        <div class="timeline-event">
                                <div class="timeline-header d-flex justify-content-between">
                                <h6 class="mb-0">Desain UI/UX Website</h6> 
                                <div>
                                <i class="menu-icon tf-icons ti ti-edit text-success" data-bs-toggle="modal" data-bs-target="#modalEditDokumen"></i>
                                <i class="menu-icon tf-icons ti ti-trash text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"></i>
                            </div>
                                </div>
                                <p class="mb-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tristique eros eget mauris blandit, vel gravida turpis molestie.</p>
                                <div class="d-flex align-items-start">
                                    <div>
                                      <img src="../../app-assets/img/avatars/2.png">
                                    </div>
                                    <div class="me-2 ms-4">
                                      <h6 class="mt-5">UI/UX Website.pdf</h6>
                                    </div>
                                </div>
                        </div>
                    </li>
                </ul> 
             </div>
             <div class="border-bottom item2">
                <ul class="timeline ms-4 mb-0 mt-4">
                    <li class="timeline-item timeline-item-transparent" style="border-left: 0px solid">
                        <span class="timeline-point timeline-point-success"></span>
                        <div class="timeline-event">
                                <div class= "timeline-header d-flex justify-content-between">
                                <h6 class="mb-0">Desain UI/UX Mobile App</h6> 
                                <div>
                                <i class="menu-icon tf-icons ti ti-edit text-success"></i>
                                <i class="menu-icon tf-icons ti ti-trash text-danger"></i>
                                </div>
                                </div>
                                <p class="mb-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tristique eros eget mauris blandit, vel gravida turpis molestie.</p>
                                <div class="d-flex align-items-start">
                                    <div>
                                      <img src="../../app-assets/img/avatars/2.png">
                                    </div>
                                    <div class="me-2 ms-4">
                                      <h6 class="mt-5">UI/UX Mobile App.pdf</h6>
                                    </div>
                                </div>
                        </div>
                    </li>
                </ul> 
             </div>
             <div class="border-bottom item2 hidden-item2 hidden">
                <ul class="timeline ms-4 mb-0 mt-4">
                    <li class="timeline-item timeline-item-transparent" style="border-left: 0px solid">
                        <span class="timeline-point timeline-point-success"></span>
                        <div class="timeline-event">
                                <div class="timeline-header d-flex justify-content-between">
                                <h6 class="mb-0">Desain UI/UX Website</h6> 
                                <div>
                                <i class="menu-icon tf-icons ti ti-edit text-success"></i>
                                <i class="menu-icon tf-icons ti ti-trash text-danger"></i>
                            </div>
                                </div>
                                <p class="mb-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tristique eros eget mauris blandit, vel gravida turpis molestie.</p>
                                <div class="d-flex align-items-start">
                                    <div>
                                      <img src="../../app-assets/img/avatars/2.png">
                                    </div>
                                    <div class="me-2 ms-4">
                                      <h6 class="mt-5">UI/UX Website.pdf</h6>
                                    </div>
                                </div>
                        </div>
                    </li>
                </ul> 
             </div>
             <div class="border-bottom item2 hidden-item2 hidden">
                <ul class="timeline ms-4 mb-0 mt-4">
                    <li class="timeline-item timeline-item-transparent" style="border-left: 0px solid">
                        <span class="timeline-point timeline-point-success"></span>
                        <div class="timeline-event">
                                <div class="timeline-header d-flex justify-content-between">
                                <h6 class="mb-0">Desain UI/UX Mobile App</h6> 
                                <div>
                                <i class="menu-icon tf-icons ti ti-edit text-success"></i>
                                <i class="menu-icon tf-icons ti ti-trash text-danger"></i>
                                </div>
                                </div>
                                <p class="mb-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tristique eros eget mauris blandit, vel gravida turpis molestie.</p>
                                <div class="d-flex align-items-start">
                                    <div>
                                      <img src="../../app-assets/img/avatars/2.png">
                                    </div>
                                    <div class="me-2 ms-4">
                                      <h6 class="mt-5">UI/UX Mobile App.pdf</h6>
                                    </div>
                                </div>
                        </div>
                    </li>
                </ul> 
             </div>
             <a href='/detail-informasi-dokumen'>
               <button class="btn btn-outline-success btn-lg toggle-button" style="width: 1350px" type="button">Selengkapnya</button>
             </a>
         </div>
     </div>
    </div>
</div>

<!-- Modal Edit Informasi Pribadi -->
<div class="modal fade" id="modalEditInformasi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header d-block">
                <h5 class="modal-title" id="modal-title">Edit Informasi Pribadi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
    <!-- Account -->
    <div class="modal-body">
      <div class="d-flex align-items-start align-items-sm-center gap-4 mb-4">
        <img src="../../app-assets/img/avatars/14.png"alt="user-avatar"class="d-block w-px-100 h-px-100 rounded"id="uploadedAvatar"/>
        <div class="button-wrapper">
          <label for="upload" class="btn btn-success me-2 mb-3" tabindex="0">
            <span class="d-none d-sm-block">Unggah Foto Baru</span>
            <i class="ti ti-upload d-block d-sm-none"></i>
            <input type="file"id="upload"class="account-file-input"hidden accept="image/png, image/jpeg"/>
          </label>
          <button type="button" class="btn btn-label-secondary account-image-reset mb-3">
            <i class="ti ti-refresh-dot d-block d-sm-none"></i>
            <span class="d-none d-sm-block">Atur Ulang</span>
          </button>

          <div class="text-muted">Format FIle JPG, GIF atau PNG. Ukuran Maksimal 800KB</div>
        </div>
      </div>
      <div class="border-top">
      <form id="formAccountSettings" method="POST" onsubmit="return false">
        <div class="row mt-4">
          <div class="mb-3 col-md-4">
            <label for="firstName" class="form-label">Nama Depan</label>
            <input class="form-control" type="text" id="namadepan" name="namadepan" value="John" autofocus/>
          </div>
          <div class="mb-3 col-md-4">
            <label for="lastName" class="form-label">Nama Belakang</label>
            <input class="form-control" type="text" name="namabelakang" id="namabelakang" value="Doe" />
          </div>
          <div class="mb-3 col-md-4">
            <label for="NIM" class="form-label">Nomor Induk Mahasiswa</label>
            <input class="form-control" type="text" id="nim" name="nim" value="7708202028" placeholder="7708202028"
            />
          </div>
          <div class="mb-3 col-md-6">
            <label for="programstudi" class="form-label">Program Studi</label>
            <select id="programstudi" class="select2 form-select">
              <option disabled selected>Pilih Program Studi</option>
              <option value="S1 Teknik">S1 Teknik</option>
              <option value="S1 Teknik">S1 Teknik</option>
            </select>
          </div>
          <div class="mb-3 col-md-6">
            <label for="fakultas" class="form-label">Fakultas</label>
            <select id="fakultas" class="select2 form-select">
              <option disabled selected>Pilih Fakultas</option>
              <option value="Fakultas Ilmu Terapan">Fakultas Ilmu Terapan</option>
              <option value="Fakultas Ilmu Terapan">Fakultas Ilmu Terapan</option>
            </select>
          </div>
          <div class="mb-3 col-md-6">
            <label for="tanggallahir" class="form-label">Tanggal Lahir</label>
            <input class="form-control" type="date" value="2005-03-09" id="tanggallahir">
          </div>
          <div class="mb-3 col-md-6">
              <label for="jeniskelamin" class="form-label">Jenis Kelamin</label>
              <select id="jeniskelamin" class="select2 form-select">
                  <option disabled selected>Pilih Jenis Kelamin</option>
                  <option value="Laki-laki">Laki-laki</option>
                  <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="mb-3 col-md-6">
              <label class="form-label" for="notelp">Nomor Telepon</label>
              <div class="input-group input-group-merge">
                <input type="text"id="notelp"name="notelp"class="form-control"placeholder="089123456789"/>
              </div>
            </div>
            <div class="mb-3 col-md-6">
                <label for="namadosen" class="form-label">Nama Dosen Wali</label>
                <input class="form-control" type="text" id="namadosen" name="namadosen" placeholder="Ahmad Jamal S.T,M.Si" />
              </div>
            <div class="mb-3 col-md-6">
                <label for="jenismagang" class="form-label">Jenis Magang</label>
                <select id="jenismagang" class="select2 form-select">
                <option disabled selected>Pilih Jenis Magang</option>
                <option value="Jenis Magang Fakultas">Jenis Magang Fakultas</option>
                <option value="Jenis Magang non Fakultas">Jenis Magang non Fakultas</option>
                </select>
            </div>
            <div class="mb-3 col-md-6">
                <label for="periodemagang" class="form-label">Periode Magang</label>
                <select id="periodemagang" class="select2 form-select">
                <option disabled selected>Pilih Periode Magang</option>
                <option value="Magang 1 Semester">Magang 1 Semester</option>
                <option value="Magang 2 Semester">Magang 2 Semester</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success me-2">Simpan</button>
          <button type="reset" class="btn btn-label-secondary">Batalkan</button>
        </div>
      </form>
      </div>
    </div>
    <!-- /Account -->
        </div>
    </div>
</div>

<!-- Modal Tambah Pengalaman dan Keahlian -->
<div class="modal fade" id="modalTambahPengalaman" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header d-block">
                <h5 class="modal-title" id="modal-title">Tambah Pengalaman dan Keahlian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
    <!-- Account -->
    <div class="modal-body border-top mt-3">
      <div class="d-flex align-items-start align-items-sm-center gap-4 mb-2">
      </div>
      <form id="formAccountSettings" method="POST" onsubmit="return false">
        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="posisi" class="form-label">Posisi / Bidang</label>
                <input class="form-control" type="text" id="posisi" name="posisi" placeholder="UI/UX Designer"/>
              </div>
          <div class="mb-3 col-md-6">
            <label for="pekerjaan" class="form-label">Jenis Pekerjaan</label>
            <select id="pekerjaan" class="select2 form-select">
              <option disabled selected>Pilih Jenis Pekerjaan</option>
              <option value="Pekerjaan">Pekerjaan</option>
              <option value="Pekerjaan">Pekerjaan</option>
            </select>
          </div>
          <div class="mb-3 col-md-6">
            <label for="namaperusahaan" class="form-label">Nama Perusahaan</label>
            <input class="form-control" type="text" id="namaperusahaan" name="namaperusahaan" placeholder="EX: PT Techno Infinity"/>
          </div>
          <div class="mb-3 col-md-6">
            <label for="sertifikasi" class="form-label">Sertifikasi</label>
            <input class="form-control" type="file" id="sertifikasi" multiple="">
            </div>
            <div class="mb-3 col-md-12">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <input class="form-control form-control-lg" type="text" id="deskripsi" name="deskripsi" placeholder="Ketik di sini..."/>
              </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success me-2">Simpan</button>
          <button type="reset" class="btn btn-label-secondary">Batalkan</button>
        </div>
      </form>
    
    </div>
    <!-- /Account -->
        </div>
    </div>
</div>

<!-- Modal Edit Pengalaman dan Keahlian -->
<div class="modal fade" id="modalEditPengalaman" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header d-block">
                <h5 class="modal-title" id="modal-title">Edit Pengalaman dan Keahlian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
    <!-- Account -->
    <div class="modal-body border-top mt-3">
      <div class="d-flex align-items-start align-items-sm-center gap-4 mb-2">
      </div>
      <form id="formAccountSettings" method="POST" onsubmit="return false">
        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="posisi" class="form-label">Posisi / Bidang</label>
                <input class="form-control" type="text" id="posisi" name="posisi" placeholder="UI/UX Designer"/>
              </div>
          <div class="mb-3 col-md-6">
            <label for="pekerjaan" class="form-label">Jenis Pekerjaan</label>
            <select id="pekerjaan" class="select2 form-select">
              <option disabled selected>Pilih Jenis Pekerjaan</option>
              <option value="Pekerjaan">Pekerjaan</option>
              <option value="Pekerjaan">Pekerjaan</option>
            </select>
          </div>
          <div class="mb-3 col-md-6">
            <label for="namaperusahaan" class="form-label">Nama Perusahaan</label>
            <input class="form-control" type="text" id="namaperusahaan" name="namaperusahaan" placeholder="EX: PT Techno Infinity"/>
          </div>
          <div class="mb-3 col-md-6">
            <label for="sertifikasi" class="form-label">Sertifikasi</label>
            <input class="form-control" type="file" id="sertifikasi" multiple="">
            </div>
            <div class="mb-3 col-md-12">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <input class="form-control form-control-lg" type="text" id="deskripsi" name="deskripsi" placeholder="Ketik di sini..."/>
              </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success me-2">Simpan</button>
          <button type="reset" class="btn btn-label-secondary">Batalkan</button>
        </div>
      </form>
    
    </div>
    <!-- /Account -->
        </div>
    </div>
</div>

<!-- Modal Tambah Dokumen Pendukung -->
<div class="modal fade" id="modalTambahDokumen" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header d-block">
                <h5 class="modal-title" id="modal-title">Tambah Dokumen Pendukung</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
    <!-- Account -->
    <div class="modal-body border-top mt-3">
      <div class="d-flex align-items-start align-items-sm-center gap-4 mb-2">
      </div>
      <form id="formAccountSettings" method="POST" onsubmit="return false">
        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="judul" class="form-label">Judul</label>
                <input class="form-control" type="text" id="judul" name="judul" placeholder="EX: Portofolio"/>
          </div>
          <div class="mb-3 col-md-6">
            <label for="unggahfile" class="form-label">Unggah File</label>
            <input class="form-control" type="file" id="unggahfile" multiple="">
            </div>
            <div class="mb-3 col-md-12">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <input class="form-control form-control-lg" type="text" id="deskripsi" name="deskripsi" placeholder="Ketik di sini..."/>
              </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success me-2">Simpan</button>
          <button type="reset" class="btn btn-label-secondary">Batalkan</button>
        </div>
      </form>
    
    </div>
    <!-- /Account -->
        </div>
    </div>
</div>

<!-- Modal Edit Dokumen Pendukung -->
<div class="modal fade" id="modalEditDokumen" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header d-block">
                <h5 class="modal-title" id="modal-title">Edit Dokumen Pendukung</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
    <!-- Account -->
    <div class="modal-body border-top mt-3">
      <div class="d-flex align-items-start align-items-sm-center gap-4 mb-2">
      </div>
      <form id="formAccountSettings" method="POST" onsubmit="return false">
        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="judul" class="form-label">Judul</label>
                <input class="form-control" type="text" id="judul" name="judul" placeholder="Portofolio"/>
          </div>
          <div class="mb-3 col-md-6">
            <label for="unggahfile" class="form-label">Unggah File</label>
            <input class="form-control" type="file" id="unggahfile" multiple="">
            </div>
            <div class="mb-3 col-md-12">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <input class="form-control form-control-lg" type="text" id="deskripsi" name="deskripsi" placeholder="Lorem Ipsum"/>
              </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success me-2">Simpan</button>
          <button type="reset" class="btn btn-label-secondary">Batalkan</button>
        </div>
      </form>
    
    </div>
    <!-- /Account -->
        </div>
    </div>
</div>


<!-- Modal Delete-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        
        </button>
      </div>
      <div class="modal-body text-center" style="display:block;">
        Apakah Anda ingin menghapus Pengalaman dan Keahlian ini?
      </div>
      <div class="modal-footer" style="display: flex; justify-content:center;">
        <button type="button" class="btn btn-success" data-dismiss="modal">Iya</button>
        <button type="button" class="btn btn-danger">Tidak</button>
      </div>
    </div>
  </div>
</div>



@endsection

@section('page_script')
<script>


</script>
@endsection