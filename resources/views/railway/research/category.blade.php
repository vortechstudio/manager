@extends("layouts.app")
@section("title")
    {{ $category->name }}
@endsection

@section("content")
    <x-base.toolbar
        :title="$category->name"
        :breads="array('Railway Manager', 'Gestion des recherches & Développements', $category->name)"
        :return="true"
        :actions="[['text' => 'Editer la catégorie', 'modal' => true, 'link' => '#addCategory', 'color' => 'primary']]" />

    @livewire('railway.research.research-table', ['category' => $category])
    @livewire('railway.research.research-category-form', ['category' => $category])


@endsection
