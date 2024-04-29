@if($noElement)
    new Tagify(document.getElementById('{{ $selector }}'));
@else
    <script type="text/javascript">
        new Tagify(document.getElementById('{{ $selector }}'));
    </script>
@endif
