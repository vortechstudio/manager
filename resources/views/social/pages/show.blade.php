@extends("layouts.app")
@section("title")
    {{ $page->translateOrNew('fr')->title }}
@endsection

@section("content")
    <x-base.toolbar
        :title="$page->translateOrNew('fr')->title"
        :breads="array('Social', 'Gestion des pages', $page->translateOrNew('fr')->title)"
        return="true"
        sticky="true" />

    
@endsection

@push("scripts")
    <script type="text/javascript">

    </script>
@endpush
