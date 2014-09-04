<?php

namespace Store\Bundle\BackendBundle\Exception;

class DoctrineQueryBuilderAliasException extends QueryException
{
    public function __construct()
    {
        parent::__construct('Entity alias is empty in QueryBuilder');
    }
}