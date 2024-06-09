@extends("layouts.app")
@section("title")
    {{ $product->name }}
@endsection

@section("content")
    <x-base.toolbar
        :title="$product->name"
        :breads="array('Railway Manager', 'Gestion de la boutique', $product->shopCategory->name, $product->name)"
        :return="true" />

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center p-5">
                <div class="d-flex align-items-start">
                    <div class="symbol symbol-100px border border-2 {{ $product->rarity_border_color }} me-3">
                        <div class="symbol-label">
                            <img src="{{ $product->image }}" class="img-fluid" alt="">
                        </div>
                    </div>
                   <div class="d-flex flex-column">
                       <div class="d-flex mb-2">
                           <span class="fw-bolder fs-1 me-3">{{ $product->name }}</span>
                           @if($product->is_packager)
                               <i class="fa-solid fa-boxes-packing fs-3 text-primary" data-bs-toggle="tooltip" data-bs-title="Appartient à un package"></i>
                           @endif
                       </div>
                       <span class="text-muted fs-6 fst-italic mb-2">{!! $product->description !!}</span>
                       <div class="d-flex align-items-center text-gray-400 fw-semibold">
                           <div class="me-5">
                               <i class="fa-solid fa-dot-circle fs-4 me-2"></i>
                               <span>{{ $product->section->name }}</span>
                           </div>
                           <div class="me-5">
                               <i class="fa-solid fa-shop fs-4 me-2"></i>
                               <span>{{ $product->shopCategory->shop->service->name }}</span>
                           </div>
                           <div class="me-5">
                               <i class="fa-solid fa-dot-circle fs-4 me-2"></i>
                               <span>{{ $product->shopCategory->name }}</span>
                           </div>
                           @isset($product->disponibility_end_at)
                               <div class="me-5">
                                   <i class="fa-solid fa-calendar-times fs-4 me-2"></i>
                                   <span>{{ $product->disponibility_end_at->format('d/m/Y à H:i') }}</span>
                               </div>
                           @endisset
                       </div>
                   </div>
                </div>
                <div class="d-flex flex-column">
                    <div class="d-flex gap-5 mb-5">
                        <button data-bs-toggle="modal" data-bs-target="#addItem" class="btn btn-secondary">Editer le produit</button>
                    </div>
                    <div class="d-flex align-items-center bg-gray-200 rounded-3 p-5 fw-bold fs-2">
                        {!! $product->price_format !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @livewire('railway.shop.shop-item-form', ["category" => $product->shopCategory, "item" => $product])
@endsection
