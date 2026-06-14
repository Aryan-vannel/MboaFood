<?php
namespace App\Models;
use CodeIgniter\Model;

class LivraisonModel extends Model
{
    protected $table         = 'livraisons';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['commande_id', 'livreur_id', 'statut', 'tentatives', 'date_livraison'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getParLivreur(int $livreurId, bool $historique = false): array
    {
        $builder = $this->db->table('livraisons')
            ->select('livraisons.*, commandes.total, commandes.statut AS commande_statut,
                      users.nom AS client_nom, users.telephone AS client_tel,
                      adresses.ville, adresses.quartier, adresses.description AS adresse')
            ->join('commandes', 'commandes.id = livraisons.commande_id', 'left')
            ->join('users', 'users.id = commandes.user_id', 'left')
            ->join('adresses', 'adresses.id = commandes.adresse_id', 'left')
            ->where('livraisons.livreur_id', $livreurId)
            ->orderBy('livraisons.created_at', 'DESC');

        if ($historique) {
            $builder->whereIn('livraisons.statut', ['livree', 'echec']);
        } else {
            $builder->whereIn('livraisons.statut', ['assignee', 'en_cours']);
        }
        return $builder->get()->getResultArray();
    }

    public function getAvecDetails(int $id): ?array
    {
        $result = $this->db->table('livraisons')
            ->select('livraisons.*, commandes.total, commandes.note,
                      users.nom AS client_nom, users.telephone AS client_tel,
                      adresses.ville, adresses.quartier, adresses.description AS adresse')
            ->join('commandes', 'commandes.id = livraisons.commande_id', 'left')
            ->join('users', 'users.id = commandes.user_id', 'left')
            ->join('adresses', 'adresses.id = commandes.adresse_id', 'left')
            ->where('livraisons.id', $id)
            ->get()->getRowArray();

        return $result ?: null;
    }

    // BUG FIX : toutes les mises à jour en query SQL brute
    public function majStatut(int $id, string $statut, ?string $dateLivraison = null): void
    {
        if ($dateLivraison) {
            $this->db->query(
                "UPDATE livraisons SET statut = ?, date_livraison = ?, updated_at = NOW() WHERE id = ?",
                [$statut, $dateLivraison, $id]
            );
        } else {
            $this->db->query(
                "UPDATE livraisons SET statut = ?, updated_at = NOW() WHERE id = ?",
                [$statut, $id]
            );
        }
    }

    public function signalerEchec(int $id): bool
    {
        $livraison  = $this->find($id);
        if (!$livraison) return false;

        $tentatives    = (int) $livraison['tentatives'] + 1;
        $commandeModel = new CommandeModel();

        if ($tentatives < 2) {
            $this->db->query(
                "UPDATE livraisons SET statut = 'assignee', livreur_id = NULL, tentatives = ?, updated_at = NOW() WHERE id = ?",
                [$tentatives, $id]
            );
            $commandeModel->changerStatut((int) $livraison['commande_id'], 'en_preparation');
        } else {
            $this->db->query(
                "UPDATE livraisons SET statut = 'echec', tentatives = ?, updated_at = NOW() WHERE id = ?",
                [$tentatives, $id]
            );
            $commandeModel->changerStatut((int) $livraison['commande_id'], 'annulee');
        }

        return true;
    }
}
