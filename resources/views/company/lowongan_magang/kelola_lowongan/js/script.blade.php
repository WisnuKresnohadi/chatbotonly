<script>
    function getDataSelect(e) {
        let nameElement = e.attr('data-after');
        $.ajax({
            url: `{{ route('kelola_lowongan') }}?element=${nameElement}&selected=${e.val()}`,
            type: 'GET',
            success: function (response) {
                $(`[name="${nameElement}"]`).removeAttr('disabled');
                $(`[name="${nameElement}"]`).find('option:not([disabled])').remove();
                $(`[name="${nameElement}"]`).val(null).trigger('change');
                $.each(response.data, function () {
                    $(`[name="${nameElement}"]`).append(new Option(this.text, this.id));
                });
            }
        });
    }
</script>