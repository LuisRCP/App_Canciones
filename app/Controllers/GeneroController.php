<?php

namespace App\Controllers;

use App\Models\GeneroModel;

class GeneroController extends BaseController
{
    public function index()
    {
        try {
            $modelo = new GeneroModel();
            $generos = $modelo->listarGeneros();

            return $this->response->setJSON([
                'success' => true,
                'generos' => $generos
            ]);
        } catch (\Throwable $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Error interno',
                'detalle' => $e->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        try {
            $modelo = new GeneroModel();
            $genero = $modelo->obtenerGenero((int) $id);

            if (!$genero) {
                return $this->response->setStatusCode(404)->setJSON([
                    'error' => 'Género no encontrado'
                ]);
            }

            return $this->response->setJSON([
                'success' => true,
                'genero' => $genero
            ]);
        } catch (\Throwable $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Error interno',
                'detalle' => $e->getMessage()
            ]);
        }
    }

    public function store()
    {
        try {
            $data = $this->request->getJSON(true);

            if (!is_array($data)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'error' => 'JSON inválido'
                ]);
            }

            $modelo = new GeneroModel();
            $resultado = $modelo->crearGenero($data);

            if (isset($resultado['error'])) {
                return $this->response->setStatusCode(400)->setJSON($resultado);
            }

            return $this->response->setStatusCode(201)->setJSON([
                'success' => true,
                'message' => 'Género creado correctamente',
                'genero_Id' => $resultado['genero_Id']
            ]);
        } catch (\Throwable $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Error interno',
                'detalle' => $e->getMessage()
            ]);
        }
    }

    public function update($id)
    {
        try {
            $data = $this->request->getJSON(true);

            if (!is_array($data)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'error' => 'JSON inválido'
                ]);
            }

            $modelo = new GeneroModel();
            $resultado = $modelo->actualizarGenero((int) $id, $data);

            if (isset($resultado['error'])) {
                return $this->response->setStatusCode(400)->setJSON($resultado);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Género actualizado correctamente'
            ]);
        } catch (\Throwable $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Error interno',
                'detalle' => $e->getMessage()
            ]);
        }
    }

    public function delete($id)
    {
        try {
            $modelo = new GeneroModel();
            $resultado = $modelo->eliminarGenero((int) $id);

            if (isset($resultado['error'])) {
                return $this->response->setStatusCode(404)->setJSON($resultado);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Género eliminado correctamente'
            ]);
        } catch (\Throwable $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Error interno',
                'detalle' => $e->getMessage()
            ]);
        }
    }
}