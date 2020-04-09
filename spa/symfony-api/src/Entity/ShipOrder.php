<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShipOrderRepository")
 */
class ShipOrder
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Person", inversedBy="shipOrders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderperson;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Destination", mappedBy="shiporder", cascade={"persist", "remove"})
     */
    private $destination;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Item", mappedBy="shiporder")
     */
    private $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id){
        $this->id = $id;
        return $this;
    }

    public function getOrderperson(): ?Person
    {
        return $this->orderperson;
    }

    public function setOrderperson(?Person $orderperson): self
    {
        $this->orderperson = $orderperson;

        return $this;
    }

    public function getDestination(): ?Destination
    {
        return $this->destination;
    }

    public function setDestination(Destination $destination): self
    {
        $this->destination = $destination;

        // set the owning side of the relation if necessary
        if ($destination->getShiporder() !== $this) {
            $destination->setShiporder($this);
        }

        return $this;
    }

    /**
     * @return Collection|Item[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setShiporder($this);
        }

        return $this;
    }

    public function removeItem(Item $item): self
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
            // set the owning side to null (unless already changed)
            if ($item->getShiporder() === $this) {
                $item->setShiporder(null);
            }
        }

        return $this;
    }
}
