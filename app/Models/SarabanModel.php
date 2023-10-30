<?php

namespace App\Models;

use CodeIgniter\Model;

class SarabanModel extends Model
{
    protected $table = 'saraban';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'doc_id',
        'doc_cat',
        'date_add',
        'doc_from',
        'doc_to',
        'doc_object',
        'doc_link',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
