<?php

namespace App\Shared\Application;

use App\Shared\Application\Event\SendCommandEvent;

final class AppEvents
{
    /**
     * @see App\Shared\Application\Event\SendCommandEvent
     */
    public const COMMAND_PRE_SEND = 'command.pre_send';

    /**
     * @see App\Shared\Application\Event\SendCommandEvent
     */
    public const COMMAND_POST_SEND = 'command.post_send';

    private function __construct()
    {
    }
}
