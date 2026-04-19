<?php

namespace App\Controllers;

use App\Models\PlaylistModel;

class PlaylistController extends BaseController
{
    public function index()
    {
        try {
            $auth = $this->request->auth ?? null;

            if (!$auth || empty($auth['usuario_id'])) {
                return $this->response->setStatusCode(401)->setJSON([
                    'error' => 'No autenticado'
                ]);
            }

            $modelo = new PlaylistModel();
            $playlists = $modelo->listarPlaylistsPorUsuario((int) $auth['usuario_id']);

            return $this->response->setJSON([
                'success' => true,
                'playlists' => $playlists
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
            $auth = $this->request->auth ?? null;

            if (!$auth || empty($auth['usuario_id'])) {
                return $this->response->setStatusCode(401)->setJSON([
                    'error' => 'No autenticado'
                ]);
            }

            $modelo = new PlaylistModel();
            $resultado = $modelo->obtenerDetallePlaylist((int) $id, (int) $auth['usuario_id']);

            if (!$resultado) {
                return $this->response->setStatusCode(404)->setJSON([
                    'error' => 'Playlist no encontrada'
                ]);
            }

            return $this->response->setJSON([
                'success' => true,
                'playlist' => $resultado['playlist'],
                'canciones' => $resultado['canciones']
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
            $auth = $this->request->auth ?? null;

            if (!$auth || empty($auth['usuario_id'])) {
                return $this->response->setStatusCode(401)->setJSON([
                    'error' => 'No autenticado'
                ]);
            }

            $data = $this->request->getJSON(true);

            if (!is_array($data)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'error' => 'JSON inválido'
                ]);
            }

            $modelo = new PlaylistModel();
            $resultado = $modelo->crearPlaylist((int) $auth['usuario_id'], $data);

            if (isset($resultado['error'])) {
                return $this->response->setStatusCode(400)->setJSON($resultado);
            }

            return $this->response->setStatusCode(201)->setJSON([
                'success' => true,
                'message' => 'Playlist creada correctamente',
                'playlist_Id' => $resultado['playlist_Id']
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
            $auth = $this->request->auth ?? null;

            if (!$auth || empty($auth['usuario_id'])) {
                return $this->response->setStatusCode(401)->setJSON([
                    'error' => 'No autenticado'
                ]);
            }

            $data = $this->request->getJSON(true);

            if (!is_array($data)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'error' => 'JSON inválido'
                ]);
            }

            $modelo = new PlaylistModel();
            $resultado = $modelo->actualizarPlaylist((int) $id, (int) $auth['usuario_id'], $data);

            if (isset($resultado['error'])) {
                return $this->response->setStatusCode(400)->setJSON($resultado);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Playlist actualizada correctamente'
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
            $auth = $this->request->auth ?? null;

            if (!$auth || empty($auth['usuario_id'])) {
                return $this->response->setStatusCode(401)->setJSON([
                    'error' => 'No autenticado'
                ]);
            }

            $modelo = new PlaylistModel();
            $resultado = $modelo->eliminarPlaylist((int) $id, (int) $auth['usuario_id']);

            if (isset($resultado['error'])) {
                return $this->response->setStatusCode(404)->setJSON($resultado);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Playlist eliminada correctamente'
            ]);
        } catch (\Throwable $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Error interno',
                'detalle' => $e->getMessage()
            ]);
        }
    }

    public function addSong($playlistId)
    {
        try {
            $auth = $this->request->auth ?? null;

            if (!$auth || empty($auth['usuario_id'])) {
                return $this->response->setStatusCode(401)->setJSON([
                    'error' => 'No autenticado'
                ]);
            }

            $data = $this->request->getJSON(true);

            if (!isset($data['cancion_Id'])) {
                return $this->response->setStatusCode(400)->setJSON([
                    'error' => 'cancion_Id es obligatorio'
                ]);
            }

            $modelo = new PlaylistModel();
            $resultado = $modelo->agregarCancion(
                (int) $playlistId,
                (int) $auth['usuario_id'],
                (int) $data['cancion_Id']
            );

            if (isset($resultado['error'])) {
                return $this->response->setStatusCode(400)->setJSON($resultado);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Canción agregada a la playlist'
            ]);
        } catch (\Throwable $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Error interno',
                'detalle' => $e->getMessage()
            ]);
        }
    }

    public function removeSong($playlistId, $cancionId)
    {
        try {
            $auth = $this->request->auth ?? null;

            if (!$auth || empty($auth['usuario_id'])) {
                return $this->response->setStatusCode(401)->setJSON([
                    'error' => 'No autenticado'
                ]);
            }

            $modelo = new PlaylistModel();
            $resultado = $modelo->quitarCancion(
                (int) $playlistId,
                (int) $auth['usuario_id'],
                (int) $cancionId
            );

            if (isset($resultado['error'])) {
                return $this->response->setStatusCode(400)->setJSON($resultado);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Canción quitada de la playlist'
            ]);
        } catch (\Throwable $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Error interno',
                'detalle' => $e->getMessage()
            ]);
        }
    }
}