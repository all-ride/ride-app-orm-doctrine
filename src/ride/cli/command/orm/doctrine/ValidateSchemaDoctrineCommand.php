<?php

namespace ride\cli\command\orm\doctrine;

use Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand;
use ride\library\dependency\DependencyInjector;

class ValidateSchemaDoctrineCommand extends AbstractDoctrineCommand {
    /**
     * @param \ride\library\dependency\DependencyInjector $di
     */
    public function __construct(DependencyInjector $di) {
        parent::__construct($di, new ValidateSchemaCommand(), 'doctrine schema validate');
    }
}