<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthenticationFailureListener
{
    /**
     * @param AuthenticationFailureEvent $event
     */
    public function onAuthenticationFailureResponse(AuthenticationFailureEvent $event)
    {
        $data = [
            'name' => 'John Doe',
            'foo' => 'bar',
        ];

        $response = new JWTAuthenticationFailureResponse('Bad credentials, please verify that your username/password are correctly set', JsonResponse::HTTP_UNAUTHORIZED);
        //$response->setData($data);

        $event->setResponse($response);
    }
}