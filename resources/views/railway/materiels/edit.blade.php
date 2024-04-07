@extends("layouts.app")
@section("title")
    Edition: {{ $engine->name }}
@endsection

@section("content")
    <form action="{{ route('railway.materiels.store') }}" method="POST">
        @csrf
        @method('PUT')
        <x-base.toolbar
            :title="$engine->name"
            :breads="array('Railway Manager', 'Gestion des matériels roulants', 'Edition', $engine->name)"
            submit="true"
            return="true"
            sticky="true" />

        @csrf

        <div class="row" x-data="{automotrice: {{ $engine->type_train->value == 'automotrice' }}, type_marchandise: {{ $engine->technical->marchandise->value != 'none' }}, in_shop: {{ $engine->in_shop }}}">
            <div class="col-sm-12 col-lg-9">
                <div class="card shadow-sm mb-5">
                    <div class="card-header">
                        <h3 class="card-title">Informations Générales</h3>
                    </div>
                    <div class="card-body">
                        <x-form.input
                            name="name"
                            value="{{ $engine->name }}"
                            label="Nom du matériel"
                            required="true" />

                        <div class="mb-10">
                            <label for="type_train" class="form-label required">Type de matériel</label>
                            <select x-model="automotrice" name="type_train" id="type_train" class="form-select" data-placeholder="---  Selectionner un type de matériel ---" required>
                                <option></option>
                                <option @if($engine->type_train->value == 'motrice') selected @endif value="motrice">Motrice</option>
                                <option @if($engine->type_train->value == 'voiture') selected @endif value="voiture">Voiture</option>
                                <option @if($engine->type_train->value == 'automotrice') selected @endif value="automotrice">Automotrice</option>
                                <option @if($engine->type_train->value == 'bus') selected @endif value="bus">Bus</option>
                            </select>
                        </div>

                        <div class="mb-10">
                            <label for="type_transport" class="form-label required">Type de matériel</label>
                            <select name="type_transport" id="type_transport" class="form-select" data-control="select2" data-placeholder="---  Selectionner un type de transport ---" required>
                                <option></option>
                                <option @if($engine->type_transport->value == 'ter') selected @endif value="ter">TER</option>
                                <option @if($engine->type_transport->value == 'tgv') selected @endif value="tgv">TGV</option>
                                <option @if($engine->type_transport->value == 'intercity') selected @endif value="intercity">Intercité</option>
                                <option @if($engine->type_transport->value == 'tram') selected @endif value="tram">Tram</option>
                                <option @if($engine->type_transport->value == 'metro') selected @endif value="metro">Metro</option>
                                <option @if($engine->type_transport->value == 'bus') selected @endif value="bus">Bus</option>
                                <option @if($engine->type_transport->value == 'other') selected @endif value="other">Other</option>
                            </select>
                        </div>

                        <div class="mb-10">
                            <label for="type_energy" class="form-label required">Type de matériel</label>
                            <select name="type_energy" id="type_energy" class="form-select" data-control="select2" data-placeholder="---  Selectionner un type d'énergie ---" required>
                                <option></option>
                                <option @if($engine->type_energy->value == 'vapeur') selected @endif value="vapeur">Vapeur</option>
                                <option @if($engine->type_energy->value == 'diesel') selected @endif value="diesel">Diesel</option>
                                <option @if($engine->type_energy->value == 'electrique') selected @endif value="electrique">Electrique</option>
                                <option @if($engine->type_energy->value == 'none') selected @endif value="none">Aucun</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm mb-5">
                    <div class="card-header">
                        <h3 class="card-title">Information Technique</h3>
                    </div>
                    <div class="card-body">
                        <x-form.input
                            name="essieux"
                            value="{{ $engine->technical->essieux }}"
                            label="Quel est le type d'essieux ?"
                            hint="Correspondance total"
                            required="true" />

                        <x-form.input
                            name="velocity"
                            value="{{ $engine->technical->velocity }}"
                            label="Vitesse Maximal"
                            required="true" />

                        <div class="mb-10">
                            <label for="type_motor" class="form-label required">Type de matériel</label>
                            <select name="type_motor" id="type_motor" class="form-select" data-control="select2" data-placeholder="---  Selectionner un type de motorisation ---" required>
                                <option></option>
                                <option @if($engine->technical->motor->value == 'diesel') selected @endif value="diesel">Diesel</option>
                                <option @if($engine->technical->motor->value == 'electrique 1500v') selected @endif value="electrique 1500v">Electrique 1500V</option>
                                <option @if($engine->technical->motor->value == 'electrique 25kv') selected @endif value="electrique 25Kv">Electrique 25kV</option>
                                <option @if($engine->technical->motor->value == 'electrique 1500v/25kv') selected @endif value="electrique 1500v/25Kv">Electrique 1500V/25kV</option>
                                <option @if($engine->technical->motor->value == 'vapeur') selected @endif value="vapeur">Vapeur</option>
                                <option @if($engine->technical->motor->value == 'hybride') selected @endif value="hybride">Hybride</option>
                                <option @if($engine->technical->motor->value == 'autre') selected @endif value="autre">Autre</option>
                            </select>
                        </div>

                        <div class="mb-10">
                            <label for="type_marchandise" class="form-label required">Type de marchandise</label>
                            <select x-model="type_marchandise" name="type_marchandise" id="type_marchandise" class="form-select" data-placeholder="---  Selectionner un type de marchandise ---" required>
                                <option></option>
                                <option @if($engine->technical->marchandise->value == 'none') selected @endif value="none">Aucun</option>
                                <option @if($engine->technical->marchandise->value == 'passagers') selected @endif value="passagers">Passagers</option>
                                <option @if($engine->technical->marchandise->value == 'marchandises') selected @endif value="marchandises">Marchandises</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm mb-5">
                    <div class="card-header">
                        <h3 class="card-title">Information relative à la gestion</h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-row justify-content-around align-items-center">
                            <x-form.switches
                                name="active"
                                :checked="$engine->active"
                                label="Ce matériel est-il actif ?" />

                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input x-model="in_shop" @if($engine->in_shop) checked @endif name="in_shop" class="form-check-input" type="checkbox" value="true" id="in_shop"/>
                                <label class="form-check-label" for="in_shop">
                                    Disponible en boutique
                                </label>
                            </div>

                            <x-form.switches
                                name="in_game"
                                :checked="$engine->in_game"
                                label="Disponible en jeu ?" />

                            <div class="mb-10">
                                <label for="visual" class="form-label required">Mode de production</label>
                                <select name="visual" id="visual" class="form-select" data-control="select2" data-placeholder="---  Selectionner un mode de production ---" required>
                                    <option></option>
                                    <option @if($engine->status->value == 'beta') selected @endif value="beta">Beta</option>
                                    <option @if($engine->status->value == 'production') selected @endif value="prod">Production</option>
                                </select>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <div class="col-sm-12 col-lg-3">
                <div class="card shadow-sm"
                     data-kt-sticky="true"
                     data-kt-sticky-name="docs-sticky-summary"
                     data-kt-sticky-offset="{default: false, xl: '200px'}"
                     data-kt-sticky-width="{lg: '250px', xl: '300px'}"
                     data-kt-sticky-left="auto"
                     data-kt-sticky-top="100px"
                     data-kt-sticky-animation="false"
                     data-kt-sticky-zindex="95"
                >
                    <div class="card-body">
                        <div x-show="automotrice === 'automotrice'">
                            <x-form.input
                                name="nb_wagon"
                                :value="$engine->technical->nb_wagon"
                                label="Nombre de voiture"
                                hint="Motrice comprise" />
                        </div>
                        <div x-show="type_marchandise === 'passagers' || type_marchandise === 'marchandises'">
                            <x-form.input
                                name="nb_marchandise"
                                :value="$engine->technical->nb_marchandise"
                                label="Capacité du matériel" />
                        </div>
                        @if($engine->in_shop)
                            <div x-show="in_shop === true">
                                <div class="mb-10">
                                    <label for="money_shop" class="form-label">Type de Monnaie</label>
                                    <select name="money_shop" id="money_shop" class="form-select" data-control="select2" data-placeholder="---  Selectionner un type de money ---">
                                        <option></option>
                                        <option @if($engine->shop->money->value == 'tpoint') selected @endif value="tpoint">T point</option>
                                        <option @if($engine->shop->money->value == 'argent') selected @endif value="argent">Argent</option>
                                        <option @if($engine->shop->money->value == 'euro') selected @endif value="euro">Argent Réel</option>
                                    </select>
                                </div>
                                <x-form.input
                                    name="price_shop"
                                    :value="$engine->shop->price"
                                    label="Montant initial" />
                            </div>
                        @endif
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
