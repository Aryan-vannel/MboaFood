<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CommandeModel;
use App\Models\FactureModel;
use App\Models\LivraisonModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class CommandeController extends BaseController
{
    public function index(): string
    {
        $statut = $this->request->getGet('statut') ?? '';
        return $this->renderAdmin('admin/commandes', [
            'title'     => 'Gestion des commandes - MboaFood',
            'commandes' => (new CommandeModel())->getToutesAvecClient($statut),
            'filtre'    => $statut,
        ]);
    }

    public function detail(int $id): string|RedirectResponse
    {
        $commande = (new CommandeModel())->getAvecDetails($id);
        if (!$commande) return redirect()->to('/admin/commandes');

        return $this->renderAdmin('admin/commande_detail', [
            'title'     => 'Commande #' . $id,
            'commande'  => $commande,
            'livreurs'  => (new UserModel())->getLivreursDisponibles(),
            'livraison' => (new LivraisonModel())->where('commande_id', $id)->first(),
            'facture'   => (new FactureModel())->getParCommande($id),
        ]);
    }

    public function accepter(int $id): RedirectResponse
    {
        $commandeModel = new CommandeModel();
        $commandeModel->changerStatut($id, 'acceptee');
        $commande     = $commandeModel->find($id);
        $factureModel = new FactureModel();
        if (!$factureModel->getParCommande($id)) {
            $factureModel->generer($id, (int) $commande['total']);
        }
        return redirect()->to('/admin/commande/' . $id)
                         ->with('success', 'Commande acceptée et facture générée.');
    }

    public function refuser(int $id): RedirectResponse
    {
        (new CommandeModel())->changerStatut($id, 'annulee');
        return redirect()->to('/admin/commandes')->with('success', 'Commande refusée.');
    }

    public function preparer(int $id): RedirectResponse
    {
        (new CommandeModel())->changerStatut($id, 'en_preparation');
        return redirect()->to('/admin/commande/' . $id)->with('success', 'Commande en préparation.');
    }

    public function prete(int $id): RedirectResponse
    {
        (new CommandeModel())->changerStatut($id, 'prete');
        return redirect()->to('/admin/commande/' . $id)->with('success', 'Commande prête.');
    }

    public function assigner(int $id): RedirectResponse
    {
        $livreurId = $this->request->getPost('livreur_id');
        if (!$livreurId) {
            return redirect()->back()->with('error', 'Veuillez sélectionner un livreur.');
        }

        $db       = \Config\Database::connect();
        $existant = (new LivraisonModel())->where('commande_id', $id)->first();

        if ($existant) {
            // BUG FIX : query SQL brute
            $db->query(
                "UPDATE livraisons SET livreur_id = ?, statut = 'assignee', updated_at = NOW() WHERE id = ?",
                [(int) $livreurId, (int) $existant['id']]
            );
        } else {
            $db->query(
                "INSERT INTO livraisons (commande_id, livreur_id, statut, tentatives, created_at, updated_at)
                 VALUES (?, ?, 'assignee', 0, NOW(), NOW())",
                [$id, (int) $livreurId]
            );
        }

        (new CommandeModel())->changerStatut($id, 'en_livraison');
        return redirect()->to('/admin/commande/' . $id)->with('success', 'Livreur assigné.');
    }
}
