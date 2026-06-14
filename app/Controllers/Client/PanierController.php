<?php
namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\PlatModel;
use CodeIgniter\HTTP\RedirectResponse;

class PanierController extends BaseController
{
    public function index(): string
    {
        $panier = session()->get('panier') ?? [];
        return $this->render('client/panier', [
            'title'  => 'Mon Panier - MboaFood',
            'panier' => $panier,
            'total'  => $this->calculerTotal($panier),
        ]);
    }

    public function ajouter(): RedirectResponse
    {
        $platId = (int) $this->request->getPost('plat_id');
        $qte    = max(1, (int) $this->request->getPost('quantite'));
        $plat   = (new PlatModel())->find($platId);

        if (!$plat || !$plat['disponible']) {
            return redirect()->back()->with('error', 'Ce plat n\'est pas disponible.');
        }

        $panier = session()->get('panier') ?? [];
        $trouve = false;

        foreach ($panier as &$item) {
            if ($item['id'] === $platId) {
                $item['quantite'] += $qte;
                $trouve = true;
                break;
            }
        }
        unset($item);

        if (!$trouve) {
            $panier[] = [
                'id'       => $platId,
                'nom'      => $plat['nom'],
                'prix'     => $plat['prix'],
                'image'    => $plat['image'] ?? '',
                'quantite' => $qte,
            ];
        }

        session()->set('panier', $panier);
        return redirect()->back()->with('success', $plat['nom'] . ' ajouté au panier !');
    }

    public function modifier(): RedirectResponse
    {
        $platId = (int) $this->request->getPost('plat_id');
        $qte    = (int) $this->request->getPost('quantite');
        $panier = session()->get('panier') ?? [];

        foreach ($panier as $k => &$item) {
            if ($item['id'] === $platId) {
                if ($qte <= 0) {
                    unset($panier[$k]);
                } else {
                    $item['quantite'] = $qte;
                }
                break;
            }
        }
        unset($item);

        session()->set('panier', array_values($panier));
        return redirect()->to('/client/panier');
    }

    public function supprimer(): RedirectResponse
    {
        $platId = (int) $this->request->getPost('plat_id');
        $panier = array_values(
            array_filter(session()->get('panier') ?? [], fn($i) => $i['id'] !== $platId)
        );
        session()->set('panier', $panier);
        return redirect()->to('/client/panier')->with('success', 'Article supprimé.');
    }

    public function vider(): RedirectResponse
    {
        session()->remove('panier');
        return redirect()->to('/client/panier');
    }

    private function calculerTotal(array $panier): int
    {
        return (int) array_sum(array_map(fn($i) => $i['prix'] * $i['quantite'], $panier));
    }
}
