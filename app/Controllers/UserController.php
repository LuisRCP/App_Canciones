<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class UserController extends BaseController
{
    public function perfilPage()
    {
        return view('auth/perfil');
    }

    public function perfil()
    {
        try {
            $auth = $this->request->auth ?? null;

            if (!$auth || empty($auth['usuario_id'])) {
                return $this->response->setStatusCode(401)
                    ->setJSON([
                        'error' => 'No autenticado'
                    ]);
            }

            $usuarioModel = new UsuarioModel();
            $resultado = $usuarioModel->obtenerPerfil((int) $auth['usuario_id']);

            if (isset($resultado['error'])) {
                return $this->response->setStatusCode(404)
                    ->setJSON([
                        'error' => $resultado['error']
                    ]);
            }

            return $this->response->setJSON([
                'success' => true,
                'usuario' => $resultado['usuario'],
                'roles'   => $resultado['roles']
            ]);

        } catch (\Throwable $e) {
            return $this->response->setStatusCode(500)
                ->setJSON([
                    'error' => 'Error interno',
                    'detalle' => $e->getMessage()
                ]);
        }
    }
}