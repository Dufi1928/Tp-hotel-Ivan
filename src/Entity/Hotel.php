<?php

namespace App\Entity;

use App\Repository\HotelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: HotelRepository::class)]
class Hotel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("hotel:read")]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups("hotel:read")]
    private ?string $address   = null;

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


    #[ORM\OneToMany(mappedBy: 'hotel', targetEntity: Suite::class)]
    #[Groups("hotel:read")]
    private Collection $suites;

    #[Vich\UploadableField(mapping:"hotel_image", fileNameProperty:"imageName")]
    private $coverImgFile;
    #[ORM\Column(type:"string", length:255, nullable:true)]
    private $coverImgName;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }




    public function __construct()
    {
        $this->suites = new ArrayCollection();
    }

    public function getCoverImgFile(): ?File
    {
        return $this->coverImgFile;
    }

    public function setCoverImgFile(?File $coverImgFile = null): self
    {
        $this->coverImgFile = $coverImgFile;

        if ($coverImgFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    public function setCoverImgName($imageName)
    {
        $this->coverImgName = $imageName;
    }

    public function getCoverImgName()
    {
        return $this->coverImgName;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

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
