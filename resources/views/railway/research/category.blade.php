@extends("layouts.app")
@section("title")
    {{ $category->name }}
@endsection

@section("content")
    <x-base.toolbar
        :title="$category->name"
        :breads="array('Railway Manager', 'Gestion des recherches & Développements', $category->name)" />


@endsection
