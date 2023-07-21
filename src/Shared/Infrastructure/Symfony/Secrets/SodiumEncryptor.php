<?php

namespace App\Shared\Infrastructure\Symfony\Secrets;

class SodiumEncryptor implements EncryptorInterface
{
    public function __construct(private readonly string $decryptionKey)
    {
    }

    public function encrypt(string $value): string
    {
        $encryptionKey = sodium_crypto_box_publickey($this->getDecryptionKey());

        return base64_encode(sodium_crypto_box_seal($value, $encryptionKey));
    }

    public function decrypt(string $value): string
    {
        return sodium_crypto_box_seal_open(base64_decode($value), $this->getDecryptionKey());
    }

    private function getDecryptionKey(): string
    {
        return base64_decode($this->decryptionKey);
    }
}
