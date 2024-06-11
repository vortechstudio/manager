@extends("layouts.app")
@section("title")
    Gestion des recherches & Développements
@endsection

@section("content")
    <x-base.toolbar
        title="Gestion des recherches & Développements"
        :breads="array('Railway Manager', 'Gestion des recherches & Développements')" />

    @livewire('railway.research.research-category-table')
@endsection
