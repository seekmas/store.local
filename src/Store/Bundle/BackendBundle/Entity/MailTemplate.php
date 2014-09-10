<?php

namespace Store\Bundle\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MailTemplate
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class MailTemplate
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
     * @ORM\Column(name="mail_title", type="string", length=255)
     */
    private $mailTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="mail_content", type="text")
     */
    private $mailContent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_sent", type="boolean")
     */
    private $isSent;

    /**
     * @var string
     *
     * @ORM\Column(name="from_email", type="string", length=255)
     */
    private $fromEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="from_name", type="string", length=255)
     */
    private $fromName;

    /**
     * @ORM\Column(name="removed_at" , type="datetime" , nullable=true)
     */
    private $removedAt;

    /**
     * @ORM\ManyToOne(targetEntity="Store" , inversedBy="mailTemplate")
     * @ORM\JoinColumn(name="store_id" , referencedColumnName="id")
     */
    private $store;

    /**
     * @ORM\COlumn(name="store_id" , type="integer")
     */
    private $storeId;

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
     * Set mailTitle
     *
     * @param string $mailTitle
     * @return MailTemplate
     */
    public function setMailTitle($mailTitle)
    {
        $this->mailTitle = $mailTitle;

        return $this;
    }

    /**
     * Get mailTitle
     *
     * @return string 
     */
    public function getMailTitle()
    {
        return $this->mailTitle;
    }

    /**
     * Set mailContent
     *
     * @param string $mailContent
     * @return MailTemplate
     */
    public function setMailContent($mailContent)
    {
        $this->mailContent = $mailContent;

        return $this;
    }

    /**
     * Get mailContent
     *
     * @return string 
     */
    public function getMailContent()
    {
        return $this->mailContent;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return MailTemplate
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
     * Set isSent
     *
     * @param boolean $isSent
     * @return MailTemplate
     */
    public function setIsSent($isSent)
    {
        $this->isSent = $isSent;

        return $this;
    }

    /**
     * Get isSent
     *
     * @return boolean 
     */
    public function getIsSent()
    {
        return $this->isSent;
    }

    /**
     * Set fromEmail
     *
     * @param string $fromEmail
     * @return MailTemplate
     */
    public function setFromEmail($fromEmail)
    {
        $this->fromEmail = $fromEmail;

        return $this;
    }

    /**
     * Get fromEmail
     *
     * @return string 
     */
    public function getFromEmail()
    {
        return $this->fromEmail;
    }

    /**
     * Set fromName
     *
     * @param string $fromName
     * @return MailTemplate
     */
    public function setFromName($fromName)
    {
        $this->fromName = $fromName;

        return $this;
    }

    /**
     * Get fromName
     *
     * @return string 
     */
    public function getFromName()
    {
        return $this->fromName;
    }

    /**
     * @param mixed $removedAt
     * @return MailTemplate
     */
    public function setRemovedAt($removedAt)
    {
        $this->removedAt = $removedAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRemovedAt()
    {
        return $this->removedAt;
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
     * @param mixed $storeId
     */
    public function setStoreId($storeId)
    {
        $this->storeId = $storeId;
    }

    /**
     * @return mixed
     */
    public function getStoreId()
    {
        return $this->storeId;
    }


}
