<?php

namespace App\Models;

use CodeIgniter\Model;

class PatientModel extends Model
{
    protected $table = 'patients';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'care_id',
        'profile_picture',
        'full_name',
        'gender',
        'birthdate',
        'email',
        'phone_number',
        'personal_id_number',
        'religion',
        'marriage_status',
        'number_of_children',
        'likely',
        'disability_type_1',
        'disability_type_2',
        'disability_type_3',
        'disability_type_4',
        'disability_type_5',
        'disability_type_6',
        'disability_type_7',
        'address',
        'district',
        'amphoe',
        'province',
        'zipcode',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
