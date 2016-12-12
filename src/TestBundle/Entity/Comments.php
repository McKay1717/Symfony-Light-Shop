<?php

namespace TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comments
 *
 * @ORM\Table(name="comments", indexes={@ORM\Index(name="fk_user_id", columns={"user_id"}), @ORM\Index(name="fk_product_id", columns={"product_id"})})
 * @ORM\Entity
 */
class Comments
{
    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=255, nullable=false)
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \TestBundle\Entity\Produits
     *
     * @ORM\ManyToOne(targetEntity="TestBundle\Entity\Produits")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $product;

    /**
     * @var \TestBundle\Entity\Users
     *
     * @ORM\ManyToOne(targetEntity="TestBundle\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;
    
    function __construct()
    {
    	$this->date = new \DateTime();
    }
    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
    	return $this->id;
    }
    /**
     * Set produit
     *
     * @param \TestBundle\Entity\Produits $produit
     *
     * @return Paniers
     */
    public function setProduct(\TestBundle\Entity\Produits $produit = null) {
    	$this->product = $produit;
    
    	return $this;
    }
    
    /**
     * Get produit
     *
     * @return \TestBundle\Entity\Produits
     */
    public function getProduct() {
    	return $this->product;
    }
    /**
     * Set user
     *
     * @param \TestBundle\Entity\Users $user
     *
     * @return Paniers
     */
    public function setUser(\TestBundle\Entity\Users $user = null) {
    	$this->user = $user;
    
    	return $this;
    }
    
    /**
     * Get user
     *
     * @return \TestBundle\Entity\Users
     */
    public function getUser() {
    	return $this->user;
    }
    
    /**
     * Set content
     *
     * @param string $ct
     *
     * @return Comments
     */
    public function setContent(string $ct) {
    	$this->content = $ct;
    
    	return $this;
    }
    
    /**
     * Get content
     *
     * @return string
     */
    public function getContent() {
    	return $this->content;
    }

    /**
     * Set dateAchat
     *
     * @param \DateTime $date
     *
     * @return Comments
     */
    public function setDate($date) {
    	$this->date = $date;
    
    	return $this;
    }
    
    /**
     * Get dateAchat
     *
     * @return \DateTime
     */
    public function getDate() {
    	return $this->date;
    }
}

