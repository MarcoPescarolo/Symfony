<?php

namespace App\Entity;

use App\Repository\PosteoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PosteoRepository::class)]
class Posteo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $titulo = null;

    #[ORM\Column(length: 500)]
    private ?string $descripcion = null;

    #[ORM\OneToOne(mappedBy: 'id_posteo', cascade: ['persist', 'remove'])]
    private ?Tag $tag = null;

    #[ORM\ManyToOne(inversedBy: 'posteos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categoria $categoria = null;

    #[ORM\ManyToOne(inversedBy: 'posteos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $usuario = null;


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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getTag(): ?Tag
    {
        return $this->tag;
    }

    public function setTag(?Tag $tag): static
    {
        // unset the owning side of the relation if necessary
        if ($tag === null && $this->tag !== null) {
            $this->tag->setIdPosteo(null);
        }

        // set the owning side of the relation if necessary
        if ($tag !== null && $tag->getIdPosteo() !== $this) {
            $tag->setIdPosteo($this);
        }

        $this->tag = $tag;

        return $this;
    }

    public function getCategoria(): ?Categoria
    {
        return $this->categoria;
    }

    public function setCategoria(?Categoria $categoria): static
    {
        $this->categoria = $categoria;

        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }
}
