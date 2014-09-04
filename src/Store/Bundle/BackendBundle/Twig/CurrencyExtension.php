<?php

namespace Store\Bundle\BackendBundle\Twig;

//use Twig_Extension;

class CurrencyExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('currency', array($this, 'currency_format')),
        ];
    }

    public function currency_format( $number)
    {
        return '<i class="fa fa-jpy"></i> '.$number;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'currency_format_filter';
    }

}