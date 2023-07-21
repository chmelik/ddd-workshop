<?php

namespace App\Shared\Infrastructure\Symfony\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:shared:generate-secret')]
class GenerateSecretCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $decryptionKey = sodium_crypto_box_keypair();
        $output->writeln(\sprintf('Decryption Key: %s', base64_encode($decryptionKey)));

        return self::SUCCESS;
    }
}
