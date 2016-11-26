<?php

namespace TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Etats
 *
 * @ORM\Table(name="etats")
 * @ORM\Entity
 */
class Etats {
	/**
	 *
	 * @var string 
	 * 		@ORM\Column(name="libelle", type="string", length=20, nullable=false)
	 *      @Assert\NotBlank()
	 *      @Assert\NotNull()
	 *      @Assert\Type(type="string",message="The value {{ value }} is not a valid {{ type }}.")
	 *      @Assert\Length(min = 3,max = 20,minMessage = "Your first name must be at least {{ limit }} characters long", maxMessage = "Your first name cannot be longer than {{ limit }} characters" )
	 */
	private $libelle;
	
	/**
	 *
	 * @var integer 
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @Assert\NotNull()
	 * @Assert\Type(type="integer",message="The value {{ value }} is not a valid {{ type }}.")
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	
	/**
	 * Set libelle
	 *
	 * @param string $libelle        	
	 *
	 * @return Etats
	 */
	public function setLibelle($libelle) {
		$this->libelle = $libelle;
		
		return $this;
	}
	
	/**
	 * Get libelle
	 *
	 * @return string
	 */
	public function getLibelle() {
		return $this->libelle;
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
	 * toString
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->getLibelle ();
	}
}
