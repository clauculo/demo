<?php

namespace App\Entity;

use App\Entity\User\CustomerGroup;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="users")
 * @ORM\Entity()
 */
class User
{
    /**
     * @ORM\Column(type="integer", options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected ?int $id = null;

    /**
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    protected ?string $firstName = null;

    /**
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     */
    protected ?string $lastName = null;

    /**
     * @var ArrayCollection<array-key, \App\Entity\Contact>
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Contact", mappedBy="user", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected Collection $contacts;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
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

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact))
        {
            $contact->setUser($this);
            $this->contacts->add($contact);
        }
        return $this;
    }

    public function getContacts(): PersistentCollection
    {
        return $this->contacts;
    }
}