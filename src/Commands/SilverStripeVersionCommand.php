<?php

namespace Goldfinch\Helpers\Commands;

use Goldfinch\Taz\Console\GeneratorCommand;
use Goldfinch\Taz\Services\InputOutput;
use Symfony\Component\Console\Command\Command;
use Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;
use SilverStripe\Admin\LeftAndMain;

#[AsCommand(name: 'app:ss-version')]
class SilverStripeVersionCommand extends GeneratorCommand
{
    protected static $defaultName = 'app:ss-version';

    protected $description = 'Get SilverStripe version';

    protected function execute($input, $output): int
    {
        // parent::execute($input, $output);

        $ss = singleton(LeftAndMain::class);

        $io = new InputOutput($input, $output);
        $io->text($ss->CMSVersionNumber());

        return Command::SUCCESS;
    }
}
