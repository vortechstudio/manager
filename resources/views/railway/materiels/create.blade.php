@extends("layouts.app")
@section("title")
    Création d'un matériel roulant
@endsection

@section("content")
    <form action="{{ route('railway.materiels.store') }}" method="POST">
        @csrf
        <x-base.toolbar
            title="Création d'un matériel roulant"
            :breads="array('Railway Manager', 'Gestion des matériels roulants', 'Création d\'un matériel roulant')"
            submit="true"
            return="true"
            sticky="true" />

        @csrf

        <div class="row" x-data="{automotrice: '', type_marchandise: '', in_shop: false}">
            <div class="col-sm-12 col-lg-9">
                <div class="card shadow-sm mb-5">
                    <div class="card-header">
                        <h3 class="card-title">Informations Générales</h3>
                    </div>
                    <div class="card-body">
                        <x-form.input
                            name="name"
                            label="Nom du matériel"
                            required="true" />

                        <div class="mb-10">
                            <label for="type_train" class="form-label required">Type de matériel</label>
                            <select x-model="automotrice" name="type_train" id="type_train" class="form-select" data-placeholder="---  Selectionner un type de matériel ---" required>
                                <option></option>
                                <option value="motrice">Motrice</option>
                                <option value="voiture">Voiture</option>
                                <option value="automotrice">Automotrice</option>
                                <option value="bus">Bus</option>
                            </select>
                        </div>

                        <div class="mb-10">
                            <label for="type_transport" class="form-label required">Type de matériel</label>
                            <select name="type_transport" id="type_transport" class="form-select" data-control="select2" data-placeholder="---  Selectionner un type de transport ---" required>
                                <option></option>
                                <option value="ter">TER</option>
                                <option value="tgv">TGV</option>
                                <option value="intercity">Intercité</option>
                                <option value="tram">Tram</option>
                                <option value="metro">Metro</option>
                                <option value="bus">Bus</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="mb-10">
                            <label for="type_energy" class="form-label required">Type de matériel</label>
                            <select name="type_energy" id="type_energy" class="form-select" data-control="select2" data-placeholder="---  Selectionner un type d'énergie ---" required>
                                <option></option>
                                <option value="vapeur">Vapeur</option>
                                <option value="diesel">Diesel</option>
                                <option value="electrique">Electrique</option>
                                <option value="none">Aucun</option>
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
                            label="Quel est le type d'essieux ?"
                            hint="Correspondance total"
                            required="true" />

                        <x-form.input
                            name="velocity"
                            label="Vitesse Maximal"
                            required="true" />

                        <div class="mb-10">
                            <label for="type_motor" class="form-label required">Type de matériel</label>
                            <select name="type_motor" id="type_motor" class="form-select" data-control="select2" data-placeholder="---  Selectionner un type de motorisation ---" required>
                                <option></option>
                                <option value="diesel">Diesel</option>
                                <option value="electrique 1500V">Electrique 1500V</option>
                                <option value="electrique 25Kv">Electrique 25kV</option>
                                <option value="electrique 1500v/25Kv">Electrique 1500V/25kV</option>
                                <option value="vapeur">Vapeur</option>
                                <option value="hybride">Hybride</option>
                                <option value="autre">Autre</option>
                            </select>
                        </div>

                        <div class="mb-10">
                            <label for="type_marchandise" class="form-label required">Type de marchandise</label>
                            <select x-model="type_marchandise" name="type_marchandise" id="type_marchandise" class="form-select" data-placeholder="---  Selectionner un type de marchandise ---" required>
                                <option></option>
                                <option value="none">Aucun</option>
                                <option value="passagers">Passagers</option>
                                <option value="marchandises">Marchandises</option>
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
                                label="Ce matériel est-il actif ?" />

                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input x-model="in_shop" name="in_shop" class="form-check-input" type="checkbox" value="true" id="in_shop"/>
                                <label class="form-check-label" for="in_shop">
                                    Disponible en boutique
                                </label>
                            </div>

                            <x-form.switches
                                name="in_game"
                                label="Disponible en jeu ?" />

                            <div class="mb-10">
                                <label for="visual" class="form-label required">Mode de production</label>
                                <select name="visual" id="visual" class="form-select" data-control="select2" data-placeholder="---  Selectionner un mode de production ---" required>
                                    <option></option>
                                    <option value="beta">Beta</option>
                                    <option value="prod">Production</option>
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
                                label="Nombre de voiture"
                                hint="Motrice comprise" />
                        </div>
                        <div x-show="type_marchandise === 'passagers' || type_marchandise === 'marchandises'">
                            <x-form.input
                                name="nb_marchandise"
                                label="Capacité du matériel" />
                        </div>
                        <div x-show="in_shop === true">
                            <div class="mb-10">
                                <label for="money_shop" class="form-label">Type de Monnaie</label>
                                <select name="money_shop" id="money_shop" class="form-select" data-control="select2" data-placeholder="---  Selectionner un type de money ---">
                                    <option></option>
                                    <option value="tpoint">T point</option>
                                    <option value="argent">Argent</option>
                                    <option value="euro">Argent Réel</option>
                                </select>
                            </div>
                            <x-form.input
                                name="price_shop"
                                label="Montant initial" />
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
