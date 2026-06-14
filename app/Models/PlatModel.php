<?php
namespace App\Models;
use CodeIgniter\Model;

class PlatModel extends Model
{
    protected $table         = 'plats';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['categorie_id', 'nom', 'description', 'prix', 'image', 'disponible'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = false;

    public function getAvecCategorie(): array
    {
        return $this->db->table('plats')
            ->select('plats.*, categories.nom AS categorie_nom')
            ->join('categories', 'categories.id = plats.categorie_id', 'left')
            ->orderBy('categories.nom', 'ASC')
            ->orderBy('plats.nom', 'ASC')
            ->get()->getResultArray();
    }

    public function getDisponibles(): array
    {
        return $this->db->table('plats')
            ->select('plats.*, categories.nom AS categorie_nom')
            ->join('categories', 'categories.id = plats.categorie_id', 'left')
            ->where('plats.disponible', 1)
            ->orderBy('categories.nom', 'ASC')
            ->orderBy('plats.nom', 'ASC')
            ->get()->getResultArray();
    }

    public function getParCategorie(): array
    {
        $grouped = [];
        foreach ($this->getDisponibles() as $plat) {
            $cat = $plat['categorie_nom'] ?? 'Autres';
            $grouped[$cat][] = $plat;
        }
        return $grouped;
    }

    // BUG FIX : utiliser query SQL brute pour éviter le bug setBind() de CI4 4.7.3
    public function toggleDisponibilite(int $id): bool
    {
        $plat = $this->find($id);
        if (!$plat) return false;
        $nouvelleValeur = $plat['disponible'] ? 0 : 1;
        $this->db->query("UPDATE plats SET disponible = ? WHERE id = ?", [$nouvelleValeur, $id]);
        return true;
    }
}
