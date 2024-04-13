@extends("layouts.app")
@section("title")
    Gestion des Quêtes, Niveaux & Récompenses
@endsection

@section("content")
    <x-base.toolbar
        title="Gestion des Quêtes, Niveaux & Récompenses"
        :breads="array('Railway Manager', 'Gestion des Quêtes, Niveaux & Récompenses')" />

    <div class="card shadow-sm" x-data="{card_title: 'Liste des quêtes', card_quest: true, card_level: false, card_new_level: false, card_new_quest: false}">
        <div class="card-header">
            <h3 class="card-title" x-text="card_title"></h3>
            <div class="card-toolbar">
                <button x-on:click="card_title = 'Liste des quêtes', card_quest = ! card_quest, card_level = ! card_level" class="btn btn-link btn-color-gray-500 btn-active-color-primary me-5">Quêtes</button>
                <button x-on:click="card_title = 'Liste des Niveaux & Recompenses', card_quest = false, card_level = true" class="btn btn-link btn-color-gray-500 btn-active-color-primary me-5">Niveaux & Recompenses</button>
            </div>
        </div>
        <div class="card-body">
            <div x-show="card_quest">
                <livewire:railway.quests.quest-table />
            </div>
            <div x-show="card_level">
                <livewire:railway.quests.level-table />
            </div>
        </div>
    </div>
@endsection
