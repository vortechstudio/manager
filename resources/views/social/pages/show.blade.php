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

    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
            <div class="card-toolbar">
                <a href="{{ route('social.pages.edit', $page->id) }}" class="btn btn-sm btn-light">
                    Editer la page
                </a>
            </div>
        </div>
        <div class="card-body">
            {!! $page->translateOrNew('fr')->content !!}
        </div>
    </div>

@endsection

@push("scripts")
    <script type="text/javascript">

    </script>
@endpush
