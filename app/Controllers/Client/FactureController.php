<?php
namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\CommandeModel;
use App\Models\FactureModel;
use CodeIgniter\HTTP\RedirectResponse;

class FactureController extends BaseController
{
    public function afficher(int $id): string|RedirectResponse
    {
        $userId  = session()->get('user_id');
        $facture = (new FactureModel())->getAvecCommande($id);

        if (!$facture) {
            return redirect()->back()->with('error', 'Facture introuvable.');
        }

        $commande = (new CommandeModel())->getAvecDetails($facture['commande_id']);

        if ((int) $commande['user_id'] !== $userId && session()->get('user_role') !== 'admin') {
            return redirect()->back()->with('error', 'Accès refusé.');
        }

        return $this->render('client/facture', [
            'title'    => 'Facture ' . $facture['numero'] . ' - MboaFood',
            'facture'  => $facture,
            'commande' => $commande,
        ]);
    }
}
