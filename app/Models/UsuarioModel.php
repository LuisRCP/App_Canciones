<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'tbl_ope_usuario';
    protected $primaryKey = 'usuario_Id';

    protected $allowedFields = [
        'email',
        'password_hash',
        'activo',
        'persona_Id'
    ];

    protected $returnType = 'array';

    public function loginUsuario($email, $password)
    {
        $db = \Config\Database::connect();

        // 1. Buscar usuario
        $user = $this->where('email', $email)
                    ->where('activo', 1)
                    ->first();

        if (!$user) {
            return ['error' => 'Usuario no encontrado o inactivo'];
        }

        // 2. Validar password
        if (!password_verify($password, $user['password_hash'])) {
            return ['error' => 'Credenciales incorrectas'];
        }

        // 3. Obtener roles
        $roles = $db->table('tbl_ope_usuario_rol ur')
            ->select('r.nombre')
            ->join('tbl_cat_rol r', 'r.rol_Id = ur.rol_Id')
            ->where('ur.usuario_Id', $user['usuario_Id'])
            ->get()
            ->getResultArray();

        // 4. Generar token
        $token = bin2hex(random_bytes(32));

        // 5. Guardar token
        $db->table('tbl_ope_usuario_token')->insert([
            'usuario_Id' => $user['usuario_Id'],
            'token' => $token,
            'tipo' => 'AUTH',
            'expiracion' => date('Y-m-d H:i:s', strtotime('+7 days')),
            'usado' => 0
        ]);

        return [
            'success' => true,
            'token' => $token,
            'usuario' => [
                'id' => $user['usuario_Id'],
                'email' => $user['email']
            ],
            'roles' => $roles
        ];
    }

    public function registrarUsuario($data)
    {
        $db = \Config\Database::connect();

        $exists = $this->where('email', $data['email'])->first();
        if ($exists) {
            return ['error' => 'El email ya está registrado'];
        }

        $db->transStart();

        // 1. Persona
        $db->table('persona')->insert([
            'persona_Nombre' => $data['nombre'],
            'persona_ApellidoPaterno' => $data['apellidoPaterno'],
            'persona_ApellidoMaterno' => $data['apellidoMaterno']
        ]);

        $personaId = $db->insertID();

        // 2. Usuario
        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);

        $this->insert([
            'email' => $data['email'],
            'password_hash' => $passwordHash,
            'activo' => 1,
            'persona_Id' => $personaId
        ]);

        $usuarioId = $this->insertID();

        // 3. Rol
        $rol = $db->table('tbl_cat_rol')
            ->where('nombre', 'USUARIO')
            ->get()
            ->getRow();

        if (!$rol) {
            return ['error' => 'Rol USUARIO no encontrado'];
        }

        // 4. Asignar rol
        $db->table('tbl_ope_usuario_rol')->insert([
            'usuario_Id' => $usuarioId,
            'rol_Id' => $rol->rol_Id
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return ['error' => 'Error en transacción'];
        }

        return [
            'success' => true,
            'usuario_id' => $usuarioId
        ];
    }
    public function obtenerPerfil(int $usuarioId): array
    {
        $db = \Config\Database::connect();

        $usuario = $db->table('tbl_ope_usuario u')
            ->select('
                u.usuario_Id,
                u.email,
                u.activo,
                p.persona_Id,
                p.persona_Nombre,
                p.persona_ApellidoPaterno,
                p.persona_ApellidoMaterno
            ')
            ->join('persona p', 'p.persona_Id = u.persona_Id')
            ->where('u.usuario_Id', $usuarioId)
            ->get()
            ->getRowArray();

        if (!$usuario) {
            return ['error' => 'Usuario no encontrado'];
        }

        $roles = $db->table('tbl_ope_usuario_rol ur')
            ->select('r.rol_Id, r.nombre')
            ->join('tbl_cat_rol r', 'r.rol_Id = ur.rol_Id')
            ->where('ur.usuario_Id', $usuarioId)
            ->orderBy('r.rol_Id', 'ASC')
            ->get()
            ->getResultArray();

        return [
            'success' => true,
            'usuario' => $usuario,
            'roles'   => $roles
        ];
    }
}