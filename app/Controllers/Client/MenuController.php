<?php
namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\PlatModel;

class MenuController extends BaseController
{
    public function index(): string
    {
        return $this->render('client/menu', [
            'title'               => 'Menu - MboaFood',
            'plats_par_categorie' => (new PlatModel())->getParCategorie(),
        ]);
    }
}
