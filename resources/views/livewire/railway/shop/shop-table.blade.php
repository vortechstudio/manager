<div>
    <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
        <div class="table-loading-message">
            <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
        </div>
        <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5 align-middle">
            <thead>
            <tr class="fw-bold fs-3">
                <th>Categorie</th>
                <th>NB d'article</th>
                <th></th>
            </tr>
            </thead>
            @if($shop->categories()->count() == 0)
                <tbody>
                <tr>
                    <td colspan="7">
                        <x-base.is-null
                            text="Aucune catégories enregistrées" />
                    </td>
                </tr>
                </tbody>
            @else
                <tbody>
                @foreach($shop->categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->items()->count() }}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('railway.shop.category', $category->id) }}" class="btn btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Gérer la catégorie"><i class="fa-solid fa-eye"></i></a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            @endif
        </table>
    </div>
</div>
