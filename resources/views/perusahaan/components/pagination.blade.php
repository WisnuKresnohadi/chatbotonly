{{-- Pagination Default --}}
{{-- @foreach ($pagination['links'] as $key => $item)
@php
    $item['not_number'] = str_contains($item['label'], 'pagination.') ? true : false;
    $item['label'] = str_contains($item['label'], 'pagination.') ? ucfirst(explode('.', $item['label'])[1]) : $item['label'];
@endphp
<li class="page-item {{ $item['active'] ? 'active' : '' }} mx-1" page="prev">
    <a class="page-link {{ $item['url'] == null ? 'disabled' : '' }} {{ $item['not_number'] ? 'px-3' : '' }}" href="javascript:void(0);" onclick="pagination($(this))" data-url="{{ $item['url'] }}">{{ $item['label'] }}</a>
</li>
@endforeach --}}
@php  
    $currentPage = $pagination['current_page'];  
    $lastPage = $pagination['last_page'];  
    $window = 2; 
    $paginationLinks = [];  
  
    
    if ($pagination['prev_page_url']) {  
        $paginationLinks[] = ['label' => 'Previous', 'url' => $pagination['prev_page_url'], 'active' => false];  
    }  
  
    
    for ($i = max(1, $currentPage - $window); $i < $currentPage; $i++) {  
        $paginationLinks[] = ['label' => $i, 'url' => $pagination['path'] . '?page=' . $i, 'active' => false];  
    }  
  
    
    $paginationLinks[] = ['label' => $currentPage, 'url' => null, 'active' => true];  
  
    
    for ($i = $currentPage + 1; $i <= min($lastPage, $currentPage + $window); $i++) {  
        $paginationLinks[] = ['label' => $i, 'url' => $pagination['path'] . '?page=' . $i, 'active' => false];  
    }  
  
    
    if ($currentPage + $window < $lastPage) {  
        $paginationLinks[] = ['label' => '...', 'url' => null, 'active' => false];  
    }  
  
    
    if ($currentPage < $lastPage && !in_array(['label' => $lastPage, 'url' => $pagination['last_page_url'], 'active' => false], $paginationLinks)) {  
        $paginationLinks[] = ['label' => $lastPage, 'url' => $pagination['last_page_url'], 'active' => false];  
    }  
  
    
    if ($pagination['next_page_url']) {  
        $paginationLinks[] = ['label' => 'Next', 'url' => $pagination['next_page_url'], 'active' => false];  
    }  
@endphp  
  
@foreach ($paginationLinks as $item)  
@php  
    $isDisabled = $item['url'] == null;  
@endphp  
<li class="page-item {{ $item['active'] ? 'active' : '' }} mx-1">  
    <a class="page-link {{ $isDisabled ? 'disabled' : '' }}" href="javascript:void(0);" onclick="pagination($(this))" data-url="{{ $item['url'] }}">{{ $item['label'] }}</a>  
</li>  
@endforeach 
