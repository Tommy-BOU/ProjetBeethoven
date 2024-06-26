<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $capacity = null;

    /**
     * @var Collection<int, Equipment>
     */
    #[ORM\ManyToMany(targetEntity: Equipment::class, mappedBy: 'Room_Equipment')]
    private Collection $equipment;

    /**
     * @var Collection<int, RoomBooking>
     */
    #[ORM\OneToMany(targetEntity: RoomBooking::class, mappedBy: 'room', orphanRemoval: true)]
    private Collection $roomBookings;

    public function __construct()
    {
        $this->equipment = new ArrayCollection();
        $this->roomBookings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): static
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * @return Collection<int, Equipment>
     */
    public function getEquipment(): Collection
    {
        return $this->equipment;
    }

    public function addEquipment(Equipment $equipment): static
    {
        if (!$this->equipment->contains($equipment)) {
            $this->equipment->add($equipment);
            $equipment->addRoomEquipment($this);
        }

        return $this;
    }

    public function removeEquipment(Equipment $equipment): static
    {
        if ($this->equipment->removeElement($equipment)) {
            $equipment->removeRoomEquipment($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, RoomBooking>
     */
    public function getRoomBookings(): Collection
    {
        return $this->roomBookings;
    }

    public function addRoomBooking(RoomBooking $roomBooking): static
    {
        if (!$this->roomBookings->contains($roomBooking)) {
            $this->roomBookings->add($roomBooking);
            $roomBooking->setRoom($this);
        }

        return $this;
    }

    public function removeRoomBooking(RoomBooking $roomBooking): static
    {
        if ($this->roomBookings->removeElement($roomBooking)) {
            // set the owning side to null (unless already changed)
            if ($roomBooking->getRoom() === $this) {
                $roomBooking->setRoom(null);
            }
        }

        return $this;
    }
}
