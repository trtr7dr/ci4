<?php

namespace App\Models;

use CodeIgniter\Model;

class PageModel extends Model {

    protected $table = 'pages';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['url', 'title', 'content', 'public', 'templates'];
    protected $useTimestamps = false;

}
