<?php

namespace App\Shared\Infrastructure\Symfony\Logger;

use Monolog\LogRecord;
use Symfony\Component\ErrorHandler\Exception\FlattenException;

final class FlattenExceptionProcessor
{
    public function __invoke(LogRecord $record): LogRecord
    {
        $context = $record->context;
        $exception = $context['exception'] ?? null;
        if (!is_a($exception, FlattenException::class, true)) {
            return $record;
        }

        unset($context['exception']);

        return $record->with(
            message: $this->getMessage($exception),
            context: $context,
        );
    }

    private function getMessage(FlattenException $flattenException): string
    {
        $message = '';
        $next = false;

        foreach (array_reverse(array_merge([$flattenException], $flattenException->getAllPrevious())) as $exception) {
            if ($next) {
                $message .= 'Next ';
            } else {
                $next = true;
            }
            $message .= $exception->getClass();

            if ('' != $exception->getMessage()) {
                $message .= ': '.$exception->getMessage();
            }

            $message .= ' in '.$exception->getFile().':'.$exception->getLine().
                "\n\n";
        }

        return rtrim($message);
    }
}
