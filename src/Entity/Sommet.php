<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SommetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SommetRepository::class)]
#[ApiResource]
class Sommet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "float", nullable: true)]
    private ?string $lat = null;

    #[ORM\Column(type: "float", nullable: true)]
    private ?string $long = null;

    #[ORM\ManyToOne(inversedBy: 'sommets')]
    private ?Polygon $polygon = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function setLat(?string $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLong(): ?string
    {
        return $this->long;
    }

    public function setLong(?string $long): self
    {
        $this->long = $long;

        return $this;
    }

    public function getPolygon(): ?Polygon
    {
        return $this->polygon;
    }

    public function setPolygon(?Polygon $polygon): self
    {
        $this->polygon = $polygon;

        return $this;
    }
}
