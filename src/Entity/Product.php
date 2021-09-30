<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @UniqueEntity("title", message = "Cette valeur existe déjà.")
 */
class Product
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
    private $title;

    /**
     * @ORM\Column(type="float", options={"default": 0})
     * @Assert\GreaterThanOrEqual(0, message = "La valeur doit être >= 0.")
     */
    private $price = 0;

    /**
     * @ORM\Column(type="integer", options={"default": 0})
     * @Assert\GreaterThanOrEqual(0, message = "La valeur doit être >= 0.")
     */
    private $stock = 0;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $available = false;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $img_url;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;


    public function __construct()
    {
        $this->created_at = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getAvailable(): ?bool
    {
        return $this->available;
    }

    public function setAvailable(bool $available): self
    {
        $this->available = $available;

        return $this;
    }

    public function getImgUrl(): ?string
    {
        return $this->img_url;
    }

    public function setImgUrl(?string $img_url): self
    {
        $this->img_url = $img_url;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
