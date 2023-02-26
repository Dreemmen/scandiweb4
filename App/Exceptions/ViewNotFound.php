<?php
declare(strict_types=1);

namespace App\Exceptions;

class ViewNotFound extends \Exception {
    protected $message = ' ### 404. View not found. ### ';
}