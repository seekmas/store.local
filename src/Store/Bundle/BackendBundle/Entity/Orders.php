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

    /**
     * @ORM\Column(name="order_id" , type="string" , length=255)
     */
    private $orderId;

    /**
     * @ORM\ManyToOne(targetEntity="User" , inversedBy="orders")
     * @ORM\JoinColumn(name="user_id" , referencedColumnName="id")
     */
    private $user;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @ORM\ManyToOne(targetEntity="Cart" , inversedBy="orders")
     * @ORM\JoinColumn(name="cart_id" , referencedColumnName="id")
     */
    private $cart;

    /**
     * @var integer
     *
     * @ORM\Column(name="cart_id", type="integer")
     */
    private $cartId;

    /**
     * @var string
     *
     * @ORM\Column(name="total_cost", type="decimal" , precision=10 , scale=2 )
     */
    private $totalCost;

    /**
     * @ORM\ManyToOne(targetEntity="Shipment" , inversedBy="orders")
     * @ORM\JoinColumn(name="shipment_id" , referencedColumnName="id")
     */
    private $shipment;

    /**
     * @var integer
     *
     * @ORM\Column(name="shipment_id", type="integer" , nullable=true)
     */
    private $shipmentId;

    /**
     * @ORM\Column(name="trackingNumber" , type="string" , length=255 , nullable=true)
     */
    private $trackingNumber;

    /**
     * @ORM\ManyToOne(targetEntity="Address" , inversedBy="orders")
     * @ORM\JoinColumn(name="address_id" , referencedColumnName="id")
     */
    private $address;

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
     * @param mixed $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
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
     * Set totalCost
     *
     * @param string $totalCost
     * @return Orders
     */
    public function setTotalCost($totalCost)
    {
        $this->totalCost = $totalCost;

        return $this;
    }

    /**
     * Get totalCost
     *
     * @return string 
     */
    public function getTotalCost()
    {
        return $this->totalCost;
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
     * @param mixed $trackingNumber
     */
    public function setTrackingNumber($trackingNumber)
    {
        $this->trackingNumber = $trackingNumber;
    }

    /**
     * @return mixed
     */
    public function getTrackingNumber()
    {
        return $this->trackingNumber;
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
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $cart
     */
    public function setCart($cart)
    {
        $this->cart = $cart;
    }

    /**
     * @return mixed
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @param string $isLocked
     */
    public function setIsLocked($isLocked)
    {
        $this->isLocked = $isLocked;
    }

    /**
     * @return string
     */
    public function getIsLocked()
    {
        return $this->isLocked;
    }

    /**
     * @param mixed $shipment
     */
    public function setShipment($shipment)
    {
        $this->shipment = $shipment;
    }

    /**
     * @return mixed
     */
    public function getShipment()
    {
        return $this->shipment;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }


}
