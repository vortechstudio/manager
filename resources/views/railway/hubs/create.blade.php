@extends("layouts.app")
@section("title")
    Création d'une Gare
@endsection

@section("content")
    <form action="{{ route('railway.hubs.store') }}" method="POST" x-data="{hub_show: ''}">
        @csrf
        <x-base.toolbar
            title="Création d'une Gare"
            :breads="array('Railway Manager', 'Gestion des Gares & Hubs', 'Création d\'une Gare')"
            return="true"
            sticky="true"
            submit="true" />

        <div class="row">
            <div class="col-sm-12 col-lg-9">
                <div class="card shadow-sm" >
                    <div class="card-body">
                        <x-form.input
                            name="name"
                            label="Nom de la Gare"
                            required="true" />

                        <div class="mb-10">
                            <label for="type" class="form-label required">Type de Gare</label>
                            <select name="type" x-model="hub_show" id="type" class="form-select" data-placeholder="---  Selectionner un type de gare ---" required>
                                <option></option>
                                <option value="halte">Halte</option>
                                <option value="small">Petite Gare</option>
                                <option value="medium">Moyenne Gare</option>
                                <option value="large">Grande Gare</option>
                                <option value="terminus">Terminus</option>
                            </select>
                        </div>

                        <x-form.input
                            name="nb_quai"
                            label="Nombre de quai"
                            required="true" />

                        <div class="d-flex flex-column">
                            <span class="form-label mb-2">Transport accepté</span>
                            <x-form.checkbox
                                name="transports[]"
                                label="Ter" />
                            <x-form.checkbox
                                name="transports[]"
                                label="Tgv" />
                            <x-form.checkbox
                                name="transports[]"
                                label="Intercité" />
                            <x-form.checkbox
                                name="transports[]"
                                label="Tram" />

                            <x-form.checkbox
                                name="transports[]"
                                label="Bus" />

                            <x-form.checkbox
                                name="transports[]"
                                label="Metro" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="" x-show="hub_show === 'large' || hub_show === 'terminus'">
                            <x-form.switches
                                name="is_hub"
                                label="Est un hub ?" />
                            <x-form.checkbox
                                name="active"
                                label="Actif" />
                            <div class="mb-10">
                                <label for="status" class="form-label required">Etape de Developpement</label>
                                <select name="status" id="status" class="form-select" data-control="select2" data-placeholder="---  Selectionner un status ---" required>
                                    <option></option>
                                    <option value="beta">Beta</option>
                                    <option value="prod">Production</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@push("scripts")
    <script type="text/javascript">
        document.querySelectorAll("[data-control='select2']").forEach(select => {
            $(select).select2()
        })
    </script>
@endpush
