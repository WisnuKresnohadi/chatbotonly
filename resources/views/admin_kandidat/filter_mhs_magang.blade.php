<!-- FILTER -->

<div class="offcanvas offcanvas-end" tabindex="-1" id="modalSlide" aria-labelledby="offcanvasAddUserLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Filter Berdasarkan</h5>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form class="add-new-user pt-0" action="" method="POST" id="filter">
            @csrf
            <div class="col-12 mb-2">
                <div class="row">
                    <div class="mb-2">
                        <label for="prodi" class="form-label">Program Studi</label>
                        <select class="form-select select2" id="prodi" name="prodi" data-placeholder="Pilih Program Studi">
                            @foreach($prodi as $item)
                            <option value="">Pilih Program Studi</option>
                            <option value="{{$item->id_prodi}}">{{$item->namaprodi}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="jenis" class="form-label">Jenis Magang</label>
                        <select class="form-select select2" id="jenis" name="jenis" data-placeholder="Pilih Jenis Magang">
                            @foreach($jenis as $item)
                            <option value="">Pilih Jenis Magang</option>
                            <option value="{{$item->id_jenismagang}}">{{$item->namajenis}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="mt-3 text-end">
                <button type="reset" class="btn btn-label-danger filter-reset">Reset</button>
                <button type="submit" class="btn btn-success filter-add">Terapkan</button>
            </div>
        </form>
    </div>
</div>