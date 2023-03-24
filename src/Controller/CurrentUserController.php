<?php
// src/Controller/CurrentUserController.php

namespace App\Controller;
use Psr\Log\LoggerInterface;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CurrentUserController extends AbstractController
{

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    /**
     * @Route("/api/current_user", name="get_current_user", methods={"GET"})
     */
    public function getCurrentUser(): JsonResponse
    {
        $user = $this->getUser();

        $this->logger->info('User object:', ['user' => $user]);

        if (!$user instanceof User) {
            return new JsonResponse(['error' => 'No authenticated user found'], 401);
        }

        // Serialize the user object to JSON
        return $this->json([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
            'address' => $user->getAddress(),
            'phone' => $user->getPhone(),
            'BirdthDate' => $user->getDateDeNaissance(),
            'firstName' => $user->getName(),
            'surname' => $user->getSurname(),
            'pseudo'=>$user->getUsername(),

        ]);
    }
}
