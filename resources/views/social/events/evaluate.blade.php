@extends("layouts.app")
@section("title")
    Evaluation d'une participation
@endsection

@section("content")
    <form action="{{ route('social.events.graphics.evaluate.store', [$event->id, $graphic->id]) }}" method="POST">
        <x-base.toolbar
            title="Evaluation d'une participation"
            :breads="array('Social', 'Gestion des évènements', $event->title, 'Evaluation')"
            return="true"
            sticky="true"
            submit="true" />
        @csrf
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Evaluation du média soumis</h3>
            </div>
            <div class="card-body">
                <x-base.alert
                    type="info"
                    icon="fa-solid fa-info-circle"
                    title="Informations"
                    content="La validation de ce formulaire est définitif" />
                <div class="d-flex flex-row justify-content-around align-items-center mb-10">
                    <label for="respectTheme" class="form-label required">Ce média respecte le thème de l'évènement ?</label>
                    <select name="respectTheme" id="respectTheme" class="form-control" data-control="select2" data-placeholder="-- Selectionner une réponse --" required>
                        <option></option>
                        <option value="5">Respecte Totalement</option>
                        <option value="3">Respecte Partiellement</option>
                        <option value="1">Ne respecte Pas</option>
                        <option value="0">Non Evalué</option>
                    </select>
                </div>
                <div class="d-flex flex-row justify-content-around align-items-center mb-10">
                    <label for="pertinenceTheme" class="form-label required">Le média est-il pertinent ?</label>
                    <select name="pertinenceTheme" id="pertinenceTheme" class="form-control" data-control="select2" data-placeholder="-- Selectionner une réponse --" required>
                        <option></option>
                        <option value="5">Il est totalement pertinent</option>
                        <option value="3">Il est partiellement pertinent</option>
                        <option value="1">Il n'est pas pertinent</option>
                        <option value="0">Non Evalué</option>
                    </select>
                </div>
                <div class="d-flex flex-row justify-content-around align-items-center mb-10">
                    <label for="usedIA" class="form-label required">L'utilisateur à t-il utilisé l'IA ?</label>
                    <select name="usedIA" id="usedIA" class="form-control" data-control="select2" data-placeholder="-- Selectionner une réponse --" required>
                        <option></option>
                        <option value="1">Oui</option>
                        <option value="5">Non</option>
                    </select>
                </div>
                <div class="d-flex flex-row justify-content-around align-items-center mb-10">
                    <label for="respectCarateristic" class="form-label required">L'utilisateur à t-il respecter les caractéristiques de l'évènement ?</label>
                    <select name="respectCarateristic" id="respectCarateristic" class="form-control" data-control="select2" data-placeholder="-- Selectionner une réponse --" required>
                        <option></option>
                        <option value="5"> Respecte Totalement</option>
                        <option value="3"> Respecte Partiellement</option>
                        <option value="1"> Ne respecte Pas</option>
                        <option value="0"> Non Evalué</option>
                        <option value="0"> Pas de caractéristiques</option>
                    </select>
                </div>
            </div>
        </div>
    </form>

@endsection
