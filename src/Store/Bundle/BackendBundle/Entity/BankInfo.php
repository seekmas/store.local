<?php

namespace Store\Bundle\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BankInfo
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class BankInfo
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
     * @ORM\Column(name="account", type="string", length=255)
     */
    private $account;

    /**
     * @var string
     *
     * @ORM\Column(name="bankname", type="string", length=255)
     */
    private $bankname;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


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
     * Set account
     *
     * @param string $account
     * @return BankInfo
     */
    public function setAccount($account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return string 
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param string $bankname
     */
    public function setBankname($bankname)
    {
        $this->bankname = $bankname;
    }

    /**
     * @return string
     */
    public function getBankname()
    {
        return $this->bankname;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return BankInfo
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
}
