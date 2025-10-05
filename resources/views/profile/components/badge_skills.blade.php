@if (count($skills) > 0)  
        <div class="skill-badge-container">
            @foreach ($skills as $index => $item)  
                <span class="badge-new rounded-pill bg-primary p-1 {{ $index >= 10 ? 'hidden' : '' }}" style="flex: 1 1 auto;">{{ $item }}</span>  
            @endforeach
        </div>
        @else
        <div class="align-self-center" style="width: 100%;">  
            <img src="\assets\images\nothing.svg" alt="no-data" style="display: flex; margin-left: auto; margin-right: auto; margin-top: 5%; margin-bottom: 5%; width: 28%;">  
            <div class="sec-title mt-5 mb-4 text-center">  
                <h4>Anda belum menambahkan keahlian</h4>  
            </div>  
        </div>  
@endif 
<br>
 @if (count($skills) > 10)  
    <button id="toggleButton" style="width: 100%;	grid-column: span 10 / span 10; background-color: transparent; border: none; display: flex; flex-direction: row; align-items: center; justify-content: center" class="text-primary">  
        <span>Show More</span><i class="ti ti-chevron-down"></i>  
    </button>  
@endif 