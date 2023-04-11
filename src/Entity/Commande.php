<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity
 */
class Commande
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_commande", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCommande;

    /**
     * @var int
     *
     * @ORM\Column(name="num_panier", type="integer", nullable=false)
     */
    private $numPanier;

    /**
     * @var string
     *
     * @ORM\Column(name="emetteur", type="string", length=255, nullable=false)
     */
    private $emetteur;

    /**
     * @var int
     *
     * @ORM\Column(name="depot", type="integer", nullable=false)
     */
    private $depot;

    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=255, nullable=false)
     */
    private $statut;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     */
    private $type;

    public function getIdCommande(): ?int
    {
        return $this->idCommande;
    }

    public function getNumPanier(): ?int
    {
        return $this->numPanier;
    }

    public function setNumPanier(int $numPanier): self
    {
        $this->numPanier = $numPanier;

        return $this;
    }

    public function getEmetteur(): ?string
    {
        return $this->emetteur;
    }

    public function setEmetteur(string $emetteur): self
    {
        $this->emetteur = $emetteur;

        return $this;
    }

    public function getDepot(): ?int
    {
        return $this->depot;
    }

    public function setDepot(int $depot): self
    {
        $this->depot = $depot;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
    public function __toString()
    {
        return $this->idCommande; // assuming that the id property is a string or can be cast to a string
    }


}
