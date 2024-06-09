<div wire:ignore.self class="modal fade" tabindex="-1" id="addPackage">
    <form action="" wire:submit="save">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Nouveau Package</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <x-form.input
                        name="name"
                        label="Nom du package"
                        required="true" />

                    <x-form.textarea
                        name="description"
                        label="Description du package"
                        required="true" />

                    <div class="row">
                        <div class="col-sm-12 col-lg-6 mb-5">
                            <div class="mb-10">
                                <label for="currency_type" class="form-label required">Type de monnaie</label>
                                <select wire:model="currency_type" name="currency_type" id="currency_type" class="form-select" required>
                                    <option>-- Selectionner un type de monnaie --</option>
                                    @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Config\Shop\ShopItemCurrencyTypeEnum::class)->toArray() as $item)
                                        <option value="{{ $item['value'] }}">{{ $item['label'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-6 mb-5">
                            <x-form.input
                                name="price"
                                label="Montant du package"
                                required="true" />
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5 align-middle" id="tablePackageSelect">
                            <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th>Produit</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($products) == 0)
                                <tr>
                                    <td colspan="2">
                                        <x-base.is-null text="Aucun produits disponible" />
                                    </td>
                                </tr>
                            @else
                                @foreach($products as $product)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="selectedProducts" wire:model="selectedProducts" value="{{ $product->id }}" id="selectedProducts" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-30px me-2">
                                                    <div class="symbol-label border border-2 {{ $product->rarity_border_color }}">
                                                        <img src="{{ $product->image }}" class="img-fluid" alt="">
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bold fs-3">{{ $product->name }}</span>
                                                    <span class="text-muted fs-5 fst-italic">{{ $product->description }}</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="save">
                        <span wire:loading.class="d-none" wire:target="save">Sauvegarder</span>
                        <span class="d-none" wire:loading.class.remove="d-none" wire:target="save">
                            <div class="spinner-grow me-2" role="status">
                              <span class="visually-hidden">Loading...</span>
                            </div>
                            Chargement...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('styles')
    <link href="{{ asset('/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@push('scripts')
    <script src="{{ asset('/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script>
        $('#tablePackageSelect').DataTable({
            "scrollY": "500px",
            "scrollCollapse": true,
            "paging": false,
            "dom": "<'table-responsive'tr>"
        })
    </script>
@endpush
