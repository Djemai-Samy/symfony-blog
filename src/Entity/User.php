<?php
// src/Entity/User.php
namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface {
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column(type: 'integer')]
  private int $id;

  #[ORM\Column(type: 'string', length: 180, unique: true)]
  private ?string $email;

  #[ORM\Column(type: 'json')]
  private array $roles = [];

  #[ORM\Column(type: 'string')]
  private string $password;

  #[ORM\Column(type: 'string', nullable:true)]
  private ?string $avatar = null;

  #[ORM\OneToMany(targetEntity: Post::class, mappedBy: 'user')]
  private $posts = null;

  public function __construct() {
    $this->posts = new ArrayCollection();
  }

  public function getPosts(): Collection {
    return $this->posts;
  }

  public function addPost(Post $post): Collection {
    $this->posts->add($post);
    return $this->posts;
  }

  public function getId(): ?int {
    return $this->id;
  }

  public function getEmail(): ?string {
    return $this->email;
  }

  public function setEmail(string $email): self {
    $this->email = $email;

    return $this;
  }

  /**
   * Représentation publique de User (e.g. a username, an email, etc.)
   *
   * @see UserInterface
   */
  public function getUserIdentifier(): string {
    return (string) $this->email;
  }

  /**
   * @see UserInterface
   */
  public function getRoles(): array {
    $roles = $this->roles;
    // Yous les utilisateur on au moin le ROLE_USER
    $roles[] = 'ROLE_USER';

    return array_unique($roles);
  }

  public function setRoles(array $roles): self {
    $this->roles = $roles;

    return $this;
  }

  /**
   * @see PasswordAuthenticatedUserInterface
   */
  public function getPassword(): string {
    return $this->password;
  }

  public function setPassword(string $password): self {
    $this->password = $password;

    return $this;
  }

  /**
   * Retourne le hashage: Seulement si vous n'utiliser pas les hasheurs (e.g. bcrypt or sodium) in your security.yaml.
   *
   * @see UserInterface
   */
  public function getSalt(): ?string {
    return null;
  }

  /**
   * @see UserInterface
   */
  public function eraseCredentials(): void {
    // Si vous enregistrer temporairement des données sensible, vous pouvez les éffacer
    // $this->plainPassword = null;
  }

  public function getAvatar(): string|null {
    return $this->avatar;
  }

  public function setAvatar(string $avatar): self {
    $this->avatar = $avatar;

    return $this;
  }
}
