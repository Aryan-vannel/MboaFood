<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    // NOTE: CodeIgniter\Controller already defines $request with a specific type.
    // Redeclaring it here causes a fatal error in CI4.7.3.

    protected $helpers = ['url', 'form', 'text'];

    public function initController(
        RequestInterface  $request,
        ResponseInterface $response,
        LoggerInterface   $logger
    ): void {
        parent::initController($request, $response, $logger);
    }

    protected function render(
        string $view,
        array  $data   = [],
        string $layout = 'layouts/main'
    ): string {
        $data['session'] = session();
        $data['content'] = view($view, $data);
        return view($layout, $data);
    }

    protected function renderAdmin(string $view, array $data = []): string
    {
        return $this->render($view, $data, 'layouts/admin');
    }

    protected function renderLivreur(string $view, array $data = []): string
    {
        return $this->render($view, $data, 'layouts/livreur');
    }
}
