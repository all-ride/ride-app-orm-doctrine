<?php

namespace ride\cli\command\orm\doctrine;

use Doctrine\ORM\Tools\Console\Command\GenerateProxiesCommand;
use ride\library\dependency\DependencyInjector;

class GenerateProxiesDoctrineCommand extends AbstractDoctrineCommand {
    /**
     * @param \ride\library\dependency\DependencyInjector $di
     */
    public function __construct(DependencyInjector $di) {
        parent::__construct($di, new GenerateProxiesCommand(), 'doctrine generate proxies');
    }
}