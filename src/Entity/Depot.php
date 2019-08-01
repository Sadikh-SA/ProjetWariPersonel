<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\DepotRepository")
 */
class Depot
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDeDepot;

    /**
     * @ORM\Column(type="float")
     */
    private $montantDuDepot;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="depots")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idCompte;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="depots")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idCaissier;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDeDepot(): ?\DateTimeInterface
    {
        return $this->dateDeDepot;
    }

    public function setDateDeDepot(\DateTimeInterface $dateDeDepot): self
    {
        $this->dateDeDepot = $dateDeDepot;

        return $this;
    }

    public function getMontantDuDepot(): ?float
    {
        return $this->montantDuDepot;
    }

    public function setMontantDuDepot(float $montantDuDepot): self
    {
        $this->montantDuDepot = $montantDuDepot;

        return $this;
    }

    public function getIdCompte(): ?Compte
    {
        return $this->idCompte;
    }

    public function setIdCompte(?Compte $idCompte): self
    {
        $this->idCompte = $idCompte;

        return $this;
    }

    public function getIdCaissier(): ?Utilisateur
    {
        return $this->idCaissier;
    }

    public function setIdCaissier(?Utilisateur $idCaissier): self
    {
        $this->idCaissier = $idCaissier;

        return $this;
    }
}
