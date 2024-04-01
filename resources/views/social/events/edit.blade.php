@extends("layouts.app")
@section("title")
    Edition d'un évènement
@endsection

@section("content")
    <x-base.toolbar
        title="Gestion des évènements"
        :breads="array('Social', 'Gestion des évènements', 'Edition d\'un évènement: '. $event->title)"
        return="true" />

    <div class="card shadow-sm">
        <form action="{{ route('social.events.update', $event->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="action" value="update">
            <div class="card-body">
                <x-form.input
                    name="title"
                    label="Titre de l'évènement"
                    value="{!! $event->title !!}"
                    required="true" />

                <div class="row">
                    <div class="col-lg-6 col-sm-12 mb-10">
                        <input data-format="datetime" class="form-control" name="start_at" placeholder="Pick a date" value="{{ $event->start_at->format('Y-m-d H:i') }}" required />
                    </div>
                    <div class="col-lg-6 col-sm-12 mb-10">
                        <input data-format="datetime" class="form-control" name="end_at" placeholder="Pick a date" value="{{ $event->end_at->format('Y-m-d H:i') }}" required />
                    </div>
                </div>

                <x-form.textarea
                    type="simple"
                    name="synopsis"
                    label="Synopsis de l'évènement"
                    value="{{ $event->synopsis }}"
                    required="true" />

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>
@endsection
