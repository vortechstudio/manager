<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="card-title">Liste des recherches</h3>
        <div class="card-toolbar">
            <div class="position-relative min-w-250px me-3">
                <i class="ki-duotone ki-magnifier fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-4"><span class="path1"></span><span class="path2"></span></i>
                <input type="text" class="form-control border-gray-200 h-40px bg-body ps-13 fs-7" wire:model.live.debounce.500ms="search" placeholder="Rechercher une recherche..." data-kt-search-element="input">
            </div>
            <select wire:model.live="perPage" class="form-select border-gray-200 h-40px bg-body ps-13 fs-7 w-100px me-3" id="perPage">
                @foreach([10,25,50,100] as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addResearch">Nouvelle recherche</button>
        </div>
    </div>
    <div class="card-body">
        @if(count($researches) == 0)
            <x-base.is-null text="Aucune recherche de disponible pour cette catégorie" />
        @else
            <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5 align-middle">
                <thead>
                    <tr>
                        <x-base.table-header :direction="$orderDirection" name="name" :field="$orderField">Désignation</x-base.table-header>
                        <th>Nb de niveau</th>
                        <th>Bénéfices</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($researches as $research)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-50px me-3">
                                        <img src="{{ $research->image }}" alt="">
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fs-3 fw-bold">{{ $research->name }}</span>
                                        <span class="fs-5 text-muted fst-italic">{{ $research->description }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $research->level }}</td>
                            <td>
                                <ul>
                                    @if($research->benefits)
                                        @foreach(json_decode($research->benefits, true) as $benefit)
                                            <li>{{ $benefit['designation'] }}</li>
                                        @endforeach
                                    @endif
                                </ul>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="" class="btn btn-sm btn-icon btn-secondary" data-bs-toggle="tooltip" title="Voir la recherche">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <button wire:click="delete({{ $research->id }})" class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip" title="Supprimer la recherche" wire:confirm="Est-vous sur ?" wire:loading.attr="disabled" wire:target="delete({{ $research->id }})">
                                        <span wire:loading.remove><i class="fa-solid fa-trash"></i> </span>
                                        <span class="d-none" wire:loading.class.remove="d-none"><i class="fa-solid fa-spinner fa-spin"></i> </span>
                                    </button>
                                </div>
                            </td>
                            <td>
                                @if($research->hasChildrens())
                                    <button class="btn btn-icon btn-sm" wire:click="$toggle('node')">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    <div class="card-footer">
        {{ $researches->links() }}
    </div>
    @livewire('railway.research.research-form', ['category' => $category])
</div>
