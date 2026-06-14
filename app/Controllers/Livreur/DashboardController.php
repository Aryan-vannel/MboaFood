<?php
namespace App\Controllers\Livreur;

use App\Controllers\BaseController;
use App\Models\LivraisonModel;

class DashboardController extends BaseController
{
    public function index(): string
    {
        $livreurId      = session()->get('user_id');
        $livraisonModel = new LivraisonModel();

        return $this->renderLivreur('livreur/dashboard', [
            'title'      => 'Mon Espace - MboaFood',
            'en_cours'   => $livraisonModel->getParLivreur($livreurId, false),
            'historique' => array_slice($livraisonModel->getParLivreur($livreurId, true), 0, 5),
        ]);
    }
}
