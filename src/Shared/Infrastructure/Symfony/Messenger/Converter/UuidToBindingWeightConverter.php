<?php

namespace App\Shared\Infrastructure\Symfony\Messenger\Converter;

use Symfony\Component\Uid\AbstractUid;

final class UuidToBindingWeightConverter
{
    public static function convert(AbstractUid $uuid): string
    {
        $string = (string)$uuid;
        if (preg_match_all('/(\d+)/', $string, $match)) {
            return self::useDigits($match[0]);
        }

        preg_match_all('/(\w)/', $string, $match);

        return self::useLetters($match[0]);
    }

    private static function useDigits(array $values): string
    {
        return (string) array_sum(
            array_map(fn (mixed $value) => (int)$value, $values)
        );
    }

    private static function useLetters(array $values): string
    {
        return (string) array_sum(
            array_map(fn (mixed $value) => ord($value), $values)
        );
    }
}
