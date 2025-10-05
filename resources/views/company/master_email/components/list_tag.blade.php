@foreach ($list_tag as $item)
<button type="button" onclick="insert_shortcode($(this))" data-shortcode="{{ $item['shortCode'] }}"
    class="mx-2 btn btn-xs btn-primary">
    {{ $item['title'] }}
</button>
@endforeach