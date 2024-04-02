<div>
    <div class="d-flex flex-row align-items-end mb-5">
        <div class="position-relative w-250px me-3">
            <i class="ki-duotone ki-magnifier fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-4"><span class="path1"></span><span class="path2"></span></i>
            <input type="text" class="form-control border-gray-200 h-40px bg-body ps-13 fs-7" wire:model.live.debounce.500ms="search" placeholder="Rechercher un évènement..." data-kt-search-element="input">
        </div>
        <select wire:model="perPage" class="form-select border-gray-200 h-40px bg-body ps-13 fs-7 w-100px" id="perPage">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
    </div>
    <div class="table-responsive">
        <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5 align-middle">
            <thead>
            <tr class="fw-bold fs-3">
                <x-base.table-header :direction="$orderDirection" name="id" :field="$orderField">#</x-base.table-header>
                <x-base.table-header :direction="$orderDirection" name="title" :field="$orderField">Titre</x-base.table-header>
                <x-base.table-header :direction="$orderDirection" name="user_id" :field="$orderField">Membre</x-base.table-header>
                <th>Cercle</th>
                <x-base.table-header :direction="$orderDirection" name="published" :field="$orderField">Publier</x-base.table-header>
                <th>Statistique</th>
                <th></th>
            </tr>
            </thead>
            @if($feeds->count() > 0)
                <tbody>
                @foreach($feeds as $feed)
                    <tr>
                        <td>{{ $feed->id }}</td>
                        <td>
                            @if($feed->has_image)
                            <div class="d-flex flex-row align-items-center">
                                <div class="symbol symbol-30px symbol-2by3 me-5">
                                    <img src="{{ $feed->images()->first()->path }}" alt="{{ $feed->title }}">
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="fw-bolder">{{ $feed->title }}</span>
                                    <span class="text-muted fst-italic">{!! Str::limit($feed->post, 50, '') !!}</span>
                                </div>
                            </div>
                            @else
                                <div class="d-flex flex-column">
                                    <span class="fw-bolder">{{ $feed->title }}</span>
                                    <span class="text-muted fst-italic">{!! Str::limit($feed->post, 50, '') !!}</span>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex flex-row align-items-center">
                                <div class="symbol symbol-30px symbol-circle me-5">
                                    <img src="{{ $feed->user->socials()->first()->avatar }}" alt="{{ $feed->user->name }}">
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="fw-bolder">{{ $feed->user->name }}</span>
                                    <span class="text-muted fst-italic">{{ $feed->user->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-row align-items-center">
                                <div class="symbol symbol-30px symbol-circle me-5">
                                    <img src="{{ \App\Models\Social\Cercle::getImage($feed->cercle()->first()->id, 'icon') }}" alt="{{ $feed->cercle()->first()->name }}">
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="fw-bolder">{{ $feed->cercle()->first()->name }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($feed->published)
                                <span class="badge badge-light-success">Publie</span>
                            @else
                                <span class="badge badge-light-danger">Non publie</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex flex-row justify-content-between align-items-center w-75">
                                <span>Nombre de commentaires</span>
                                <span class="badge badge-primary">{{ $feed->comments()->count() }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('social.feeds.show', $feed->id) }}" class="btn btn-icon btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Gérer l'évènement">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <button class="btn btn-icon btn-light-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Rejeter ce poste" onclick="confirm('Etes-vous sur de vouloir rejeter cet article ?') || event.stopImmediatePropagation()" wire:click="reject({{ $feed->id }})">
                                    <i class="fa-solid fa-ban" wire:loading.remove wire:target="reject({{ $feed->id }})"></i>
                                    <i class="fa-solid fa-spinner fa-spin-pulse" wire:loading wire:target="reject({{ $feed->id }})"></i>
                                </button>
                                <button wire:click="destroy({{ $feed->id }})" onclick="confirm('Voulez-vous supprimer ce service ?') || event.stopImmediatePropagation()" class="btn btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Supprimer l'évènement">
                                    <i class="fa-solid fa-trash" wire:loading.remove wire:target="destroy({{ $feed->id }})"></i>
                                    <i class="fa-solid fa-spinner fa-spin-pulse" wire:loading wire:target="destroy({{ $feed->id }})"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            @else
                <tbody>
                    <tr>
                        <td colspan="7">
                            <x-base.is-null
                                text="Aucun article disponible" />
                        </td>
                    </tr>
                </tbody>
            @endif
        </table>
    </div>
    {{ $feeds->links() }}
</div>
