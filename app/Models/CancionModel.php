<?php

namespace App\Models;

use CodeIgniter\Model;

class CancionModel extends Model
{
    protected $table = 'tbl_ope_cancion';
    protected $primaryKey = 'cancion_Id';

    protected $allowedFields = [
        'cancion_Nombre',
        'autor',
        'fecha_lanzamiento',
        'duracion',
        'imagen',
        'archivo_url',
        'genero_Id',
        'activo'
    ];

    protected $returnType = 'array';

    private function normalizarCancion(array $cancion): array
    {
        if (isset($cancion['cancion_Id'])) {
            $cancion['cancion_Id'] = (int) $cancion['cancion_Id'];
        }
        if (isset($cancion['genero_Id']) && $cancion['genero_Id'] !== null) {
            $cancion['genero_Id'] = (int) $cancion['genero_Id'];
        }
        if (isset($cancion['duracion']) && $cancion['duracion'] !== null) {
            $cancion['duracion'] = (int) $cancion['duracion'];
        }
        if (isset($cancion['activo'])) {
            $cancion['activo'] = (int) $cancion['activo'];
        }

        return $cancion;
    }

    private function normalizarLista(array $lista): array
    {
        return array_map(fn ($item) => $this->normalizarCancion($item), $lista);
    }

    public function listarCanciones(?int $generoId = null): array
    {
        $builder = $this->db->table($this->table . ' c')
            ->select('c.*, g.genero_Nombre')
            ->join('tbl_cat_genero g', 'g.genero_Id = c.genero_Id', 'left')
            ->orderBy('c.cancion_Nombre', 'ASC');

        if ($generoId !== null) {
            $builder->where('c.genero_Id', $generoId);
        }

        $canciones = $builder->get()->getResultArray();

        return $this->normalizarLista($canciones);
    }

    public function obtenerCancion(int $id): ?array
    {
        $cancion = $this->db->table($this->table . ' c')
            ->select('c.*, g.genero_Nombre')
            ->join('tbl_cat_genero g', 'g.genero_Id = c.genero_Id', 'left')
            ->where('c.cancion_Id', $id)
            ->get()
            ->getRowArray();

        if (!$cancion) {
            return null;
        }

        return $this->normalizarCancion($cancion);
    }

    public function crearCancion(array $data): array
    {
        $nombre = trim($data['cancion_Nombre'] ?? '');
        $autor = trim($data['autor'] ?? '');
        $archivoUrl = trim($data['archivo_url'] ?? '');
        $duracion = isset($data['duracion']) ? (int) $data['duracion'] : 0;
        $generoId = ($data['genero_Id'] ?? null) !== null && $data['genero_Id'] !== ''
            ? (int) $data['genero_Id']
            : null;

        if ($nombre === '') {
            return ['error' => 'El nombre de la canción es obligatorio'];
        }

        if ($autor === '') {
            return ['error' => 'El autor es obligatorio'];
        }

        if ($archivoUrl === '') {
            return ['error' => 'La URL o archivo de audio es obligatorio'];
        }

        $id = $this->insert([
            'cancion_Nombre' => $nombre,
            'autor' => $autor,
            'fecha_lanzamiento' => $data['fecha_lanzamiento'] ?? null,
            'duracion' => $duracion,
            'imagen' => $data['imagen'] ?? null,
            'archivo_url' => $archivoUrl,
            'genero_Id' => $generoId,
            'activo' => 1
        ], true);

        if (!$id) {
            return ['error' => 'No se pudo crear la canción'];
        }

        return [
            'success' => true,
            'cancion_Id' => (int) $id
        ];
    }

    public function actualizarCancion(int $id, array $data): array
    {
        $cancion = $this->find($id);
        if (!$cancion) {
            return ['error' => 'Canción no encontrada'];
        }

        $nombre = trim($data['cancion_Nombre'] ?? '');
        $autor = trim($data['autor'] ?? '');
        $archivoUrl = trim($data['archivo_url'] ?? '');
        $duracion = isset($data['duracion']) ? (int) $data['duracion'] : 0;
        $generoId = ($data['genero_Id'] ?? null) !== null && $data['genero_Id'] !== ''
            ? (int) $data['genero_Id']
            : null;

        if ($nombre === '') {
            return ['error' => 'El nombre de la canción es obligatorio'];
        }

        if ($autor === '') {
            return ['error' => 'El autor es obligatorio'];
        }

        if ($archivoUrl === '') {
            return ['error' => 'La URL o archivo de audio es obligatorio'];
        }

        $ok = $this->update($id, [
            'cancion_Nombre' => $nombre,
            'autor' => $autor,
            'fecha_lanzamiento' => $data['fecha_lanzamiento'] ?? null,
            'duracion' => $duracion,
            'imagen' => $data['imagen'] ?? null,
            'archivo_url' => $archivoUrl,
            'genero_Id' => $generoId,
            'activo' => isset($data['activo']) ? (int) $data['activo'] : 1
        ]);

        if (!$ok) {
            return ['error' => 'No se pudo actualizar la canción'];
        }

        return ['success' => true];
    }

    public function eliminarCancion(int $id): array
    {
        $cancion = $this->find($id);
        if (!$cancion) {
            return ['error' => 'Canción no encontrada'];
        }

        $ok = $this->delete($id);
        if (!$ok) {
            return ['error' => 'No se pudo eliminar la canción'];
        }

        return ['success' => true, 'cancion' => $this->normalizarCancion($cancion)];
    }
}