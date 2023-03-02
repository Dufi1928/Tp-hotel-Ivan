<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\HotelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: HotelRepository::class)]
#[ApiResource]
class Hotel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("hotel:read")]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups("hotel:read")]
    private ?string $adress = null;

    #[ORM\Column(length: 60)]
    #[Groups("hotel:read")]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(length: 60)]
    #[Groups("hotel:read")]
    private ?string $city = null;

    #[ORM\Column]
    #[Groups("hotel:read")]
    private ?int $numberOfRooms = null;

    #[ORM\Column(length: 60)]
    #[Groups("hotel:read")]
    private ?string $email = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups("hotel:read")]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Groups("hotel:read")]
    private ?string $coverImg = null;


    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Admin $admin = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Manager $manager = null;

    #[ORM\ManyToOne(inversedBy: 'hotels')]
    private ?Admin $admins = null;

    #[ORM\OneToMany(mappedBy: 'hotel', targetEntity: Suite::class)]
    #[Groups("hotel:read")]
    private Collection $suites;

    public function __construct()
    {
        $this->suites = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getNumberOfRooms(): ?int
    {
        return $this->numberOfRooms;
    }

    public function setNumberOfRooms(int $numberOfRooms): self
    {
        $this->numberOfRooms = $numberOfRooms;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCoverImg(): ?string
    {
        return $this->coverImg;
    }

    public function setCoverImg(string $coverImg): self
    {
        $this->coverImg = $coverImg;

        return $this;
    }


    public function getAdmin(): ?Admin
    {
        return $this->admin;
    }

    public function setAdmin(?Admin $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    public function getManager(): ?Manager
    {
        return $this->manager;
    }

    public function setManager(?Manager $manager): self
    {
        $this->manager = $manager;

        return $this;
    }

    public function getAdmins(): ?Admin
    {
        return $this->admins;
    }

    public function setAdmins(?Admin $admins): self
    {
        $this->admins = $admins;

        return $this;
    }

    /**
     * @return Collection<int, Suite>
     */
    public function getSuites(): Collection
    {
        return $this->suites;
    }

    public function addSuite(Suite $suite): self
    {
        if (!$this->suites->contains($suite)) {
            $this->suites->add($suite);
            $suite->setHotel($this);
        }

        return $this;
    }

    public function removeSuite(Suite $suite): self
    {
        if ($this->suites->removeElement($suite)) {
            // set the owning side to null (unless already changed)
            if ($suite->getHotel() === $this) {
                $suite->setHotel(null);
            }
        }

        return $this;
    }
}
