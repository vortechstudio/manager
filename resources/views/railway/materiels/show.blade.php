@extends("layouts.app")
@section("title")
    Engine: {{ $engine->name }}
@endsection

@section("content")
    <x-base.toolbar
        :title="$engine->name"
        :breads="array('Railway Manager', 'Gestion des matériels roulants', $engine->name)"
        return="true"
        sticky="true" />

@endsection
