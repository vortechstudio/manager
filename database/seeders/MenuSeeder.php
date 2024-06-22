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
        Menu::set('manager_head', 'Messagerie', '/social/messagerie', 2);
        Menu::set('manager_head', 'Menu', '/social/menu', 2);

        Menu::set('manager_head', 'Wiki', '#');
        Menu::set('manager_head', 'Catégories', '/wiki/categories', 11);
        Menu::set('manager_head', 'Articles', '/wiki/articles', 11);

        Menu::set('manager_head', 'Railway Manager', '#');
        Menu::set('manager_head', 'Matériels Roulants', '/railway/materiels', 14);
        Menu::set('manager_head', 'Gares & Hubs', '/railway/hubs', 14);
        Menu::set('manager_head', 'Lignes', '/railway/lignes', 14);
        Menu::set('manager_head', 'Quêtes', '/railway/quests', 14);
        Menu::set('manager_head', 'Service de location', '/railway/location', 14);
        Menu::set('manager_head', 'Service bancaire', '/railway/finance', 14);
        Menu::set('manager_head', 'Recherches & Développements', '/railway/recherches', 14);
        Menu::set('manager_head', 'Bonus Journalier', '/railway/bonus', 14);
        Menu::set('manager_head', 'Porte Carte', '/railway/portecarte', 14);
        Menu::set('manager_head', 'Boutique', '/railway/shop', 14);
        Menu::set('manager_head', 'Succès', '/railway/achievement', 14);
        Menu::set('manager_head', 'Configurations', '/railway/config', 14);

        Menu::set('manager_head', 'Administration', '#');
        Menu::set('manager_head', 'Gestion des utilisateurs', '/admin/users', 27);
        Menu::set('manager_head', 'Gestion des boutiques', '/admin/shops', 27);
        Menu::set('manager_head', 'Laravel Pulse', '/pulse', 27);
        Menu::set('manager_head', 'Log Système', '/log-viewer', 27);
        Menu::set('manager_head', 'Horizon', '/horizon', 27);

        Menu::set('manager_head', 'Support Technique', '#');
        Menu::set('manager_head', 'Tickets', '/support/tickets', 33);
        Menu::set('manager_head', 'Rapport de Bugs', '/support/bugs', 33);
        Menu::set('manager_head', 'Suggestions', '/support/suggestions', 33);
        Menu::set('manager_head', 'Rapport de plaintes', '/support/complaints', 33);

        Menu::set('railway_manager_app', 'Acceuil', '/');

        \App\Models\Config\Menu::set('railway_manager_app', 'Gestion du réseau', '#', 'fa-solid fa-globe');
        Menu::set('railway_manager_app', 'Planification', '/network/planning', 39);
        Menu::set('railway_manager_app', 'Achat de HUB', '/network/hub/buy', 39);
        Menu::set('railway_manager_app', 'Achat de Ligne', '/network/line/buy', 39);
        Menu::set('railway_manager_app', 'Réseau', '/network', 39);

        \App\Models\Config\Menu::set('railway_manager_app', 'Gestion du matériel', '#', 'fa-solid fa-train');
        Menu::set('railway_manager_app', 'Achat de Materiels', '/train/buy', 44);
        Menu::set('railway_manager_app', 'Technicentre', '/technicentre', 44);
        Menu::set('railway_manager_app', 'Matériels', '/train', 44);

        \App\Models\Config\Menu::set('railway_manager_app', 'Gestion de la compagnie', '#', 'fa-solid fa-building');
        Menu::set('railway_manager_app', 'Profil', '/company/profile', 48);
        Menu::set('railway_manager_app', 'Classement', '/company/rank', 48);
        Menu::set('railway_manager_app', 'Compagnie', '/company', 48);
        Menu::set('railway_manager_app', 'contrat', '/company/contrat', 48);

        \App\Models\Config\Menu::set('railway_manager_app', 'Centre de compétence', '#', 'fa-solid fa-flask-vial');
        Menu::set('railway_manager_app', 'Général', '/research', 53);
        Menu::set('railway_manager_app', 'Infrastructure', '/research/infrastructure', 53);
        Menu::set('railway_manager_app', 'Matériels', '/research/train', 53);

        \App\Models\Config\Menu::set('railway_manager_app', 'Services', '/services', 'fa-solid fa-bell-concierge');

        \App\Models\Config\Menu::set('railway_manager_app', 'Finances', '#', 'fa-solid fa-building-columns');
        Menu::set('railway_manager_app', 'Banques', '/finance/bank', 59);
        Menu::set('railway_manager_app', 'Comptabilité', '/finance/comptability', 59);
        Menu::set('railway_manager_app', 'Finance', '/finance', 59);

        \App\Models\Config\Menu::set('railway_manager_app', 'Bureau du marketing', '#', 'fa-solid fa-lightbulb');
        Menu::set('railway_manager_app', 'Audit Interne', '/marketing/internalaudit', 63);
        Menu::set('railway_manager_app', 'Gestion des tarifs', '/marketing/pricing', 63);
        Menu::set('railway_manager_app', 'Marketing', '/marketing', 63);

        \App\Models\Config\Menu::set('account_head', 'Accueil', '/', 'fa-solid fa-house');

        \App\Models\Config\Menu::set('account_head', 'Comptes', '#', 'fa-regular fa-circle-user');
        Menu::set('account_head', 'Informations de compte', '/account', 68);
        Menu::set('account_head', 'Historique du compte', '/account/history', 68);
        Menu::set('account_head', 'Historique de connexion', '/account/loginStatus', 68);
        Menu::set('account_head', 'Mes données personnels', '/account/rgpd', 68);

        \App\Models\Config\Menu::set('account_head', 'Services & Options', '#', 'fa-solid fa-gear');
        Menu::set('account_head', 'Etat des services & Options', '/services', 73);
        Menu::set('account_head', 'Sécuriser mon compte (MFA)', '/services/mfa', 73);

        \App\Models\Config\Menu::set('account_head', 'Centre de support', '#', 'fa-solid fa-headset');

    }
}
