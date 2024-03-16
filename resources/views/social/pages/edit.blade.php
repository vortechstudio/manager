@extends("layouts.app")
@section("title")
    Edition d'une page
@endsection

@section("content")


    <form action="{{ route('social.pages.update', $page->id) }}" method="POST">
        @csrf
        @method("PUT")
        <x-base.toolbar
            :title="$page->translateOrNew('fr')->title"
            :breads="array('Social', 'Gestion des pages', $page->translateOrNew('fr')->title)"
            return="true"
            sticky="true"
            submit="true" />

       <div class="row">
           <div class="col-sm-12 col-lg-8">
               <x-form.input
                   name="title"
                   label="Titre de la page"
                   value="{{ $page->translateOrNew('fr')->title }}"
                   required="true" />

               <x-form.textarea
                   type="simple"
                   name="description"
                   value="{{ $page->translateOrNew('fr')->description }}"
                   label="Courte description de la page" />

               <x-form.textarea
                   type="laraberg"
                   name="content"
                   value="{!! $page->translateOrNew('fr')->content !!}"
                   label="Contenue de la page"
                   required="true" />
           </div>
           <div class="col-sm-12 col-lg-4">
               <div class="card shadow-sm">
                   <div class="card-body">
                       <div class="mb-10">
                           <label for="keywords" class="form-label">Mots clefs</label>
                           <input id="keywords" type="text" name="keywords" value="{{ $page->translateOrNew('fr')->keywords }}" class="form-control">
                       </div>
                       <div class="mb-10">
                           <label for="author" class="form-label required">Auteur</label>
                           <div wire:ignore>
                               <select id="author" name="author" class="form-select" data-control="select2" data-placeholder="-- Selectionner un auteur --" data-pharaonic="select2"  wire:model.defer="form.author">
                                   <option value=""></option>
                                   @foreach($authors as $item)
                                       <option value="{{ $item->id }}" {{ auth()->user()->id == $page->creator_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                   @endforeach
                               </select>
                           </div>
                       </div>
                       <div class="mb-10">
                           <x-form.switches
                               name="published"
                               label="Publié la page"
                               value="1"
                               checked="{{ $page->published }}"
                               class-check="primary" />
                       </div>
                   </div>
               </div>
           </div>
       </div>
    </form>

@endsection

@push("scripts")
    <script type="text/javascript">
        new Tagify(document.getElementById('keywords'));
    </script>
@endpush
