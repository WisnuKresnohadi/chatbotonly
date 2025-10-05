@php    
    $activeIndex = collect($data)->search(function($item) {
        return $item['active'];
    });        
    $rejectIndex = collect($data)->search(function($item) {
        return $item['isReject'];
    });       
@endphp

<div class="d-flex justify-content-center">
    @foreach ($data as $key => $item)
        <div class="d-flex flex-column justify-content-center align-items-center">
            <span class="badge badge-center rounded-pill {{ $key <= $activeIndex ? ($item['active'] ? ($item['isReject'] ? 'bg-danger' : ($key == count($data) - 1 ? 'bg-primary' : 'bg-label-primary')) : 'bg-primary') : 'bg-secondary'}}" style="font-size: 19pt;padding: 1.9rem;">{{ $item['title'] }}</span>
        </div>
        @if (($key+1) != count($data))      
        <div style="width: 10%;" class="position-relative mx-4">
            <span class="w-100 position-absolute start-50 translate-middle" style="top:35px;border: 1px solid {{ $key < $activeIndex ? ($key === $rejectIndex - 1 ? '#ea5355ad' :'#4EA971') : '#D3D6DB' }}"></span>
        </div>
        @endif
    @endforeach
</div>
<div class="d-flex justify-content-center">
    @foreach ($data as $key => $item)
    <span class="fw-semibold mt-4 text-center" style="width: 249px;">{{ $item['desc'] }}</span>
    @endforeach
</div>