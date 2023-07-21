<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\Messenger;

use App\Shared\Application\AppEvents;
use App\Shared\Application\Command\CommandBusInterface;
use App\Shared\Application\Command\CommandInterface;
use App\Shared\Application\Event\SendCommandEvent;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class CommandBus implements CommandBusInterface
{
    public function __construct(private readonly MessageBusInterface $commandBus, private readonly EventDispatcherInterface $eventDispatcher)
    {
    }

    public function dispatch(CommandInterface $command): void
    {
        $this->eventDispatcher->dispatch(new SendCommandEvent($command), AppEvents::COMMAND_PRE_SEND);
        $this->commandBus->dispatch($command);
        $this->eventDispatcher->dispatch(new SendCommandEvent($command), AppEvents::COMMAND_POST_SEND);
    }
}
