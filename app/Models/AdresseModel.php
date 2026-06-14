<?php
namespace App\Models;
use CodeIgniter\Model;

class AdresseModel extends Model
{
    protected $table         = 'adresses';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['user_id', 'ville', 'quartier', 'description', 'is_default'];
    protected $useTimestamps = false;

    public function getParUser(int $userId): array
    {
        return $this->where('user_id', $userId)->findAll();
    }

    public function getDefault(int $userId): ?array
    {
        return $this->where('user_id', $userId)->where('is_default', 1)->first()
            ?? $this->where('user_id', $userId)->first();
    }
}
