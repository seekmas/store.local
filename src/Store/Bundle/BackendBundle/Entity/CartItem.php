<?php

namespace Store\Bundle\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CartItem
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class CartItem
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
     * @ORM\ManyToOne(targetEntity="ProductBasket" , inversedBy="cartItem")
     * @ORM\JoinColumn(name="productBasketId" , referencedColumnName="id")
     */
    private $productBasket;

    /**
     * @var integer
     *
     * @ORM\Column(name="productBasket_id", type="integer")
     */
    private $productBasketId;

    /**
     * @ORM\ManyToOne(targetEntity="Cart" , inversedBy="cartItem")
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
     * @var integer
     *
     * @ORM\Column(name="sum", type="integer")
     */
    private $sum;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="removed_at", type="datetime")
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
     * Set productBasketId
     *
     * @param integer $productBasketId
     * @return CartItem
     */
    public function setProductBasketId($productBasketId)
    {
        $this->productBasketId = $productBasketId;

        return $this;
    }

    /**
     * Get productBasketId
     *
     * @return integer 
     */
    public function getProductBasketId()
    {
        return $this->productBasketId;
    }

    /**
     * Set cartId
     *
     * @param integer $cartId
     * @return CartItem
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
     * Set sum
     *
     * @param integer $sum
     * @return CartItem
     */
    public function setSum($sum)
    {
        $this->sum = $sum;

        return $this;
    }

    /**
     * Get sum
     *
     * @return integer 
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return CartItem
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
     * Set removedAt
     *
     * @param \DateTime $removedAt
     * @return CartItem
     */
    public function setRemovedAt($removedAt)
    {
        $this->removedAt = $removedAt;

        return $this;
    }

    /**
     * Get removedAt
     *
     * @return \DateTime 
     */
    public function getRemovedAt()
    {
        return $this->removedAt;
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
     * @param mixed $productBasket
     */
    public function setProductBasket($productBasket)
    {
        $this->productBasket = $productBasket;
    }

    /**
     * @return mixed
     */
    public function getProductBasket()
    {
        return $this->productBasket;
    }


}
