<?php

namespace ride\cli\command\orm\doctrine;

use Doctrine\ORM\Tools\Console\Command\EnsureProductionSettingsCommand;
use ride\library\dependency\DependencyInjector;

class EnsureProductionSettingsDoctrineCommand extends AbstractDoctrineCommand {
    /**
     * @param \ride\library\dependency\DependencyInjector $di
     */
    public function __construct(DependencyInjector $di) {
        parent::__construct($di, new EnsureProductionSettingsCommand(), 'doctrine ensure-production-settings');
    }
}