<?php

namespace Store\Bundle\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Orders
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Orders
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    private $user;
    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @var integer
     *
     * @ORM\Column(name="cart_id", type="integer")
     */
    private $cartId;

    /**
     * @var string
     *
     * @ORM\Column(name="totoal_cost", type="decimal")
     */
    private $totoalCost;

    /**
     * @var integer
     *
     * @ORM\Column(name="shipment_id", type="integer")
     */
    private $shipmentId;

    /**
     * @var integer
     *
     * @ORM\Column(name="address_id", type="integer")
     */
    private $addressId;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="payment_status", type="integer")
     */
    private $paymentStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="alipay_params", type="text" , nullable=true)
     */
    private $alipayParams;

    /**
     * @var string
     *
     * @ORM\Column(name="locked", type="boolean" , nullable=true)
     */
    private $isLocked;


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
     * Set userId
     *
     * @param integer $userId
     * @return Orders
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set cartId
     *
     * @param integer $cartId
     * @return Orders
     */
    public function setCartId($cartId)
    {
        $this->cartId = $cartId;

        return $this;
    }

    /**
     * Get cartId
     *
     * @return integer 
     */
    public function getCartId()
    {
        return $this->cartId;
    }

    /**
     * Set totoalCost
     *
     * @param string $totoalCost
     * @return Orders
     */
    public function setTotoalCost($totoalCost)
    {
        $this->totoalCost = $totoalCost;

        return $this;
    }

    /**
     * Get totoalCost
     *
     * @return string 
     */
    public function getTotoalCost()
    {
        return $this->totoalCost;
    }

    /**
     * Set shipmentId
     *
     * @param integer $shipmentId
     * @return Orders
     */
    public function setShipmentId($shipmentId)
    {
        $this->shipmentId = $shipmentId;

        return $this;
    }

    /**
     * Get shipmentId
     *
     * @return integer 
     */
    public function getShipmentId()
    {
        return $this->shipmentId;
    }

    /**
     * Set addressId
     *
     * @param integer $addressId
     * @return Orders
     */
    public function setAddressId($addressId)
    {
        $this->addressId = $addressId;

        return $this;
    }

    /**
     * Get addressId
     *
     * @return integer 
     */
    public function getAddressId()
    {
        return $this->addressId;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Orders
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Orders
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set paymentStatus
     *
     * @param integer $paymentStatus
     * @return Orders
     */
    public function setPaymentStatus($paymentStatus)
    {
        $this->paymentStatus = $paymentStatus;

        return $this;
    }

    /**
     * Get paymentStatus
     *
     * @return integer 
     */
    public function getPaymentStatus()
    {
        return $this->paymentStatus;
    }

    /**
     * Set alipayParams
     *
     * @param string $alipayParams
     * @return Orders
     */
    public function setAlipayParams($alipayParams)
    {
        $this->alipayParams = $alipayParams;

        return $this;
    }

    /**
     * Get alipayParams
     *
     * @return string 
     */
    public function getAlipayParams()
    {
        return $this->alipayParams;
    }

    /**
     * Set locked
     *
     * @param string $locked
     * @return Orders
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }

    /**
     * Get locked
     *
     * @return string 
     */
    public function getLocked()
    {
        return $this->locked;
    }
}
