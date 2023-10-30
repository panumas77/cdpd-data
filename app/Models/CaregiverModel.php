<?php

namespace App\Models;

use CodeIgniter\Model;

class CaregiverModel extends Model
{
    protected $table = 'caregivers';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'pat_id',
        'full_name',
        'gender',
        'birthdate',
        'email',
        'phone_number',
        'personal_id_number',
        'religion',
        'relationship',
        'address',
        'district',
        'amphoe',
        'province',
        'zipcode',

    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';



    public function searchCaregivers($search)
    {
        return $this->db->table('caregivers')
            ->like('name', $search)
            ->orLike('personal_id', $search)
            ->get()
            ->getResult();
    }
}
