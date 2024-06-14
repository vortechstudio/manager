<div class="modal fade" tabindex="-1" id="addResearch">
    <form action="" wire:submit="{{ $researches ? 'editing' : 'save' }}">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{ $researches ? $researches->name : 'Nouvelle Recherche' }}</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <x-form.input
                        name="name"
                        label="Nom de la recherche"
                        required="true" />

                    <x-form.textarea
                        name="description"
                        label="Description de la recherche" />

                    <div class="row">
                        <div class="col-sm-12 col-lg-3 mb-5">
                            <x-form.input
                                name="level"
                                type="number"
                                label="Combien de niveau"
                                required="true" />
                        </div>
                        <div class="col-sm-12 col-lg-3 mb-5">
                            <x-form.input
                                name="cost"
                                type="number"
                                label="Cout de base de la recherche"
                                required="true" />
                        </div>
                        <div class="col-sm-12 col-lg-3 mb-5">
                            <x-form.input
                                name="time_base"
                                type="number"
                                label="Nombre de minute de base"
                                required="true" />
                        </div>
                        <div class="col-sm-12 col-lg-3 mb-5">
                            <div class="mb-10">
                                <label for="parent_id" class="form-label">Parent</label>
                                <select name="parent_id" id="parent_id" wire:model="parent_id" class="form-select" data-control="select2" data-placeholder="---  Selectionner un type de matériel ---">
                                    <option></option>
                                    @foreach(\App\Models\Railway\Research\RailwayResearches::where('railway_research_category_id', $category->id)->get() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="{{ $researches ? 'editing' : 'save' }}">
                        <span wire:loading.class="d-none" wire:target="{{ $researches ? 'editing' : 'save' }}">Sauvegarder</span>
                        <span class="d-none" wire:loading.class.remove="d-none" wire:target="{{ $researches ? 'editing' : 'save' }}">
                            <div class="spinner-grow me-2" role="status">
                              <span class="visually-hidden">Loading...</span>
                            </div>
                            Chargement...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<x-script.pluginForm />
