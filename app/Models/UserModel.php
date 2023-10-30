<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'full_name',
        'nickname',
        'email',
        'username',
        'password',
        'position',
        'role',
        'active',
        'created_at',
        'updated_at',
    ];


    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];

    // protected $validationRules    = [];
    // protected $validationMessages = [];
    // protected $skipValidation     = false;

    protected function beforeInsert(array $data)
    {
        $data = $this->hashPassword($data);
        return $data;
    }

    protected function beforeUpdate(array $data)
    {
        $data = $this->hashPassword($data);
        return $data;
    }

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password']))

            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);

        return $data;
    }


    function userRole_options()
    {

        $userRole_options = array(
            'User' => 'User',
            'Admin' => 'Admin',
            'Root' => 'Root'
        );

        return $userRole_options;
    }
}
