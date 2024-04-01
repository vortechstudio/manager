@extends("layouts.app")
@section("title")
    Gestion des Évènements
@endsection

@section("content")
    <x-base.toolbar
        title="Gestion des évènements"
        :breads="array('Social', 'Gestion des évènements')" />

    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Liste des évènements</h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#addEvent">
                    Nouvelle Évènement
                </button>
            </div>
        </div>
        <div class="card-body">
            <livewire:social.event-table />
        </div>
    </div>

    <div class="modal fade" tabindex="-1" data-bs-focus="false" id="addEvent">
        <div class="modal-dialog modal-xl">
            <form action="{{ route('social.events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Nouvel évènement</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <x-form.input
                            name="title"
                            label="Titre de l'évènement"
                            required="true" />

                        <div class="mb-10">
                            <label for="type_event" class="form-label required">Type d'évènement</label>
                            <select id="type_event" name="type_event" class="form-select" data-control="select2" data-placeholder="-- Selectionner un type d'article --" data-dropdown-parent="#addEvent" required>
                                <option value=""></option>
                                @foreach($types as $item)
                                    <option value="{{ $item['value'] }}">{{ $item['label'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-10">
                            <label for="cercle_id" class="form-label required">Cercles</label>
                            <select id="cercle_id" name="cercle_id" class="form-select" data-control="select2" data-placeholder="-- Selectionner un cercle --" data-dropdown-parent="#addEvent" required>
                                <option value=""></option>
                                @foreach($cercles as $item)
                                    <option value="{{ $item['value'] }}">{{ $item['label'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-sm-12 mb-10">
                                <input data-format="datetime" class="form-control" name="start_at" placeholder="Pick a date" required />
                            </div>
                            <div class="col-lg-6 col-sm-12 mb-10">
                                <input data-format="datetime" class="form-control" name="end_at" placeholder="Pick a date" required />
                            </div>
                        </div>

                        <x-form.image-input
                            name="image"
                            width="w-600px"
                            label="Image de l'évènement" />

                        <x-form.textarea
                            type="simple"
                            name="synopsis"
                            label="Synopsis de l'évènement"
                            required="true" />

                        <x-form.textarea
                            type="laraberg"
                            name="contenue"
                            label="Contenue de l'évènement"
                            required="true" />

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermé</button>
                        <button type="submit" class="btn btn-primary">Valider</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
