<?php

namespace ride\cli\command\orm\doctrine;

use Doctrine\ORM\Tools\Console\Command\GenerateRepositoriesCommand;
use ride\library\dependency\DependencyInjector;

class GenerateRepositoriesDoctrineCommand extends AbstractDoctrineCommand {
    /**
     * @param \ride\library\dependency\DependencyInjector $di
     */
    public function __construct(DependencyInjector $di) {
        parent::__construct($di, new GenerateRepositoriesCommand(), 'doctrine generate repositories');
    }
}