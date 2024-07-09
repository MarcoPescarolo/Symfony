<?php

namespace App\Entity;

use App\Repository\CategoriaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriaRepository::class)]
class Categoria
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $titulo = null;

    #[ORM\OneToMany(targetEntity: Posteo::class, mappedBy: 'categoria')]
    private Collection $posteos;

    public function __construct()
    {
        $this->posteos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): static
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * @return Collection<int, Posteo>
     */
    public function getPosteos(): Collection
    {
        return $this->posteos;
    }

    public function addPosteo(Posteo $posteo): static
    {
        if (!$this->posteos->contains($posteo)) {
            $this->posteos->add($posteo);
            $posteo->setCategoria($this);
        }

        return $this;
    }

    public function removePosteo(Posteo $posteo): static
    {
        if ($this->posteos->removeElement($posteo)) {
            // set the owning side to null (unless already changed)
            if ($posteo->getCategoria() === $this) {
                $posteo->setCategoria(null);
            }
        }

        return $this;
    }


    public function __toString(): string
    {
        return $this->titulo ?? '';
    }
}
