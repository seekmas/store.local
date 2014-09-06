<?php

namespace Store\Bundle\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Shipment
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Shipment
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
     * @ORM\ManyToOne(targetEntity="Store" , inversedBy="shipment")
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
     * @var string
     *
     * @ORM\Column(name="shipment_name", type="string", length=255)
     */
    private $shipmentName;

    /**
     * @var string
     *
     * @ORM\Column(name="shipment_price" , type="decimal" , precision=10 , scale=2 )
     */
    private $shipmentPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="shipment_description", type="text")
     */
    private $shipmentDescription;

    /**
     * @ORM\Column(name="created_at" , type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(name="removed_at" , type="datetime" , nullable=true)
     */
    private $removedAt;


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
     * @return Shipment
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
     * Set shipmentName
     *
     * @param string $shipmentName
     * @return Shipment
     */
    public function setShipmentName($shipmentName)
    {
        $this->shipmentName = $shipmentName;

        return $this;
    }

    /**
     * Get shipmentName
     *
     * @return string 
     */
    public function getShipmentName()
    {
        return $this->shipmentName;
    }

    /**
     * Set shipmentPrice
     *
     * @param string $shipmentPrice
     * @return Shipment
     */
    public function setShipmentPrice($shipmentPrice)
    {
        $this->shipmentPrice = $shipmentPrice;

        return $this;
    }

    /**
     * Get shipmentPrice
     *
     * @return string 
     */
    public function getShipmentPrice()
    {
        return $this->shipmentPrice;
    }

    /**
     * Set shipmentDescription
     *
     * @param string $shipmentDescription
     * @return Shipment
     */
    public function setShipmentDescription($shipmentDescription)
    {
        $this->shipmentDescription = $shipmentDescription;

        return $this;
    }

    /**
     * Get shipmentDescription
     *
     * @return string 
     */
    public function getShipmentDescription()
    {
        return $this->shipmentDescription;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $removedAt
     */
    public function setRemovedAt($removedAt)
    {
        $this->removedAt = $removedAt;
    }

    /**
     * @return mixed
     */
    public function getRemovedAt()
    {
        return $this->removedAt;
    }

}
