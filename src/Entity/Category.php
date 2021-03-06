<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category

{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="ne me laisse pas tout vide")
     * @Assert\Length(max="255", maxMessage="La catégorie saisie {{ value }} est trop longue, elle ne devrait pas dépasser {{ limit }} caractères")
    */
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
/**
* @ORM\OneToMany(targetEntity=Program::class, mappedBy="category")
*/
    private $programs;

    public function __construct()
    {
        $this->programs = new ArrayCollection();
    } 
/**
* @return Collection|Program[]
*/
    public function gProgetrams(): Collection
    {
        return $this->programs;
    }
/**
 * @param Program $program
 * @return Category
 */
    public function addProgram(Program $program): self
    {
        if (!$this->programs->contains($program)) {
            $this->programs[] = $program;
            $program->setCategory($this);
        }

        return $this;
    }
/**
 * @param Program $program
 * @return Category
 */
public function removeProgram(Program $program): self
{
    if ($this->programs->removeElement($program)) {
        // set the owning side to null (unless already changed)
        if ($program->getCategory() === $this) {
            $program->setCategory(null);
            }
        }

    return $this;
    }

/**
 * @return Collection|Program[]
 */
public function getPrograms(): Collection
{
    return $this->programs;
}
}
