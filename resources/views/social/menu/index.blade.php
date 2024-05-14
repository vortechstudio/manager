@extends("layouts.app")
@section("title")
    Gestion des menus
@endsection

@section("content")
    <x-base.toolbar
        title="Gestion des menus"
        :breads="array('Social', 'Gestion des menus')" />

    <livewire:social.menu.menu-table />
@endsection
