<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post {
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 255)]
  private ?string $titre = null;

  #[ORM\Column(type: "text")]
  private ?string $contenu = null;

  #[ORM\Column(type: "text")]
  private ?string $image = null;

  #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'posts')]
  private $user = null;
  
  public function getId(): ?int {
    return $this->id;
  }

  public function getUser(): ?User {
    return $this->user;
  }

  public function setUser(User $user): static {
    $this->user = $user;

    return $this;
  }

  public function getContenu(): ?string
  {
    return $this->contenu;
  }

  public function setContenu(?string $contenu): self
  {
    $this->contenu = $contenu;

    return $this;
  }

  public function getTitre(): ?string
  {
    return $this->titre;
  }

  public function setTitre(?string $titre): self
  {
    $this->titre = $titre;

    return $this;
  }

  public function getImage(): ?string
  {
    return $this->image;
  }

  public function setImage(?string $image): self
  {
    $this->image = $image;

    return $this;
  }
}