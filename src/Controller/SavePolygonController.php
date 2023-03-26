<?php

namespace App\Controller;

use App\Entity\Polygon;
use App\Entity\Sommet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SavePolygonController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/api/polygon', methods: ['POST'])]
    public function savePolygon(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $polygon = new Polygon();
        $polygon->setCreatedAt(new \DateTimeImmutable());

        foreach ($data['sommets'] as $vertex) {
            $sommet = new Sommet();
            $sommet->setLat($vertex['lat']);
            $sommet->setLong($vertex['long']);
            $sommet->setPolygon($polygon);

            $this->entityManager->persist($sommet);
        }

        $this->entityManager->persist($polygon);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Polygon created'], JsonResponse::HTTP_CREATED);
    }
}
