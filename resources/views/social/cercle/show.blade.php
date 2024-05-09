@extends("layouts.app")
@section("title")
    {{ $cercle->name }}
@endsection

@section("content")
    <x-base.toolbar
        :title="$cercle->name"
        :breads="array('Social', 'Gestion des cercles', $cercle->name)"
        return="true" />
@endsection
