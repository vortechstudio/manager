@extends("layouts.app")
@section("title")
    Gestion des Lignes
@endsection

@section("content")
    <x-base.toolbar
        title="Gestion des Lignes"
        :breads="array('Railway Manager', 'Gestion des Lignes')" />

    <livewire:railway.ligne.ligne-table />
@endsection
