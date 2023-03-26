<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PolygonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PolygonRepository::class)]
#[ApiResource]
class Polygon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'polygon', targetEntity: Sommet::class)]
    private Collection $sommets;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->sommets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Sommet>
     */
    public function getSommets(): Collection
    {
        return $this->sommets;
    }

    public function addSommet(Sommet $sommet): self
    {
        if (!$this->sommets->contains($sommet)) {
            $this->sommets->add($sommet);
            $sommet->setPolygon($this);
        }

        return $this;
    }

    public function removeSommet(Sommet $sommet): self
    {
        if ($this->sommets->removeElement($sommet)) {
            // set the owning side to null (unless already changed)
            if ($sommet->getPolygon() === $this) {
                $sommet->setPolygon(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
