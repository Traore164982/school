<?php

namespace App\EventSubscriber;

use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\PrePersist;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class InfoSubscriber implements EventSubscriberInterface
{
    public function onTra(RequestEvent $request): void
    {
        dd('on tra');
    }

    public static function getSubscribedEvents(): array
    {
        return [
                    Events::prePersist => 'onTra',
        ];
    }
}
