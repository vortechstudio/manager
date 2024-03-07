@extends("layouts.app")
@section("title")
    Création d'une page
@endsection

@section("content")


    <form action="">
        @csrf
        <x-base.toolbar
            title="Création d'une page"
            :breads="array('Social', 'Gestion des pages', 'Création d\'une page')"
            return="true"
            sticky="true"
            submit="true" />

    </form>

@endsection
