<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonRepository")
 */
class Person
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Phone", mappedBy="person", orphanRemoval=true)
     */
    private $phones;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ShipOrder", mappedBy="orderperson", orphanRemoval=true)
     */
    private $shipOrders;

    public function __construct()
    {
        $this->phones = new ArrayCollection();
        $this->shipOrders = new ArrayCollection();
    }

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
    
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Collection|Phone[]
     */
    public function getPhones(): Collection
    {
        return $this->phones;
    }

    public function addPhone(Phone $phone): self
    {
        if (!$this->phones->contains($phone)) {
            $this->phones[] = $phone;
            $phone->setPerson($this);
        }

        return $this;
    }

    public function removePhone(Phone $phone): self
    {
        if ($this->phones->contains($phone)) {
            $this->phones->removeElement($phone);
            // set the owning side to null (unless already changed)
            if ($phone->getPerson() === $this) {
                $phone->setPerson(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ShipOrder[]
     */
    public function getShipOrders(): Collection
    {
        return $this->shipOrders;
    }

    public function addShipOrder(ShipOrder $shipOrder): self
    {
        if (!$this->shipOrders->contains($shipOrder)) {
            $this->shipOrders[] = $shipOrder;
            $shipOrder->setOrderperson($this);
        }

        return $this;
    }

    public function removeShipOrder(ShipOrder $shipOrder): self
    {
        if ($this->shipOrders->contains($shipOrder)) {
            $this->shipOrders->removeElement($shipOrder);
            // set the owning side to null (unless already changed)
            if ($shipOrder->getOrderperson() === $this) {
                $shipOrder->setOrderperson(null);
            }
        }

        return $this;
    }
}
