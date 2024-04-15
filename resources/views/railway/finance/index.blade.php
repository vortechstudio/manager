@extends("layouts.app")
@section("title")
    Gestion des Services bancaires
@endsection

@section("content")
    <x-base.toolbar
        title="Gestion des Services de location"
        :breads="array('Railway Manager', 'Gestion des Services bancaires')" />

    <livewire:railway.finance.finance-table />
@endsection
