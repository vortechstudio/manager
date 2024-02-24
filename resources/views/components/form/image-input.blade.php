@push("styles")
    <style>
        .image-input-placeholder {
            background-image: url('https://placehold.co/600x400');
        }

        [data-bs-theme="dark"] .image-input-placeholder {
            background-image: url('https://placehold.co/600x400/black/white');
        }
    </style>
@endpush

<div class="image-input image-input-outline {{ $width }}" data-kt-image-input="true" style="background-image: url(https://placehold.co/600x400)">
    <div class="image-input-wrapper {{ $width }}" style="background-image: url(https://placehold.co/600x400)">
        <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
               data-kt-image-input-action="change"
               data-bs-toggle="tooltip"
               data-bs-dismiss="click"
               title="Changer l'image">
            <i class="fa-solid fa-pencil fs-5"></i>
            <input type="file" wire:model="{{ $name }}" accept="{{ $accept }}" />
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
