<?php

namespace Store\Bundle\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductBasket
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ProductBasket
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
     * @ORM\OneToOne(targetEntity="Product" , inversedBy="productBasket")
     * @ORM\JoinColumn(name="product_id" , referencedColumnName="id")
     */
    private $product;

    /**
     * @var integer
     *
     * @ORM\Column(name="product_id", type="integer")
     */
    private $productId;

    /**
     * @ORM\ManyToOne(targetEntity="Store" , inversedBy="productBasket")
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
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="removed_at", type="datetime" , nullable=true )
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
     * Set productId
     *
     * @param integer $productId
     * @return ProductBasket
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * Get productId
     *
     * @return integer 
     */
    public function getProductId()
    {
        return $this->productId;
    }


    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return ProductBasket
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
     * @return ProductBasket
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
     * @param mixed $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
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
     * @param int $storeId
     */
    public function setStoreId($storeId)
    {
        $this->storeId = $storeId;
    }

    /**
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

}
