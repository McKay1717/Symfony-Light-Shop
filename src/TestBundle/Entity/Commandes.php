<?php

namespace TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Commandes
 *
 * @ORM\Table(name="commandes", indexes={@ORM\Index(name="fk_commandes_users", columns={"user_id"}), @ORM\Index(name="fk_commandes_etats", columns={"etat_id"})})
 * @ORM\Entity
 */
class Commandes {
	
	/**
	 * @ORM\OneToMany(targetEntity="TestBundle\Entity\Paniers", mappedBy="commande")
	 */
	private $paniers;
	/**
	 *
	 * @var float @ORM\Column(name="prix", type="float", precision=6, scale=2, nullable=false)
	 *      @Assert\Type(type="float",message="The value {{ value }} is not a valid {{ type }}.")
	 */
	private $prix;
	
	/**
	 *
	 * @var \DateTime @ORM\Column(name="date_achat", type="datetime", nullable=false)
	 *      @Assert\DateTime()
	 */
	private $dateAchat = 'CURRENT_TIMESTAMP';
	
	/**
	 *
	 * @var integer @ORM\Column(name="id", type="integer")
	 *      @ORM\Id
	 *      @ORM\GeneratedValue(strategy="IDENTITY")
	 *      @Assert\Type(type="integer",message="The value {{ value }} is not a valid {{ type }}.")
	 */
	private $id;
	
	/**
	 *
	 * @var \TestBundle\Entity\Etats @Assert\Valid()
	 *      @ORM\ManyToOne(targetEntity="TestBundle\Entity\Etats")
	 *      @ORM\JoinColumns({
	 *      @ORM\JoinColumn(name="etat_id", referencedColumnName="id")
	 *      })
	 */
	private $etat;
	
	/**
	 *
	 * @var \TestBundle\Entity\Users @Assert\Valid()
	 *      @ORM\ManyToOne(targetEntity="TestBundle\Entity\Users")
	 *      @ORM\JoinColumns({
	 *      @ORM\JoinColumn(name="user_id", referencedColumnName="id")
	 *      })
	 */
	private $user;
	
	public function __construct() {
		$this->paniers = new ArrayCollection();
	}
	
	/**
	 * Get paniers
	 *
	 * 
	 */
	public function getPaniers() {
		return $this->paniers;
	}
	/**
	 * Set prix
	 *
	 * @param float $prix        	
	 *
	 * @return Commandes
	 */
	public function setPrix($prix) {
		$this->prix = $prix;
		
		return $this;
	}
	
	/**
	 * Get prix
	 *
	 * @return float
	 */
	public function getPrix() {
		return $this->prix;
	}
	
	/**
	 * Set dateAchat
	 *
	 * @param \DateTime $dateAchat        	
	 *
	 * @return Commandes
	 */
	public function setDateAchat($dateAchat) {
		$this->dateAchat = $dateAchat;
		
		return $this;
	}
	
	/**
	 * Get dateAchat
	 *
	 * @return \DateTime
	 */
	public function getDateAchat() {
		return $this->dateAchat;
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
	 * Set etat
	 *
	 * @param \TestBundle\Entity\Etats $etat        	
	 *
	 * @return Commandes
	 */
	public function setEtat(\TestBundle\Entity\Etats $etat = null) {
		$this->etat = $etat;
		
		return $this;
	}
	
	/**
	 * Get etat
	 *
	 * @return \TestBundle\Entity\Etats
	 */
	public function getEtat() {
		return $this->etat;
	}
	
	/**
	 * Set user
	 *
	 * @param \TestBundle\Entity\Users $user        	
	 *
	 * @return Commandes
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
	 * toString
	 * 
	 * @return string
	 */
	public function __toString() {
		$string = "Commande n°";
		$string .= $this->getId ();
		$string .= " de ";
		$string .= $this->getUser()->__toString();
    	return $string;
    }
    
}
