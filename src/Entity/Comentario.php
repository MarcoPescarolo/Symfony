<?php

namespace App\Entity;

use App\Repository\ComentarioRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComentarioRepository::class)]
class Comentario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 500)]
    private ?string $descripcion = null;

    #[ORM\ManyToOne(inversedBy: 'comentarios')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Posteo $posteo = null;

    #[ORM\ManyToOne(inversedBy: 'comentarios')]
    private ?Usuario $usuario = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPosteo(): ?Posteo
    {
        return $this->posteo;
    }

    public function setPosteo(?Posteo $posteo): static
    {
        $this->posteo = $posteo;

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
