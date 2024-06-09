@extends("layouts.app")
@section("title")
    Boutique: {{ $category->name }}
@endsection

@section("content")
    <x-base.toolbar
        title="Gestion de la boutique"
        :breads="array('Railway Manager', 'Gestion de la boutique', $category->name)"
        :return="true" />

    @livewire('railway.shop.shop-item-table', ["category" => $category])
@endsection
