<?php

namespace ride\cli\command\orm\doctrine;

use Doctrine\ORM\Tools\Console\Command\ConvertMappingCommand;
use ride\library\dependency\DependencyInjector;

class ConvertMappingDoctrineCommand extends AbstractDoctrineCommand {
    /**
     * @param \ride\library\dependency\DependencyInjector $di
     */
    public function __construct(DependencyInjector $di) {
        parent::__construct($di, new ConvertMappingCommand(), 'doctrine convert-mapping');
    }
}