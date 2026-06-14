<?php
namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class AuthController extends BaseController
{
    public function login(): string
    {
        if (session()->get('user_id')) return redirect()->to($this->dashUrl());
        return $this->render('auth/login', ['title' => 'Connexion - MboaFood']);
    }

    public function loginProcess(): RedirectResponse
    {
        $userModel = new UserModel();
        $user      = $userModel->findByEmail($this->request->getPost('email'));

        if (!$user || !password_verify($this->request->getPost('password'), $user['password'])) {
            return redirect()->back()->with('error', 'Email ou mot de passe incorrect.')->withInput();
        }
        if (!$user['actif']) {
            return redirect()->back()->with('error', 'Votre compte est désactivé.')->withInput();
        }

        session()->set([
            'user_id'    => $user['id'],
            'user_nom'   => $user['nom'],
            'user_role'  => $user['role'],
            'user_email' => $user['email'],
        ]);

        return redirect()->to($this->dashUrl($user['role']))
                         ->with('success', 'Bienvenue, ' . $user['nom'] . ' !');
    }

    public function register(): string
    {
        if (session()->get('user_id')) return redirect()->to('/client');
        return $this->render('auth/register', ['title' => 'Inscription - MboaFood']);
    }

    public function registerProcess(): RedirectResponse
    {
        $rules = [
            'nom'      => 'required|min_length[2]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // BUG FIX : query SQL brute pour insert user
        $db  = \Config\Database::connect();
        $tel = $this->request->getPost('telephone') ?? '';
        $db->query(
            "INSERT INTO users (nom, email, password, telephone, role, actif, created_at, updated_at)
             VALUES (?, ?, ?, ?, 'client', 1, NOW(), NOW())",
            [
                $this->request->getPost('nom'),
                $this->request->getPost('email'),
                password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                $tel,
            ]
        );

        return redirect()->to('/auth/login')->with('success', 'Compte créé ! Connectez-vous.');
    }

    public function logout(): RedirectResponse
    {
        session()->destroy();
        return redirect()->to('/auth/login')->with('success', 'Déconnecté avec succès.');
    }

    private function dashUrl(string $role = ''): string
    {
        $role = $role ?: session()->get('user_role');
        return match ($role) {
            'admin'   => '/admin',
            'livreur' => '/livreur',
            default   => '/client',
        };
    }
}
