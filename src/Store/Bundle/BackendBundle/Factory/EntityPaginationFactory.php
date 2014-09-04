<?php

namespace Store\Bundle\BackendBundle\Factory;

use Store\Bundle\BackendBundle\Exception\DoctrineQueryBuilderAliasException;

class EntityPaginationFactory
{
    protected $_paginator;
    protected $_repository;
    protected $_perPage;
    protected $_request;
    protected $_condition;
    protected $order_by = 'id';

    public function __construct( $request , $paginator , $repository , $perPage = 12)
    {
        $this->_request = $request;
        $this->_paginator = $paginator;
        $this->_repository = $repository;
        $this->_perPage = $perPage;
    }

    //generate a paginator
    public function createPagination()
    {
        $query = $this->getRepository()
             ->createQueryBuilder('p')
             ->select('p');

        $query = $this->parseWhere($query,'p',$this->getCondition())
                      ->orderBy('p.'.$this->getOrderBy() , 'desc');

        $paginator  = $this->getPaginator();
        $pagination = $paginator->paginate(
            $query,
            $this->_request->getCurrentRequest()->get('page', 1)/*page number*/,
            $this->getPerPage()
        );

        return $pagination;
    }

    protected function parseWhere( $query , $alias , array $array)
    {
        if( $alias == '')
            throw new DoctrineQueryBuilderAliasException();

        $count = 0;
        foreach( $array as $key => $value)
        {
            if( $count == 0)
            {
                $query->where($alias.'.'.$key .' = '. $value);
                $count++;
            }else
            {
                $query->AndWhere($alias.'.'.$key . ' = ' . $value);
            }
        }
        return $query;
    }

    /**
     * @param mixed $paginator
     * @return EntityPaginationFactory
     */
    public function setPaginator($paginator)
    {
        $this->_paginator = $paginator;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaginator()
    {
        return $this->_paginator;
    }

    /**
     * @param mixed $repository
     * @return EntityPaginationFactory
     */
    public function setRepository($repository)
    {
        $this->_repository = $repository;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRepository()
    {
        return $this->_repository;
    }

    /**
     * @param mixed $perPage
     * @return EntityPaginationFactory
     */
    public function setPerPage($perPage)
    {
        $this->_perPage = $perPage;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPerPage()
    {
        return $this->_perPage;
    }

    /**
     * @param mixed $order_by
     * @return EntityPaginationFactory
     */
    public function setOrderBy($order_by)
    {
        $this->order_by = $order_by;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderBy()
    {
        return $this->order_by;
    }

    /**
     * @param mixed $condition
     * @return EntityPaginationFactory
     */
    public function setCondition($condition)
    {
        $this->_condition = $condition;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCondition()
    {
        return $this->_condition;
    }


}