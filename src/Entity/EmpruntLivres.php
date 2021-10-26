<?php

namespace App\Entity;

use App\Repository\EmpruntLivresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmpruntLivresRepository::class)
 */
class EmpruntLivres
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Livre::class)
     */
    private $Livre;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="empruntLivres")
     */
    private $User;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rapport;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_de_reservation;

    public function __construct()
    {
        $this->Livre = new ArrayCollection();
        $this->User = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

//    /**
//     * @return Collection|Livre[]
//     */
    public function getLivre(): Livre
    {
        return $this->Livre;
    }

    public function setLivre(Livre $livre): self
    {
            $this->Livre = $livre;
        return $this;
    }

    public function removeLivre(Livre $livre): self
    {
        $this->Livre->removeElement($livre);

        return $this;
    }

//    /**
//     * @return Collection|User[]
//     */
    public function getUser(): User
    {
        return $this->User;
    }

    public function setUser(User $user): self
    {
            $this->User= $user;

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->User->removeElement($user);

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getRapport(): ?string
    {
        return $this->rapport;
    }

    public function setRapport(?string $rapport): self
    {
        $this->rapport = $rapport;

        return $this;
    }

    public function getDateDeReservation(): ?\DateTimeInterface
    {
        return $this->date_de_reservation;
    }

    public function setDateDeReservation(\DateTimeInterface $date_de_reservation): self
    {
        $this->date_de_reservation = $date_de_reservation;

        return $this;
    }
}
