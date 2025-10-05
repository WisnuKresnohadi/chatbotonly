<div class="col-12 px-4">
    @foreach ($lowongan as $item)
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex justify-content-start py-2">
            <span class="badge badge-dot me-3 bg-primary my-auto"></span>
            <h6 class="my-auto">{{ $item->intern_position }}</h6>
        </div>
        <h6 class="my-auto py-2">{{ $item->kuota }} Kuota penerimaan</h6>
    </div>
    @endforeach
</div>