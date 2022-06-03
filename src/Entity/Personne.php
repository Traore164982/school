<?php

namespace App\Entity;

use App\Repository\PersonneRepository;
use Doctrine\ORM\Mapping as ORM;

 #[ORM\InheritanceType("JOINED")]
 #[ORM\DiscriminatorColumn(name:"role", type:"string")]
 #[ORM\DiscriminatorMap(["personne" => "Personne","user"=>"User" ,"professeur" => "Professeur"])]
#[ORM\Entity(repositoryClass: PersonneRepository::class)]
class Personne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\Column(type: 'string', length: 255)]
    protected $nomComplet;

/*     #[ORM\Column(type: 'string', length: 30)]
    protected $role; */

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomComplet(): ?string
    {
        return $this->nomComplet;
    }

    public function setNomComplet(string $nomComplet): self
    {
        $this->nomComplet = $nomComplet;

        return $this;
    }

/*     public function getRole(): ?string
    {
        return $this->role;
    } */

/*     public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    } */
}
