<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class AuthController extends BaseController
{
    public function login()
    {
        try {
            $data = $this->request->getJSON(true);

            if (!isset($data['email']) || !isset($data['password'])) {
                return $this->response->setStatusCode(400)
                    ->setJSON(['error' => 'Email y password requeridos']);
            }

            $usuarioModel = new \App\Models\UsuarioModel();

            $resultado = $usuarioModel->loginUsuario(
                $data['email'],
                $data['password']
            );

            if (isset($resultado['error'])) {
                return $this->response->setStatusCode(401)
                    ->setJSON(['error' => $resultado['error']]);
            }

            return $this->response->setJSON([
                'message' => 'Login exitoso',
                'token' => $resultado['token'],
                'usuario' => $resultado['usuario'],
                'roles' => $resultado['roles']
            ]);

        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)
                ->setJSON([
                    'error' => 'Error interno',
                    'detalle' => $e->getMessage()
                ]);
        }
    }

    public function register()
    {
        try {
            $data = $this->request->getJSON(true);

            if (
                !isset($data['email']) ||
                !isset($data['password']) ||
                !isset($data['nombre']) ||
                !isset($data['apellidoPaterno']) ||
                !isset($data['apellidoMaterno'])
            ) {
                return $this->response->setStatusCode(400)
                    ->setJSON(['error' => 'Datos incompletos']);
            }

            $usuarioModel = new \App\Models\UsuarioModel();

            $resultado = $usuarioModel->registrarUsuario($data);

            if (isset($resultado['error'])) {
                return $this->response->setStatusCode(500)
                    ->setJSON(['error' => $resultado['error']]);
            }

            return $this->response->setJSON([
                'message' => 'Usuario registrado correctamente',
                'usuario_id' => $resultado['usuario_id']
            ]);

        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)
                ->setJSON([
                    'error' => 'Error interno',
                    'detalle' => $e->getMessage()
                ]);
        }
    }
    public function loginPage()
    {
        return view('auth/login');
    }

    public function registerPage()
    {
        return view('auth/register');
    }
}