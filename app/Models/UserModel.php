<?php
namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table         = 'users';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['nom', 'email', 'password', 'telephone', 'role', 'actif'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function findByEmail(string $email): ?array
    {
        return $this->where('email', $email)->first();
    }

    public function getByRole(string $role): array
    {
        return $this->where('role', $role)->findAll();
    }

    // BUG FIX : query SQL brute
    public function toggleActif(int $id): void
    {
        $this->db->query(
            "UPDATE users SET actif = IF(actif = 1, 0, 1), updated_at = NOW() WHERE id = ?",
            [$id]
        );
    }

    public function getLivreursDisponibles(): array
    {
        return $this->db->query("
            SELECT * FROM users
            WHERE role = 'livreur'
            AND actif = 1
            AND id NOT IN (
                SELECT livreur_id FROM livraisons
                WHERE statut IN ('assignee','en_cours')
                AND livreur_id IS NOT NULL
            )
        ")->getResultArray();
    }
}
