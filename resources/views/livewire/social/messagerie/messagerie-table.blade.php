<div>
    <div class="d-flex flex-row align-items-end mb-5">
        <div class="position-relative w-250px me-3">
            <i class="ki-duotone ki-magnifier fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-4"><span class="path1"></span><span class="path2"></span></i>
            <input type="text" class="form-control border-gray-200 h-40px bg-body ps-13 fs-7" wire:model.live.debounce.500ms="search" placeholder="Rechercher un service..." data-kt-search-element="input">
        </div>
        <select wire:model.live="perPage" class="form-select border-gray-200 h-40px bg-body ps-13 fs-7 w-100px me-5" id="perPage">
            @foreach([10,25,50,100] as $value)
                <option value="{{ $value }}">{{ $value }}</option>
            @endforeach
        </select>
        <select wire:model.live="selectTypeMessage" class="form-select border-gray-200 h-40px bg-body ps-13 fs-7 w-250px me-5" id="selectTypeMessage">
            <option value=""></option>
            @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Railway\Core\MessageTypeEnum::class)->toArray() as $type)
                <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
            @endforeach
        </select>
        <button class="btn btn-outline btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addMessage"><i class="fa-solid fa-plus-circle me-3"></i> Nouveau Message</button>
    </div>
    <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
        <div class="table-loading-message">
            <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
        </div>
        <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5 align-middle">
            <thead>
            <tr class="fw-bold fs-3">
                <x-base.table-header :direction="$orderDirection" name="message_subject" :field="$orderField">Sujet</x-base.table-header>
                <x-base.table-header :direction="$orderDirection" name="message_type" :field="$orderField">Type</x-base.table-header>
                <th></th>
            </tr>
            </thead>
            @if($messages->count() == 0)
                <tbody>
                <tr>
                    <td colspan="3">
                        <x-base.is-null
                            text="Aucun message enregistrées" />
                    </td>
                </tr>
                </tbody>
            @else
                <tbody>
                @foreach($messages as $message)
                    <tr>
                        <td>{{ $message->message_subject }}</td>
                        <td>{{ Str::ucfirst($message->message_type->value) }}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a wire:navigate href="{{ route('social.messagerie.show', $message->id) }}" class="btn btn-icon btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Voir le message">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="" wire:click="destroy({{ $message->id }})" class="btn btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Supprimer le message">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            @endif
        </table>
    </div>
    {{ $messages->links() }}
    <div wire:ignore.self class="modal fade" tabindex="-1" id="addMessage">
        <form wire:submit="save" method="post">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Nouveau message</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 col-lg-9 mb-5">
                                <x-form.input
                                    name="message_subject"
                                    label="Sujet"
                                    required="true" />

                                <div class="mb-10">
                                    <label for="service_id" class="form-label required">Service Affilier</label>
                                    <select wire:model="service_id" name="service_id" id="service_id" class="form-select" data-placeholder="---  Selectionner un service ---" required>
                                        <option></option>
                                        @foreach(\App\Models\Config\Service::all() as $service)
                                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <x-form.textarea
                                    type="ckeditor"
                                    name="message_content"
                                    label="Contenue du message"
                                    required="true" />
                            </div>
                            <div class="col-sm-12 col-lg-3 mb-5">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <div class="mb-10">
                                            <label for="message_type" class="form-label required">Type de message</label>
                                            <select wire:model="message_type" name="message_type" id="message_type" class="form-select" data-placeholder="---  Selectionner un type de message ---" required>
                                                <option></option>
                                                @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Railway\Core\MessageTypeEnum::class)->toArray() as $type)
                                                    <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <x-form.checkbox
                                                name="allUser"
                                                value="true"
                                                label="Envoyer à tous les utilisateurs" />

                                            <div class="mb-10">
                                                <label for="user_id" class="form-label">Utilisateur</label>
                                                <select wire:model="user_id" name="user_id" id="user_id" class="form-select" data-placeholder="---  Selectionner un utilisateur ---">
                                                    <option></option>
                                                    @foreach(\App\Models\User\User::all() as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div>
                                            <x-form.checkbox
                                                name="retarded"
                                                value="true"
                                                label="Retarder le message" />

                                            <x-form.input
                                                type="datetime-local"
                                                name="retarded_at"
                                                label="Date/Heure d'envoie" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" wire:click="resetForm">Réinitialiser</button>
                        <button type="submit" class="btn btn-primary">
                            <span wire:loading.remove wire:target="save"><i class="fa-regular fa-paper-plane me-3"></i> Envoyer</span>
                            <span wire:loading wire:target="save"><i class="fa-solid fa-spinner fa-spin-pulse"></i>Veuillez patienter</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @push('scripts')
        <x-base.close-modal />
    @endpush
</div>
