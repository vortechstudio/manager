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
        Menu::set('manager_head', 'Configurations', '/railway/config', 12);

        Menu::set('manager_head', 'Administration', '#');
        Menu::set('manager_head', 'Gestion des utilisateurs', '/admin/users', 23);
        Menu::set('manager_head', 'Laravel Pulse', '/pulse', 23);
        Menu::set('manager_head', 'Log Système', '/log-viewer', 23);
        Menu::set('manager_head', 'Horizon', '/horizon', 23);

        Menu::set('manager_head', 'Support Technique', '#');
        Menu::set('manager_head', 'Tickets', '/support/tickets', 28);
        Menu::set('manager_head', 'Rapport de Bugs', '/support/bugs', 28);
        Menu::set('manager_head', 'Suggestions', '/support/suggestions', 28);
        Menu::set('manager_head', 'Rapport de plaintes', '/support/complaints', 28);

        Menu::set('railway_manager_app', 'Acceuil', '/');

        Menu::set('railway_manager_app', 'Gestion du réseau', '#');
        Menu::set('railway_manager_app', 'Planification', '/network/planning', 34);
        Menu::set('railway_manager_app', 'Achat de HUB', '/network/hub/buy', 34);
        Menu::set('railway_manager_app', 'Achat de Ligne', '/network/line/buy', 34);
        Menu::set('railway_manager_app', 'Réseau', '/network', 34);

        Menu::set('railway_manager_app', 'Gestion du matériel', '#');
        Menu::set('railway_manager_app', 'Achat de Materiels', '/train/buy', 39);
        Menu::set('railway_manager_app', 'Technicentre', '/technicentre', 39);
        Menu::set('railway_manager_app', 'Matériels', '/train', 39);

        Menu::set('railway_manager_app', 'Gestion de la Compagnie', '#');
        Menu::set('railway_manager_app', 'Customisation', '/company/customize', 43);
        Menu::set('railway_manager_app', 'Profil', '/company/profile', 43);
        Menu::set('railway_manager_app', 'Classement', '/company/rank', 43);
        Menu::set('railway_manager_app', 'Compagnie', '/company', 43);

        Menu::set('railway_manager_app', 'Centre de compétence', '#');
        Menu::set('railway_manager_app', 'Général', '/research', 48);
        Menu::set('railway_manager_app', 'Infrastructure', '/research/infrastructure', 48);
        Menu::set('railway_manager_app', 'Matériels', '/research/train', 48);

        Menu::set('railway_manager_app', 'Services', '#');
        Menu::set('railway_manager_app', 'Partenariat', '/services/partner', 53);
        Menu::set('railway_manager_app', 'Infrastructures', '/services/infrastructure', 53);
        Menu::set('railway_manager_app', 'Service à bord', '/services/board', 53);
        Menu::set('railway_manager_app', 'Service en gare', '/services/station', 53);

        Menu::set('railway_manager_app', 'Finances', '#');
        Menu::set('railway_manager_app', 'Banques', '/finance/bank', 58);
        Menu::set('railway_manager_app', 'Compatibilite', '/finance/compatibility', 58);
        Menu::set('railway_manager_app', 'Finance', '/finance', 58);

        Menu::set('railway_manager_app', 'Bureau du marketing', '#');
        Menu::set('railway_manager_app', 'Audit Interne', '/marketing/internalaudit', 62);
        Menu::set('railway_manager_app', 'Gestion des tarifs', '/marketing/pricing', 62);
        Menu::set('railway_manager_app', 'Marketing', '/marketing', 62);

        Menu::set('account_head', 'Accueil', '/');

        Menu::set('account_head', 'Comptes', '#');
        Menu::set('account_head', 'Informations de compte', '/account', 67);
        Menu::set('account_head', 'Historique du compte', '/account/history', 67);
        Menu::set('account_head', 'Historique de connexion', '/account/loginStatus', 67);
        Menu::set('account_head', 'Mes données personnels', '/account/rgpd', 67);

        Menu::set('account_head', 'Services & Options', '#');
        Menu::set('account_head', 'Etat des services & Options', '/services', 72);
        Menu::set('account_head', 'Sécuriser mon compte (MFA)', '/services/mfa', 72);

        Menu::set('account_head', 'Centre de support', '#');

    }
}
