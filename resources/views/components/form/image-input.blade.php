@push("styles")
    <style>
        .image-input-placeholder {
            background-image: url('{{ $default }}');
        }

        [data-bs-theme="dark"] .image-input-placeholder {
            background-image: url('{{ $default }}');
        }
    </style>
@endpush

<div wire:ignore.self class="image-input image-input-outline {{ $width }}" data-kt-image-input="true" style="background-image: url({{ $default }}); background-position: center; background-size: cover">
    <div class="image-input-wrapper {{ $width }}" style="background-image: url({{ $default }}); background-position: center; background-size: cover">
        <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
               data-kt-image-input-action="change"
               data-bs-toggle="tooltip"
               data-bs-dismiss="click"
               title="Changer l'image">
            <i class="fa-solid fa-pencil fs-5"></i>
            <input type="file" wire:model="{{ $isModel ? $model.'.'.$name : $name }}" name="{{ $name }}" accept="{{ $accept }}" />
            <input type="hidden" name="avatar_remove" />
        </label>
        <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
              data-kt-image-input-action="cancel"
              data-bs-toggle="tooltip"
              data-bs-dismiss="click"
              title="Annuler">
            <i class="fa-solid fa-xmark fs-3"></i>
        </span>
        <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
              data-kt-image-input-action="remove"
              data-bs-toggle="tooltip"
              data-bs-dismiss="click"
              title="Supprimer l'image">
            <i class="fa-solid fa-xmark fs-3"></i>
        </span>
    </div>
</div>
