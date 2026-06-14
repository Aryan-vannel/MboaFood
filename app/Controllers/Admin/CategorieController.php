<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategorieModel;
use CodeIgniter\HTTP\RedirectResponse;

class CategorieController extends BaseController
{
    public function index(): string
    {
        return $this->renderAdmin('admin/categories', [
            'title'      => 'Catégories - MboaFood',
            'categories' => (new CategorieModel())->findAll(),
        ]);
    }

    public function ajouter(): RedirectResponse
    {
        // BUG FIX : query SQL brute
        \Config\Database::connect()->query(
            "INSERT INTO categories (nom, description) VALUES (?, ?)",
            [
                $this->request->getPost('nom'),
                $this->request->getPost('description') ?? '',
            ]
        );
        return redirect()->to('/admin/categories')->with('success', 'Catégorie ajoutée.');
    }

    public function supprimer(int $id): RedirectResponse
    {
        (new CategorieModel())->delete($id);
        return redirect()->to('/admin/categories')->with('success', 'Catégorie supprimée.');
    }
}
