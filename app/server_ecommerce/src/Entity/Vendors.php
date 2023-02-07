<?php

namespace App\Entity;

use App\Repository\VendorsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VendorsRepository::class)
 */
class Vendors
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $products_list = [];

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

    public function getProductsList(): ?array
    {
        return $this->products_list;
    }

    public function setProductsList(?array $products_list): self
    {
        $this->products_list = $products_list;

        return $this;
    }
}
