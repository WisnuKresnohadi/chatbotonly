<script src="{{ asset('app-assets/js/pdfviewer.jquery.js') }}"></script>
<script>
    const options = {
        width: 1100,
        height: 1100,
    };

    $('#pdfviewer').pdfViewer(`{{ $data }}`, options);
</script>