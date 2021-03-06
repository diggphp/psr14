<?php

declare(strict_types=1);

namespace DiggPHP\Psr14;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;
use Psr\EventDispatcher\StoppableEventInterface;

class EventDispatcher implements EventDispatcherInterface
{
    private $provider;

    public function __construct(ListenerProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    public function dispatch(object $event)
    {
        if ($event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
            return $event;
        }
        foreach ($this->provider->getListenersForEvent($event) as $listener) {
            $listener($event);
            if ($event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
                break;
            }
        }
        return $event;
    }
}
