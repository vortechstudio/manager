@extends("layouts.app")
@section("title")
    Gestion de la boutique
@endsection

@section("content")
    <x-base.toolbar
        title="Gestion de la boutique"
        :breads="array('Railway Manager', 'Gestion de la boutique')" />

    @livewire('railway.shop.shop-table')
@endsection
