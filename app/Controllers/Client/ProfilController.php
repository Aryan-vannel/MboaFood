<?php
namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class ProfilController extends BaseController
{
    public function index(): string
    {
        return $this->render('client/profil', [
            'title' => 'Mon Profil - MboaFood',
            'user'  => (new UserModel())->find(session()->get('user_id')),
        ]);
    }

    public function modifier(): RedirectResponse
    {
        $userId = (int) session()->get('user_id');
        $nom    = $this->request->getPost('nom');
        $tel    = $this->request->getPost('telephone') ?? '';
        $pwd    = $this->request->getPost('password');

        // BUG FIX : query SQL brute pour update profil
        if ($pwd && strlen($pwd) >= 6) {
            $hash = password_hash($pwd, PASSWORD_DEFAULT);
            \Config\Database::connect()->query(
                "UPDATE users SET nom = ?, telephone = ?, password = ?, updated_at = NOW() WHERE id = ?",
                [$nom, $tel, $hash, $userId]
            );
        } else {
            \Config\Database::connect()->query(
                "UPDATE users SET nom = ?, telephone = ?, updated_at = NOW() WHERE id = ?",
                [$nom, $tel, $userId]
            );
        }

        session()->set('user_nom', $nom);
        return redirect()->to('/client/profil')->with('success', 'Profil mis à jour.');
    }
}
