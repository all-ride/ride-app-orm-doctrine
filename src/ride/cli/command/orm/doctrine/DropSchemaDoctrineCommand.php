<?php

namespace ride\cli\command\orm\doctrine;

use Doctrine\ORM\Tools\Console\Command\SchemaTool\DropCommand;
use ride\library\dependency\DependencyInjector;

class DropSchemaDoctrineCommand extends AbstractDoctrineCommand {
    /**
     * @param \ride\library\dependency\DependencyInjector $di
     */
    public function __construct(DependencyInjector $di) {
        parent::__construct($di, new DropCommand(), 'doctrine schema drop');
    }
}