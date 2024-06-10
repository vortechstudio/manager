<div>
    <div class="card shadow-sm">
        <div class="card-header">
            <div class="card-title">
                <div class="position-relative w-250px me-3">
                    <i class="ki-duotone ki-magnifier fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-4"><span class="path1"></span><span class="path2"></span></i>
                    <input type="text" class="form-control border-gray-200 h-40px bg-body ps-13 fs-7" wire:model.live.debounce.500ms="search" placeholder="Rechercher un évènement..." data-kt-search-element="input">
                </div>
                <select wire:model.live="perPage" class="form-select border-gray-200 h-40px bg-body ps-13 fs-7 w-100px me-3" id="perPage">
                    @foreach([10,25,50,100] as $value)
                        <option value="{{ $value }}">{{ $value }}</option>
                    @endforeach
                </select>
                <select wire:model.live="bySector" class="form-select border-gray-200 h-40px bg-body ps-13 fs-7 w-250px me-3" id="bySector">
                    <option value="">-- Selectionner le secteur ---</option>
                    @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Railway\Core\AchievementTypeEnum::class)->toArray() as $type)
                        <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                    @endforeach
                </select>
                <select wire:model.live="byLevel" class="form-select border-gray-200 h-40px bg-body ps-13 fs-7 w-250px me-5" id="byLevel">
                    <option value="">-- Selectionner le level ---</option>
                    @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Railway\Core\AchievementLevelEnum::class)->toArray() as $type)
                        <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="card-toolbar gap-5">
                <button data-bs-toggle="modal" data-bs-target="#addTrophy" type="button" class="btn btn-sm btn-light">
                    Nouveau trophée
                </button>
                <button wire:click="export" class="btn btn-sm btn-light" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="export"><i class="fa-solid fa-file-upload me-3"></i> Exporter</span>
                    <span wire:loading wire:target="export"><i class="fa-solid fa-spinner fa-spin me-3"></i> Export en cours...</span>
                </button>
                <button wire:click="import" class="btn btn-sm btn-light" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="import"><i class="fa-solid fa-file-download me-3"></i> Importer</span>
                    <span wire:loading wire:target="import"><i class="fa-solid fa-spinner fa-spin me-3"></i> Export en cours...</span>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
                <div class="table-loading-message">
                    <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
                </div>
                <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5 align-middle">
                    <thead>
                    <tr class="fw-bold fs-3">
                        <th></th>
                        <x-base.table-header :direction="$orderDirection" name="sector" :field="$orderField">Secteur</x-base.table-header>
                        <x-base.table-header :direction="$orderDirection" name="name" :field="$orderField">Désignation</x-base.table-header>
                        <th>Nombre de déblocage</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($achievements as $trophy)
                        <tr>
                            <td>
                                @if(!$trophy->action_function_exist)
                                    <i class="fa-solid fa-exclamation-circle text-danger fs-2 animate__animated animate__flash animate__infinite" data-bs-toggle="tooltip" data-bs-title="La fonction n'existe pas dans le code"></i>
                                @endif
                            </td>
                            <td>{{ Str::ucfirst($trophy->type->value) }}</td>
                            <td>
                                <div class="d-flex flex-row justify-content-between align-items-center">
                                    <div class="d-flex flex-row align-items-center">
                                        <div class="symbol symbol-50px me-3">
                                            <img src="{{ Storage::url('icons/railway/success/'.$trophy->level->value.'.png') }}" alt="">
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold fs-3">{{ $trophy->name }}</span>
                                            <span class="text-gray-600">{{ $trophy->description }}</span>
                                        </div>
                                    </div>
                                    @if($trophy->rewards->count() > 0)
                                        @if($trophy->rewards->count() == 1)
                                            <div class="symbol symbol-50px">
                                                <img src="{{ Storage::url('icons/railway/'.$trophy->rewards()->first()->type->value.'.png') }}" alt="">
                                                <span class="symbol-badge badge badge-sm badge-primary top-100 start-100">{{ $trophy->rewards()->first()->quantity }}</span>
                                            </div>
                                        @else
                                            <div class="symbol-group symbol-hover">
                                                @foreach($trophy->rewards as $reward)
                                                    <div class="symbol symbol-50px">
                                                        <img src="{{ Storage::url('icons/railway/'.$reward->type_reward->value.'.png') }}" alt="">
                                                        <span class="symbol-badge badge badge-sm badge-primary top-100 start-100">{{ $reward->amount_reward }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-circle badge-primary">{{ \App\Models\User\Railway\UserRailwayAchievement::where('railway_achievement_id', $trophy->id)->count() }}</span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a wire:navigate href="{{ route('railway.achievement.show', $trophy->id) }}" class="btn btn-icon btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Voir le trophée">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="" wire:click="delete({{ $trophy->id }})" class="btn btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Supprimer le trophée" wire:confirm="Voulez-vous supprimer ce trophée !">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $achievements->links() }}
        </div>
    </div>
    <div wire:ignore.self class="modal fade" tabindex="-1" id="addTrophy">
        <form action="" wire:submit="save" method="POST">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Nouveau Trophée</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 col-lg-6 mb-5">
                                <div class="mb-10" wire:ignore>
                                    <label for="sector" class="form-label required">Type de Trophée</label>
                                    <select wire:model="sector" data-control="select2" name="sector" id="sector" class="form-select" required>
                                        <option>--- Sélectionner un type de trophée ---</option>
                                        @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Railway\Core\AchievementTypeEnum::class)->toArray() as $sector)
                                            <option value="{{ $sector['value'] }}">{{ $sector['label'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-6 mb-5">
                                <div class="mb-10" wire:ignore>
                                    <label for="level" class="form-label required">Niveau du trophée</label>
                                    <select wire:model="level" name="level" data-control="select2" id="level" class="form-select" required>
                                        <option>--- Sélectionner un niveau ---</option>
                                        @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Railway\Core\AchievementLevelEnum::class)->toArray() as $level)
                                            <option value="{{ $level['value'] }}">{{ $level['label'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <x-form.input
                            name="name"
                            label="Nom du trophée"
                            required="true" />
                        <x-form.textarea
                            name="description"
                            label="Description du trophée" />
                        <div class="row">
                            <div class="col-sm-12 col-lg-6 mb-5">
                                <x-form.input
                                    type="number"
                                    name="goal"
                                    label="Qte avant déblocage"
                                    required="true" />
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermé</button>
                        <button type="submit" class="btn btn-primary">
                            <span wire:loading.remove wire:target="save"><i class="fa-solid fa-check me-3"></i> Valider</span>
                            <span wire:loading wire:target="save"><i class="fa-solid fa-spinner fa-spin-pulse"></i>Veuillez patienter</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<x-script.pluginForm />
@push('scripts')
    <x-base.close-modal />
@endpush
