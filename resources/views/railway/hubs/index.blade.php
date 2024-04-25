@extends("layouts.app")
@section("title")
    Gestion des Gares & Hubs
@endsection

@section("content")
    <x-base.toolbar
        title="Gestion des Gares & Hubs"
        :breads="array('Railway Manager', 'Gestion des Gares & Hubs')" />

    <livewire:railway.hubs.hub-table />
@endsection
