<?php
namespace Store\Bundle\BackendBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class CommonEvent extends Event
{
    protected $request;
    protected $service_container;

    public function __construct($request,$service_container)
    {
        $this->request = $request;
        $this->service_container = $service_container;
    }

    /**
     * @param mixed $service_container
     */
    public function setServiceContainer($service_container)
    {
        $this->service_container = $service_container;
    }

    /**
     * @return mixed
     */
    public function getServiceContainer()
    {
        return $this->service_container;
    }

    /**
     * @param mixed $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }


}