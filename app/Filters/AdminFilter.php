<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeaderLine('Authorization');

        if (!$authHeader) {
            return service('response')->setStatusCode(401)
                ->setJSON(['error' => 'Token requerido']);
        }

        $token = str_replace('Bearer ', '', $authHeader);

        $db = \Config\Database::connect();

        $tokenData = $db->table('tbl_ope_usuario_token')
            ->where('token', $token)
            ->where('usado', 0)
            ->where('expiracion >=', date('Y-m-d H:i:s'))
            ->get()
            ->getRow();

        if (!$tokenData) {
            return service('response')->setStatusCode(401)
                ->setJSON(['error' => 'Token inválido']);
        }

        // Verificar rol ADMIN
        $rol = $db->table('tbl_ope_usuario_rol ur')
            ->select('r.nombre')
            ->join('tbl_cat_rol r', 'r.rol_Id = ur.rol_Id')
            ->where('ur.usuario_Id', $tokenData->usuario_Id)
            ->where('r.nombre', 'ADMIN')
            ->get()
            ->getRow();

        if (!$rol) {
            return service('response')->setStatusCode(403)
                ->setJSON(['error' => 'Acceso solo para administradores']);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}