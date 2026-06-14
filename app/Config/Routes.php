<?php

use CodeIgniter\Router\RouteCollection;

/**
 * Routes Configuration — Compatible CI4 4.7.x
 *
 * @var RouteCollection $routes
 */

// ── PUBLIC ──────────────────────────────────────────────────────
$routes->get('/',           'HomeController::index');
$routes->get('/menu',       'HomeController::menu');
$routes->get('/plat/(:num)','HomeController::plat/$1');

// ── AUTHENTIFICATION ─────────────────────────────────────────────
$routes->get( '/auth/login',    'AuthController::login');
$routes->post('/auth/login',    'AuthController::loginProcess');
$routes->get( '/auth/register', 'AuthController::register');
$routes->post('/auth/register', 'AuthController::registerProcess');
$routes->get( '/auth/logout',   'AuthController::logout');

// ── ESPACE CLIENT ─────────────────────────────────────────────────
$routes->group('client', ['filter' => 'auth:client'], function ($routes) {
    $routes->get( '/',                        'Client\DashboardController::index');
    $routes->get( 'menu',                     'Client\MenuController::index');
    // Panier
    $routes->get( 'panier',                   'Client\PanierController::index');
    $routes->post('panier/ajouter',           'Client\PanierController::ajouter');
    $routes->post('panier/modifier',          'Client\PanierController::modifier');
    $routes->post('panier/supprimer',         'Client\PanierController::supprimer');
    $routes->post('panier/vider',             'Client\PanierController::vider');
    // Commandes
    $routes->get( 'commande/passer',          'Client\CommandeController::passer');
    $routes->post('commande/valider',         'Client\CommandeController::valider');
    $routes->get( 'commandes',                'Client\CommandeController::liste');
    $routes->get( 'commande/(:num)',          'Client\CommandeController::detail/$1');
    $routes->post('commande/annuler/(:num)',  'Client\CommandeController::annuler/$1');
    // Adresses
    $routes->get( 'adresses',                'Client\AdresseController::index');
    $routes->post('adresse/ajouter',         'Client\AdresseController::ajouter');
    $routes->post('adresse/supprimer/(:num)','Client\AdresseController::supprimer/$1');
    // Profil & Facture
    $routes->get( 'profil',                  'Client\ProfilController::index');
    $routes->post('profil/modifier',         'Client\ProfilController::modifier');
    $routes->get( 'facture/(:num)',          'Client\FactureController::afficher/$1');
});

// ── ESPACE ADMINISTRATEUR ─────────────────────────────────────────
$routes->group('admin', ['filter' => 'auth:admin'], function ($routes) {
    $routes->get( '/',                           'Admin\DashboardController::index');
    // Plats
    $routes->get( 'plats',                       'Admin\PlatController::index');
    $routes->get( 'plat/ajouter',                'Admin\PlatController::ajouter');
    $routes->post('plat/ajouter',                'Admin\PlatController::ajouterProcess');
    $routes->get( 'plat/modifier/(:num)',         'Admin\PlatController::modifier/$1');
    $routes->post('plat/modifier/(:num)',         'Admin\PlatController::modifierProcess/$1');
    $routes->post('plat/supprimer/(:num)',        'Admin\PlatController::supprimer/$1');
    $routes->post('plat/toggle/(:num)',           'Admin\PlatController::toggle/$1');
    // Commandes
    $routes->get( 'commandes',                   'Admin\CommandeController::index');
    $routes->get( 'commande/(:num)',              'Admin\CommandeController::detail/$1');
    $routes->post('commande/accepter/(:num)',     'Admin\CommandeController::accepter/$1');
    $routes->post('commande/refuser/(:num)',      'Admin\CommandeController::refuser/$1');
    $routes->post('commande/preparer/(:num)',     'Admin\CommandeController::preparer/$1');
    $routes->post('commande/prete/(:num)',        'Admin\CommandeController::prete/$1');
    $routes->post('commande/assigner/(:num)',     'Admin\CommandeController::assigner/$1');
    // Utilisateurs
    $routes->get( 'utilisateurs',                'Admin\UtilisateurController::index');
    $routes->post('utilisateur/toggle/(:num)',   'Admin\UtilisateurController::toggle/$1');
    // Catégories
    $routes->get( 'categories',                  'Admin\CategorieController::index');
    $routes->post('categorie/ajouter',           'Admin\CategorieController::ajouter');
    $routes->post('categorie/supprimer/(:num)',  'Admin\CategorieController::supprimer/$1');
    // Factures
    $routes->get( 'factures',                    'Admin\FactureController::index');
    $routes->get( 'facture/(:num)',               'Admin\FactureController::detail/$1');
});

// ── ESPACE LIVREUR ────────────────────────────────────────────────
$routes->group('livreur', ['filter' => 'auth:livreur'], function ($routes) {
    $routes->get( '/',                          'Livreur\DashboardController::index');
    $routes->get( 'livraisons',                 'Livreur\LivraisonController::index');
    $routes->get( 'livraison/(:num)',            'Livreur\LivraisonController::detail/$1');
    $routes->post('livraison/accepter/(:num)',   'Livreur\LivraisonController::accepter/$1');
    $routes->post('livraison/livree/(:num)',     'Livreur\LivraisonController::livree/$1');
    $routes->post('livraison/echec/(:num)',      'Livreur\LivraisonController::echec/$1');
    $routes->get( 'historique',                 'Livreur\LivraisonController::historique');
    $routes->get( 'profil',                     'Livreur\ProfilController::index');
});
