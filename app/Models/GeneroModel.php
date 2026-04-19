<?php

namespace App\Models;

use CodeIgniter\Model;

class GeneroModel extends Model
{
    protected $table = 'tbl_cat_genero';
    protected $primaryKey = 'genero_Id';
    protected $allowedFields = [
        'genero_Nombre'
    ];
    protected $returnType = 'array';

    private function normalizarGenero(array $genero): array
    {
        if (isset($genero['genero_Id'])) {
            $genero['genero_Id'] = (int) $genero['genero_Id'];
        }

        return $genero;
    }

    private function normalizarLista(array $lista): array
    {
        return array_map(fn ($item) => $this->normalizarGenero($item), $lista);
    }

    public function listarGeneros(): array
    {
        $generos = $this->orderBy('genero_Nombre', 'ASC')->findAll();
        return $this->normalizarLista($generos);
    }

    public function obtenerGenero(int $id): ?array
    {
        $genero = $this->find($id);

        if (!$genero) {
            return null;
        }

        return $this->normalizarGenero($genero);
    }

    public function crearGenero(array $data): array
    {
        $nombre = trim($data['genero_Nombre'] ?? '');

        if ($nombre === '') {
            return ['error' => 'El nombre del género es obligatorio'];
        }

        $existe = $this->where('genero_Nombre', $nombre)->first();
        if ($existe) {
            return ['error' => 'El género ya existe'];
        }

        $id = $this->insert([
            'genero_Nombre' => $nombre
        ], true);

        if (!$id) {
            return ['error' => 'No se pudo crear el género'];
        }

        return [
            'success' => true,
            'genero_Id' => (int) $id
        ];
    }

    public function actualizarGenero(int $id, array $data): array
    {
        $genero = $this->find($id);
        if (!$genero) {
            return ['error' => 'Género no encontrado'];
        }

        $nombre = trim($data['genero_Nombre'] ?? '');
        if ($nombre === '') {
            return ['error' => 'El nombre del género es obligatorio'];
        }

        $existe = $this->where('genero_Nombre', $nombre)
            ->where('genero_Id !=', $id)
            ->first();

        if ($existe) {
            return ['error' => 'Ya existe otro género con ese nombre'];
        }

        $ok = $this->update($id, [
            'genero_Nombre' => $nombre
        ]);

        if (!$ok) {
            return ['error' => 'No se pudo actualizar el género'];
        }

        return ['success' => true];
    }

    public function eliminarGenero(int $id): array
    {
        $genero = $this->find($id);
        if (!$genero) {
            return ['error' => 'Género no encontrado'];
        }

        $ok = $this->delete($id);
        if (!$ok) {
            return ['error' => 'No se pudo eliminar el género'];
        }

        return ['success' => true];
    }
}