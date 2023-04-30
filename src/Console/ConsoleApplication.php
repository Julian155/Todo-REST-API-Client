<?php
declare(strict_types=1);

namespace App\Console;

use App\Database\Communication\Command\LoadDemoDataCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\HttpKernel\KernelInterface;

class ConsoleApplication extends Application
{
    /**
     * @param \Symfony\Component\HttpKernel\KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        parent::__construct($kernel);

        $this->addCommands($this->getConsoleCommands());
    }

    /**
     * @return \Symfony\Component\Console\Command\Command[]
     */
    public function getConsoleCommands(): array
    {
        return [
            new LoadDemoDataCommand(),
        ];
    }
}
