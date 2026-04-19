<?php

namespace App\Controllers;

use App\Models\CancionModel;

class CancionController extends BaseController
{
    public function index()
    {
        try {
            $generoId = $this->request->getGet('genero_Id');
            $generoId = ($generoId !== null && $generoId !== '') ? (int) $generoId : null;

            $modelo = new CancionModel();
            $canciones = $modelo->listarCanciones($generoId);

            return $this->response->setJSON([
                'success' => true,
                'canciones' => $canciones
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
            $modelo = new CancionModel();
            $cancion = $modelo->obtenerCancion((int) $id);

            if (!$cancion) {
                return $this->response->setStatusCode(404)->setJSON([
                    'error' => 'Canción no encontrada'
                ]);
            }

            return $this->response->setJSON([
                'success' => true,
                'cancion' => $cancion
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
            $modelo = new CancionModel();

            $data = [
                'cancion_Nombre'    => trim((string) $this->request->getPost('cancion_Nombre')),
                'autor'             => trim((string) $this->request->getPost('autor')),
                'fecha_lanzamiento' => $this->request->getPost('fecha_lanzamiento') ?: null,
                'duracion'          => $this->request->getPost('duracion'),
                'genero_Id'         => $this->request->getPost('genero_Id'),
                'activo'            => 1
            ];

            $audioPath = $this->guardarArchivo('audio', 'canciones', 'archivo_url');
            if ($audioPath !== null) {
                $data['archivo_url'] = $audioPath;
            } else {
                $data['archivo_url'] = trim((string) $this->request->getPost('archivo_url'));
            }

            $imagenPath = $this->guardarArchivo('imagen', 'portadas', 'imagen');
            if ($imagenPath !== null) {
                $data['imagen'] = $imagenPath;
            } else {
                $data['imagen'] = trim((string) $this->request->getPost('imagen')) ?: null;
            }

            $resultado = $modelo->crearCancion($data);

            if (isset($resultado['error'])) {
                return $this->response->setStatusCode(400)->setJSON($resultado);
            }

            return $this->response->setStatusCode(201)->setJSON([
                'success' => true,
                'message' => 'Canción creada correctamente',
                'cancion_Id' => $resultado['cancion_Id']
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
            $modelo = new CancionModel();
            $cancionActual = $modelo->obtenerCancion((int) $id);

            if (!$cancionActual) {
                return $this->response->setStatusCode(404)->setJSON([
                    'error' => 'Canción no encontrada'
                ]);
            }

            $data = [
                'cancion_Nombre'    => trim((string) $this->request->getPost('cancion_Nombre')),
                'autor'             => trim((string) $this->request->getPost('autor')),
                'fecha_lanzamiento' => $this->request->getPost('fecha_lanzamiento') ?: null,
                'duracion'          => $this->request->getPost('duracion'),
                'genero_Id'         => $this->request->getPost('genero_Id'),
                'activo'            => $this->request->getPost('activo') ?? 1
            ];

            $audioPath = $this->guardarArchivo('audio', 'canciones', 'archivo_url');
            if ($audioPath !== null) {
                $this->eliminarArchivoSiExiste($cancionActual['archivo_url'] ?? null);
                $data['archivo_url'] = $audioPath;
            } else {
                $data['archivo_url'] = trim((string) $this->request->getPost('archivo_url'));
            }

            $imagenPath = $this->guardarArchivo('imagen', 'portadas', 'imagen');
            if ($imagenPath !== null) {
                $this->eliminarArchivoSiExiste($cancionActual['imagen'] ?? null);
                $data['imagen'] = $imagenPath;
            } else {
                $data['imagen'] = trim((string) $this->request->getPost('imagen')) ?: null;
            }

            $resultado = $modelo->actualizarCancion((int) $id, $data);

            if (isset($resultado['error'])) {
                return $this->response->setStatusCode(400)->setJSON($resultado);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Canción actualizada correctamente'
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
            $modelo = new CancionModel();
            $cancion = $modelo->obtenerCancion((int) $id);

            if (!$cancion) {
                return $this->response->setStatusCode(404)->setJSON([
                    'error' => 'Canción no encontrada'
                ]);
            }

            $resultado = $modelo->eliminarCancion((int) $id);

            if (isset($resultado['error'])) {
                return $this->response->setStatusCode(400)->setJSON($resultado);
            }

            $this->eliminarArchivoSiExiste($cancion['archivo_url'] ?? null);
            $this->eliminarArchivoSiExiste($cancion['imagen'] ?? null);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Canción eliminada correctamente'
            ]);
        } catch (\Throwable $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Error interno',
                'detalle' => $e->getMessage()
            ]);
        }
    }

    private function guardarArchivo(string $inputName, string $carpeta, string $campo): ?string
    {
        $archivo = $this->request->getFile($inputName);

        if (!$archivo || !$archivo->isValid() || $archivo->hasMoved()) {
            return null;
        }

        $directorio = FCPATH . 'uploads/' . $carpeta;

        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true);
        }

        $nombreNuevo = $archivo->getRandomName();
        $archivo->move($directorio, $nombreNuevo);

        return 'uploads/' . $carpeta . '/' . $nombreNuevo;
    }

    private function eliminarArchivoSiExiste(?string $rutaRelativa): void
    {
        if (!$rutaRelativa) {
            return;
        }

        $ruta = FCPATH . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $rutaRelativa);

        if (is_file($ruta)) {
            @unlink($ruta);
        }
    }
}