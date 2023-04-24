<?php

declare(strict_types=1);

namespace DiggPHP\Psr14;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;
use Psr\EventDispatcher\StoppableEventInterface;
use Fig\EventDispatcher\ParameterDeriverTrait;
use SplPriorityQueue;

class Event implements EventDispatcherInterface, ListenerProviderInterface
{
    use ParameterDeriverTrait;
    private $listeners = [];

    public function dispatch(object $event)
    {
        if ($event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
            return $event;
        }
        foreach ($this->getListenersForEvent($event) as $listener) {
            $listener($event);
            if ($event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
                break;
            }
        }
        return $event;
    }

    public function getListenersForEvent(object $event): iterable
    {
        $queue = new SplPriorityQueue();
        foreach ($this->listeners as $listener) {
            if ($event instanceof $listener['type']) {
                $queue->insert($listener['listener'], $listener['priority']);
            }
        }
        return $queue;
    }

    public function listen(callable $listener, int $priority = 0): self
    {
        $type = $this->getParameterType($listener);
        $this->listeners[] = [
            'type' => $type,
            'listener' => $listener,
            'priority' => $priority,
        ];
        return $this;
    }
}
