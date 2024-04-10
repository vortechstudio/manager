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
        Menu::set('manager_head', 'Articles', '/social/articles', 2);
        Menu::set('manager_head', 'Pages', '/social/pages', 2);
        Menu::set('manager_head', 'Cercles', '/social/cercles', 2);
        Menu::set('manager_head', 'Services', '/social/services', 2);
        Menu::set('manager_head', 'Evènements', '/social/events', 2);
        Menu::set('manager_head', 'Postes Sociales', '/social/feeds', 2);

        Menu::set('manager_head', 'Wiki', '#');
        Menu::set('manager_head', 'Catégories', '/wiki/categories', 9);
        Menu::set('manager_head', 'Articles', '/wiki/articles', 9);

        Menu::set('manager_head', 'Railway Manager', '#');
        Menu::set('manager_head', 'Matériels Roulants', '/railway/materiels', 12);
        Menu::set('manager_head', 'Gares & Hubs', '/railway/hubs', 12);
        Menu::set('manager_head', 'Lignes', '/railway/lignes', 12);
        Menu::set('manager_head', 'Quêtes', '/railway/quests', 12);
        Menu::set('manager_head', 'Service de location', '/railway/location', 12);
        Menu::set('manager_head', 'Service bancaire', '/railway/finance', 12);
        Menu::set('manager_head', 'Recherches & Développements', '/railway/recherches', 12);
        Menu::set('manager_head', 'Bonus Journalier', '/railway/bonus', 12);
        Menu::set('manager_head', 'Porte Carte', '/railway/portecarte', 12);
        Menu::set('manager_head', 'Tutoriels', '/railway/tutoriels', 12);
        Menu::set('manager_head', 'Saison Pass', '/railway/pass', 12);
        Menu::set('manager_head', 'Configurations', '/railway/config', 12);

        Menu::set('manager_head', 'Administration', '#');
        Menu::set('manager_head', 'Gestion des utilisateurs', '/admin/users', 25);
        Menu::set('manager_head', 'Laravel Pulse', '/pulse', 25);
        Menu::set('manager_head', 'Log Système', '/log-viewer', 25);
        Menu::set('manager_head', 'Horizon', '/horizon', 25);

        Menu::set('manager_head', 'Support Technique', '#');
        Menu::set('manager_head', 'Tickets', '/support/tickets', 30);
        Menu::set('manager_head', 'Rapport de Bugs', '/support/bugs', 30);
        Menu::set('manager_head', 'Suggestions', '/support/suggestions', 30);
        Menu::set('manager_head', 'Rapport de plaintes', '/support/complaints', 30);
    }
}
