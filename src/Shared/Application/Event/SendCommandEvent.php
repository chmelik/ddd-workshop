<?php

namespace App\Shared\Application\Event;

use App\Shared\Application\Command\CommandInterface;
use Symfony\Contracts\EventDispatcher\Event;

final class SendCommandEvent extends Event
{
    public function __construct(public readonly CommandInterface $command)
    {
    }
}
