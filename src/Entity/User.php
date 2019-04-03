<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @ApiResource(attributes={
 *     "normalization_context"={"groups"={"user.read"}},
 *     "denormalization_context"={"groups"={"user.write"}}
 * },
 * itemOperations={
 *   "put"={"denormalization_context"={"groups"={"user.update"}}},
 *   "get",
 *   "delete"
 * })
 * @ApiFilter(BooleanFilter::class, properties={"isActive"})
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="users")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({
     *     "user.read"
     * })
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Groups({
     *     "user.read",
     *     "user.write"
     * })
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Groups({
     *     "user.read",
     *     "user.write"
     * })
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @NotBlank(message="Please provide username")
     * @Groups({
     *     "user.read",
     *     "user.write"
     * })
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Groups({
     *     "user.read",
     *     "user.write"
     * })
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Groups({
     *     "user.read",
     *     "user.write"
     * })
     */
    private $phone;

    /**
     * @ORM\Column(type="boolean", options={"default" : false})
     * @Groups({
     *     "user.read",
     *     "user.write",
     *     "user.update"
     * })
     */
    private $isActive;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({
     *     "user.write",
     *     "user.update"
     * })
     */
    private $password;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Roles", mappedBy="users")
     * @ApiSubresource(maxDepth=1)
     * @Groups({
     *     "user.read",
     *     "user.write",
     *     "user.update"
     * })
     */
    private $roles;

    public function __construct($username)
    {
        $this->isActive = true;
        $this->username = $username;
        $this->roles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getSalt()
    {
        return null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection|Roles[]
     */
    public function getRoles(): array
    {
        return $this->roles->toArray();
        // return array('ROLE_USER');
    }

    public function addRole(Roles $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
            $role->addUser($this);
        }

        return $this;
    }

    public function removeRole(Roles $role): self
    {
        if ($this->roles->contains($role)) {
            $this->roles->removeElement($role);
            $role->removeUser($this);
        }

        return $this;
    }

    public function eraseCredentials()
    {
    }
}
