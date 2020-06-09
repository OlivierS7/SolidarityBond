<?php

namespace App\Entity;

use App\Repository\ContainsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContainsRepository::class)
 */
class Contains
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToMany(targetEntity=Orders::class)
     */
    private $nbOrder;

    /**
     * @ORM\ManyToMany(targetEntity=Products::class)
     */
    private $nbProduct;

    public function __construct()
    {
        $this->nbOrder = new ArrayCollection();
        $this->nbProduct = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return Collection|Orders[]
     */
    public function getNbOrder(): Collection
    {
        return $this->nbOrder;
    }

    public function addNbOrder(Orders $nbOrder): self
    {
        if (!$this->nbOrder->contains($nbOrder)) {
            $this->nbOrder[] = $nbOrder;
        }

        return $this;
    }

    public function removeNbOrder(Orders $nbOrder): self
    {
        if ($this->nbOrder->contains($nbOrder)) {
            $this->nbOrder->removeElement($nbOrder);
        }

        return $this;
    }

    /**
     * @return Collection|Products[]
     */
    public function getNbProduct(): Collection
    {
        return $this->nbProduct;
    }

    public function addNbProduct(Products $nbProduct): self
    {
        if (!$this->nbProduct->contains($nbProduct)) {
            $this->nbProduct[] = $nbProduct;
        }

        return $this;
    }

    public function removeNbProduct(Products $nbProduct): self
    {
        if ($this->nbProduct->contains($nbProduct)) {
            $this->nbProduct->removeElement($nbProduct);
        }

        return $this;
    }
}
