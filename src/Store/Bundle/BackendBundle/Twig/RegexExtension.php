<?php

namespace Store\Bundle\BackendBundle\Twig;

//use Twig_Extension;

class RegexExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('regex_replace', array($this, 'regex_replace')),
        ];
    }

    public function regex_replace( $origin , $regex , $replacement )
    {
        return preg_replace($regex , $replacement , $origin);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'regex_filter';
    }

}