<?php

namespace App\Controller;

use App\Entity\Polygon;
use App\Entity\Sommet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


class SavePolygonController
{
    private EntityManagerInterface $entityManager;
    private $serializer;

    public function __construct(EntityManagerInterface $entityManager, NormalizerInterface $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    #[Route('/api/polygon', methods: ['POST'])]
    public function savePolygon(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $polygon = new Polygon();
        $polygon->setCreatedAt(new \DateTimeImmutable());
        $sommetsJson = [];
        $sommets = [];
        foreach ($data['sommets'] as $vertex) {
            $sommet = new Sommet();
            $sommet->setLat($vertex['lat']);
            $sommet->setLong($vertex['long']);
            $sommetsJson[]= [
                'lat' => $sommet->getLat(),
                'long' => $sommet->getLong()];
            $sommet->setPolygon($polygon);

            $this->entityManager->persist($sommet);
            $sommets[] = $sommet;
        }

        $this->entityManager->persist($polygon);
        $this->entityManager->flush();

        $json = json_encode($sommets);

        return new JsonResponse(['status' => 'Polygon created', 'sommets' => $sommetsJson], JsonResponse::HTTP_CREATED);
    }
}
