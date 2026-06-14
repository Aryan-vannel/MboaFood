<?php
namespace App\Filters;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        if (!$session->get('user_id')) {
            return redirect()->to('/auth/login')->with('error', 'Veuillez vous connecter.');
        }
        if ($arguments) {
            $role = $session->get('user_role');
            if (!in_array($role, $arguments)) {
                return redirect()->to('/')->with('error', 'Accès non autorisé.');
            }
        }
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
