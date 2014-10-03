<?php

namespace ride\cli\command\orm\doctrine;

use Doctrine\ORM\Tools\Console\Command\GenerateEntitiesCommand;
use ride\library\dependency\DependencyInjector;

class GenerateEntitiesDoctrineCommand extends AbstractDoctrineCommand {
    /**
     * @param \ride\library\dependency\DependencyInjector $di
     */
    public function __construct(DependencyInjector $di) {
        parent::__construct($di, new GenerateEntitiesCommand(), 'doctrine generate entities');
    }
}