<?php
namespace App\Models;
use CodeIgniter\Model;

class FactureModel extends Model
{
    protected $table         = 'factures';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['commande_id', 'numero', 'montant_ht', 'tva', 'montant_ttc'];
    protected $useTimestamps = false;

    // BUG FIX : query SQL brute pour insert
    public function generer(int $commandeId, int $total): array
    {
        $numero = 'FAC-' . date('Ymd') . '-' . str_pad((string)$commandeId, 5, '0', STR_PAD_LEFT);
        $this->db->query(
            "INSERT INTO factures (commande_id, numero, montant_ht, tva, montant_ttc, date_facture)
             VALUES (?, ?, ?, 0, ?, NOW())",
            [$commandeId, $numero, $total, $total]
        );
        return [
            'commande_id' => $commandeId,
            'numero'      => $numero,
            'montant_ht'  => $total,
            'tva'         => 0,
            'montant_ttc' => $total,
        ];
    }

    public function getAvecCommande(int $id): ?array
    {
        return $this->db->table('factures')
            ->select('factures.*, commandes.created_at AS commande_date,
                      users.nom AS client_nom, users.email AS client_email, users.telephone')
            ->join('commandes', 'commandes.id = factures.commande_id', 'left')
            ->join('users', 'users.id = commandes.user_id', 'left')
            ->where('factures.id', $id)
            ->get()->getRowArray() ?: null;
    }

    public function getParCommande(int $commandeId): ?array
    {
        return $this->where('commande_id', $commandeId)->first();
    }
}
