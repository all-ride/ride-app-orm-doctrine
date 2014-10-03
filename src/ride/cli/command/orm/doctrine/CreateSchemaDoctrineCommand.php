<?php

namespace ride\cli\command\orm\doctrine;

use Doctrine\ORM\Tools\Console\Command\SchemaTool\CreateCommand;
use ride\library\dependency\DependencyInjector;

class CreateSchemaDoctrineCommand extends AbstractDoctrineCommand {
    /**
     * @param \ride\library\dependency\DependencyInjector $di
     */
    public function __construct(DependencyInjector $di) {
        parent::__construct($di, new CreateCommand(), 'doctrine schema create');
    }
}