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


    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Posteo $id_posteo = null;

    #[ORM\Column(length: 500)]
    private ?string $descripcion = null;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getIdPosteo(): ?Posteo
    {
        return $this->id_posteo;
    }

    public function setIdPosteo(Posteo $id_posteo): static
    {
        $this->id_posteo = $id_posteo;

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
}
