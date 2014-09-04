<?php

namespace Store\Bundle\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Photo
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Photo
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
     * @ORM\ManyToOne(targetEntity="ProductBasket" , inversedBy="photo")
     * @ORM\JoinColumn(name="productBasket_id" , referencedColumnName="id")
     */
    private $productBasket;

    /**
     * @var integer
     *
     * @ORM\Column(name="productBasket_id", type="integer")
     */
    private $productBasketId;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255)
     */
    private $photo;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_enabled", type="boolean" , nullable=true)
     */
    private $isEnabled;

    /**
     * @ORM\Column(name="created_at" , type="datetime")
     */
    private $createdAt;


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
     * @return Photo
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
     * Set photo
     *
     * @param string $photo
     * @return Photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string 
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set isEnabled
     *
     * @param boolean $isEnabled
     * @return Photo
     */
    public function setIsEnabled($isEnabled)
    {
        $this->isEnabled = $isEnabled;

        return $this;
    }

    /**
     * Get isEnabled
     *
     * @return boolean 
     */
    public function getIsEnabled()
    {
        return $this->isEnabled;
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

}
