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
                    @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Railway\Core\AchievementSectorEnum::class)->toArray() as $type)
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
            <div class="card-toolbar">
                <button data-bs-toggle="modal" data-bs-target="#addTrophy" type="button" class="btn btn-sm btn-light">
                    Nouveau trophée
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
                        <x-base.table-header :direction="$orderDirection" name="sector" :field="$orderField">Secteur</x-base.table-header>
                        <x-base.table-header :direction="$orderDirection" name="name" :field="$orderField">Désignation</x-base.table-header>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($achievements as $trophy)
                        <td>{{ Str::ucfirst($trophy->sector->value) }}</td>
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
                                @if($trophy->rewards()->count() > 0)
                                    @if($trophy->rewards()->count == 1)
                                        <div class="symbol symbol-50px">
                                            <img src="{{ Storage::url('icons/railway/success/reward/'.$trophy->rewards()->first()->type_reward.'.png') }}" alt="">
                                            <span class="symbol-badge badge badge-sm badge-primary top-100 start-100">{{ $trophy->rewards()->first()->amount_reward }}</span>
                                        </div>
                                    @else
                                        <div class="symbol-group symbol-hover">
                                            @foreach($trophy->rewards as $reward)
                                                <div class="symbol symbol-50px">
                                                    <img src="{{ Storage::url('icons/railway/success/reward/'.$reward->type_reward.'.png') }}" alt="">
                                                    <span class="symbol-badge badge badge-sm badge-primary top-100 start-100">{{ $reward->amount_reward }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                @endif
                            </div>
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
                                <div class="mb-10">
                                    <label for="sector" class="form-label required">Type de Trophée</label>
                                    <select wire:model="sector" name="sector" id="sector" class="form-select" required>
                                        <option>--- Sélectionner un type de trophée ---</option>
                                        @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Railway\Core\AchievementSectorEnum::class)->toArray() as $sector)
                                            <option value="{{ $sector['value'] }}">{{ $sector['label'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-6 mb-5">
                                <div class="mb-10">
                                    <label for="level" class="form-label required">Niveau du trophée</label>
                                    <select wire:model="level" name="level" id="level" class="form-select" required>
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
                                    name="action"
                                    label="Action"
                                    required="true"
                                    hint="Cette action est le déclencheur de déblocage du trophée par le joueur" />
                            </div>
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

@push('scripts')
    <x-base.close-modal />
@endpush
