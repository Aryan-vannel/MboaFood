<?php
namespace App\Models;
use CodeIgniter\Model;

class CategorieModel extends Model
{
    protected $table         = 'categories';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['nom', 'description', 'image'];
    protected $useTimestamps = false;
}
