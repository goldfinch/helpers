<?php

namespace Goldfinch\Helpers\Commands;

use Goldfinch\Taz\Console\GeneratorCommand;
use Goldfinch\Taz\Services\InputOutput;
use Symfony\Component\Console\Command\Command;

#[AsCommand(name: 'app:crypto-key')]
class GenerateCryptoKeyCommand extends GeneratorCommand
{
    protected static $defaultName = 'app:crypto-key';

    protected $description = 'Generate bin2hex key';

    protected function execute($input, $output): int
    {
        // parent::execute($input, $output);

        $key = bin2hex(random_bytes(16));

        $io = new InputOutput($input, $output);
        $io->text($key);

        return Command::SUCCESS;
    }
}
