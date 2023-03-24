<?php

namespace App\Services\JWT;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\User;

class EmailPayloadFactory
{
    public function __invoke(JWTCreatedEvent $event)
    {
        /** @var User $user */
        $user = $event->getUser();

        if (!$user instanceof User) {
            return;
        }

        $payload = $event->getData();
        $payload['email'] = $user->getEmail();
        unset($payload['username']); // Remove the username field from the payload

        $event->setData($payload);
    }
}
