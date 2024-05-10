@extends("layouts.app")
@section("title")
    Gestion des cercles
@endsection

@section("content")
    <x-base.toolbar
        title="Gestion des cercles"
        :breads="array('Social', 'Gestion des cercles')" />
    <livewire:social.cercle />
@endsection
