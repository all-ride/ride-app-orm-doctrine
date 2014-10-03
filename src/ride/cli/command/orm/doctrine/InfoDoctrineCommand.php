<?php

namespace ride\cli\command\orm\doctrine;

use Doctrine\ORM\Tools\Console\Command\InfoCommand;
use ride\library\dependency\DependencyInjector;

class InfoDoctrineCommand extends AbstractDoctrineCommand {
    /**
     * @param \ride\library\dependency\DependencyInjector $di
     */
    public function __construct(DependencyInjector $di) {
        parent::__construct($di, new InfoCommand(), 'doctrine info');
    }
}