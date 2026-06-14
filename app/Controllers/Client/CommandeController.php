<?php
namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\AdresseModel;
use App\Models\CommandeModel;
use App\Models\DetailCommandeModel;
use App\Models\FactureModel;
use CodeIgniter\HTTP\RedirectResponse;

class CommandeController extends BaseController
{
    public function passer(): string|RedirectResponse
    {
        $panier = session()->get('panier') ?? [];
        if (empty($panier)) {
            return redirect()->to('/client/menu')->with('error', 'Votre panier est vide.');
        }
        return $this->render('client/commande_passer', [
            'title'    => 'Valider ma commande - MboaFood',
            'panier'   => $panier,
            'total'    => $this->calculerTotal($panier),
            'adresses' => (new AdresseModel())->getParUser((int) session()->get('user_id')),
        ]);
    }

    public function valider(): RedirectResponse
    {
        $panier = session()->get('panier') ?? [];
        if (empty($panier)) return redirect()->to('/client/menu');

        $userId    = (int) session()->get('user_id');
        $total     = $this->calculerTotal($panier);
        $adresseId = $this->request->getPost('adresse_id');
        $note      = $this->request->getPost('note') ?? '';
        $db        = \Config\Database::connect();

        // BUG FIX : query SQL brute pour insert commande
        if (!empty($adresseId) && is_numeric($adresseId)) {
            $db->query(
                "INSERT INTO commandes (user_id, adresse_id, statut, total, note, created_at, updated_at)
                 VALUES (?, ?, 'en_attente', ?, ?, NOW(), NOW())",
                [$userId, (int) $adresseId, $total, $note]
            );
        } else {
            $db->query(
                "INSERT INTO commandes (user_id, statut, total, note, created_at, updated_at)
                 VALUES (?, 'en_attente', ?, ?, NOW(), NOW())",
                [$userId, $total, $note]
            );
        }

        $commandeId = $db->insertID();
        (new DetailCommandeModel())->insererLignes($commandeId, $panier);
        session()->remove('panier');

        return redirect()->to('/client/commande/' . $commandeId)
                         ->with('success', 'Commande passée avec succès !');
    }

    public function liste(): string
    {
        return $this->render('client/commandes', [
            'title'     => 'Mes Commandes - MboaFood',
            'commandes' => (new CommandeModel())->getParClient((int) session()->get('user_id')),
        ]);
    }

    public function detail(int $id): string|RedirectResponse
    {
        $userId        = (int) session()->get('user_id');
        $commandeModel = new CommandeModel();
        $check         = $commandeModel->find($id);

        if (!$check || (int) $check['user_id'] !== $userId) {
            return redirect()->to('/client/commandes')->with('error', 'Commande introuvable.');
        }

        return $this->render('client/commande_detail', [
            'title'    => 'Commande #' . $id . ' - MboaFood',
            'commande' => $commandeModel->getAvecDetails($id),
            'facture'  => (new FactureModel())->getParCommande($id),
        ]);
    }

    public function annuler(int $id): RedirectResponse
    {
        $userId        = (int) session()->get('user_id');
        $commandeModel = new CommandeModel();
        $commande      = $commandeModel->find($id);

        if (!$commande || (int) $commande['user_id'] !== $userId) {
            return redirect()->to('/client/commandes')->with('error', 'Commande introuvable.');
        }
        if (!$commandeModel->peutEtreAnnulee($id)) {
            return redirect()->back()->with('error', 'Cette commande ne peut plus être annulée.');
        }
        $commandeModel->changerStatut($id, 'annulee');
        return redirect()->to('/client/commandes')->with('success', 'Commande annulée.');
    }

    private function calculerTotal(array $panier): int
    {
        return (int) array_sum(array_map(fn($i) => $i['prix'] * $i['quantite'], $panier));
    }
}
