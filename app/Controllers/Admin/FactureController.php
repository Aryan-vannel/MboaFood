<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CommandeModel;
use App\Models\FactureModel;
use CodeIgniter\HTTP\RedirectResponse;

class FactureController extends BaseController
{
    public function index(): string
    {
        $db       = \Config\Database::connect();
        $factures = $db->table('factures f')
            ->select('f.*, u.nom AS client_nom, c.total')
            ->join('commandes c', 'c.id = f.commande_id')
            ->join('users u', 'u.id = c.user_id')
            ->orderBy('f.date_facture', 'DESC')
            ->get()->getResultArray();

        return $this->renderAdmin('admin/factures', [
            'title'    => 'Factures - MboaFood',
            'factures' => $factures,
        ]);
    }

    public function detail(int $id): string|RedirectResponse
    {
        $facture = (new FactureModel())->getAvecCommande($id);
        if (!$facture) {
            return redirect()->to('/admin/factures')->with('error', 'Facture introuvable.');
        }

        $commande = (new CommandeModel())->getAvecDetails($facture['commande_id']);
        return $this->renderAdmin('admin/facture_detail', [
            'title'    => 'Facture ' . $facture['numero'],
            'facture'  => $facture,
            'commande' => $commande,
        ]);
    }
}
