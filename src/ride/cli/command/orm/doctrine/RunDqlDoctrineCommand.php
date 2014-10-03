<?php

namespace ride\cli\command\orm\doctrine;

use Doctrine\ORM\Tools\Console\Command\RunDqlCommand;
use ride\library\dependency\DependencyInjector;

class RunDqlDoctrineCommand extends AbstractDoctrineCommand {
    /**
     * @param \ride\library\dependency\DependencyInjector $di
     */
    public function __construct(DependencyInjector $di) {
        parent::__construct($di, new RunDqlCommand(), 'doctrine run dql');
    }
}