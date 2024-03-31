<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Pharaonic\Laravel\Menus\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        Menu::set('manager_head', 'Tableau de bord', route('home'));

        Menu::set('manager_head', 'Socials & Blog', '#');
        Menu::set('manager_head', 'Articles', route('social.articles.index'), 2);
        Menu::set('manager_head', 'Pages', route('social.pages.index'), 2);
        Menu::set('manager_head', 'Cercles', route('social.cercles.index'), 2);
        Menu::set('manager_head', 'Services', route('social.services.index'), 2);
        Menu::set('manager_head', 'Evènements', '#', 2);
        Menu::set('manager_head', 'Postes Sociales', '#', 2);

        Menu::set('manager_head', 'Wiki', '#');
        Menu::set('manager_head', 'Catégories', '#', 9);
        Menu::set('manager_head', 'Articles', '#', 9);

        Menu::set('manager_head', 'Railway Manager', '#');
        Menu::set('manager_head', 'Matériels Roulants', '#', 12);
        Menu::set('manager_head', 'Gares & Hubs', '#', 12);
        Menu::set('manager_head', 'Lignes', '#', 12);
        Menu::set('manager_head', 'Badges & Récompenses', '#', 12);
        Menu::set('manager_head', 'Service de location', '#', 12);
        Menu::set('manager_head', 'Service bancaire', '#', 12);
        Menu::set('manager_head', 'Recherches & Développements', '#', 12);
        Menu::set('manager_head', 'Bonus Journalier', '#', 12);
        Menu::set('manager_head', 'Porte Carte', '#', 12);
        Menu::set('manager_head', 'Tutoriels', '#', 12);
        Menu::set('manager_head', 'Saison Pass', '#', 12);
        Menu::set('manager_head', 'Configurations', '#', 12);

        Menu::set('manager_head', 'Administration', '#');
        Menu::set('manager_head', 'Gestion des utilisateurs', '#', 25);
        Menu::set('manager_head', 'Laravel Pulse', '/pulse', 25);
        Menu::set('manager_head', 'Log Système', '/log-viewer', 25);
        Menu::set('manager_head', 'Horizon', '/horizon', 25);

        Menu::set('manager_head', 'Support Technique', '#');
        Menu::set('manager_head', 'Tickets', '#', 30);
        Menu::set('manager_head', 'Rapport de Bugs', '#', 30);
        Menu::set('manager_head', 'Suggestions', '#', 30);
        Menu::set('manager_head', 'Rapport de plaintes', '#', 30);
    }
}
