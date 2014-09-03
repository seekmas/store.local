<?php

namespace Store\Bundle\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * product
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Product
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
     * @var string
     *
     * @ORM\Column(name="product_name", type="string", length=255)
     */
    private $productName;

    /**
     * @var string
     *
     * @ORM\Column(name="product_alias", type="string", length=255 , nullable=true )
     */
    private $productAlias;

    /**
     * @var string
     *
     * @ORM\Column(name="product_desc", type="text")
     */
    private $productDesc;

    /**
     * @var string
     *
     * @ORM\Column(name="product_price", type="decimal" , precision=10 , scale=2 )
     */
    private $productPrice;

    /**
     * @ORM\Column(name="photo" , type="string" , length=255 , nullable=true )
     */
    private $photo;

    /**
     *
     * @ORM\OneToOne(targetEntity="ProductBasket" , mappedBy="product")
     */
    private $productBasket;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_available", type="boolean" , nullable=true )
     */
    private $isAvailable;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime" , nullable=true )
     */
    private $updatedAt;


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
     * Set productName
     *
     * @param string $productName
     * @return Product
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;

        return $this;
    }

    /**
     * Get productName
     *
     * @return string 
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * Set productAlias
     *
     * @param string $productAlias
     * @return Product
     */
    public function setProductAlias($productAlias)
    {
        $this->productAlias = $productAlias;

        return $this;
    }

    /**
     * Get productAlias
     *
     * @return string 
     */
    public function getProductAlias()
    {
        return $this->productAlias;
    }

    /**
     * Set productDesc
     *
     * @param string $productDesc
     * @return Product
     */
    public function setProductDesc($productDesc)
    {
        $this->productDesc = $productDesc;

        return $this;
    }

    /**
     * Get productDesc
     *
     * @return string 
     */
    public function getProductDesc()
    {
        return $this->productDesc;
    }

    /**
     * Set productPrice
     *
     * @param string $productPrice
     * @return Product
     */
    public function setProductPrice($productPrice)
    {
        $this->productPrice = $productPrice;

        return $this;
    }

    /**
     * Get productPrice
     *
     * @return string 
     */
    public function getProductPrice()
    {
        return $this->productPrice;
    }

    /**
     * Set isAvailable
     *
     * @param boolean $isAvailable
     * @return Product
     */
    public function setIsAvailable($isAvailable)
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    /**
     * Get isAvailable
     *
     * @return boolean 
     */
    public function getIsAvailable()
    {
        return $this->isAvailable;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Product
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


    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Product
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
