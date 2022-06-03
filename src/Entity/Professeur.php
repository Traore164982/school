<?php

namespace App\Entity;

use App\Repository\ProfesseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Process\Process;

#[ORM\Entity(repositoryClass: ProfesseurRepository::class)]
class Professeur extends Personne
{

    #[ORM\Column(type: 'string', length: 255)]
    private $grade;

    #[ORM\ManyToMany(targetEntity: Module::class, mappedBy: 'professeurs')]
    private $Rp;

    public function __construct()
    {
        $this->Rp = new ArrayCollection();
        $this->modules = new ArrayCollection();
    }


    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(string $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * @return Collection<int, Module>
     */
    public function getRp(): Collection
    {
        return $this->Rp;
    }

    public function addRp(Module $rp): self
    {
        if (!$this->Rp->contains($rp)) {
            $this->Rp[] = $rp;
            $rp->addProfesseur($this);
        }

        return $this;
    }

    public function removeRp(Module $rp): self
    {
        if ($this->Rp->removeElement($rp)) {
            $rp->removeProfesseur($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Module>
     */
    public function getModules(): Collection
    {
        return $this->modules;
    }

    public function addModule(Module $module): self
    {
        if (!$this->modules->contains($module)) {
            $this->modules[] = $module;
            $module->addProfesseur($this);
        }

        return $this;
    }

    public function removeModule(Module $module): self
    {
        if ($this->modules->removeElement($module)) {
            $module->removeProfesseur($this);
        }

        return $this;
    }
}
