<?php

declare(strict_types=1);

namespace App\Product\Domain\Exception;

use App\Product\Domain\ValueObject\MediaId;

class MissingMediaException extends \RuntimeException
{
    public function __construct(MediaId $id, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(sprintf('Cannot find Media with id %s', $id), $code, $previous);
    }
}
