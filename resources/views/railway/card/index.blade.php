@extends("layouts.app")
@section("title")
    Gestion du porte carte
@endsection

@section("content")
    <x-base.toolbar
        title="Gestion du porte carte"
        :breads="array('Railway Manager', 'Gestion du porte carte')" />

    <livewire:railway.card.card-action :cards="$cards" />
    <livewire:railway.card.card-table />
@endsection

@push("scripts")
@endpush
