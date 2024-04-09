<?php

namespace App\Console\Commands;

use App\Actions\Railway\EngineAction;
use App\Actions\Railway\GareAction;
use App\Models\Railway\Engine\RailwayEngine;
use App\Models\Railway\Gare\RailwayGare;
use App\Services\SncfService;
use Illuminate\Console\Command;

use RakibDevs\Weather\Weather;
use function Laravel\Prompts\alert;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class SystemCreateCommand extends Command
{
    protected $signature = 'create {action}';

    protected $description = 'Système de création interactive';

    public function handle(): void
    {
        match ($this->argument('action')) {
            'engine' => $this->createEngine(),
            'gare' => $this->createGare(),
        };
    }

    private function createEngine(): void
    {
        intro("Création d'un matériel roulant !");
        $name = text(
            label: 'Nom du matériel roulant ?',
            required: true
        );

        $type_train = select(
            label: 'Type de matériel ?',
            options: ['motrice', 'voiture', 'automotrice', 'bus'],
            required: true
        );

        $type_transport = select(
            label: 'Type de transport ?',
            options: ['ter', 'tgv', 'intercity', 'tram', 'metro', 'bus', 'other']
        );

        $type_energy = select(
            label: "Type d'energie ?",
            options: ['vapeur', 'diesel', 'electrique', 'hybride', 'none']
        );

        if ($type_train == 'automotrice') {
            $nb_wagon = text(
                label: 'Nombre de voiture comportant l\'automotrice ?',
                hint: 'Motrice comprise',
            );
        } else {
            $nb_wagon = 0;
        }

        \Laravel\Prompts\info('Information Technique du matériel roulant');
        $essieux = text(
            label: "Quel est le type d'essieux",
            required: true
        );

        $velocity = text(
            label: "Quel est la vitesse maximal de l'engin ?",
            required: true
        );

        $type_motor = select(
            label: 'Quel est le type de motorisation',
            options: ['diesel', 'electrique 1500V', 'electrique 25000V', 'electrique 1500V/25000V', 'vapeur', 'hybride', 'autre']
        );

        $type_marchandise = select(
            label: 'Quel est le type de marchandise transporter',
            options: ['none', 'passagers', 'marchandises']
        );

        if ($type_motor != 'none') {
            $nb_marchandise = text(
                label: 'Capacité de chargement'
            );
        } else {
            $nb_marchandise = 0;
        }

        \Laravel\Prompts\info('Information relative à la gestion');

        $active = confirm(
            label: 'Ce matériel est-il actif ?',
            yes: 'Oui',
            no: 'Non',
        );

        $in_shop = confirm(
            label: 'Ce matériel est-il disponible en boutique ?',
            yes: 'Oui',
            no: 'Non',
        );

        $in_game = confirm(
            label: 'Ce matériel est-il disponible en jeux ?',
            yes: 'Oui',
            no: 'Non',
        );

        $visual = select(
            label: 'Mode de production de ce matériel',
            options: ['beta', 'prod'],
            hint: 'Si prod est selectionner, le matériel est disponible en béta et en prod simultanément'
        );

        if ($in_shop) {
            $money_shop = select(
                label: 'Quel est le type de monnaie en boutique ?',
                options: ['tpoint', 'argent', 'euro']
            );

            $price_shop = text(
                label: 'Quel est le montant initial ?'
            );
        } else {
            $money_shop = null;
            $price_shop = null;
        }

        $duree_maintenance = (new EngineAction())->calcDurationMaintenance($essieux, $type_train == 'automotrice', $type_train == 'automotrice' ? $nb_wagon : 1);
        $val_essieux = (new EngineAction())->getDataCalcForEssieux($essieux, $type_train == 'automotrice', $type_train == 'automotrice' ? $nb_wagon : 1);

        $price_achat = (new EngineAction)->calcTarifAchat(
            $type_train,
            $type_energy,
            $type_motor,
            $type_marchandise,
            (new EngineAction)->getDataCalcForEssieux($essieux, $type_train == 'automotrice', $type_train == 'automotrice' ? $nb_wagon : 1),
            $nb_wagon
        );

        $price_maintenance = (new EngineAction)->calcPriceMaintenance(
            (new EngineAction())->calcDurationMaintenance($essieux)->diffInMinutes(now()->startOfDay()),
            $val_essieux
        );

        $price_location = (new EngineAction)->calcPriceLocation($price_achat);

        info('Création du matériel roulant');

        $engine = RailwayEngine::create([
            'uuid' => \Str::uuid(),
            'name' => $name,
            'type_transport' => $type_transport,
            'type_train' => $type_train,
            'type_energy' => $type_energy,
            'duration_maintenance' => $duree_maintenance,
            'active' => $active,
            'in_shop' => $in_shop,
            'in_game' => $in_game,
            'status' => $visual,
        ]);

        $engine->price()->create([
            'achat' => $price_achat,
            'maintenance' => $price_maintenance,
            'in_reduction' => false,
            'location' => $price_location,
            'engine_id' => $engine->id,
        ]);

        $engine->shop()->create([
            'money' => $money_shop,
            'price' => $price_shop,
            'engine_id' => $engine->id,
        ]);

        $engine->technical()->create([
            'essieux' => $essieux,
            'velocity' => $velocity,
            'motor' => $type_motor,
            'marchandise' => $type_marchandise,
            'nb_marchandise' => $nb_marchandise,
            'nb_wagon' => $nb_wagon,
            'engine_id' => $engine->id,
        ]);

        alert('Le matériel roulant a bien été créé');
        \Laravel\Prompts\info('Installer les images dans les dossiers correspondant. (engines/types_train/slugify_name.gif)');
    }

    private function createGare()
    {
        intro("Création d'une gare !");
        $name = text(
            label: 'Nom de la gare ?',
        );

        $type_gare = select(
            label: 'Type de la gare ?',
            options: ['halte', 'small', 'medium', 'large', 'terminus']
        );

        $nb_quai = text(
            label: 'Quel est le nombre de quai ?'
        );

        $transports = multiselect(
            label: 'Selectionner les types de transport acceptées dans cette gare',
            options: ['ter' => 'TER', 'tgv' => 'TGV', 'intercity' => 'INTERCITY', 'bus' => 'BUS', 'metro' => 'METRO'],
        );

        if ($type_gare == 'large' || $type_gare == 'terminus') {
            $hub = confirm('Cette gare est-elle un hub ?');
        } else {
            $hub = false;
        }

        if ($hub) {
            $visual = select(
                label: 'Mode de production de ce matériel',
                options: ['beta', 'prod'],
                hint: 'Si prod est selectionner, le matériel est disponible en béta et en prod simultanément'
            );
            $active = confirm("Voulez-vous l'activer ?");
        } else {
            $visual = null;
            $active = false;
        }

        $sncf = new SncfService();

        $gare = RailwayGare::create([
            'uuid' => \Str::uuid(),
            'name' => $name,
            'type' => $type_gare,
            'latitude' => $sncf->searchGare($name)['latitude'],
            'longitude' => $sncf->searchGare($name)['longitude'],
            'city' => $sncf->searchGare($name)['city'],
            'pays' => $sncf->searchGare($name)['pays'],
            'freq_base' => $sncf->searchFreq($name)['freq'],
            'hab_city' => (new GareAction())->getHabitant($type_gare, $sncf->searchFreq($name)['freq']),
            'transports' => json_encode($transports),
            'equipements' => json_encode((new GareAction)->defineEquipements($type_gare)),
        ]);

        $wt = new Weather();
        $weather = $wt->getCurrentByCord($gare->latitude, $gare->longitude);
        $gare->weather()->create([
            'weather' => $weather->weather[0]->description,
            'temperature' => $weather->main->temp,
            'latest_update' => now(),
            'railway_gare_id' => $gare->id,
        ]);

        if ($hub) {
            $gare->hub()->create([
                'price_base' => (new GareAction)->definePrice($type_gare, $nb_quai),
                'taxe_hub_price' => (new GareAction)->defineTaxeHub((new GareAction)->definePrice($type_gare, $nb_quai), $nb_quai),
                'active' => $active,
                'status' => $visual,
                'railway_gare_id' => $gare->id,
            ]);
        }

        info('La gare a bien été créée');

    }
}