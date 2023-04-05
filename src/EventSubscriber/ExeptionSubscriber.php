<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment;

class ExceptionSubscriber implements EventSubscriberInterface
{
  public function __construct(private Environment $twig)
  {}

  public static function getSubscribedEvents(): array
  {
    // return the subscribed events, their methods and priorities
    return [
      KernelEvents::EXCEPTION => [
        ['onNotFoundException', -10],
      ],
    ];
  }

  public function onNotFoundException(ExceptionEvent $event): void
  {
    $exception = $event->getThrowable();
    if ($exception instanceof NotFoundHttpException) {
      $response = new JsonResponse([], Response::HTTP_NOT_FOUND);
      $event->setResponse($response);
      
      $response = new Response(
        $this->twig->render('error/page404.html.twig'),
        Response::HTTP_OK,
        ['content-type' => 'text/html']
      );
      $event->setResponse($response);
    }
  }
}
