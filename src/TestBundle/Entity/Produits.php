<?php

namespace TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Produits
 *
 * @ORM\Table(name="produits", indexes={@ORM\Index(name="fk_produits_typeProduits", columns={"typeProduit_id"})})
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Produits
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=50, nullable=true)
     * 	     @Assert\NotBlank()
	 *      @Assert\NotNull()
	 *      @Assert\Length(min = 3,max = 50,minMessage = "Your first name must be at least {{ limit }} characters long", maxMessage = "Your first name cannot be longer than {{ limit }} characters" )
	 */
    
    private $nom;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=6, scale=2, nullable=true)
     */
    private $prix;
    
    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="imageName")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=50, nullable=true)
     */
    private $photo;
    
    

    /**
     * @var boolean
     *
     * @ORM\Column(name="dispo", type="boolean", nullable=false)
     * @Assert\Type(type="bool",message="The value {{ value }} is not a valid {{ type }}.")
     */
    private $dispo;

    /**
     * @var integer
     *
     * @ORM\Column(name="stock", type="integer", nullable=false)
     */
    private $stock;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \TestBundle\Entity\Typeproduits
     * @Assert\Valid()
     * @ORM\ManyToOne(targetEntity="TestBundle\Entity\Typeproduits")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="typeProduit_id", referencedColumnName="id")
     * })
     */
    private $typeproduit;



    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Produits
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prix
     *
     * @param float $prix
     *
     * @return Produits
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return Produits
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
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return Product
     */
    public function setImageFile(File $image = null)
    {
    	$this->imageFile = $image;
    
    	if ($image) {
    		// It is required that at least one field changes if you are using doctrine
    		// otherwise the event listeners won't be called and the file is lost
    		$this->updatedAt = new \DateTime('now');
    	}
    
    	return $this;
    }
    
    /**
     * @return File|null
     */
    public function getImageFile()
    {
    	return $this->imageFile;
    }

    /**
     * Set dispo
     *
     * @param boolean $dispo
     *
     * @return Produits
     */
    public function setDispo($dispo)
    {
        $this->dispo = $dispo;

        return $this;
    }

    /**
     * Get dispo
     *
     * @return boolean
     */
    public function getDispo()
    {
        return $this->dispo;
    }

    /**
     * Set stock
     *
     * @param integer $stock
     *
     * @return Produits
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return integer
     */
    public function getStock()
    {
        return $this->stock;
    }

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
     * Set typeproduit
     *
     * @param \TestBundle\Entity\Typeproduits $typeproduit
     *
     * @return Produits
     */
    public function setTypeproduit(\TestBundle\Entity\Typeproduits $typeproduit = null)
    {
        $this->typeproduit = $typeproduit;

        return $this;
    }

    /**
     * Get typeproduit
     *
     * @return \TestBundle\Entity\Typeproduits
     */
    public function getTypeproduit()
    {
        return $this->typeproduit;
    }
    /**
     * toString
     * @return string
     */
    public function __toString()
    {
    	return $this->getNom();
    }
    public function getImageName()
    {
    	return $this->getPhoto();
    }
    public function setImageName($img)
    {
    	return $this->setPhoto($img);
    }
    
}
