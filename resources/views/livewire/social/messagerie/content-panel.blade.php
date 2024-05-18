<div>
    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">{{ $message->message_subject }}</h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#editContent">
                    Editer le message
                </button>
            </div>
        </div>
        <div class="card-body">
            {!! $message->message_content !!}
        </div>
    </div>
    <div wire:ignore.self class="modal fade" tabindex="-1" id="editContent">
        <form action="" wire:submit="save" method="POST">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Edition du message</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 col-lg-6">
                                <x-form.input
                                    name="message_subject"
                                    label="Sujet"
                                    :value="$message->message_subject"
                                    required="true" />
                            </div>
                            <div class="col-sm-12 col-lg-3">
                                <div class="mb-10">
                                    <label for="message_type" class="form-label required">Type de matériel</label>
                                    <select wire:model="message.message_type" name="message_type" id="message_type" class="form-select" data-placeholder="---  Selectionner un type de matériel ---" required>
                                        <option></option>
                                        @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Railway\Core\MessageTypeEnum::class)->toArray() as $type)
                                            <option value="{{ $type['value'] }}" @if($type['value'] == $message->message_type->value) selected @endif>{{ $type['label'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-3">
                                <div class="mb-10">
                                    <label for="service_id" class="form-label required">Services</label>
                                    <select wire:model="message.service_id" name="service_id" id="service_id" class="form-select" data-placeholder="---  Selectionner un type de matériel ---" required>
                                        <option></option>
                                        @foreach(\Spatie\LaravelOptions\Options::forModels(\App\Models\Config\Service::class, 'name', 'id')->toArray() as $type)
                                            <option value="{{ $type['value'] }}" @if($type['value'] == $message->service_id) selected @endif>{{ $type['label'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <x-form.textarea
                                type="ckeditor"
                                name="message_content"
                                label="Contenue du message"
                                value="{!! $message->message_content !!}"
                                required="true" />
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">
                            <span wire:loading.remove wire:target="save"><i class="fa-regular fa-paper-plane me-3"></i> Envoyer</span>
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
