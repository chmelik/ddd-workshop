<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Symfony\Messenger\Message;

use App\Shared\Infrastructure\Symfony\Messenger\Message\AbstractMessageEvent;

final class ProductDeletedEvent extends AbstractMessageEvent
{
}
