<?php
declare(strict_types = 1);

namespace App\Models;

use App\Classes\Application;
use App\Classes\DatabasePDO;

abstract class Model {
    protected ?DatabasePDO $db = null;
    
    public function __construct(){
        $this->db = Application::db();
    }
}