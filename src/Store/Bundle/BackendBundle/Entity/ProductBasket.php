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
     * @ORM\ManyToOne(targetEntity="Category" , inversedBy="productBasket")
     * @ORM\JoinColumn(name="category_id" , referencedColumnName="id")
     */
    private $category;

    /**
     * @ORM\Column(name="category_id" , type="integer" , nullable=true)
     */
    private $categoryId;

    /**
     * @ORM\OneToMany(targetEntity="Photo" , mappedBy="productBasket")
     */
    private $photo;
    /**
     * @ORM\ManyToMany(targetEntity="Tag" , mappedBy="productBasket")
     */
    private $tag;

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

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $categoryId
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    }

    /**
     * @return mixed
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    }

    /**
     * @return mixed
     */
    public function getTag()
    {
        return $this->tag;
    }
}
