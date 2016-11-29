<?php

namespace TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity
 * @UniqueEntity("email")
 */
class Users implements UserInterface, \Serializable {
	/**
	 *
	 * @var string @ORM\Column(name="email", type="string", length=255, nullable=false)
	 *      @Assert\Email()
	 */
	private $email;
	
	/**
	 *
	 * @var string @ORM\Column(name="password", type="string", length=255, nullable=false)
	 *     @Assert\NotBlank()
	 */
	private $password;
	
	/**
	 *
	 * @var string @ORM\Column(name="login", type="string", length=255, nullable=false)
	 */
	private $login;
	
	/**
	 *
	 * @var string @ORM\Column(name="nom", type="string", length=255, nullable=false)
	 */
	private $nom;
	
	/**
	 *
	 * @var string @ORM\Column(name="code_postal", type="string", length=255, nullable=false)
	 */
	private $codePostal;
	
	/**
	 *
	 * @var string @ORM\Column(name="ville", type="string", length=255, nullable=false)
	 */
	private $ville;
	
	/**
	 *
	 * @var string @ORM\Column(name="adresse", type="string", length=255, nullable=false)
	 */
	private $adresse;
	
	/**
	 *
	 * @var boolean @ORM\Column(name="valide", type="boolean", nullable=false)
	 */
	private $valide;
	
	/**
	 *
	 * @var string @ORM\Column(name="droit", type="string", length=255, nullable=false)
	 */
	private $droit;
	
	/**
	 *
	 * @var integer @ORM\Column(name="id", type="integer")
	 *      @ORM\Id
	 *      @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	
	/**
	 * Set email
	 *
	 * @param string $email        	
	 *
	 * @return Users
	 */
	public function setEmail($email) {
		$this->email = $email;
		
		return $this;
	}
	
	/**
	 * Get email
	 *
	 * @return string
	 */
	public function getEmail() {
		return $this->email;
	}
	
	/**
	 * Set password
	 *
	 * @param string $password        	
	 *
	 * @return Users
	 */
	public function setPassword($password) {
		$this->password = $password;
		
		return $this;
	}
	
	/**
	 * Get password
	 *
	 * @return string
	 */
	public function getPassword() {
		return $this->password;
	}
	
	/**
	 * Set login
	 *
	 * @param string $login        	
	 *
	 * @return Users
	 */
	public function setLogin($login) {
		$this->login = $login;
		
		return $this;
	}
	
	/**
	 * Get login
	 *
	 * @return string
	 */
	public function getLogin() {
		return $this->login;
	}
	
	/**
	 * Set nom
	 *
	 * @param string $nom        	
	 *
	 * @return Users
	 */
	public function setNom($nom) {
		$this->nom = $nom;
		
		return $this;
	}
	
	/**
	 * Get nom
	 *
	 * @return string
	 */
	public function getNom() {
		return $this->nom;
	}
	
	/**
	 * Set codePostal
	 *
	 * @param string $codePostal        	
	 *
	 * @return Users
	 */
	public function setCodePostal($codePostal) {
		$this->codePostal = $codePostal;
		
		return $this;
	}
	
	/**
	 * Get codePostal
	 *
	 * @return string
	 */
	public function getCodePostal() {
		return $this->codePostal;
	}
	
	/**
	 * Set ville
	 *
	 * @param string $ville        	
	 *
	 * @return Users
	 */
	public function setVille($ville) {
		$this->ville = $ville;
		
		return $this;
	}
	
	/**
	 * Get ville
	 *
	 * @return string
	 */
	public function getVille() {
		return $this->ville;
	}
	
	/**
	 * Set adresse
	 *
	 * @param string $adresse        	
	 *
	 * @return Users
	 */
	public function setAdresse($adresse) {
		$this->adresse = $adresse;
		
		return $this;
	}
	
	/**
	 * Get adresse
	 *
	 * @return string
	 */
	public function getAdresse() {
		return $this->adresse;
	}
	
	/**
	 * Set valide
	 *
	 * @param boolean $valide        	
	 *
	 * @return Users
	 */
	public function setValide($valide) {
		$this->valide = $valide;
		
		return $this;
	}
	
	/**
	 * Get valide
	 *
	 * @return boolean
	 */
	public function getValide() {
		return $this->valide;
	}
	
	/**
	 * Set droit
	 *
	 * @param string $droit        	
	 *
	 * @return Users
	 */
	public function setDroit($droit) {
		$this->droit = $droit;
		
		return $this;
	}
	
	/**
	 * Get droit
	 *
	 * @return string
	 */
	public function getDroit() {
		return $this->droit;
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
		return $this->getEmail ();
	}
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \Symfony\Component\Security\Core\User\UserInterface::getRoles()
	 */
	public function getRoles() {
		return explode ( ',', $this->droit );
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \Symfony\Component\Security\Core\User\UserInterface::getSalt()
	 */
	public function getSalt() {
		return null;
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \Symfony\Component\Security\Core\User\UserInterface::getUsername()
	 */
	public function getUsername() {
		return $this->getLogin();
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \Symfony\Component\Security\Core\User\UserInterface::eraseCredentials()
	 */
	public function eraseCredentials() {
		$this->setPassword(null);
		
	}
	/**
	 *
	 * @see \Serializable::serialize()
	 */
	public function serialize() {
		return serialize ( array (
				$this->id,
				$this->login,
				$this->password 
		)
		// see section on salt below
		// $this->salt,
		 );
	}
	
	/**
	 *
	 * @see \Serializable::unserialize()
	 */
	public function unserialize($serialized) {
		list ( $this->id, $this->login, $this->password, )
		// see section on salt below
		// $this->salt
		 = unserialize ( $serialized );
	}
}
