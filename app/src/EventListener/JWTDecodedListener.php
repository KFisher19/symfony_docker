<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;

class JWTDecodedListener
{
    /**
     * @param JWTDecodedEvent $event
     *
     * @return void
     */
    public function onJWTDecoded(JWTDecodedEvent $event)
    {
        $payload = $event->getPayload();
        $user = $this->userRepository->findOneByUsername($payload['username']);

        $payload['custom_user_data'] = $user->getCustomUserInformations();

        $event->setPayload($payload); // Don't forget to regive the payload for next event / step
    }
}