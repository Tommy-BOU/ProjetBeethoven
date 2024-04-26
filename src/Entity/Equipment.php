<?php

namespace App\Entity;

use App\Repository\EquipmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipmentRepository::class)]
class Equipment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Room>
     */
    #[ORM\ManyToMany(targetEntity: Room::class, inversedBy: 'equipment')]
    private Collection $Room_Equipment;

    public function __construct()
    {
        $this->Room_Equipment = new ArrayCollection();
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

    /**
     * @return Collection<int, Room>
     */
    public function getRoomEquipment(): Collection
    {
        return $this->Room_Equipment;
    }

    public function addRoomEquipment(Room $roomEquipment): static
    {
        if (!$this->Room_Equipment->contains($roomEquipment)) {
            $this->Room_Equipment->add($roomEquipment);
        }

        return $this;
    }

    public function removeRoomEquipment(Room $roomEquipment): static
    {
        $this->Room_Equipment->removeElement($roomEquipment);

        return $this;
    }

    public function __toString() {
        return $this->name;
    }
}
