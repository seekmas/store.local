<?php

namespace Store\Bundle\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Alipay
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Alipay
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="account" , type="string" , length=255)
     */
    private $account;

    /**
     * @var integer
     *
     * @ORM\Column(name="partner_id", type="string" , length=255)
     */
    private $partnerId;

    /**
     * @var string
     *
     * @ORM\Column(name="partner_key", type="string", length=255)
     */
    private $partnerKey;

    /**
     * @ORM\ManyToOne(targetEntity="Store" , inversedBy="alipay")
     * @ORM\JoinColumn(name="store_id" , referencedColumnName="id")
     */
    private $store;

    /**
     * @var integer
     *
     * @ORM\Column(name="store_id", type="integer")
     */
    private $storeId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_default", type="boolean" , nullable=true)
     */
    private $isDefault;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $account
     */
    public function setAccount($account)
    {
        $this->account = $account;
    }

    /**
     * @return mixed
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set partnerId
     *
     * @param integer $partnerId
     * @return Alipay
     */
    public function setPartnerId($partnerId)
    {
        $this->partnerId = $partnerId;

        return $this;
    }

    /**
     * Get partnerId
     *
     * @return integer 
     */
    public function getPartnerId()
    {
        return $this->partnerId;
    }

    /**
     * Set partnerKey
     *
     * @param string $partnerKey
     * @return Alipay
     */
    public function setPartnerKey($partnerKey)
    {
        $this->partnerKey = $partnerKey;

        return $this;
    }

    /**
     * Get partnerKey
     *
     * @return string 
     */
    public function getPartnerKey()
    {
        return $this->partnerKey;
    }

    /**
     * @param mixed $store
     */
    public function setStore($store)
    {
        $this->store = $store;
    }

    /**
     * @return mixed
     */
    public function getStore()
    {
        return $this->store;
    }

    /**
     * Set storeId
     *
     * @param integer $storeId
     * @return Alipay
     */
    public function setStoreId($storeId)
    {
        $this->storeId = $storeId;

        return $this;
    }

    /**
     * Get storeId
     *
     * @return integer 
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

    /**
     * Set isDefault
     *
     * @param boolean $isDefault
     * @return Alipay
     */
    public function setIsDefault($isDefault)
    {
        $this->isDefault = $isDefault;

        return $this;
    }

    /**
     * Get isDefault
     *
     * @return boolean 
     */
    public function getIsDefault()
    {
        return $this->isDefault;
    }
}
