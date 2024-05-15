@extends("layouts.app")
@section("title")
    Gestion des boutiques
@endsection

@section("content")
    <x-base.toolbar
        title="Gestion des boutiques"
        :breads="array('Administration', 'Gestion des boutiques')" />

    <livewire:admin.shop.shop-table />
@endsection
