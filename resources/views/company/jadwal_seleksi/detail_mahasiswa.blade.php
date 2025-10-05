@extends('partials.vertical_menu')

@section('page_style')
@endsection

@section('content')
<div class="d-flex justify-content-start">
    <a href="{{ $urlBack }}" class="btn btn-outline-primary">
        <i class="ti ti-arrow-left"></i>&ensp;
        Kembali
    </a>
</div>
<div class="d-flex justify-content-start mt-3">
    <h4><span class="text-muted">Proses Seleksi</span>&ensp;/&ensp;Detail Mahasiswa</h4>
</div>

<div class="row">
    <div class="col-12">
        @include('mahasiswa/card_detail_mhs')
    </div>
</div>
@endsection

@section('page_script')
<script>
    document.getElementById('unduhProfileBtn').addEventListener('click', function() {
        const nim = '{{ $data->nim }}';
        window.open('/unduh-profile/' + nim, '_blank');
    });  

    const buttons = document.querySelectorAll('.show-btn');

    buttons.forEach(button => {
       button.addEventListener('click', showMore);
    });

    function showMore() {
            var content = this.previousElementSibling;
            var isShowMore = this.innerText === "Show More";
            var deskripsi = $(this).attr("data-deskripsi");

            var lessContent = deskripsi.substring(0, 250) + "...";            

            if (isShowMore) {
                content.innerHTML = deskripsi;
                this.innerText = "Show Less";
            } else {
                content.innerHTML = lessContent;
                this.innerText = "Show More";
            }
        }
</script>
@endsection
