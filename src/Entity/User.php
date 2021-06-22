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

    /**
     * @ORM\OneToOne(targetEntity=PaymentInfo::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $paymentInfo;

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

    public function addSubscriptionCollection(ArrayCollection $subscriptionCollection) : self
    {
        foreach($subscriptionCollection as $subscription) {
            $this->addSubscription($subscription);
        }

        return $this;
    }

    public function addSubscription(Subscription $subscription): self
    {
        if (!$this->subscriptionCollection->contains($subscription)) {
            $subscription->setUser($this);
            $this->subscriptionCollection->add($subscription);
        }

        return $this;
    }

    public function removeSubscription(Subscription $subscription): self
    {
        // set the owning side to null (unless already changed)
        if ($this->subscriptionCollection->removeElement($subscription) && $subscription->getUser() === $this)
        {
            $subscription->setUser(null);
        }

        return $this;
    }

    public function getPaymentInfo(): ?PaymentInfo
    {
        return $this->paymentInfo;
    }

    public function setPaymentInfo(PaymentInfo $paymentInfo): self
    {
        $this->paymentInfo = $paymentInfo;

        return $this;
    }
}
