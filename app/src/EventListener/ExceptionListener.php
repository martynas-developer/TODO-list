<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    private $env;

    public function __construct($env)
    {
        $this->env = $env;
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        if ($this->env === 'dev') {
            $response = new JsonResponse([
                'error' => $event->getThrowable()->getMessage(),
                'file' => $event->getThrowable()->getFile(),
                'line' => $event->getThrowable()->getLine(),
            ]);
            $event->setResponse($response);
        } else {
            $event->setResponse(new JsonResponse());
        }
    }
}