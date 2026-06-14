<?php
namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\AdresseModel;
use CodeIgniter\HTTP\RedirectResponse;

class AdresseController extends BaseController
{
    public function index(): string
    {
        return $this->render('client/adresses', [
            'title'    => 'Mes Adresses - MboaFood',
            'adresses' => (new AdresseModel())->getParUser((int) session()->get('user_id')),
        ]);
    }

    public function ajouter(): RedirectResponse
    {
        $userId    = (int) session()->get('user_id');
        $isDefault = $this->request->getPost('is_default') ? 1 : 0;

        // BUG FIX : query SQL brute
        \Config\Database::connect()->query(
            "INSERT INTO adresses (user_id, ville, quartier, description, is_default)
             VALUES (?, ?, ?, ?, ?)",
            [
                $userId,
                $this->request->getPost('ville'),
                $this->request->getPost('quartier'),
                $this->request->getPost('description') ?? '',
                $isDefault,
            ]
        );

        return redirect()->to('/client/adresses')->with('success', 'Adresse ajoutée.');
    }

    public function supprimer(int $id): RedirectResponse
    {
        $userId       = (int) session()->get('user_id');
        $adresseModel = new AdresseModel();
        $adr          = $adresseModel->find($id);

        if ($adr && (int) $adr['user_id'] === $userId) {
            $adresseModel->delete($id);
        }
        return redirect()->to('/client/adresses')->with('success', 'Adresse supprimée.');
    }
}
