<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Email::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Subscription::class, mappedBy="user", orphanRemoval=true)
     */
    private $subscriptionCollection;

    public function __construct()
    {
        $this->subscriptionCollection = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?Email
    {
        return $this->email;
    }

    public function setEmail(Email $email): self
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

    /**
     * @return Collection|Subscription[]
     */
    public function getSubscriptionCollection(): Collection
    {
        return $this->subscriptionCollection;
    }

    public function addSubscriptionCollection(Subscription $subscriptionCollection): self
    {
        if (!$this->subscriptionCollection->contains($subscriptionCollection)) {
            $this->subscriptionCollection[] = $subscriptionCollection;
            $subscriptionCollection->setUser($this);
        }

        return $this;
    }

    public function removeSubscriptionCollection(Subscription $subscriptionCollection): self
    {
        if ($this->subscriptionCollection->removeElement($subscriptionCollection)) {
            // set the owning side to null (unless already changed)
            if ($subscriptionCollection->getUser() === $this) {
                $subscriptionCollection->setUser(null);
            }
        }

        return $this;
    }
}
