<?php

namespace App\EventSubscriber;

use App\Service\DatabaseTranslator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class TranslationSubscriber implements EventSubscriberInterface
{
    private $databaseTranslator;

    public function __construct(DatabaseTranslator $databaseTranslator)
    {
        $this->databaseTranslator = $databaseTranslator;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 20],
        ];
    }

    public function onKernelRequest(RequestEvent $event)
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $this->databaseTranslator->loadTranslations();
    }
}