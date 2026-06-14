<?php
namespace App\Controllers\Livreur;

use App\Controllers\BaseController;
use App\Models\CommandeModel;
use App\Models\LivraisonModel;
use CodeIgniter\HTTP\RedirectResponse;

class LivraisonController extends BaseController
{
    public function index(): string
    {
        return $this->renderLivreur('livreur/livraisons', [
            'title'      => 'Mes Livraisons - MboaFood',
            'livraisons' => (new LivraisonModel())->getParLivreur((int) session()->get('user_id'), false),
        ]);
    }

    public function detail(int $id): string|RedirectResponse
    {
        $livreurId      = (int) session()->get('user_id');
        $livraisonModel = new LivraisonModel();
        $check          = $livraisonModel->find($id);

        if (!$check || (int) $check['livreur_id'] !== $livreurId) {
            return redirect()->to('/livreur/livraisons')->with('error', 'Livraison introuvable.');
        }

        return $this->renderLivreur('livreur/livraison_detail', [
            'title'     => 'Livraison #' . $id . ' - MboaFood',
            'livraison' => $livraisonModel->getAvecDetails($id),
            'commande'  => (new CommandeModel())->getAvecDetails((int) $check['commande_id']),
        ]);
    }

    public function accepter(int $id): RedirectResponse
    {
        $livreurId      = (int) session()->get('user_id');
        $livraisonModel = new LivraisonModel();
        $livraison      = $livraisonModel->find($id);

        if ($livraison && (int) $livraison['livreur_id'] === $livreurId) {
            // BUG FIX : utiliser majStatut() SQL brute
            $livraisonModel->majStatut($id, 'en_cours');
        }
        return redirect()->to('/livreur/livraison/' . $id);
    }

    public function livree(int $id): RedirectResponse
    {
        $livreurId      = (int) session()->get('user_id');
        $livraisonModel = new LivraisonModel();
        $livraison      = $livraisonModel->find($id);

        if ($livraison && (int) $livraison['livreur_id'] === $livreurId) {
            $livraisonModel->majStatut($id, 'livree', date('Y-m-d H:i:s'));
            (new CommandeModel())->changerStatut((int) $livraison['commande_id'], 'livree');
        }
        return redirect()->to('/livreur/livraisons')->with('success', 'Livraison confirmée !');
    }

    public function echec(int $id): RedirectResponse
    {
        $livreurId      = (int) session()->get('user_id');
        $livraisonModel = new LivraisonModel();
        $livraison      = $livraisonModel->find($id);

        if ($livraison && (int) $livraison['livreur_id'] === $livreurId) {
            $livraisonModel->signalerEchec($id);
        }
        return redirect()->to('/livreur/livraisons')
                         ->with('error', 'Échec signalé. Commande retournée en préparation.');
    }

    public function historique(): string
    {
        return $this->renderLivreur('livreur/historique', [
            'title'      => 'Historique des livraisons - MboaFood',
            'livraisons' => (new LivraisonModel())->getParLivreur((int) session()->get('user_id'), true),
        ]);
    }
}
