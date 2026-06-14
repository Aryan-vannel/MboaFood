<?php
namespace App\Models;
use CodeIgniter\Model;

class CommandeModel extends Model
{
    protected $table         = 'commandes';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['user_id', 'adresse_id', 'statut', 'total', 'note'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getAvecDetails(int $id): ?array
    {
        $commande = $this->db->table('commandes')
            ->select('commandes.*, users.nom AS client_nom, users.telephone AS client_tel,
                      adresses.ville, adresses.quartier, adresses.description AS adresse_desc')
            ->join('users', 'users.id = commandes.user_id', 'left')
            ->join('adresses', 'adresses.id = commandes.adresse_id', 'left')
            ->where('commandes.id', $id)
            ->get()->getRowArray();

        if (!$commande) return null;

        $commande['lignes'] = $this->db->table('details_commande')
            ->select('details_commande.*, plats.nom AS plat_nom, plats.image AS plat_image')
            ->join('plats', 'plats.id = details_commande.plat_id', 'left')
            ->where('details_commande.commande_id', $id)
            ->get()->getResultArray();

        return $commande;
    }

    public function getParClient(int $userId): array
    {
        return $this->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    public function getToutesAvecClient(string $statut = ''): array
    {
        $builder = $this->db->table('commandes')
            ->select('commandes.*, users.nom AS client_nom, users.telephone AS client_tel')
            ->join('users', 'users.id = commandes.user_id', 'left')
            ->orderBy('commandes.created_at', 'DESC');
        if ($statut) {
            $builder->where('commandes.statut', $statut);
        }
        return $builder->get()->getResultArray();
    }

    // BUG FIX : query SQL brute pour éviter setBind()
    public function changerStatut(int $id, string $statut): bool
    {
        $this->db->query("UPDATE commandes SET statut = ?, updated_at = NOW() WHERE id = ?", [$statut, $id]);
        return true;
    }

    public function peutEtreAnnulee(int $id): bool
    {
        $commande = $this->find($id);
        if (!$commande) return false;
        return in_array($commande['statut'], ['en_attente', 'acceptee', 'en_preparation']);
    }

    public function getStats(): array
    {
        return [
            'total'            => $this->countAll(),
            'en_attente'       => $this->where('statut', 'en_attente')->countAllResults(),
            'en_cours'         => $this->whereIn('statut', ['acceptee', 'en_preparation', 'prete', 'en_livraison'])->countAllResults(),
            'livrees'          => $this->where('statut', 'livree')->countAllResults(),
            'chiffre_affaires' => (int) ($this->db->table('commandes')
                ->selectSum('total')
                ->where('statut', 'livree')
                ->get()->getRowArray()['total'] ?? 0),
        ];
    }
}
