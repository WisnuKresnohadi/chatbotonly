@extends('partials_admin.template')

@section('page_style')
<style>

</style>
@endsection

@section('main')
<a href="/berkas-akhir-magang/mandiri" type="button" class="btn btn-outline-success mb-3 waves-effect">
    <span class="ti ti-arrow-left me-2"></span>Kembali
</a>
<div class="row ">
    <div class="mb-2">
        <h4 class="fw-bold text-sm">Laporan Magang Jennie Ruby Jane
        </h4>
    </div>
</div>

<div class="row">
    <div class="col-9">
        <object data='https://pdfjs-express.s3-us-west-2.amazonaws.com/docs/choosing-a-pdf-viewer.pdf' type="application/pdf" width="880" height="650">

            <iframe src='https://pdfjs-express.s3-us-west-2.amazonaws.com/docs/choosing-a-pdf-viewer.pdf' width="880" height="650">
                <p>This browser does not support PDF!</p>
            </iframe>
        </object>
    </div>
    <div class="col-3">
        <div class="card">
            <div class="card-body">
                <div>
                    <button class="btn btn-success" style="width: 235px;" data-bs-toggle="modal" data-bs-target="#modalSetuju"> <i class="ti ti-check me-1"></i> Lengkap</button>
                </div>
                <div class="mt-2">
                    <button class="btn btn-danger" style="width: 235px;" data-bs-toggle="modal" data-bs-target="#modalPenolakan"> <i class="ti ti-x me-1"></i> Tidak Lengkap</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPenolakan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-0">
                <h5 class="text-center mb-3" id="modalCenterTitle">Alasan Penolakan Laporan Akhir Magang </h5>
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="alasan" class="form-label">Alasan Penolakan</label>
                        <textarea type="text" id="alasan" class="form-control" placeholder="Masukkan alasan penolakan"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    Batal
                </button>
                <button type="button" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalSetuju" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body pb-2">
                <div class="row text-center">
                    <div>
                        <img class="image" src="{{ asset('app-assets/img/alert.png') }}" alt="">
                    </div>
                    <h5>Apakah anda yakin ingin menyetujui Berkas?</h5>
                    <p>Harap pastikan bahwa data sudah benar!</p>
                </div>
            </div>
            <div class="text-center pb-4">
                <button type="button" class="btn btn-success me-2">Ya, Yakin</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>




@endsection

@section('page_script')

@endsection