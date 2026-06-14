<?php
namespace App\Controllers;

use App\Models\CategorieModel;
use App\Models\PlatModel;
use CodeIgniter\HTTP\RedirectResponse;

class HomeController extends BaseController
{
    public function index(): string
    {
        $platModel = new PlatModel();
        return $this->render('home/index', [
            'title'         => 'Accueil - MboaFood',
            'plats_vedette' => array_slice($platModel->getDisponibles(), 0, 6),
            'categories'    => (new CategorieModel())->findAll(),
        ]);
    }

    public function menu(): string
    {
        return $this->render('home/menu', [
            'title'               => 'Notre Menu - MboaFood',
            'plats_par_categorie' => (new PlatModel())->getParCategorie(),
        ]);
    }

    public function plat(int $id): string|RedirectResponse
    {
        $plat = (new PlatModel())->find($id);
        if (!$plat) {
            return redirect()->to('/menu');
        }
        return $this->render('home/plat', [
            'title' => $plat['nom'] . ' - MboaFood',
            'plat'  => $plat,
        ]);
    }
}
