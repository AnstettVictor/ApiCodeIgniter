<?php namespace App\Models;

use CodeIgniter\Model;

class Users extends Model
{

    protected $DBGroup    = 'default';

    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [

        'name', 
        'email',
        'country',
        'department'
    
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';


    protected $validationRules    = [

        'name' => 'required|min_length[5]|max_length[32]',
        'email' => 'required|valid_email|is_unique[users.email]',
        'country' => 'required|alpha|exact_length[2]',
        'department' => 'required|decimal|exact_length[4]',


    ];
    protected $validationMessages = [

    ];
    protected $skipValidation     = false;
}