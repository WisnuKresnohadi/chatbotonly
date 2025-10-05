<div class="modal fade" id="modalEditJadwal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header d-block">
                <h4 class="modal-title text-center">Laporan Harian Magang </h4>
                <h6 class="modal-title text-center date-formated"></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="" function-callback="afterCreateLogbookday">
                @csrf
                <input type="hidden" name="date">
                <input type="hidden" name="emoticon">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="activity" class="form-label">Kamu melakukan pekerjan apa hari ini?</label>
                        <textarea type="text" class="form-control" rows="3" name="activity" id="activity" placeholder="Tulis Disini"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mt-4">
                        <label for="mood" class="form-label">Silahkan pilih mood anda pada hari ini :</label>
                        <div class="d-flex mt-1">
                            <div class="text-center">
                                <img id="imageFour" class="cursor-pointer image-emot" src="{{asset('app-assets/img/emot/frustasi.png')}}" data-original-src="{{asset('app-assets/img/emot/frustasi.png')}}" data-selected-src="{{asset('app-assets/img/emot/frustasi1.png')}}" data-bobot="1" data-selected="false" onclick="changeImage($(this))"/>
                            </div>
                            <div class="text-center">
                                <img id="imageThree" class="cursor-pointer image-emot" src="{{asset('app-assets/img/emot/sad.png')}}" data-original-src="{{asset('app-assets/img/emot/sad.png')}}" data-selected-src="{{asset('app-assets/img/emot/sad1.png')}}" data-bobot="2" data-selected="false" onclick="changeImage($(this))"/>
                            </div>
                            <div class="text-center">
                                <img id="imageFive" class="cursor-pointer image-emot" src="{{asset('app-assets/img/emot/datar.png')}}" data-original-src="{{asset('app-assets/img/emot/datar.png')}}" data-selected-src="{{asset('app-assets/img/emot/datar1.png')}}" data-bobot="3" data-selected="false" onclick="changeImage($(this))"/>
                            </div>
                            <div class="text-center">
                                <img id="imageOne" class="cursor-pointer image-emot" src="{{asset('app-assets/img/emot/happy.png')}}" data-original-src="{{asset('app-assets/img/emot/happy.png')}}" data-selected-src="{{asset('app-assets/img/emot/happy1.png')}}" data-bobot="4" data-bobot="1" data-selected="false" onclick="changeImage($(this))"/>
                            </div>
                            <div class="text-center">
                                <img id="imageTwo" class="cursor-pointer image-emot" src="{{asset('app-assets/img/emot/love.png')}}" data-original-src="{{asset('app-assets/img/emot/love.png')}}" data-selected-src="{{asset('app-assets/img/emot/love1.png')}}" data-bobot="5" data-selected="false" onclick="changeImage($(this))"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" id="jadikan-libur" onclick="changeLogbookLibur($(this))">Jadikan Hari Libur</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>