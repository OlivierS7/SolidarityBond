<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Rollerworks\Component\PasswordStrength\Validator\Constraints as RollerworksPassword;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 * @UniqueEntity("email")
 */
class Users implements UserInterface,\Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32)
     * @Assert\Length(
     *     min=3,
     *     minMessage="Votre prénom doit faire au moins {{ limit }} caractères."
     * )
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Votre prénom ne doit contenir que des lettres."
     * )
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\Length(
     *     min=3,
     *     minMessage="Votre nom doit faire au moins {{ limit }} caractères."
     * )
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Votre nom ne doit contenir que des lettres."
     * )
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=128)
     * @Assert\Email(
     *     message="L'email '{{ value }}' n'est pas un email valide."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\Length(
     *     min=8,
     *     minMessage="Votre mot de passe doit faire au moins {{ limit }} caractères."
     * )
     * @RollerworksPassword\PasswordRequirements(requireLetters=true, requireNumbers=true, requireCaseDiff=true)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $phone;

    /**
     * @ORM\ManyToOne(targetEntity=Status::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=Comments::class, mappedBy="user")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=Subjects::class, mappedBy="user")
     */
    private $subjects;

    /**
     * @ORM\OneToMany(targetEntity=Orders::class, mappedBy="user")
     */
    private $orders;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->subjects = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|Comments[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Subjects[]
     */
    public function getSubjects(): Collection
    {
        return $this->subjects;
    }

    public function addSubject(Subjects $subject): self
    {
        if (!$this->subjects->contains($subject)) {
            $this->subjects[] = $subject;
            $subject->setUser($this);
        }

        return $this;
    }

    public function removeSubject(Subjects $subject): self
    {
        if ($this->subjects->contains($subject)) {
            $this->subjects->removeElement($subject);
            // set the owning side to null (unless already changed)
            if ($subject->getUser() === $this) {
                $subject->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Orders[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Orders $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setUser($this);
        }

        return $this;
    }

    public function removeOrder(Orders $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            // set the owning side to null (unless already changed)
            if ($order->getUser() === $this) {
                $order->setUser(null);
            }
        }

        return $this;
    }

    public function getRoles() {
        return array('ROLE_USER');
    }

    public function getSalt() {
        return null;
    }

    public function getUsername() {}

    public function eraseCredentials() {}

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->firstName,
            $this->lastName,
            $this->email,
            $this->password,
            $this->status
        ]);
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->firstName,
            $this->lastName,
            $this->email,
            $this->password,
            $this->status
            ) = unserialize($serialized, ['allowed_classes' => false]);
    }
}
