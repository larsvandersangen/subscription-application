<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SubscriptionRepository;
use App\Endpoint\SubscriptionResolver;
use App\Endpoint\SubscriptionItemResolver;
use App\Endpoint\SubscriptionMutator;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     graphql={
 *         "customChangeEmail": {
 *              "mutation": SubscriptionMutator::class,
 *              "args": {
 *                  "id": {
 *                      "type": "ID!",
 *                      "description": "The identifier of the subscription to change the email for"
 *                  },
 *                  "changeEmailTo": {
 *                      "type": "String!",
 *                      "description": "The email to change it into?"
 *                  }
 *              }
 *         },
 *         "customSubscriptionEndpoint": {
 *             "collection_query": SubscriptionResolver::class
 *         },
 *         "customSubscriptionItemEndpoint":  {
 *             "item_query": SubscriptionItemResolver::class,
 *             "args": {
 *               "id": {"type": "ID!"},
 *             }
 *         },
 *     }
 * )
 * @ORM\Entity(repositoryClass=SubscriptionRepository::class)
 */
class Subscription
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="subscriptionCollection")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity=Email::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phonenumber;

    /**
     * @ORM\ManyToOne(targetEntity=Address::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $address;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
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

    public function getPhonenumber(): ?string
    {
        return $this->phonenumber;
    }

    public function setPhonenumber(string $phonenumber): self
    {
        $this->phonenumber = $phonenumber;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }
}
