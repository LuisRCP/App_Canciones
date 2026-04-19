<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeaderLine('Authorization');

        if (empty($authHeader)) {
            return service('response')
                ->setStatusCode(401)
                ->setJSON([
                    'error' => 'Token requerido'
                ]);
        }

        if (!preg_match('/Bearer\s+(\S+)/i', $authHeader, $matches)) {
            return service('response')
                ->setStatusCode(401)
                ->setJSON([
                    'error' => 'Formato de token inválido'
                ]);
        }

        $token = trim($matches[1]);

        if ($token === '') {
            return service('response')
                ->setStatusCode(401)
                ->setJSON([
                    'error' => 'Token vacío'
                ]);
        }

        $db = \Config\Database::connect();

        $tokenRow = $db->table('tbl_ope_usuario_token tok')
            ->select('tok.token_Id, tok.usuario_Id, tok.token, tok.tipo, tok.expiracion, tok.usado, u.email, u.activo')
            ->join('tbl_ope_usuario u', 'u.usuario_Id = tok.usuario_Id')
            ->where('tok.token', $token)
            ->where('tok.tipo', 'AUTH')
            ->where('tok.usado', 0)
            ->where('tok.expiracion >=', date('Y-m-d H:i:s'))
            ->where('u.activo', 1)
            ->get()
            ->getRowArray();

        if (!$tokenRow) {
            return service('response')
                ->setStatusCode(401)
                ->setJSON([
                    'error' => 'Token inválido o expirado'
                ]);
        }

        $roles = $db->table('tbl_ope_usuario_rol ur')
            ->select('r.rol_Id, r.nombre')
            ->join('tbl_cat_rol r', 'r.rol_Id = ur.rol_Id')
            ->where('ur.usuario_Id', $tokenRow['usuario_Id'])
            ->orderBy('r.rol_Id', 'ASC')
            ->get()
            ->getResultArray();

        $request->auth = [
            'token_id'   => (int) $tokenRow['token_Id'],
            'usuario_id' => (int) $tokenRow['usuario_Id'],
            'email'      => $tokenRow['email'],
            'roles'      => $roles,
            'token'      => $tokenRow['token'],
        ];

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No hace falta por ahora
    }
}