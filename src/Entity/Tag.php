<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titulo = null;

    #[ORM\OneToOne(inversedBy: 'tag', cascade: ['persist', 'remove'])]
    private ?Posteo $id_posteo = null;

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

    public function getIdPosteo(): ?Posteo
    {
        return $this->id_posteo;
    }

    public function setIdPosteo(?Posteo $id_posteo): static
    {
        $this->id_posteo = $id_posteo;

        return $this;
    }
}
