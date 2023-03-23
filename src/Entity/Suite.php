<?php

namespace App\Entity;

use App\Repository\SuiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: SuiteRepository::class)]
#[Vich\Uploadable]
class Suite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("hotel:read")]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    #[Groups("hotel:read")]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups("hotel:read")]
    private ?string $description = null;


    #[Vich\UploadableField(mapping:"suite_image", fileNameProperty:"imageName")]
    private $imageFile;
    #[ORM\Column(type:"string", length:255, nullable:true)]
    private $imageName;


    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }
    public function formatPrice(): string
    {
        if ($this->price == 0) {
            return 'none';
        }

        return '$' . number_format($this->price / 100, 2, '.', ',');
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
    }

    public function getImageName()
    {
        return $this->imageName;
    }



    #[ORM\Column]
    #[Groups("hotel:read")]
    private ?float $price = null;


    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Groups("hotel:read")]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    #[Groups("hotel:read")]
    private ?int $beds = null;

    #[ORM\Column]
    #[Groups("hotel:read")]
    private ?int $bathroom = null;

    #[ORM\Column]
    #[Groups("hotel:read")]
    private ?float $size = null;

    #[ORM\ManyToOne(inversedBy: 'suites')]
    private ?Hotel $hotel = null;

    #[ORM\OneToMany(mappedBy: 'suite', targetEntity: Booking::class)]
    private Collection $bookings;



    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getBeds(): ?int
    {
        return $this->beds;
    }

    public function setBeds(int $beds): self
    {
        $this->beds = $beds;

        return $this;
    }

    public function getBathroom(): ?int
    {
        return $this->bathroom;
    }

    public function setBathroom(int $bathroom): self
    {
        $this->bathroom = $bathroom;

        return $this;
    }

    public function getSize(): ?float
    {
        return $this->size;
    }

    public function setSize(float $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getHotel(): ?Hotel
    {
        return $this->hotel;
    }

    public function setHotel(?Hotel $hotel): self
    {
        $this->hotel = $hotel;

        return $this;
    }
    public function __construct()
    {
        $this->updatedAt = new \DateTimeImmutable();
        $this->bookings = new ArrayCollection();
    }
    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->setSuite($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getSuite() === $this) {
                $booking->setSuite(null);
            }
        }

        return $this;
    }

}
