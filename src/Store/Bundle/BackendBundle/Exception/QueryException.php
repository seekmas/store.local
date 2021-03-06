<?php

namespace Store\Bundle\BackendBundle\Exception;

use Exception;

class QueryException extends Exception
{
    public function __construct( $message)
    {
        parent::__construct( trim( $message) ? $message : 'You throw a query-builder exception');
    }
}