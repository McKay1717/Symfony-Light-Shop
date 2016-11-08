<?php

namespace TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Paniers
 *
 * @ORM\Table(name="paniers", indexes={@ORM\Index(name="fk_paniers_users", columns={"user_id"}), @ORM\Index(name="fk_paniers_produits", columns={"produit_id"}), @ORM\Index(name="fk_paniers_commandes", columns={"commande_id"})})
 * @ORM\Entity
 */
class Paniers
{
    /**
     * @var integer
     *
     * @ORM\Column(name="quantite", type="integer", nullable=false)
     */
    private $quantite;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=6, scale=2, nullable=false)
     */
    private $prix;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAjoutPanier", type="datetime", nullable=false)
     */
    private $dateajoutpanier = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \TestBundle\Entity\Commandes
     *
     * @ORM\ManyToOne(targetEntity="TestBundle\Entity\Commandes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="commande_id", referencedColumnName="id")
     * })
     */
    private $commande;

    /**
     * @var \TestBundle\Entity\Produits
     *
     * @ORM\ManyToOne(targetEntity="TestBundle\Entity\Produits")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="produit_id", referencedColumnName="id")
     * })
     */
    private $produit;

    /**
     * @var \TestBundle\Entity\Users
     *
     * @ORM\ManyToOne(targetEntity="TestBundle\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;



    /**
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return Paniers
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return integer
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set prix
     *
     * @param float $prix
     *
     * @return Paniers
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
     * Set dateajoutpanier
     *
     * @param \DateTime $dateajoutpanier
     *
     * @return Paniers
     */
    public function setDateajoutpanier($dateajoutpanier)
    {
        $this->dateajoutpanier = $dateajoutpanier;

        return $this;
    }

    /**
     * Get dateajoutpanier
     *
     * @return \DateTime
     */
    public function getDateajoutpanier()
    {
        return $this->dateajoutpanier;
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
     * Set commande
     *
     * @param \TestBundle\Entity\Commandes $commande
     *
     * @return Paniers
     */
    public function setCommande(\TestBundle\Entity\Commandes $commande = null)
    {
        $this->commande = $commande;

        return $this;
    }

    /**
     * Get commande
     *
     * @return \TestBundle\Entity\Commandes
     */
    public function getCommande()
    {
        return $this->commande;
    }

    /**
     * Set produit
     *
     * @param \TestBundle\Entity\Produits $produit
     *
     * @return Paniers
     */
    public function setProduit(\TestBundle\Entity\Produits $produit = null)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get produit
     *
     * @return \TestBundle\Entity\Produits
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * Set user
     *
     * @param \TestBundle\Entity\Users $user
     *
     * @return Paniers
     */
    public function setUser(\TestBundle\Entity\Users $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \TestBundle\Entity\Users
     */
    public function getUser()
    {
        return $this->user;
    }
}
