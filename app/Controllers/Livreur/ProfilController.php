<?php
namespace App\Controllers\Livreur;

use App\Controllers\BaseController;
use App\Models\UserModel;

class ProfilController extends BaseController
{
    public function index(): string
    {
        return $this->renderLivreur('livreur/profil', [
            'title' => 'Mon Profil - MboaFood',
            'user'  => (new UserModel())->find(session()->get('user_id')),
        ]);
    }
}
