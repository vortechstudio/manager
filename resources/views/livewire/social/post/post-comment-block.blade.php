<div class="d-flex flex-row justify-content-between align-items-center bg-gray-300 p-5 rounded-3">
    <div class="d-flex flex-row">
        <div class="symbol symbol-30px symbol-circle me-3">
            <img src="{{ $comment->user->socials()->first()->avatar }}" alt="{{ $comment->user->name }}" />
        </div>
        <div class="d-flex flex-column">
            <span class="fw-bold">
                {{ $comment->user->name }}
                @if($comment->reject()->count() > 0)
                    <span class="badge badge-light-danger">Commentaire rejeter</span>
                @endif
            </span>
            <span class="text-muted mb-5">{{ $comment->created_at->diffForHumans() }}</span>
            {!! $comment->comment !!}
        </div>
    </div>
    <button wire:click="reject({{ $comment->id }})" class="btn btn-sm btn-icon btn-danger">
        <i class="fa-solid fa-ban" wire:loading.remove wire:target="reject({{ $comment->id }})"></i>
        <i class="fa-solid fa-spinner fa-spin" wire:loading wire:target="reject({{ $comment->id }})"></i>
    </button>
</div>
