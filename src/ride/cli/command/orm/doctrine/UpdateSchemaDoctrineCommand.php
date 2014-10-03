<?php

namespace ride\cli\command\orm\doctrine;

use Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand;
use ride\library\dependency\DependencyInjector;

class UpdateSchemaDoctrineCommand extends AbstractDoctrineCommand {
    /**
     * @param \ride\library\dependency\DependencyInjector $di
     */
    public function __construct(DependencyInjector $di) {
        parent::__construct($di, new UpdateCommand(), 'doctrine schema update');
    }
}