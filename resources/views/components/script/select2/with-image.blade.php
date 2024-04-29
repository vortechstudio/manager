<script type="text/javascript">
    let optFormat = function (item) {
        if ( !item.id ) {
            return item.text;
        }

        let span = document.createElement('span');
        let imgUrl = item.element.getAttribute('data-avatar');
        let template = '';

        template += '<img src="' + imgUrl + '" class="rounded-circle h-20px me-2" alt="image"/>';
        template += item.text;

        span.innerHTML = template;

        return $(span);
    }

    $('#{{ $name }}').select2({
        templateSelection: optFormat,
        templateResult: optFormat
    });
</script>
