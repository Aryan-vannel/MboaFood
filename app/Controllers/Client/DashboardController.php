<?php
namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\CommandeModel;

class DashboardController extends BaseController
{
    public function index(): string
    {
        $userId    = session()->get('user_id');
        $commandes = (new CommandeModel())->getParClient($userId);

        return $this->render('client/dashboard', [
            'title'           => 'Mon Espace - MboaFood',
            'commandes'       => $commandes,
            'total_commandes' => count($commandes),
            'en_cours'        => count(array_filter($commandes, fn($c) => in_array(
                $c['statut'],
                ['en_attente', 'acceptee', 'en_preparation', 'prete', 'en_livraison']
            ))),
        ]);
    }
}
