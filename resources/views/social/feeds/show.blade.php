@extends("layouts.app")
@section("title")
    Feed: {{ $feed->title }}
@endsection

@section("content")
    <x-base.toolbar
        :title="$feed->title"
        :breads="array('Social', 'Gestion des articles', $feed->title)"
        sticky="true"
        return="true"/>

    <div class="row">
        <div class="col-md-9 col-sm-12">

            <div class="card shadow-sm">
                @if($feed->type == 'image' && $feed->images()->count() > 0)
                    <img src="{{ $feed->images()->first()->path }}" alt="{{ $feed->title }}">
                @endif
                <div class="card-body">
                    {!! $feed->post !!}
                    <div class="separator my-10"></div>
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Tous les commentaires ({{ $feed->comments()->count() }})</h3>
                        </div>
                        <div class="card-body">
                            @if($feed->comments()->count() > 0)
                                @foreach($feed->comments as $comment)
                                    <livewire:social.post.post-comment-block :comment="$comment" />
                                @endforeach
                            @else
                                <x-base.is-null text="Aucun commentaire pour cette article"/>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-3 col-sm-12"></div>
    </div>

@endsection
