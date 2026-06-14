<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategorieModel;
use App\Models\PlatModel;
use CodeIgniter\HTTP\RedirectResponse;

class PlatController extends BaseController
{
    public function index(): string
    {
        return $this->renderAdmin('admin/plats', [
            'title' => 'Gestion des plats - MboaFood',
            'plats' => (new PlatModel())->getAvecCategorie(),
        ]);
    }

    public function ajouter(): string
    {
        return $this->renderAdmin('admin/plat_form', [
            'title'      => 'Ajouter un plat',
            'categories' => (new CategorieModel())->findAll(),
            'plat'       => null,
        ]);
    }

    public function ajouterProcess(): RedirectResponse
    {
        if (!$this->request->getPost('nom') || !$this->request->getPost('prix')) {
            return redirect()->back()
                             ->with('error', 'Le nom et le prix sont obligatoires.')
                             ->withInput();
        }

        $image       = $this->uploadImage();
        $categorieId = $this->request->getPost('categorie_id');
        $db          = \Config\Database::connect();

        // BUG FIX DÉFINITIF : utiliser query() brute pour éviter le bug
        // CI4 4.7.3 setBind() avec clés int quand allowedFields filtre le tableau
        if (!empty($categorieId) && is_numeric($categorieId)) {
            $db->query(
                "INSERT INTO plats (categorie_id, nom, description, prix, image, disponible, created_at)
                 VALUES (?, ?, ?, ?, ?, 1, NOW())",
                [
                    (int) $categorieId,
                    $this->request->getPost('nom'),
                    $this->request->getPost('description') ?? '',
                    (int) $this->request->getPost('prix'),
                    $image,
                ]
            );
        } else {
            $db->query(
                "INSERT INTO plats (nom, description, prix, image, disponible, created_at)
                 VALUES (?, ?, ?, ?, 1, NOW())",
                [
                    $this->request->getPost('nom'),
                    $this->request->getPost('description') ?? '',
                    (int) $this->request->getPost('prix'),
                    $image,
                ]
            );
        }

        return redirect()->to('/admin/plats')->with('success', 'Plat ajouté avec succès.');
    }

    public function modifier(int $id): string|RedirectResponse
    {
        $plat = (new PlatModel())->find($id);
        if (!$plat) {
            return redirect()->to('/admin/plats')->with('error', 'Plat introuvable.');
        }
        return $this->renderAdmin('admin/plat_form', [
            'title'      => 'Modifier le plat',
            'categories' => (new CategorieModel())->findAll(),
            'plat'       => $plat,
        ]);
    }

    public function modifierProcess(int $id): RedirectResponse
    {
        $platModel   = new PlatModel();
        $plat        = $platModel->find($id);

        if (!$plat) {
            return redirect()->to('/admin/plats')->with('error', 'Plat introuvable.');
        }

        $image       = $this->uploadImage();
        $imageFinale = !empty($image) ? $image : ($plat['image'] ?? '');
        $categorieId = $this->request->getPost('categorie_id');
        $db          = \Config\Database::connect();

        // BUG FIX DÉFINITIF : même approche pour la modification
        if (!empty($categorieId) && is_numeric($categorieId)) {
            $db->query(
                "UPDATE plats SET categorie_id=?, nom=?, description=?, prix=?, image=? WHERE id=?",
                [
                    (int) $categorieId,
                    $this->request->getPost('nom'),
                    $this->request->getPost('description') ?? '',
                    (int) $this->request->getPost('prix'),
                    $imageFinale,
                    $id,
                ]
            );
        } else {
            $db->query(
                "UPDATE plats SET categorie_id=NULL, nom=?, description=?, prix=?, image=? WHERE id=?",
                [
                    $this->request->getPost('nom'),
                    $this->request->getPost('description') ?? '',
                    (int) $this->request->getPost('prix'),
                    $imageFinale,
                    $id,
                ]
            );
        }

        return redirect()->to('/admin/plats')->with('success', 'Plat modifié avec succès.');
    }

    public function supprimer(int $id): RedirectResponse
    {
        (new PlatModel())->delete($id);
        return redirect()->to('/admin/plats')->with('success', 'Plat supprimé.');
    }

    public function toggle(int $id): RedirectResponse
    {
        (new PlatModel())->toggleDisponibilite($id);
        return redirect()->back();
    }

    private function uploadImage(): string
    {
        $file = $this->request->getFile('image');

        if (!$file || !$file->isValid() || $file->hasMoved()) {
            return '';
        }

        $type = $file->getMimeType();
        if (!in_array($type, ['image/jpeg', 'image/png', 'image/gif', 'image/webp'])) {
            return '';
        }

        $uploadPath = FCPATH . 'uploads/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $name = $file->getRandomName();
        $file->move($uploadPath, $name);

        return 'uploads/' . $name;
    }
}
