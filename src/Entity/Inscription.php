<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Attache::class, inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private $attache;

    #[ORM\ManyToOne(targetEntity: Etudiant::class, inversedBy: 'inscriptions', cascade :["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    private $etudiant;

    #[ORM\ManyToOne(targetEntity: Classe::class, inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private $classe;

    #[ORM\ManyToOne(targetEntity: Annee::class, inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private $annee;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAttache(): ?Attache
    {
        return $this->attache;
    }

    public function setAttache(?Attache $attache): self
    {
        $this->attache = $attache;

        return $this;
    }

    public function getEtudiant(): ?Etudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(?Etudiant $etudiant): self
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): self
    {
        $this->classe = $classe;

        return $this;
    }

    public function getAnnee(): ?Annee
    {
        return $this->annee;
    }

    public function setAnnee(?Annee $annee): self
    {
        $this->annee = $annee;

        return $this;
    }
}
