<?php

namespace App\Exceptions\Book;

use Exception;

class ErrorParsingDataCheckResponseExeption extends Exception
{
    public function __construct($message = 'Error parsing data check response')
    {
        parent::__construct($message);
    }
}
