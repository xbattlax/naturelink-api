<?php

namespace App\Controller;

use App\Entity\Polygon;
use App\Entity\Sommet;
use App\Repository\PolygonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PolygonController
{
    private EntityManagerInterface $entityManager;
    private PolygonRepository $polygonRepository;

    public function __construct(EntityManagerInterface $entityManager, PolygonRepository $polygonRepository)
    {
        $this->entityManager = $entityManager;
        $this->polygonRepository = $polygonRepository;
    }

    #[Route('/public/polygons', methods: ['GET'])]
    public function getAllPolygons(): JsonResponse
    {
        $polygons = $this->polygonRepository->findAll();
        $result = [];

        foreach ($polygons as $polygon) {
            $sommets = [];
            foreach ($polygon->getSommets() as $sommet) {
                $sommets[] = [
                    'latitude' => $sommet->getLat(),
                    'longitude' => $sommet->getLong(),
                ];
            }

            $result[] = [
                'id' => $polygon->getId(),
                'sommets' => $sommets,
                'createdAt' => $polygon->getCreatedAt(),
                'updatedAt' => $polygon->getUpdatedAt(),
            ];
        }

        return new JsonResponse($result);
    }

}

