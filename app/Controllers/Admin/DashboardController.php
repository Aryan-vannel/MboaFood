<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CommandeModel;
use App\Models\PlatModel;
use App\Models\UserModel;

class DashboardController extends BaseController
{
    public function index(): string
    {
        $commandeModel = new CommandeModel();
        $stats         = $commandeModel->getStats();
        $stats['total_clients'] = count((new UserModel())->getByRole('client'));
        $stats['total_plats']   = (new PlatModel())->countAll();

        return $this->renderAdmin('admin/dashboard', [
            'title'               => 'Tableau de bord - MboaFood',
            'stats'               => $stats,
            'dernieres_commandes' => $commandeModel->getToutesAvecClient(),
        ]);
    }
}
