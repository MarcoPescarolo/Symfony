<?php

namespace App\Entity;

use App\Repository\PosteoRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PosteoRepository::class)]
#[Vich\Uploadable]
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

    #[ORM\OneToMany(targetEntity: Comentario::class, mappedBy: 'posteo', orphanRemoval: true)]
    private Collection $comentarios;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imagen = null;

    #[Vich\UploadableField(mapping: 'posteo_images', fileNameProperty: 'imagen')]
    private ?File $imageFile = null;

    public function __construct()
    {
        $this->comentarios = new ArrayCollection();
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->fecha = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
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

    /**
     * @return Collection<int, Comentario>
     */
    public function getComentarios(): Collection
    {
        return $this->comentarios;
    }

    public function addComentario(Comentario $comentario): static
    {
        if (!$this->comentarios->contains($comentario)) {
            $this->comentarios->add($comentario);
            $comentario->setPosteo($this);
        }

        return $this;
    }

    public function removeComentario(Comentario $comentario): static
    {
        if ($this->comentarios->removeElement($comentario)) {
            // set the owning side to null (unless already changed)
            if ($comentario->getPosteo() === $this) {
                $comentario->setPosteo(null);
            }
        }

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(?string $imagen): static
    {
        $this->imagen = $imagen;

        return $this;
    }
}
