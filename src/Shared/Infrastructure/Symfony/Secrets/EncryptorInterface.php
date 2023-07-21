<?php

namespace App\Shared\Infrastructure\Symfony\Secrets;

interface EncryptorInterface
{
    public function encrypt(string $value): string;

    public function decrypt(string $value): string;
}
