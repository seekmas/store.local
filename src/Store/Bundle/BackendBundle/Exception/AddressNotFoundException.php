<?php

namespace Store\Bundle\BackendBundle\Exception;

class AddressNotFoundException extends AddressException
{
    public function __construct()
    {
        parent::__construct('Your shipment address is not found');
    }
}