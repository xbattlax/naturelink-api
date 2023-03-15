<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SignUpController
{
    private $userRepository;
    private $passwordHasher;
    private $entityManager;
    private $validator;

    public function __construct(
        UserRepository $userRepository,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ) {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    /**
     * @Route("/register", name="register", methods={"POST"})
     */
    public function register(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $email = $data['email'] ?? '';
        $plainPassword = $data['password'] ?? '';
        $username = $data['username'] ?? '';
        $name = $data['name'] ?? '';
        $surname = $data['surname'] ?? '';
        $date_de_naissance = isset($data['date_de_naissance']) ? new \DateTime($data['date_de_naissance']) : null;
        $phone = $data['phone'] ?? '';
        $address = $data['address'] ?? '';

        $existingUser = $this->userRepository->findOneBy(['email' => $email]);
        if ($existingUser) {
            return new JsonResponse(['error' => 'User already exists.'], Response::HTTP_CONFLICT);
        }

        $user = new User();
        $user->setEmail($email);
        $user->setRoles([]);
        $user->setPlainPassword($plainPassword);
        $user->setPassword(
            $this->passwordHasher->hashPassword($user, $plainPassword)
        );
        $user->setUsername($username);
        $user->setName($name);
        $user->setSurname($surname);
        $user->setDateDeNaissance($date_de_naissance);
        $user->setPhone($phone);
        $user->setAddress($address);

        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return new JsonResponse(['error' => $errorsString], Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'User created successfully'], Response::HTTP_CREATED);
    }
}
