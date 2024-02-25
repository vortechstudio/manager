<div>
    <x-base.toolbar
        :title="$article->title"
        :breads="array('Social', 'Articles', $article->title)"
        :actions="[
            [
                'wire' => !$article->status ? 'publish('.$article->id.')' : 'unpublish('.$article->id.')',
                'text' => !$article->status ? 'Publier' : 'Dépublier',
                'color' => !$article->status ? 'success' : 'danger'
            ],
        ]"
    />

    <div class="row">
        <div class="col-sm-12 col-lg-4 mb-10">
            <div class="card shadow-sm">
                <img src="{{ Storage::url("blog/$article->id/default.webp") }}" class="card-img-top" alt="...">
                <div class="card-body">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <span class="fw-bold">Cercle</span>
                        <div class="d-flex flex-row align-items-center">
                            <div class="symbol symbol-30px symbol-circle me-3">
                                <img src="{{ $article->cercle->cercle_icon }}" alt="{{ $article->cercle->name }}">
                            </div>
                            <span>{{ $article->cercle->name }}</span>
                        </div>
                    </div>
                    <div class="separator border-3 border-gray-300 my-5"></div>
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <span class="fw-bold">Type</span>
                        <span>{{ $article->type }}</span>
                    </div>
                    <div class="separator border-3 border-gray-300 my-5"></div>
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <span class="fw-bold">Auteur</span>
                        <div class="d-flex flex-row align-items-center">
                            <div class="symbol symbol-30px symbol-circle me-3">
                                <img src="{{ $article->author()->first()->socials()->first()->avatar }}" alt="{{ $article->author()->first()->name }}">
                            </div>
                            <span>{{ $article->author()->first()->name }}</span>
                        </div>
                    </div>
                    <div class="separator border-3 border-gray-300 my-5"></div>
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <span class="fw-bold">Etat</span>
                        @if($article->published)
                            <span class="badge badge-success">Publier</span>
                        @else
                            <span class="badge badge-danger">Non Publier</span>
                        @endif
                    </div>
                    <div class="separator border-3 border-gray-300 my-5"></div>
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <span class="fw-bold">Publié sur les réseaux</span>
                        @if($article->publish_social)
                            <span class="badge badge-success">Publier</span>
                        @else
                            <span class="badge badge-danger">Non Publier</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
