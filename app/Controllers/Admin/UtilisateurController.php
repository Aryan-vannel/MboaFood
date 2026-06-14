<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class UtilisateurController extends BaseController
{
    public function index(): string
    {
        $userModel = new UserModel();
        return $this->renderAdmin('admin/utilisateurs', [
            'title'    => 'Utilisateurs - MboaFood',
            'clients'  => $userModel->getByRole('client'),
            'livreurs' => $userModel->getByRole('livreur'),
        ]);
    }

    public function toggle(int $id): RedirectResponse
    {
        // BUG FIX : utiliser toggleActif() qui utilise SQL brute
        (new UserModel())->toggleActif($id);
        return redirect()->back();
    }
}
