<div>
    <div class="card shadow-sm mb-5">
        <div class="card-body">
            <div class="d-flex flex-end">
                <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addReward">Ajouter une récompense</button>
            </div>
        </div>
    </div>
    <div class="card shadow-sm" x-data="{card_title: 'Récompenses'}">
        <div class="card-header">
            <h3 class="card-title" x-text="card_title"></h3>
            <div class="card-toolbar">
                <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                    <li class="nav-item">
                        <a x-on:click="card_title = 'Récompenses'" class="nav-link active" data-bs-toggle="tab" href="#rewards">Récompenses</a>
                    </li>
                    <li class="nav-item">
                        <a x-on:click="card_title = 'Joueurs'" class="nav-link" data-bs-toggle="tab" href="#users">Joueurs</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="rewards" role="tabpanel">
                    <livewire:railway.achievement.achievement-rewards-table :achievement="$achievement" />
                </div>
                <div class="tab-pane" id="users" role="tabpanel">
                    <livewire:admin.user.user-table :users="$users" />
                </div>
            </div>
        </div>

    </div>
    <div wire:ignore.self class="modal fade" tabindex="-1" id="addReward">
        <form action="" wire:submit="save" method="POST">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Nouvelle récompense</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body" x-data="{selectedReward: ''}">
                        <div class="mb-10">
                            <label for="selectedReward" class="form-label">Récompense Existante</label>
                            <select wire:model.live="selectedReward" name="selectedReward" id="selectedReward" class="form-select">
                                <option class="text-gray-300">-- Selectionner une récompense existante</option>
                                @foreach(\App\Models\Railway\Core\RailwayAchievementReward::all() as $reward)
                                    <option value="{{ $reward->id }}">{{ $reward->type->value }} ({{ $reward->quantity }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div x-show="selectedReward === ''">
                            <div class="row">
                                <div class="col-sm-12 col-lg-6 mb-5">
                                    <div class="mb-10">
                                        <label for="type_reward" class="form-label required">Type de matériel</label>
                                        <select wire:model="type_reward" name="type_reward" id="type_reward" class="form-select" required>
                                            <option>-- Sélectionner un type de récompense --</option>
                                            @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Railway\Core\AchievementRewardTypeEnum::class)->toArray() as  $type)
                                                <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-6 mb-5">
                                    <x-form.input
                                        type="number"
                                        name="amount_reward"
                                        label="Montant de la récompense"
                                        required="true" />
                                </div>
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
