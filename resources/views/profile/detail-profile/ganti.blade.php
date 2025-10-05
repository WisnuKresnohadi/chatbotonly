<div class="modal fade modals" id="ganti">
    <div class="modal-dialog modal-lg  modal-dialog-centered">
        @if (auth()->user()->hasRole('Dosen'))
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title" id="largeModalLabel">Ubah Data Profile</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('ganti.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
          <div>
            <div>
                <label for="foto">Upload foto</foto>
                <input type="file" class="form-control-file" id="foto" name="foto">
                </div>
            </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
        </form>
        @elseif (auth()->user()->hasRole('Mitra'))
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title" id="largeModalLabel">Ubah Data Profile</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('ganti.store')}}" method="POST" enctype="multipart/form-data">
              @csrf
          <div>
            <div>
                <label for="foto">Upload foto</foto>
                <input type="file" class="form-control-file" id="foto" name="foto">
                    <br>
                </div>
            </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
      </form>
        @elseif (auth()->user()->hasRole('LKM'))
        <div class="modal-content">
            <div class="modal-header">
              <h3 class="modal-title" id="largeModalLabel">Ganti Foto</h3>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('ganti.store')}}" method="POST" enctype="multipart/form-data">
              @csrf
              <div >
                <div class="display: grid; gap: 5rem;">
                    <label for="foto">Upload foto</label>
                    <input type="file" class="form-control-file" id="foto" name="foto">
                        <br>
                    </div>
                </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
        @endif
      </form> 
    </div>
</div>