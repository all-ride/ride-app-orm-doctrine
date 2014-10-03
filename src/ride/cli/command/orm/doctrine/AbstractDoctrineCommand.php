<?php

namespace ride\cli\command\orm\doctrine;

use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use ride\application\orm\doctrine\ManagerRegistry;
use ride\library\cli\command\symfony\console\AbstractSymfonyCommand;
use ride\library\dependency\DependencyInjector;
use Symfony\Component\Console\Command\Command;

/**
 * This base class facilitates Doctrine ORM commands integration with the Ride framework.
 */
abstract class AbstractDoctrineCommand extends AbstractSymfonyCommand {
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * @var \ride\library\dependency\DependencyInjector
     */
    private $diContainer;

    /**
     * @param \ride\library\dependency\DependencyInjector $di
     * @param \Symfony\Component\Console\Command\Command $command
     * @param string $name
     * @param string|null $description
     */
    public function __construct(DependencyInjector $di, Command $command, $name, $description = null) {
        parent::__construct($command, $name, $description);

        $this->diContainer = $di;

        $this->addFlag('em', 'Entity manager to use.');
    }

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    private function setEntityManager($entityManager) {
        $this->entityManager = $entityManager;

        $helperSet = $this->getApplication()->getHelperSet();
        $helperSet->set(new EntityManagerHelper($entityManager), 'em');
        $helperSet->set(new ConnectionHelper($entityManager->getConnection()), 'db');
    }

    /**
     * @throws \ride\library\dependency\exception\DependencyException
     * @throws \ride\library\dependency\exception\DependencyNotFoundException
     */
    public function execute() {
        $emName = null;

        if ($this->input->getFlag('em')) {
            $emName = $this->input->getFlag('em');
        }

        /** @var ManagerRegistry $managerRegistry */
        $managerRegistry = $this->diContainer->get('ride\\application\\orm\\doctrine\\ManagerRegistry');
        $this->setEntityManager($managerRegistry->getManager($emName));

        parent::execute();
    }
}