<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProfilLivreur
 *
 * @ORM\Table(name="profil livreur")
 * @ORM\Entity
 */
class ProfilLivreur
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_livreur", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idLivreur;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_livreur", type="string", length=255, nullable=false)
     */
    private $nomLivreur;

    /**
     * @var string
     *
     * @ORM\Column(name="secteur", type="string", length=255, nullable=false)
     */
    private $secteur;

    /**
     * @var string
     *
     * @ORM\Column(name="moy_livraison", type="string", length=255, nullable=false)
     */
    private $moyLivraison;

    /**
     * @var string
     *
     * @ORM\Column(name="volume", type="string", length=255, nullable=false)
     */
    private $volume;

    public function getIdLivreur(): ?int
    {
        return $this->idLivreur;
    }

    public function getNomLivreur(): ?string
    {
        return $this->nomLivreur;
    }

    public function setNomLivreur(string $nomLivreur): self
    {
        $this->nomLivreur = $nomLivreur;

        return $this;
    }

    public function getSecteur(): ?string
    {
        return $this->secteur;
    }

    public function setSecteur(string $secteur): self
    {
        $this->secteur = $secteur;

        return $this;
    }

    public function getMoyLivraison(): ?string
    {
        return $this->moyLivraison;
    }

    public function setMoyLivraison(string $moyLivraison): self
    {
        $this->moyLivraison = $moyLivraison;

        return $this;
    }

    public function getVolume(): ?string
    {
        return $this->volume;
    }

    public function setVolume(string $volume): self
    {
        $this->volume = $volume;

        return $this;
    }


}
