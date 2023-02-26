<?php
declare(strict_types=1);

namespace App\Exceptions;

class RouteNotFound extends \Exception {
    protected $message = ' ### 404. Page not found. ### ';
}