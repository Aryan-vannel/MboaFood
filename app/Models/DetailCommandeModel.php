<?php
namespace App\Models;
use CodeIgniter\Model;

class DetailCommandeModel extends Model
{
    protected $table         = 'details_commande';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['commande_id', 'plat_id', 'quantite', 'prix_unitaire'];
    protected $useTimestamps = false;

    // BUG FIX : query SQL brute pour chaque ligne
    public function insererLignes(int $commandeId, array $panier): void
    {
        $db = \Config\Database::connect();
        foreach ($panier as $item) {
            $db->query(
                "INSERT INTO details_commande (commande_id, plat_id, quantite, prix_unitaire)
                 VALUES (?, ?, ?, ?)",
                [
                    $commandeId,
                    (int) $item['id'],
                    (int) $item['quantite'],
                    (int) $item['prix'],
                ]
            );
        }
    }
}
